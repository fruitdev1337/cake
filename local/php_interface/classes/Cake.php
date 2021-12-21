<?
namespace Ttcr;
use Bitrix\Sale;
use \Bitrix\Main\Loader;
use \Bitrix\Highloadblock as HL;

Class Cake {

    function sendToBitrix($method, $data){
        $url = 'https://cakeaway.bitrix24.ru/rest/17/7l93gt5genyqlf9c/'.$method;
        $data = http_build_query($data);
        $curl = curl_init();
        $opts = array(
            CURLOPT_SSL_VERIFYPEER => 0,
            CURLOPT_POST=>1,
            CURLOPT_HEADER=>0,
            CURLOPT_RETURNTRANSFER=>1,
            CURLOPT_URL=>$url,
            CURLOPT_POSTFIELDS=>$data,
        );
        curl_setopt_array($curl, $opts);
        $result = curl_exec($curl);
        curl_close($curl);
        return json_decode($result, 1);
    }

    function sendData($id){

        $order_id = $id;
        $order = self::getOrder($order_id);
        $products = self::getProductsFromOrder($order_id);

        if($order['DELIVERY_PRICE']){
            $delivery_prod = ['NAME'=>'Доставка', 'delivery_name'=>'Доставка', 'PRICE'=>$order['DELIVERY_PRICE'], 'QUANTITY'=>1];
            $products[] = $delivery_prod;
        }
        foreach($products as &$product){
            $product['added'] = self::addProduct($product);
            $prod_links[] = $_SERVER['SERVER_NAME'].$product['DETAIL_PAGE_URL'];
        }
        $order_link = $_SERVER['SERVER_NAME'].'/personal/orders/'.$order_id;
        $manufact = self::getManufact($products);
        $contact_id = self::addContact($order);

        $img_data_added = [];
        if(count($order['ADD_IMG']['VALUE'])){
            foreach($order['ADD_IMG']['VALUE'] as $img_val_arr){
                $prod_img = $img_val_arr['SRC'];
                $img_arr = explode('/', $prod_img);
                $file_data = file_get_contents($_SERVER['DOCUMENT_ROOT'].$prod_img);
                $img_data_added[] = array("fileData"=> [$img_arr[count($img_arr)-1], base64_encode($file_data)]);
            }
        }else{
            $img_data_added = '';
        }

        $newDeal = self::sendToBitrix('crm.deal.add', [
            'fields'=>[
                'TITLE'=>'Заявка с сайта - '.$order_id,
                'STAGE_ID'=>'NEW',
                'CONTACT_ID'=>$contact_id,
                'CURRENCY_ID' => 'RUB',
                'OPPORTUNITY' => $order['TOTAL'],
                'OPENED' => 'Y',
                'COMMENTS'=> $order['COMMENT'],
                'ORIGIN_ID'=> $order_id,
                'UF_CRM_1626051504' => $manufact, //произвоитель
                'UF_CRM_1625798381'=>$order['SHIPMENT'], //Вид доставки
                'UF_CRM_1626664060'=>$order['DELIVERY_PRICE'], //Стоимость доставки
                'UF_CRM_1625801171798'=>$order['ADDRESS']['VALUE'][0], //Адрес доставки
                'UF_CRM_1626353259811'=>$order['DELIVERY_TIME']['VALUE'][0], //Дата доставки
                'UF_CRM_1629866886'=>$order['DELIVERY_TIME_H']['OPTIONS'][$order['DELIVERY_TIME_H']['VALUE'][0]], //Время доставки
                'UF_CRM_1626051661'=>$order['PAYMENT'], //статус оплаты
                'UF_CRM_1631558320'=>$img_data_added, //Прикрепленный файл
                'UF_CRM_1631558342'=>$order['CAKE_TEXT']['VALUE'], //Текст на торте
                'UF_CRM_1631558383'=>$order['IMG_COMP']['VALUE'][0], //Сопоставление изображений
                'UF_CRM_1629834105'=>$prod_links, //ССылки на товары в заказе
                'UF_CRM_1632317848'=>$order_id, //номер заказа в отдельное поле для црмщиков
                'UF_CRM_1635954288'=>$order_link, //ссылка на заказ в профиле

            ],
            'params'=>[
                'REGISTER_SONET_EVENT'=>'Y'
            ],
        ]);
        self::addProductRows($products, $newDeal['result']);

    }
    public function addProductRows($products, $deal_id){
        foreach ($products as $item){
            $row['PRODUCT_ID'] = $item['added'];
            $row['PRICE'] = $item['PRICE'];
            $row['QUANTITY'] = $item['QUANTITY'];
            $rows[] = $row;
        }
        $newRows = self::sendToBitrix('crm.deal.productrows.set',[
            'id'=> $deal_id,
            'rows'=>$rows,
        ]);
        return $newRows;
    }
    public function addProduct($product){
        $main_props = self::formatMainProps($product);
        $isset = self::checkProduct($main_props['new_name']);
        if($isset['total'] !=0) return $isset['result'][0]['ID'];

        if($product['PREVIEW_PICTURE']){
            $prod_img = \CFile::GetPath($product['PREVIEW_PICTURE']);
            $img_arr = explode('/', $prod_img);
            $file_data = file_get_contents($_SERVER['DOCUMENT_ROOT'].$prod_img);
            $img_data = array("fileData"=> [$img_arr[count($img_arr)-1], base64_encode($file_data)]);
        }else{
            $img_data = '';
        }

        $newProduct = self::sendToBitrix('crm.product.add',[
            'fields'=>[
                'NAME'=>$main_props['new_name'],
                "CURRENCY_ID" => "RUB",
                "PRICE" => $product['PRICE'],
                "CODE" => $product['CODE'],
                "ACTIVE" => 'Y',
                'PREVIEW_PICTURE'=>$img_data,
                'DETAIL_PICTURE'=>$img_data,
                'QUANTITY'=>1,
                'PROPERTY_107' => $main_props['props']['WEIGHT']['VALUE'],
                'PROPERTY_109' => $main_props['props']['FILLING']['VALUE'],
                'PROPERTY_111' => $main_props['props']['NUMBER_LAYERS']['VALUE'],
                'PROPERTY_113' => $main_props['props']['DECORATING']['VALUE'],
            ]
        ]);
        return $newProduct['result'];
    }
    public function checkProduct($name){
        $list = self::sendToBitrix('crm.product.list', [
            'filter'=> ['NAME'=>$name],
            'select'=>['ID'],
        ]);
        return $list;
    }
    public function addContact($order){
        $isset = self::checkContact($order['PHONE']['VALUE'][0]);
        if($isset['total'] !=0) {
            $upd = self::updateContact($isset['result'][0]['ID'], $order['FIO']['VALUE'][0]);
            return $isset['result'][0]['ID'];
        }
        $newContact = self::sendToBitrix('crm.contact.add',[
            'fields'=>[
                'NAME'=>$order['FIO']['VALUE'][0],
                'TYPE_ID'=>'CLIENT',
                'OPENED'=>'Y',
                'EMAIL'=>[['VALUE'=>$order['EMAIL']['VALUE'][0], 'VALUE_TYPE'=>'WORK']],
                'PHONE'=>[['VALUE'=>$order['PHONE']['VALUE'][0], 'VALUE_TYPE'=>'WORK']],
            ],
            'params'=>[
                'REGISTER_SONET_EVENT'=>'Y'
            ],
        ]);
        return $newContact['result'];
    }
    public function updateContact($upd_id, $new_name){
        $updContact = self::sendToBitrix('crm.contact.update',[
            'id'=> $upd_id,
            'fields'=>[
                'NAME'=> $new_name,
            ]
        ]);
        return $updContact['result'];
    }
    public function checkContact($phone){
        $list = self::sendToBitrix('crm.contact.list', [
            'filter'=> ['PHONE'=>$phone],
            'select'=>['ID'],
        ]);
        return $list;
    }
    public function checkOrder($order_id){
        $list = self::sendToBitrix('crm.deal.list', [
            'filter'=> ['ORIGIN_ID'=>$order_id],
            'select'=>['ID'],
        ]);
        return $list;
    }

    public function getOrder($ORDER_ID){
        $order = \Bitrix\Sale\Order::load($ORDER_ID);
//        $basket = $order->getBasket();
        $propertyCollection = $order->getPropertyCollection();

        $order_data = $propertyCollection->getArray();
        foreach($order_data['properties'] as $prop){
            $order_props[$prop['CODE']] = $prop;
        }
        $order_props['TOTAL'] = $order->getPrice();
        $order_props['DATE'] = $order->getDateInsert();
        $order_props['ID'] = $order->getId();
        $order_props['IS_PAID'] = $order->isPaid();
        $order_props['DELIVERY_PRICE'] = $order->getDeliveryPrice();
        $order_props['CURRENCY'] = $order->getCurrency();
        $order_props['HASH'] = $order->getHash();
        $order_props['COMMENT'] = $order->getField('USER_DESCRIPTION');
        if($order->isPaid()){
            $order_props['PAYMENT'] = 'Оплачено';
        }else{
            $order_props['PAYMENT'] = 'Не оплачено';
        }

        $shipmentCollection = $order->getShipmentCollection();
        foreach($shipmentCollection as $shipment){
            $delivery = $shipment->getFieldValues();
            $order_props['SHIPMENT'] = $delivery['DELIVERY_NAME'];
        }
//        $order->getField('USER_DESCRIPTION'); //комментарии пользователя
//        $order->getId(); // ID заказа
//        $order->getSiteId(); // ID сайта
//        $order->getDateInsert(); // объект Bitrix\Main\Type\DateTime
//        $order->getPersonTypeId(); // ID типа покупателя
//        $order->getUserId(); // ID пользователя
//        $order->getPrice(); // Сумма заказа
//        $order->getDiscountPrice(); // Размер скидки
//        $order->getDeliveryPrice(); // Стоимость доставки
//        $order->getSumPaid(); // Оплаченная сумма
//        $order->getCurrency(); // Валюта заказа
//        $order->isPaid(); // true, если оплачен
//        $order->isAllowDelivery(); // true, если разрешена доставка
//        $order->isShipped(); // true, если отправлен
//        $order->isCanceled(); // true, если отменен

        return $order_props;
    }
    public function getPaymentButt($order_id){

        \CModule::IncludeModule("sale");
        $order_id = intval($order_id);

        $orderObj  = Sale\Order::load( $order_id );
        $paymentCollection  =  $orderObj ->getPaymentCollection();
        $payment  =  $paymentCollection [0];
        $service  = Sale\PaySystem\Manager::getObjectById( $payment ->getPaymentSystemId());
        $context  = \Bitrix\Main\Application::getInstance()->getContext();
        $service ->initiatePay( $payment ,  $context ->getRequest());

        $initResult = $service->initiatePay($payment, $context->getRequest(), \Bitrix\Sale\PaySystem\BaseServiceHandler::STRING);
        $buffered_output = $initResult->getTemplate();

        return $buffered_output;
    }

    public function getProductsFromOrder($order_id){
        $basket = Sale\Order::load($order_id)->getBasket();
        $prods = [];
        $products = $orderBasket = $basket->getBasketItems();
        foreach ($products as $item){
            $basketPropertyCollection = $item->getPropertyCollection();
            $props = $basketPropertyCollection->getPropertyValues();
            $prod_id = $item->getProductId();
            $prod_item = self::getProdProps($prod_id);
            $prod_item['PROD_ID'] = $prod_id;
            $prod_item['PRICE'] = $item->getPrice();
            $prod_item['QUANTITY'] = $item->getQuantity();
            $prod_item['basket_props'] = $props;
            $prods[] = $prod_item;
        }
        return $prods;
    }

    public function getProdProps($prod_id){

        $ElementID = $prod_id;
        $mxResult = \CCatalogSku::GetProductInfo($ElementID);
        if (is_array($mxResult)) {
            $PRODUCT_ID = $mxResult['ID']; // ID товара родителя
        } else {
            $PRODUCT_ID = $prod_id;
        }

        $res = \CIBlockElement::GetList(array(), ['IBLOCK_ID'=>4, 'ID'=>$PRODUCT_ID], false, array(), array('IBLOCK_ID', 'ID', 'CODE','NAME', 'PREVIEW_PICTURE', 'DETAIL_PICTURE', 'DETAIL_PAGE_URL'));
        while($ob = $res->GetNextElement())
        {
            $fields = $ob->GetFields();
            $fields['props'] = $ob->GetProperties();
        }

        $item = $fields;

        $res_sku = \CIBlockElement::GetList(array(), ['IBLOCK_ID'=>5, 'ID'=>$prod_id], false, array(), array('IBLOCK_ID', 'ID', 'CODE','NAME', 'PREVIEW_PICTURE', 'DETAIL_PICTURE'));
        while($ob_sku = $res_sku->GetNextElement())
        {
            $sku = $ob_sku->GetFields();
            $sku['props'] = $ob_sku->GetProperties();
        }
        $item['sku'] = $sku;

        return $item;
    }
    public function formatMainProps($product){
        if(!$product['delivery_name']){
            $need = array('WEIGHT', 'FILLING', 'NUMBER_LAYERS', 'DECORATING');
            $add_to_name = '';
            if($product['sku']['props']) {
                foreach ($product['sku']['props'] as $p_key => &$prop) {
                    if (in_array($p_key, $need)) {
                        if ($prop['USER_TYPE'] == 'directory') {
                            $prop['VALUE'] = self::getDictProp($prop);
                        }
                        if ($prop['VALUE']) {
                            $add_arr[] = $prop['VALUE'];
                            $res['props'][$p_key] = $prop;
                        }
                    }
                }
                $add_to_name = implode(' | ', $add_arr).' ';
            }
            $new_name = $product['NAME'].$add_to_name;
        }else{
            $new_name = $product['delivery_name'];
        }

        $res['new_name'] = $new_name;
        return $res;
    }
    public function getManufact($products){
        $brand_id = $products[0]['props']['BRAND']['VALUE'];
        $res = \CIBlockElement::GetList(array(), ['IBLOCK_ID'=>3, 'ID'=>$brand_id], false, array(), array('IBLOCK_ID', 'ID', 'CODE','NAME', 'PREVIEW_PICTURE', 'DETAIL_PICTURE'));
        while($ob = $res->GetNextElement())
        {
            $fields = $ob->GetFields();
            return $fields['NAME'];
        }
        return false;
    }

    public function getDictProp($arr){
        $sTableName = $arr['USER_TYPE_SETTINGS']['TABLE_NAME'];
        if ( Loader::IncludeModule('highloadblock') && !empty($sTableName) && !empty($arr["VALUE"]) )
        {
            $hlblock = HL\HighloadBlockTable::getRow([
                'filter' => [
                    '=TABLE_NAME' => $sTableName
                ],
            ]);

            if ( $hlblock )
            {
                $entity      = HL\HighloadBlockTable::compileEntity( $hlblock );
                $entityClass = $entity->getDataClass();

                $arRecords = $entityClass::getList([
                    'filter' => [
                        'UF_XML_ID' => $arr["VALUE"]
                    ],
                ]);
                foreach ($arRecords as $record)
                {
                  return  $record['UF_NAME'];
                }
            }
        }
    }
    public function sendPayed($order_id){
        $deal = self::checkOrder($order_id);
        $deal_id = $deal['result'][0]['ID'];
        if($deal_id){
            $update_deal = self::sendToBitrix('crm.deal.update',[
                'id'=> $deal_id,
                'fields'=>[
                    'UF_CRM_1626051661'=>'Оплачено',
                ],
                'params'=> ["REGISTER_SONET_EVENT"=> "Y" ],
        ]);
            return $update_deal['result'];
        }
    }
    public function checkPay($order_id){
        $order = \Bitrix\Sale\Order::load($order_id);

        if($order->isPaid()){
            self::sendPayed($order_id);
        }
    }

    public function setOrderCookie($order_id){
        $_SESSION['ORDERS_PAY'][$order_id] = $order_id; // пришлось так сделать, т.к. просто перезапись сессии не успевает отрабатывать при нескольких разделенных заказах

        $c_data = (array) json_decode($_COOKIE['order_pay_acces']);
        if(!$c_data) $c_data = [];
        foreach($_SESSION['ORDERS_PAY'] as $o_id){
            $order = \Bitrix\Sale\Order::load($o_id);
            if($order){
                $c_data[$o_id] = $order->getHash();
            }
        }
        setcookie("order_pay_acces", json_encode($c_data), time()+3600, '/');
    }
    public function checkOrderHash($order_id){
        $c_data = (array) json_decode($_COOKIE['order_pay_acces']);
        $hash = $c_data[$order_id];

        $order = \Bitrix\Sale\Order::load($order_id);
        if(!$order) return false;

        if($order->getHash() == $hash){
            return true;
        }
        return false;
    }

    public function getPointProps($item_id){
        $IBLOCK_ID = 4;
        $arFilter = array("IBLOCK_ID" => $IBLOCK_ID, "ACTIVE" => "Y", "ID" => $item_id);
        $arSelect = array("PROPERTY_BRAND.PROPERTY_ADDR", 'PROPERTY_BRAND.NAME');
        $props = [];

        $res = \CIBlockElement::GetList(array(), $arFilter, false, false, $arSelect);
        while($ob = $res->GetNextElement()){
            $arFields = $ob->GetFields();
            if(!empty($arFields["PROPERTY_BRAND_PROPERTY_ADDR_VALUE"]))
            {
                $props['name'] = $arFields["PROPERTY_BRAND_NAME"];
                $props['address'] = $arFields["PROPERTY_BRAND_PROPERTY_ADDR_VALUE"];
            }
        }
        return $props;
    }
}
?>