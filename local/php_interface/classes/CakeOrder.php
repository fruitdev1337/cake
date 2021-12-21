<?
namespace Ttcr;
use Ttcr\Cake;
use Bitrix\Sale;
use Bitrix\Main\Context,
    Bitrix\Currency\CurrencyManager,
    Bitrix\Sale\Order,
    Bitrix\Sale\Basket,
    Bitrix\Sale\Delivery,
    Bitrix\Sale\PaySystem;

Class CakeOrder {
    public static $warning_text = "Внимание! Вы заказываете торты от разных кондитерских. Ваш заказ будет разделен на несколько. Расчет доставки для каждого заказа осуществляется отдельно. Оплата каждого заказа осуществляется отдельно.";

    public function doSplit($order){

        $basket = $order->getBasket();

        $orderBasket = $basket->getBasketItems();
        foreach ($orderBasket as $item){
            $basketPropertyCollection = $item->getPropertyCollection();
            $props = $basketPropertyCollection->getPropertyValues();
            $prod_id = $item->getProductId();
            $prod_item = self::getProdProps($prod_id);
            $prod_item['PRODUCT_ID'] = $prod_id;
            $prod_item['CART_ID'] = $item->getId();
            $prod_item['PRICE'] = $item->getPrice();
            $prod_item['QUANTITY'] = $item->getQuantity();
            $prod_item['basket_props'] = $props;
            $prods[] = $prod_item;
        }
        foreach($prods as $prod){
            $prod_main = explode('#',$prod['basket_props']['PRODUCT.XML_ID']['VALUE'])[0];
            $cart_item = ['product_name'=> $prod['NAME'],'product_id'=>$prod['PRODUCT_ID'], 'cart_id'=>$prod['CART_ID'], 'main_prod_id'=>$prod_main, 'quantity'=>$prod['QUANTITY']];
            $manufacturers[$prod['PROPERTY_BRAND_ID']][] = $cart_item;
        }

        $other_orders = array();
        if(count($manufacturers)>1){
            $current_order = array_shift($manufacturers);

            $other_orders = $manufacturers;
            foreach ($other_orders as $order_prod){
                foreach ($order_prod as $order_item){
                    $basket->getItemById($order_item['cart_id'])->delete();
                }
            }
            $basket->save();

            $order_sum = $order->getPrice();

            $paymentCollection = $order->getPaymentCollection();
            foreach($paymentCollection as $payment){
                $payment->setField('SUM', $order_sum);
            }

            self::addCustomData($current_order, $order);
//            $propertyCollection = $order->getPropertyCollection();
//            $order_data = $propertyCollection->getArray();
//            dump($order_data);
//            exit();
        }else{
            self::addCustomData(array_shift($manufacturers), $order);
        }


        if(count($other_orders)){
            $order_props['payment_id'] = $order->getPaymentSystemId()[0];
            $delivery_ids = $order->getDeliverySystemId();
            $order_props['delivery_id'] = $delivery_ids[0];
            $order_props['COMMENT'] = $order->getField('USER_DESCRIPTION');
            $propertyCollection = $order->getPropertyCollection();
            $order_data = $propertyCollection->getArray();
            foreach($order_data['properties'] as $prop){
                $order_props['props'][$prop['CODE']] = $prop;
            }
            $order_user_id = $order->getUserId();
            foreach ($other_orders as $order_cart){
               $order_res = self::saveOtherOrder($order_cart, $order_user_id, $order_props);
               self::clearUserCart($order_cart);
            }
        }
    }

    public function clearUserCart($items){ // Нужно чтобы чистилась корзина от товаров, которые добавляются в другие заказы
        $basket = Basket::loadItemsForFUser(Sale\Fuser::getId(), \Bitrix\Main\Context::getCurrent()->getSite());
        foreach($items as $basket_item){
            $basket->getItemById($basket_item['cart_id'])->delete();
        }
        $basket->save();
    }

    /*
     * Создание нового заказа из сплитованного
     * */
    public function saveOtherOrder($cart_item, $user_id, $order_props){
        $siteId = Context::getCurrent()->getSite();
        $currencyCode = CurrencyManager::getBaseCurrency();
        $order = Order::create($siteId, $user_id);
        $order->setPersonTypeId(1);
        $order->setField('CURRENCY', $currencyCode);
        if ($order_props['COMMENT']) {
            $order->setField('USER_DESCRIPTION', $order_props['COMMENT']);
        }
        $basket = Basket::create($siteId);
        foreach($cart_item as $product){
            $item = $basket->createItem('catalog', $product['product_id']);
            $item->setFields(array(
                'QUANTITY' => $product['quantity'],
                'CURRENCY' => $currencyCode,
                'LID' => $siteId,
                'PRODUCT_PROVIDER_CLASS' => '\CCatalogProductProvider',
            ));
        }

        $order->setBasket($basket);

        $shipmentCollection = $order->getShipmentCollection();
        $shipment = $shipmentCollection->createItem(
            \Bitrix\Sale\Delivery\Services\Manager::getObjectById($order_props['delivery_id'])
        );
        $shipmentItemCollection = $shipment->getShipmentItemCollection();

        foreach ($basket as $basketItem)
        {
            $item = $shipmentItemCollection->createItem($basketItem);
            $item->setQuantity($basketItem->getQuantity());
        }


        $paymentCollection = $order->getPaymentCollection();
        $payment = $paymentCollection->createItem(
            \Bitrix\Sale\PaySystem\Manager::getObjectById($order_props['payment_id']) // 1 - ID платежной системы
        );

        $payment->setField("SUM", $order->getPrice());
        $payment->setField("CURRENCY", $order->getCurrency());


        $propertyCollection = $order->getPropertyCollection();

        foreach($order_props['props'] as $prop_code=>$prop){
            if($prop['ID'] == 20 || $prop['ID'] == 22 || $prop['ID'] == 24) continue; // do not save custom fields. Its have own
            $propertyValue = $propertyCollection->getItemByOrderPropertyId($prop['ID']);
            $propertyValue->setValue($prop['VALUE'][0]);
        }

        self::addCustomData($cart_item, $order);

        $order->doFinalAction(true);

        $result = $order->save();
        if (!$result->isSuccess())
        {
            var_dump($result->getErrorMessages());exit();
        }
        $orderId = $order->getId();
        Cake::setOrderCookie($orderId);
        return $orderId;
    }
    public function getProdProps($prod_id){

        $ElementID = $prod_id;
        $mxResult = \CCatalogSku::GetProductInfo($ElementID);
        if (is_array($mxResult)) {
            $PRODUCT_ID = $mxResult['ID']; // ID товара родителя
        } else {
            $PRODUCT_ID = $prod_id;
        }

        $res = \CIBlockElement::GetList(array(), ['IBLOCK_ID'=>4, 'ID'=>$PRODUCT_ID], false, array(), array('IBLOCK_ID', 'ID', 'CODE','NAME', 'PREVIEW_PICTURE', 'DETAIL_PICTURE', 'PROPERTY_BRAND.ID'));
        while($ob = $res->GetNextElement())
        {
            $fields = $ob->GetFields();
            $fields['props'] = $ob->GetProperties();
        }
        return $fields;
    }

    public function checkAddImg($product_id){
        //$item['PRODUCT_ID']
        $ids = [];
            $mxResult = \CCatalogSku::GetProductInfo($product_id);
            if (is_array($mxResult)) {
                $PRODUCT_ID = $mxResult['ID']; // ID товара родителя
            } else {
                $PRODUCT_ID = $product_id;
            }
//            $comp_ids[$item['PRODUCT_ID']] = $PRODUCT_ID;
            $ids[] = $PRODUCT_ID;
        $res = \CIBlockElement::GetList(array(), ['IBLOCK_ID'=>4, 'ID'=>$ids, 'PROPERTY_APPLICATION_VALUE' =>'Да'], false, array(), array('IBLOCK_ID', 'ID', 'CODE','NAME', 'PREVIEW_PICTURE', 'DETAIL_PICTURE', 'PROPERTY_BRAND.ID', 'PROPERTY_APPLICATION'));
        while($ob = $res->GetNextElement())
        {
            $fields[] = $ob->GetFields();
        }
        if($fields && count($fields)){
            return true;
        }else{
            return false;
        }
    }

    public function checkNotification($count = false){
        $brands = [];
        $basket = Basket::loadItemsForFUser(Sale\Fuser::getId(), \Bitrix\Main\Context::getCurrent()->getSite());
        foreach($basket as $basket_item){
           $prod_id = $basket_item->getProductId();
           $props = self::getProdProps($prod_id);
           $brand_id = $props['PROPERTY_BRAND_ID'];
           $brands[$brand_id] = $brand_id;
        }
        if($count){
            return count($brands);
        }
        if(count($brands)>1){
            return self::$warning_text;
        }else{
            return false;
        }
    }

    public function getProductBrand($prod_id){
        $res = self::getProdProps($prod_id);

        $db_prop = \CIBlockElement::GetProperty(3, $res['PROPERTY_BRAND_ID'], array(), Array("CODE"=>"shop_code"));
        if($ar_props = $db_prop->Fetch()){
            $shopCode = $ar_props["VALUE"];
        }

        if($shopCode){
            return $shopCode;
        }else{
            return false;
        }
    }

    public function getOrderProps($order_id){ // get order customers text and img properties
        $order = \Bitrix\Sale\Order::load($order_id);
        $propertyCollection = $order->getPropertyCollection();

        $order_data = $propertyCollection->getArray();
        foreach($order_data['properties'] as $prop){
            $order_props[$prop['CODE']] = $prop;
        }
        return $order_props;
    }

    public function addCustomData($current_order, &$order){ // Добавление полей кастомных изображений и текста на изделии
        //adding custom imgs and text
        $custom_data = json_decode($_COOKIE['custom_add']);
        $c_items_arr = [];
        $imgs = [];
        $texts = [];
        $current_props_collection = $order->getPropertyCollection();
        foreach ($current_order as $cart_item){
            $cart_id = intval($cart_item['cart_id']);
            if(isset($custom_data->$cart_id)){
                $c_data = $custom_data->$cart_id;
                $img = array_shift($c_data->imgs);
                $text = array_shift($c_data->text);
                $imgs[] = $img->file_id;
                $texts[] = $text;
                $file_name = \CFile::GetFileArray($img->file_id)['FILE_NAME'];
                $c_items_arr[$cart_id]= ['product_name'=>$cart_item['product_name'], 'file_name'=>$file_name, 'text'=>$text];
            }
        }
        if($imgs){
            $propertyValue = $current_props_collection->getItemByOrderPropertyId(20); // custom img prop
            $propertyValue->setValue($imgs);
        }
        if($texts){
            $propertyValue = $current_props_collection->getItemByOrderPropertyId(22); // custom text prop
            $propertyValue->setValue($texts);
        }

        // Запишем в поле для соответсвия, чтобы смогли расшифровать что для чего, если в одном заказе больше 1 товара с кастомной картинкой
        if(count($c_items_arr)>1){
            $val = '';
            foreach($c_items_arr as $item_pr){
                $val .=$item_pr['product_name'].' - '.$item_pr['text'].' \ '.$item_pr['file_name'].'; ';
            }
            $propertyValue = $current_props_collection->getItemByOrderPropertyId(24); // custom img prop
            $propertyValue->setValue($val);
        }
    }

    public function getMaxDeliveryTime($rows){ // Найдем максимальное время изготовления у товаров в заказе + информацию о бренде
        foreach ($rows as $item){
            $prod_id = $item['data']['PRODUCT_ID'];
            $prod_data[$prod_id] = self::getProdProps($prod_id);
            $hours[$prod_id] = $prod_data[$prod_id]['props']['TIME_MANUFACTURING']['VALUE'];
        }
        $res['max_time'] = max($hours);
        $res['brand'] = $prod_data[array_search(max($hours),$hours)]['props']['BRAND'];

        return $res;
    }
// Рассчет времни изготовления изделия с учетом выходных и рабочих часов
    public function getReadyTimeNew($time_manufacturing, $brand = array()){
        if(!$time_manufacturing) return false;
        $arMapDayWeek = ["Mon", "Tue", "Wed", "Thu", "Fri", "Sat", "Sun"];
        $completeDate = false;
        $hours_diff = 1;// за какое время до конца рабочего дня заказ перекидывается на следущий рабочий день. Типа если заказ сделали в 18:10 - то мы уже сегодня его не делаем, начинаем со следующего дня
        $arWorkTime = array();
        $res = \CIBlockElement::GetProperty($brand["IBLOCK_ID"], $brand['ID'], array(), array("CODE" => "WORK_TIME"));
        while ($ob = $res->GetNext())
        {
            $arItem = unserialize(htmlspecialchars_decode($ob['VALUE']));
            if($arItem){
                $arWorkTime[$arItem["WEEK_DAY"]] = $arItem;
            }
        }
        if(empty($arWorkTime)) return false;

        $nowTime = new \DateTime('now');
//        $nowTime = new \DateTime('2021-09-25 16:30:00'); // тестрировать в разное время
        $CurDayWeek = $nowTime->format("D");

//        $mod_now_time = new \DateTime('2021-09-25 16:30:00'); // тестрировать в разное время
        $mod_now_time = new \DateTime('now');
        $mod_now_time = $mod_now_time->modify('+'.$time_manufacturing.' hours');
        if(!empty($arWorkTime[$CurDayWeek])){ // Сегодня не выходной
            $fromTodayWork = new \DateTime(date("Y-m-d").' '.$arWorkTime[$CurDayWeek]["TIME_FROM"]. ':00');
            $toTodayWork = new \DateTime(date("Y-m-d").' '.$arWorkTime[$CurDayWeek]["TIME_TO"]. ':00');

            $hoursToday = $fromTodayWork->diff($toTodayWork)->h;
            if($nowTime < $fromTodayWork && $hoursToday-$hours_diff > $time_manufacturing){ // еще не начался рабочий день
                $completeDate = $fromTodayWork->modify('+'.$time_manufacturing.' hours');
//                dump($completeDate);
                return $completeDate;
            }elseif ($nowTime > $fromTodayWork & $mod_now_time < $toTodayWork){ // рабочий день идет и успеваем сделать в этот день
                $completeDate = $nowTime->modify('+'.$time_manufacturing.' hours');
//                dump($completeDate);
                return $completeDate;
            }
        }
        // Если не вышло, то высчитываем когда же будет готово
        // Принцип такой, что мы идем в цикле по дням (учитывая выходные и нерабочие часы), делая торт, и уменьшаем время нужное на изготовление, когда время вышло возвращаем получившийся день


        $time_in_current_day = 0;
        $rest_minutes = 0;
        if(!empty($arWorkTime[$CurDayWeek])){
            if($nowTime < $toTodayWork ){ // && $mod_now_time < $toTodayWork
                // Сколько часов осталось в текущем дне, если он рабочий
                if($nowTime >= $fromTodayWork){
                    $time_in_current_day = $nowTime->diff($toTodayWork)->h;
                    if($nowTime->diff($toTodayWork)->i > 0){
                        $time_in_current_day +=1;
                        $rest_minutes = $nowTime->diff($toTodayWork)->i;
                    }
                }else{
                    $time_in_current_day= $fromTodayWork->diff($toTodayWork)->h;
                }

            }
        }
        $rest_hours = $time_manufacturing - $time_in_current_day;
        $do_time = $nowTime;
        do{
//            dump($rest_hours);
            $do_time->modify('tomorrow');
            $dayOfWeek = $do_time->format("D");
            $hoursInDay = 0;
            if(!empty($arWorkTime[$dayOfWeek])){
                $fromDayWork = new \DateTime(date("Y-m-d").' '.$arWorkTime[$dayOfWeek]["TIME_FROM"]. ':00');
                $toDayWork = new \DateTime(date("Y-m-d").' '.$arWorkTime[$dayOfWeek]["TIME_TO"]. ':00');
                $hoursInDay = $fromDayWork->diff($toDayWork)->h; // рабочее колво часов в дне (вдруг в админке в разные дни поставят разное время работы)
            }
            $rest_hours -= $hoursInDay;
//            dump($dayOfWeek);

            if($rest_hours < 0){ // Когда время кончилось, высчитываем сколько там нужно еще в этом дне и выводим окончательную дату
                $t_in_day = $hoursInDay - abs($rest_hours);
                $dt = new \DateTime($arWorkTime[$dayOfWeek]["TIME_FROM"]);
                $do_time->setTime($dt->format('H'), $dt->format('i'));
                $completeDate = $do_time->modify('+'.$t_in_day.' hours');

                if($rest_minutes) { // Добавляем минуты, которые округлялись
                    $completeDate = $do_time->modify('+'.$rest_minutes.' minutes');
                }
                break;
            }
        }while($rest_hours >= 0);

        return $completeDate;
    }
}
?>