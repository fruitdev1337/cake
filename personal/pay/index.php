<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Оплата");
$APPLICATION->SetAdditionalCSS(SITE_TEMPLATE_PATH."/components/bitrix/sale.personal.section/bootstrap_v4/bitrix/sale.personal.order.list/bootstrap_v4/style.css", true);
use Ttcr\CakeOrder;
use Ttcr\Cake;

$c_data = (array) json_decode($_COOKIE['order_pay_acces']);
//dump($c_data);

//Cake::setOrderCookie(322);
$orders = [];
foreach($c_data as $order_id=>$hash){
    if(Cake::checkOrderHash($order_id)){
        $order_data = Cake::getOrder($order_id);
        $order_data['items'] = Cake::getProductsFromOrder($order_id);
        if($order_data){
            $orders[] = $order_data;
        }
    }
}
if(empty($orders)){
        header('Location: /personal/');
}
?>
    <div class="title_box">
        <h1>Мои заказы</h1>
    </div>
    <?foreach($orders as $order):?>
    <div class="row mx-0 sale-order-list-title-container p-2">
        <h3 class="col mb-1 mt-1">
            Заказ №<?=$order['ID']?> от <?=$order['DATE']->format('d.m.Y')?> на сумму <?=$order['TOTAL']?> <i class="fa fa-rub"><span>₽</span></i>
          </h3>
    </div>
    <div class="row mx-0 mb-5">
        <div class="col pt-3 sale-order-list-inner-container">
            <div class="row mb-3 align-items-center">
                <div class="col-auto">
                    <span class="sale-order-list-inner-title-line-item">Оплата</span>
                </div>
                <div class="col">
                    <hr class="sale-order-list-inner-title-line">
                </div>
            </div>
            <div class="row mb-3 sale-order-list-inner-row">
                <div class="col sale-order-list-inner-row-body">
                    <div class="row">
                        <div class="col sale-order-list-payment">
                            <div class="mb-1 sale-order-list-payment-title">Оплата заказа
                                <?if($order['IS_PAID']){
                                    $paid_class = 'sale-order-list-status-success';
                                }else{
                                    $paid_class = 'sale-order-list-status-alert';
                                }
                                ?>
                                <span class="<?=$paid_class?>"><?=$order['PAYMENT']?></span>
                            </div>

                            <?
                            foreach($order['items'] as &$product){
                                $product['main_props'] = Cake::formatMainProps($product);
                            }
                            $img_comp = $order['IMG_COMP']['VALUE'][0];
                            $img_comp_arr = explode('; ', $img_comp);
                            $point_data = Cake::getPointProps($order['items'][0]['ID']);
                            ?>
                            <?foreach($order['items'] as $n=>$item):?>
                            <?
                                $prod_comp = $img_comp_arr[$n];
                                $prod_comp = trim(str_replace($item['NAME'].' - ', '', $prod_comp));
                                $prod_comp_arr = explode('\\', $prod_comp); // [0] - текст для этого продукта, [1] - картинка
                                $prod_c_img = '';
                                foreach($order['ADD_IMG']['VALUE'] as $c_img){
                                    if($c_img['FILE_NAME'] == trim($prod_comp_arr[1])){
                                        $prod_c_img = $c_img;
                                    }
                                }
                            ?>
                                <div class="mb-1 sale-order-list-payment-price">
                                                <span class="sale-order-list-payment-element  order-link">
                                                    <a href="<?=$item['DETAIL_PAGE_URL']?>"><?=$item['NAME']?></a></span>
                                    <span class="sale-order-list-payment-number  order-price"><?=$item['PRICE']?> <i class="fa fa-rub"><span>₽</span></i></span>
                                </div>
                                <?if($item['main_props']['props']):?>
                                    <?
                                    $mp_arr = [];
                                    foreach ($item['main_props']['props'] as $m_props){
                                        $mp_arr[] = $m_props['NAME'].': '.$m_props['VALUE'];
                                    }

                                    ?>
                                    <div class="mb-1 sale-order-list-payment-price">
                                        <p class="f-w-b  order-title">Парамерты:</p>
                                        <p><?=implode(', ', $mp_arr)?></p>
                                    </div>
                                <?endif;?>
                                <?if($prod_comp_arr[0]):?>
                                    <div class="mb-1 sale-order-list-payment-price">
                                        <p class="f-w-b  order-title">Текст для нанесения на торте:</p>
                                        <p><?=$prod_comp_arr[0]?></p>
                                    </div>
                                <?endif;?>
                                <?if($prod_c_img):?>
                                    <div class="mb-1 sale-order-list-payment-price">
                                        <p class="f-w-b  order-title">Файл:</p>
                                        <p><a href="<?=$prod_c_img['SRC']?>"><?=$prod_c_img['ORIGINAL_NAME']?></a></p>
                                    </div>
                                <?endif;?>
                             <?endforeach;?>
                            <?
                            $delivery_cost = '';
                            if($order['SHIPMENT'] == 'Самовывоз'){
                                $delivery_name = 'Самовывоз';
                            }else{
                                $delivery_name = 'Доставка';
                                $delivery_cost = ' '.CurrencyFormat($order['DELIVERY_PRICE'], $order['CURRENCY'] ? $order['CURRENCY'] : 'RUB');
                            }
                            if($order['DELIVERY_TIME_H']['VALUE'][0]){
                                $d_h = $order['DELIVERY_TIME_H']['VALUE'][0];
                            }else{
                                $d_h = 0;
                            }
                            ?>
                            <div class="mb-1 sale-order-list-payment-price">
                                <p class="f-w-b  order-title  order-delivery"><?=$delivery_name.$delivery_cost?></p>
                                <p>
                                    <span>Дата и время получения: <?=$order['DELIVERY_TIME']['VALUE'][0]?></span>
                                    <span><?=$order['DELIVERY_TIME_H']['OPTIONS'][$d_h]?></span>
                                </p>
                            </div>

                            <?if($point_data):?>
                                <div class="mb-1 sale-order-list-payment-price">

                                    <?if(!$delivery_cost):?>
                                        <p class="f-w-b  order-title">Адрес «<?=$point_data['name']?>»:</p>
                                        <p><?=$point_data['address']?></p>
                                        <!--                                                <p>-->
                                        <!--                                                </p><div class="order-title">Режим работы:</div>-->
                                        <!--                                                <div>ежедневно 9:00 – 21:00</div>-->
                                    <?else:?>
                                        <p class="f-w-b  order-title">Адрес</p>
                                        <p><?=$order['DATA']['ADDRESS']['VALUE'][0]?></p>
                                    <?endif;?>
                                    <p></p>
                                    <?if($order['COMMENT']):?>
                                        <p>
                                            <span>Комментарий к заказу:</span>
                                            <span><?=$order['COMMENT']?></span>
                                        </p>
                                    <?endif;?>
                                </div>
                            <?endif;?>
                            <?if($order['FIO']['VALUE'][0]):?>
                                <div class="mb-1 sale-order-list-payment-price">
                                    <p class="f-w-b  order-title">Покупатель</p>
                                    <p>
                                        <span>ФИО:</span>
                                        <span><?=$order['FIO']['VALUE'][0]?></span>
                                    </p>
                                    <?if($order['PHONE']['VALUE'][0]):?>
                                        <p>
                                            <span>Телефон:</span>
                                            <span><?=$order['PHONE']['VALUE'][0]?></span>
                                        </p>
                                    <?endif;?>
                                    <?if($order['EMAIL']['VALUE'][0]):?>
                                        <p>
                                            <span>E-mail:</span>
                                            <span><?=$order['EMAIL']['VALUE'][0]?></span>
                                        </p>
                                    <?endif;?>
                                </div>
                            <?endif;?>

                            <?if($order['DELIVERY_PRICE'] > 0):?>
                                <div class="mb-1 sale-order-list-payment-price">
                                    <span class="sale-order-list-payment-element">Доставка:</span>
                                    <span class="sale-order-list-payment-number"><?=CurrencyFormat($order['DELIVERY_PRICE'], $order['CURRENCY'] ? $order['CURRENCY'] : 'RUB')?></span>
                                </div>
                            <?endif;?>
                            <br>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col">
                            <hr class="sale-order-list-inner-title-line">
                        </div>
                    </div>
                    <div class="row pb-3 sale-order-list-inner-row">
                        <div class="col-12 col-sm-6 sale-order-list-about-container mb-sm-0 mb-2 text-sm-left text-center">
                            <p><span>Сумма к оплате по счету:</span> <span><?=$order['TOTAL']?> <i class="fa fa-rub"><span>₽</span></i></span></p>
                        </div>
                        <?
                        if (!$order['IS_PAID'])
                        {
                            ?>
                            <div class="col-12 col-sm-6 sale-order-list-repeat-container mb-sm-0 mb-2 text-right-sm">
                                <a class="btn-primary ajax_reload js-get-payment" data-orderId="<?=$order['ID']?>" href="#">Оплатить</a>
                                <div class="js-payment-wrapper" style="display:none;"></div>
                            </div>
                            <?
                        }
                        ?>

                    </div>
                </div>
            </div>

        </div>
    </div>
<?endforeach;?>

<? require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>