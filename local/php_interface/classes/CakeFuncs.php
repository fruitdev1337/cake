<?
namespace Ttcr;

Class CakeFuncs {

    /* формирование данных точки тинькофф из модуля веб формы и запись самой точки в инфоблок*/
    public function savePointData($web_form_id){
        $iblock_id = 3;
        \CModule::IncludeModule('form');
        // Ну и зачем было коды делать другими?! Да и еще и без логики с ошибками, ну пздц
        // форматирование и сопастовление свойств их админки
        $matching_arr = array(
            'name_company_en' => 'billingDescriptor',
            'name_company_full' => 'fullName',
            'name_company_short' => 'name',
            'inn' => 'inn',
            'kpp' => 'kpp',
            'ogrn' => 'ogrn',
            'zip_legal' => 'zip',
            'city_legal' => 'city',
            'street_legal' => 'street',
            'email' => 'email',
            'address_founder' => 'f_address',
            'nationality_founder' => 'f_citizenship',
            'name_founder' => 'f_firstName',
            'second_name_founder' => 'f_middleName',
            'first_name_founder' => 'f_lastName',
            'address_boss' => 'ceo_address',
            'name_boss' => 'ceo_firstName',
            'second_name_boss' => 'ceo_middleName',
            'first_name_boss' => 'ceo_lastName',
            'date_birth_boss' => 'ceo_birthDate',
            'phone_boss' => 'ceo_phone',
            'web_site' => 'siteUrl',
            'payment_account' => 'account',
            'bank' => 'bankName',
            'bik' => 'bik',
            'address' => 'ADDR',
        );
        $data = [];
        $arAnswer = \CFormResult::GetDataByID($web_form_id, array(), $arResult, $results);

        foreach($results as $code=>$res){
            $arr = array_shift($res);
            if($arr['USER_FILE_ID']){
                $val = $arr['USER_FILE_ID'];
            }else{
                $val = $arr['USER_TEXT'];
            }
            $data[$code] = $val;
        }


        $el = new \CIBlockElement;
        $PROP = array();

        foreach ($data as $c=>$value){
            $PROP[$matching_arr[$c]] = $value;
        }
        $days = [
            0=>'Mon',
            1=>'Tue',
            2=>'Wed',
            3=>'Thu',
            4=>'Fri',
            5=>'Sat',
            6=>'Sun',
        ];
        $time_data = [];
        $n = 0;
        foreach($results['work_time'] as $work_arr){
            $t_arr = [];
            if($work_arr['USER_TEXT']){
                $time_arr = explode(' - ', $work_arr['USER_TEXT']);
                $t_arr = ['WEEK_DAY'=>$days[$n], 'TIME_FROM'=>$time_arr[0], 'TIME_TO'=>$time_arr[1]];
                $time_data['n'.$n] = $t_arr;
            }
            $n++;
        }
        if($time_data){
            $PROP['WORK_TIME'] = $time_data;
        }
        $PROP['in_id'] = $web_form_id.rand(1,1000);
        $arLoadProductArray = Array(
            'MODIFIED_BY' => $GLOBALS['USER']->GetID(), // элемент изменен текущим пользователем
            'IBLOCK_ID' => $iblock_id,
            'PROPERTY_VALUES' => $PROP,
            'NAME' => $data['name_pastry_shops'],
            'CODE' => \Cutil::translit($data['name_pastry_shops'],"ru"),
            'ACTIVE' => 'N', // активен
            'DETAIL_TEXT' => $data['about'],
            'PREVIEW_PICTURE' => \CFile::MakeFileArray($data['logo']),
        );

        if($PRODUCT_ID = $el->Add($arLoadProductArray)) {
            return $PRODUCT_ID;
        } else {
            echo 'Error: '.$el->LAST_ERROR;
            return false;
        }
    }
}
?>