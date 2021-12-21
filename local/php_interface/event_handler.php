<?php
use Ttcr\CakeOrder;
use Ttcr\Cake;
use Ttcr\CakeTinkoff;
use Ttcr\CakeFuncs;

//Обработка событий
\Bitrix\Main\EventManager::getInstance()->addEventHandler(
	'iblock', 
	'OnIBlockPropertyBuildList', 
	['lib\usertype\CUserTypeWorkTine', 'GetUserTypeDescription']
);

//\Bitrix\Main\EventManager::getInstance()->addEventHandler(
//	'sale',
//	'OnSaleComponentOrderOneStepProcess',
//	'SetUserDescription'
//);

\Bitrix\Main\EventManager::getInstance()->addEventHandler(
	'sale',
	'OnSaleOrderBeforeSaved',
	'splitOrder'
);
\Bitrix\Main\EventManager::getInstance()->addEventHandler(
	'sale',
	'OnSaleOrderSaved',
	'sendToBitrix'
);
\Bitrix\Main\EventManager::getInstance()->addEventHandler(
	'sale',
	'OnSaleComponentOrderOneStepProcess',
	'replaceOrderProps'
);
\Bitrix\Main\EventManager::getInstance()->addEventHandler(
	'sale',
	'OnSalePaymentEntitySaved',
	'checkPay'
);

\Bitrix\Main\EventManager::getInstance()->addEventHandler(
    'iblock',
    'OnAfterIBlockElementAdd',
    'pointRegister'
);
\Bitrix\Main\EventManager::getInstance()->addEventHandler(
    'iblock',
    'OnAfterIBlockElementUpdate',
    'pointRegister'
);

\Bitrix\Main\EventManager::getInstance()->addEventHandler(
    'sale',
    'OnOrderNewSendEmail',
    'mailModify'
);
\Bitrix\Main\EventManager::getInstance()->addEventHandler(
    'form',
    'onAfterResultAdd',
    'savePointData'
);


/* подставил адрес самовывоза */
function gettUserDescription($arResult)
{
	$basket = Bitrix\Sale\Basket::loadItemsForFUser(Bitrix\Sale\Fuser::getId(false), Bitrix\Main\Context::getCurrent()->getSite());
	$arItemsID = array();
	foreach ($basket as $item) {
		$mxResult = CCatalogSku::GetProductInfo($item->getProductId());
		if(is_array($mxResult))
			$arItemsID[] = $mxResult['ID'];
		else
			$arItemsID[] = $item->getProductId();
	}

	$IBLOCK_ID = 4;
	$arFilter = array("IBLOCK_ID" => $IBLOCK_ID, "ACTIVE" => "Y", "ID" => $arItemsID);
	$arSelect = array("PROPERTY_BRAND.PROPERTY_ADDR");

	$desc = $arResult['DELIVERY']['3']['DESCRIPTION'];
	$brand_addr = [];

	$res = CIBlockElement::GetList(array(), $arFilter, false, false, $arSelect);
	while($ob = $res->GetNextElement()){
		$arFields = $ob->GetFields();
		if(!empty($arFields["PROPERTY_BRAND_PROPERTY_ADDR_VALUE"]))
		{
            $brand_addr[$arFields['PROPERTY_BRAND_PROPERTY_ADDR_VALUE_ID']] = $arFields["PROPERTY_BRAND_PROPERTY_ADDR_VALUE"];
		}
	}
	foreach ($brand_addr as $brand_addr){
        $desc .= ' <br> <b>' .$brand_addr. '</b>';
        $addr = true;
    }
    return $desc;

}

function splitOrder(\Bitrix\Main\Event $event){
//    global $APPLICATION;
//    $APPLICATION->RestartBuffer();
    $parameters = $event->getParameters();
    $order = $parameters['ENTITY'];
    $d_insert = $order->getDateInsert();
    if (!isset($d_insert)) {
        CakeOrder::doSplit($order);
    }
}
function sendToBitrix(\Bitrix\Main\Event $event){
//        global $APPLICATION;
//    $APPLICATION->RestartBuffer();
    $parameters = $event->getParameters();
    $order = $parameters['ENTITY'];
    $isNew = $event->getParameter("IS_NEW");
    if ($isNew){
        $order_id = $order->getId();
        Cake::sendData($order_id);
        Cake::setOrderCookie($order_id);
    }
}
function replaceOrderProps(&$arResult){

    $arResult['JS_DATA']['DELIVERY'][3]['DESCRIPTION'] = gettUserDescription($arResult);
    $arResult['JS_DATA']['BRANDS_COUNT'] = CakeOrder::checkNotification(true);

    $time_data = CakeOrder::getMaxDeliveryTime($arResult['JS_DATA']['GRID']['ROWS']);
    $min_delivery_date = CakeOrder::getReadyTimeNew($time_data['max_time'], array('IBLOCK_ID'=>$time_data['brand']['LINK_IBLOCK_ID'], 'ID'=>$time_data['brand']['VALUE']));

    if(!$min_delivery_date) $min_delivery_date = new DateTime('now');

    foreach($arResult['JS_DATA']['ORDER_PROP']['properties'] as &$prop) {
        if($prop['ID'] == 21){


            $day = $min_delivery_date->format("d.m.Y");
            $prop['VALUE'] = $day;
        }
        if($prop['ID'] == 23){
            $prop['min_hour'] = $min_delivery_date->format("H");
        }
    }
}
function checkPay(\Bitrix\Main\Event $event){

    $payment = $event->getParameter("ENTITY");
    $order_id = $payment->getField('ORDER_ID');

    Cake::checkPay($order_id);
}
//TODO причесать все нужно
function pointRegister(&$arFields){
    if($arFields['IBLOCK_ID'] == 3 && !empty($arFields['PROPERTY_VALUES'][92])){
        $tinkoff = new CakeTinkoff('Cakeaway', 'K1AlX5hB');
//    $tinkoff = new CakeTinkoff('Cakeaway', 'Cakeaway'); //test
        $rs = $tinkoff->autorize();
        $res = $tinkoff->doRegister($arFields['ID']);
    }
}
//TODO по возможности убрать в класс
function mailModify($orderID, &$eventName, &$arFields) { // Добавление в шаблон письма кастомных полей
    $order_data = Cake::getOrder($orderID);
    $adding_text = '';

    if(count($order_data['ADD_IMG']['VALUE'])){
        $adding_text .='Прикрепленный рисунок: <br>';

        foreach($order_data['ADD_IMG']['VALUE'] as $img_arr){
            $adding_text .= '<a href="'.$img_arr['SRC'].'">'.$img_arr['ORIGINAL_NAME'].'</a><br>';
        }
    }
    if(count($order_data['CAKE_TEXT']['VALUE'])){
        $adding_text .= 'Прикрепленный текст: <br><br>';
        foreach ($order_data['CAKE_TEXT']['VALUE'] as $text){
            $adding_text .= $text.'<br>';
        }
    }
    if($order_data['COMMENT']){
        $adding_text .= 'Комментарий: '.$order_data['COMMENT'].'<br><br>';
    }

    $adding_text .= 'Доставка: '. $order_data['SHIPMENT'].'<br>';
    if($order_data['DELIVERY_PRICE']){
        $adding_text .= 'Стоимость доставки: '.$order_data['DELIVERY_PRICE']. ' ₽ <br>';
        $adding_text .= 'Адрес доставки: '.$order_data['ADDRESS']['VALUE'][0].'<br>';
    }
    if($order_data['DELIVERY_TIME']['VALUE'][0]){
        $adding_text .= 'Дата доставки: '.$order_data['DELIVERY_TIME']['VALUE'][0].'<br>';
    }
    if($order_data['DELIVERY_TIME_H']['VALUE'][0]){
        $adding_text .= 'Время доставки: '.$order_data['DELIVERY_TIME_H']['VALUE'][0].'<br>';
    }

    $arFields['CUSTOM_FIELDS'] = $adding_text;
}

function savePointData($WEB_FORM_ID, $result_id){
    if($WEB_FORM_ID == 2){
        CakeFuncs::savePointData($result_id);
    }
}
