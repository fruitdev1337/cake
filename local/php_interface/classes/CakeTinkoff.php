<?
namespace Ttcr;


Class CakeTinkoff {
    protected $_error;
    protected $_login;
    protected $_password;
    protected $_api_url;
    protected $_response;
    protected $_status;
    protected $_token;


    public function __construct($login, $password)
    {
//        $this->_api_url = 'https://sm-register-test.tcsbank.ru/';
        $this->_api_url = 'https://sm-register.tinkoff.ru/';
        $this->_login = $login;
        $this->_password = $password;
    }
    public function buildQuery($path, $args)
    {
        $url = $this->_api_url;
        $url = $this->_combineUrl($url, $path);

        return $this->_sendRequest($url, $args, false);
    }
    public function autorize(){
        $args = array(
            'grant_type' => 'password',
            'username' => $this->_login,
            'password' => $this->_password,
        );
        $result =  $this->_sendRequest('https://sm-register.tinkoff.ru/oauth/token', $args, true);
        $res = json_decode($result);
        if($res->access_token){
            $token = $res->access_token;
            $this->_token = $token;
            return true;
        }else{
            return false;
        }
    }
    private function _sendRequest($api_url, $args, $auth = false)
    {
        $this->_error = '';

        if (is_array($args)) {
            if($auth){
                $args = http_build_query($args);
            }else{
                $args = json_encode($args);
            }
        }

        if(!$auth){
            $headers = ['Authorization: Bearer '.$this->_token, 'Content-Type: application/json'];
        }else{
            $headers = ['Content-Type: application/x-www-form-urlencoded'];
        }
        if ($curl = curl_init()) {
            curl_setopt($curl, CURLOPT_URL, $api_url);
            curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($curl, CURLOPT_POST, true);
            curl_setopt($curl, CURLOPT_POSTFIELDS, $args);
            curl_setopt($curl, CURLOPT_HTTPHEADER, $headers,);

            if($auth) {
                curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
                curl_setopt($curl, CURLOPT_USERPWD, "partner:partner");
            }

            $out = curl_exec($curl);
//            if(!$out){
//                var_dump(123);
//                $header_size = curl_getinfo($curl, CURLINFO_HEADER_SIZE);
//                $header = substr($out, 0, $header_size);
//                var_dump($header);
//            }

            $this->_response = $out;
            $json = json_decode($out);
            if ($json) {
                if (@$json->ErrorCode !== "0") {
                    $this->_error = @$json->Details;
                } else {
                    $this->_status = @$json->Status;
                }
            }

            curl_close($curl);

            return $out;

        } else {
            throw new HttpException(
                'Can not create connection to ' . $api_url . ' with args '
                . $args, 404
            );
        }
    }
    private function _combineUrl()
    {
        $args = func_get_args();
        $url = '';
        foreach ($args as $arg) {
            if (is_string($arg)) {
                if ($arg[strlen($arg) - 1] !== '/') {
                    $arg .= '/';
                }
                $url .= $arg;
            } else {
                continue;
            }
        }

        return $url;
    }

    public function doRegister($shop_id){
        $data = $this->getPointData($shop_id);
        if($data){
            $result =  $this->buildQuery('register', $data);
            $result = json_decode($result);
            if($result->shopCode) { // регистрация успешно прошла
                $this->setShopCode($shop_id, $result->shopCode);
            }else{// ошибка или уже зарегистрированно
                if(isset($result->errors)){
                    echo 'При регистрации точки возникли ошибки. Нажмите кнопку "назад" в браузере и исправьте ошибки:<br><br>';
                    foreach ($result->errors as $error){
                        echo 'Поле '.$error->field. ' - '.$error->defaultMessage.'. Отклоненные данные: '.$error->rejectedValue.'<br><br>';
                    }
                    exit();
                }
                return true;
            }
        }else{
            return false;
        }

    }

    public function getPointData($shop_id){
        $res = \CIBlockElement::GetList(array(), ['IBLOCK_ID'=>3, 'ID'=>$shop_id], false, array(), array('IBLOCK_ID', 'ID', 'CODE','NAME'));
        while($ob = $res->GetNextElement())
        {
            $fields = $ob->GetFields();
            $fields['props'] = $ob->GetProperties();
        }
        $arr_props = $fields['props'];
        if($arr_props['approved']['VALUE'] !== 'Y') return false;
        $point_props['shopArticleId'] = $arr_props['in_id']['VALUE'];
        $point_props['billingDescriptor'] = $arr_props['billingDescriptor']['VALUE'];
        $point_props['fullName'] = $arr_props['fullName']['VALUE'];
        $point_props['name'] = $arr_props['name']['VALUE'];
        $point_props['inn'] = $arr_props['inn']['VALUE'];
        if($arr_props['kpp']['VALUE'] == '-' || $arr_props['kpp']['VALUE'] == 'нет'){
            $point_props['kpp'] = '000000000';
        }else{
            $point_props['kpp'] = $arr_props['kpp']['VALUE'];
        }
        $point_props['ogrn'] = $arr_props['ogrn']['VALUE'];
        $point_props['addresses'] = [
            [
                'type'=>'legal',
                'zip'=> $arr_props['zip']['VALUE'],
                'country'=> 'RUS',
                'city'=> $arr_props['city']['VALUE'],
                'street'=> $arr_props['street']['VALUE'],
            ],
            [
                'type'=>'actual',
                'zip'=> $arr_props['zip']['VALUE'],
                'country'=> 'RUS',
                'city'=> $arr_props['city']['VALUE'],
                'street'=> $arr_props['street']['VALUE'],
            ],
        ];
        $point_props['email'] = $arr_props['email']['VALUE'];
        $point_props['founders'] = [
            'individuals'=> [
                [
                    'address'=> $arr_props['f_address']['VALUE'],
                    'citizenship'=> $arr_props['f_citizenship']['VALUE'],
                    'firstName'=> $arr_props['f_firstName']['VALUE'],
                    'lastName'=> $arr_props['f_lastName']['VALUE'],
                    'middleName'=> $arr_props['f_middleName']['VALUE'],
                ]
            ],
        ];

        $birthDate = new \DateTime($arr_props['ceo_birthDate']['VALUE']);
        $birth_val = $birthDate->format('Y-m-d');

        $point_props['ceo'] = [
            'address'=> $arr_props['ceo_address']['VALUE'],
            'firstName'=> $arr_props['ceo_firstName']['VALUE'],
            'lastName'=> $arr_props['ceo_lastName']['VALUE'],
            'middleName'=> $arr_props['ceo_middleName']['VALUE'],
            'birthDate'=> $birth_val,
            'phone'=> $arr_props['ceo_phone']['VALUE'],
        ];
        if($arr_props['siteUrl']['VALUE'] == '-' || $arr_props['siteUrl']['VALUE'] == 'нет'){
            $point_props['siteUrl'] = 'https://cakeaway.club.ru/';
        }else{
            $point_props['siteUrl'] = $arr_props['siteUrl']['VALUE'];
        }
        $point_props['bankAccount'] = [
            'account'=> $arr_props['account']['VALUE'],
            'bankName'=> $arr_props['bankName']['VALUE'],
            'bik'=> $arr_props['bik']['VALUE'],
            'details'=> 'Перевод средств cakeaway',
            'tax'=> $arr_props['tax']['VALUE'],
        ];

        return $point_props;
    }

    public function setShopCode($id, $shop_code){
        if(\CIBlockElement::SetPropertyValueCode($id, "shop_code", $shop_code)){
            return true;
        }else{
            return false;
        }
    }
}
?>