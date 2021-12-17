<?
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
if(\Bitrix\Main\Loader::includeSharewareModule("krayt.retail") == \Bitrix\Main\Loader::MODULE_DEMO_EXPIRED ||
   \Bitrix\Main\Loader::includeSharewareModule("krayt.retail") ==  \Bitrix\Main\Loader::MODULE_NOT_FOUND
    )
{ return false;}


use Bitrix\Main,
	Bitrix\Main\Localization\Loc,
	Bitrix\Main\Page\Asset;

use Ttcr\Cake;

Asset::getInstance()->addJs("/bitrix/components/bitrix/sale.order.payment.change/templates/bootstrap_v4/script.js");
Asset::getInstance()->addCss("/bitrix/components/bitrix/sale.order.payment.change/templates/bootstrap_v4/style.css");
CJSCore::Init(array('clipboard', 'fx'));
Loc::loadMessages(__FILE__);
if (!empty($arResult['ERRORS']['FATAL']))
{
	foreach($arResult['ERRORS']['FATAL'] as $code => $error)
	{
		if ($code !== $component::E_NOT_AUTHORIZED)
			ShowError($error);
	}
	$component = $this->__component;
	if ($arParams['AUTH_FORM_IN_TEMPLATE'] && isset($arResult['ERRORS']['FATAL'][$component::E_NOT_AUTHORIZED]))
	{
		?>
		<div class="row">
			<div class="col-md-8 offset-md-2 col-lg-6 offset-lg-3">
				<div class="alert alert-danger"><?=$arResult['ERRORS']['FATAL'][$component::E_NOT_AUTHORIZED]?></div>
			</div>
			<? $authListGetParams = array(); ?>
			<div class="col-md-8 offset-md-2 col-lg-6 offset-lg-3" id="catalog-subscriber-auth-form" style="<?=$authStyle?>">
				<?$APPLICATION->AuthForm('', false, false, 'N', false);?>
			</div>
		</div>
		<?
	}

}
else
{
	if (!empty($arResult['ERRORS']['NONFATAL']))
	{
		foreach($arResult['ERRORS']['NONFATAL'] as $error)
		{
			ShowError($error);
		}
	}
	?>
	<div class="row mb-3">
		<div class="col">
			<?
			$nothing = !isset($_REQUEST["filter_history"]) && !isset($_REQUEST["show_all"]);
			$clearFromLink = array("filter_history","filter_status","show_all", "show_canceled");

			if ($show_history = false && $nothing || $_REQUEST["filter_history"] == 'N')
			{
				?>
				<a class="mr-4 link-green-border sale-order-link" href="<?=$APPLICATION->GetCurPageParam("filter_history=Y", $clearFromLink, false)?>"><?echo Loc::getMessage("SPOL_TPL_VIEW_ORDERS_HISTORY")?></a>
				<?
			}
			if ($_REQUEST["filter_history"] == 'Y')
			{
				?>
				<a class="mr-4 link-green-border sale-order-link" href="<?=$APPLICATION->GetCurPageParam("", $clearFromLink, false)?>"><?echo Loc::getMessage("SPOL_TPL_CUR_ORDERS")?></a>
				<?
				if ($_REQUEST["show_canceled"] == 'Y')
				{
					?>
					<a class="mr-4 link-green-border sale-order-link" href="<?=$APPLICATION->GetCurPageParam("filter_history=Y", $clearFromLink, false)?>"><?echo Loc::getMessage("SPOL_TPL_VIEW_ORDERS_HISTORY")?></a>
					<?
				}
				else
				{
					?>
					<a class="mr-4 link-green-border sale-order-link" href="<?=$APPLICATION->GetCurPageParam("filter_history=Y&show_canceled=Y", $clearFromLink, false)?>"><?echo Loc::getMessage("SPOL_TPL_VIEW_ORDERS_CANCELED")?></a>
					<?
				}
			}
			?>
		</div>
	</div>
	<?
    if (!count($arResult['ORDERS']))
    {
        if ($_REQUEST["filter_history"] == 'Y')
        {
            if ($_REQUEST["show_canceled"] == 'Y')
            {
                ?>
                <h3><?= Loc::getMessage('SPOL_TPL_EMPTY_CANCELED_ORDER')?></h3>
                <?
            }
            else
            {
                ?>
                <h3><?= Loc::getMessage('SPOL_TPL_EMPTY_HISTORY_ORDER_LIST')?></h3>
                <?
            }
        }
        else
        {
            ?>
            <h3><?= Loc::getMessage('SPOL_TPL_EMPTY_ORDER_LIST')?></h3>
            <?
        }
    }
	if (!count($arResult['ORDERS']))
	{
		?>
		<div class="row my-3">
			<div class="col">
				<a href="<?=htmlspecialcharsbx($arParams['PATH_TO_CATALOG'])?>" class="btn-primary mr-4"><?=Loc::getMessage('SPOL_TPL_LINK_TO_CATALOG')?></a>
			</div>
		</div>
		<?
	}

	if ($_REQUEST["filter_history"] !== 'Y')
	{
		$paymentChangeData = array();
		$orderHeaderStatus = null;

		foreach ($arResult['ORDERS'] as $key => $order)
		{
			if ($orderHeaderStatus !== $order['ORDER']['STATUS_ID'] && $arResult['SORT_TYPE'] == 'STATUS')
			{
				$orderHeaderStatus = $order['ORDER']['STATUS_ID'];

				?>
				<div class="row mb-3">
					<div class="col">
						<h2><?= Loc::getMessage('SPOL_TPL_ORDER_IN_STATUSES') ?> &laquo;<?=htmlspecialcharsbx($arResult['INFO']['STATUS'][$orderHeaderStatus]['NAME'])?>&raquo;</h2>
					</div>
				</div>
				<?
			}
			?>
			<div class="row mx-0 sale-order-list-title-container p-2">
				<h3 class="col mb-1 mt-1">
					<?=Loc::getMessage('SPOL_TPL_ORDER')?>
					<?=Loc::getMessage('SPOL_TPL_NUMBER_SIGN').$order['ORDER']['ACCOUNT_NUMBER']?>
					<?=Loc::getMessage('SPOL_TPL_FROM_DATE')?>
					<?=$order['ORDER']['DATE_INSERT']->format($arParams['ACTIVE_DATE_FORMAT'])?>,
					<?=count($order['BASKET_ITEMS']);?>
					<?
					$count = count($order['BASKET_ITEMS']) % 10;
					if ($count == '1')
					{
						echo Loc::getMessage('SPOL_TPL_GOOD');
					}
					elseif ($count >= '2' && $count <= '4')
					{
						echo Loc::getMessage('SPOL_TPL_TWO_GOODS');
					}
					else
					{
						echo Loc::getMessage('SPOL_TPL_GOODS');
					}
					?>
					<?=Loc::getMessage('SPOL_TPL_SUMOF')?>
					<?=$order['ORDER']['FORMATED_PRICE']?>
				</h3>
			</div>
			<div class="row mx-0 mb-5">
				<div class="col pt-3 sale-order-list-inner-container">
					<div class="row mb-3 align-items-center">
						<div class="col-auto">
							<span class="sale-order-list-inner-title-line-item"><?=Loc::getMessage('SPOL_TPL_PAYMENT')?></span>
						</div>
						<div class="col">
							<hr class="sale-order-list-inner-title-line" />
						</div>
					</div>

					<?
					$showDelimeter = false;
					foreach ($order['PAYMENT'] as $payment)
					{
						if ($order['ORDER']['LOCK_CHANGE_PAYSYSTEM'] !== 'Y')
						{
							$paymentChangeData[$payment['ACCOUNT_NUMBER']] = array(
								"order" => htmlspecialcharsbx($order['ORDER']['ACCOUNT_NUMBER']),
								"payment" => htmlspecialcharsbx($payment['ACCOUNT_NUMBER']),
								"allow_inner" => $arParams['ALLOW_INNER'],
								"refresh_prices" => $arParams['REFRESH_PRICES'],
								"path_to_payment" => $arParams['PATH_TO_PAYMENT'],
								"only_inner_full" => $arParams['ONLY_INNER_FULL']
							);
						}
						?>

						<? if ($showDelimeter)
						{
							?>
								<hr class="sale-order-list-inner-title-line mb-3" />
							<?
						}
						else
						{
							$showDelimeter = true;
						}
						?>

                        <?
                        ?>
						<div class="row mb-3 sale-order-list-inner-row">
							<div class="col sale-order-list-inner-row-body">
								<div class="row">
									<div class="col sale-order-list-payment">
										<div class="mb-1 sale-order-list-payment-title"><?
											$paymentSubTitle = Loc::getMessage('SPOL_TPL_BILL')." ".Loc::getMessage('SPOL_TPL_NUMBER_SIGN').htmlspecialcharsbx($payment['ACCOUNT_NUMBER']);
											if(isset($payment['DATE_BILL']))
											{
												$paymentSubTitle .= " ".Loc::getMessage('SPOL_TPL_FROM_DATE')." ".$payment['DATE_BILL']->format($arParams['ACTIVE_DATE_FORMAT']);
											}
											$paymentSubTitle .=",";
											$paymentSubTitle = 'Оплата заказа';
											echo $paymentSubTitle;
											/*
											?>
											<span class="sale-order-list-payment-title-element"><?=$payment['PAY_SYSTEM_NAME']?></span><?*/
											if ($payment['PAID'] === 'Y')
											{
												?>
												<span class="sale-order-list-status-success"><?=Loc::getMessage('SPOL_TPL_PAID')?></span>
												<?
											}
											elseif ($order['ORDER']['IS_ALLOW_PAY'] == 'N')
											{
												?>
												<span class="sale-order-list-status-restricted"><?=Loc::getMessage('SPOL_TPL_RESTRICTED_PAID')?></span>
												<?
											}
											else
											{
												?>
												<span class="sale-order-list-status-alert"><?=Loc::getMessage('SPOL_TPL_NOTPAID')?></span>
												<?
											}
											?>
										</div>
                                        <?
                                        $order['DATA'] = Cake::getOrder($order['ORDER']['ID']);
                                        //TODO если в 1 заказе 2 и более товара с текстами, то нужно их распределить в вывод в правильные товары
                                        $products = Cake::getProductsFromOrder($order['ORDER']['ID']);
                                        foreach($products as &$product){
                                            $product['main_props'] = Cake::formatMainProps($product);
                                        }
                                        $img_comp = $order['DATA']['IMG_COMP']['VALUE'][0];
                                        $img_comp_arr = explode('; ', $img_comp);
                                        $point_data = Cake::getPointProps($products[0]['ID']);
                                        ?>
                                        <?foreach($products as $n=>$b_item):?>
                                        <?
                                            $prod_comp = $img_comp_arr[$n];
                                            $prod_comp = trim(str_replace($b_item['NAME'].' - ', '', $prod_comp));
                                            $prod_comp_arr = explode('\\', $prod_comp); // [0] - текст для этого продукта, [1] - картинка
                                            $prod_c_img = '';
                                            foreach($order['DATA']['ADD_IMG']['VALUE'] as $c_img){
                                                if($c_img['FILE_NAME'] == trim($prod_comp_arr[1])){
                                                    $prod_c_img = $c_img;
                                                }
                                            }
                                        ?>
                                            <div class="mb-1 sale-order-list-payment-price">
                                                <span class="sale-order-list-payment-element  order-link">
                                                    <a href="<?=$b_item['DETAIL_PAGE_URL']?>"><?=$b_item['NAME']?></a></span>
                                                <span class="sale-order-list-payment-number  order-price"><?=CurrencyFormat($b_item['PRICE'], 'RUB')?> </span>
                                            </div>
                                        <?if($b_item['main_props']['props'] && $_GET['a']=='aa'):?>
                                            <?
                                            $mp_arr = [];
                                            foreach ($b_item['main_props']['props'] as $m_props){
                                                $mp_arr[] = $m_props['NAME'].': '.$m_props['VALUE'];
                                            }

                                            ?>
                                                <div class="mb-1 sale-order-list-payment-price">
                                                    <p class="f-w-b  order-title">Парамерты:</p>
                                                    <p><?=implode(', ', $mp_arr)?></p>
                                                </div>
                                          <?endif;?>
                                        <?if($prod_comp_arr[0] && $_GET['a']=='aa'):?>
                                                <div class="mb-1 sale-order-list-payment-price">
                                                    <p class="f-w-b  order-title">Текст для нанесения на торте:</p>
                                                    <p><?=$prod_comp_arr[0]?></p>
                                                </div>
                                        <?endif;?>
                                        <?if($prod_c_img && $_GET['a']=='aa'):?>
                                                <div class="mb-1 sale-order-list-payment-price">
                                                    <p class="f-w-b  order-title">Файл:</p>
                                                    <p><a href="<?=$prod_c_img['SRC']?>"><?=$prod_c_img['ORIGINAL_NAME']?></a></p>
                                                </div>
                                        <?endif;?>
                                        <?endforeach;?>

                                        <?
                                        if($order['SHIPMENT'][0]['DELIVERY_ID'] == 3){
                                            $delivery_name = 'Самовывоз';
                                        }else{
                                            $delivery_name = 'Доставка';
                                        }
                                        if($order['DATA']['DELIVERY_TIME_H']['VALUE'][0]){
                                            $d_h = $order['DATA']['DELIVERY_TIME_H']['VALUE'][0];
                                        }else{
                                            $d_h = 0;
                                        }
                                        ?>
                                        <div class="mb-1 sale-order-list-payment-price">
                                            <p class="f-w-b  order-title  order-delivery"><?=$delivery_name?></p>
                                            <p>
                                                <span>Дата и время получения: <?=$order['DATA']['DELIVERY_TIME']['VALUE'][0]?></span>
                                                <span><?=$order['DATA']['DELIVERY_TIME_H']['OPTIONS'][$d_h]?></span>
                                            </p>
                                        </div>

                                        <?if($point_data):?>
                                            <div class="mb-1 sale-order-list-payment-price">
                                                <p class="f-w-b  order-title">Адрес «<?=$point_data['name']?>»:</p>
                                                <p><?=$point_data['address']?></p>
<!--                                                <p>-->
<!--                                                </p><div class="order-title">Режим работы:</div>-->
<!--                                                <div>ежедневно 9:00 – 21:00</div>-->
                                                <p></p>
                                                <?if($order['DATA']['COMMENT']):?>
                                                    <p>
                                                        <span>Комментарий к заказу:</span>
                                                        <span><?=$order['DATA']['COMMENT']?></span>
                                                    </p>
                                                <?endif;?>
                                            </div>
                                         <?endif;?>
                                        <?if($order['DATA']['FIO']['VALUE'][0]):?>
                                            <div class="mb-1 sale-order-list-payment-price">
                                                <p class="f-w-b  order-title">Покупатель</p>
                                                <p>
                                                    <span>ФИО:</span>
                                                    <span><?=$order['DATA']['FIO']['VALUE'][0]?></span>
                                                </p>
                                                <?if($order['DATA']['PHONE']['VALUE'][0]):?>
                                                <p>
                                                    <span>Телефон:</span>
                                                    <span><?=$order['DATA']['PHONE']['VALUE'][0]?></span>
                                                </p>
                                                <?endif;?>
                                                <?if($order['DATA']['EMAIL']['VALUE'][0]):?>
                                                <p>
                                                    <span>E-mail:</span>
                                                    <span><?=$order['DATA']['EMAIL']['VALUE'][0]?></span>
                                                </p>
                                                <?endif;?>
                                            </div>
                                        <?endif;?>


                                        <?if(count($order['SHIPMENT']) && intval($order['SHIPMENT'][0]['PRICE_DELIVERY'])):?>
                                            <div class="mb-1 sale-order-list-payment-price">
                                                <span class="sale-order-list-payment-element">Доставка:</span>
                                                <span class="sale-order-list-payment-number"><?=CurrencyFormat($order['SHIPMENT'][0]['PRICE_DELIVERY'], $order['SHIPMENT'][0]['CURRENCY'] ? $order['SHIPMENT'][0]['CURRENCY'] : 'RUB')?></span>
                                            </div>
                                        <?endif;?>
                                        <br>


										<div class="mb-1 sale-order-list-payment-price">
											<span class="sale-order-list-payment-element"><?=Loc::getMessage('SPOL_TPL_SUM_TO_PAID')?>:</span>
											<span class="sale-order-list-payment-number"><?=$payment['FORMATED_SUM']?></span>
										</div>
										<? if (!empty($payment['CHECK_DATA']))
										{
											$listCheckLinks = "";
											foreach ($payment['CHECK_DATA'] as $checkInfo)
											{
												$title = Loc::getMessage('SPOL_CHECK_NUM', array('#CHECK_NUMBER#' => $checkInfo['ID']))." - ". htmlspecialcharsbx($checkInfo['TYPE_NAME']);
												if (strlen($checkInfo['LINK']))
												{
													$link = $checkInfo['LINK'];
													$listCheckLinks .= "<div><a href='$link' target='_blank'>$title</a></div>";
												}
											}
											if (strlen($listCheckLinks) > 0)
											{
												?>
												<div class="sale-order-list-payment-check">
													<div class="sale-order-list-payment-check-left"><?= Loc::getMessage('SPOL_CHECK_TITLE')?>:</div>
													<div class="sale-order-list-payment-check-left"><?=$listCheckLinks?></div>
												</div>
												<?
											}
										}
										if ($payment['PAID'] !== 'Y' && $order['ORDER']['LOCK_CHANGE_PAYSYSTEM'] !== 'Y' && false)
										{
											?>
											<a href="#" class="sale-order-list-change-payment" id="<?= htmlspecialcharsbx($payment['ACCOUNT_NUMBER']) ?>"><?= Loc::getMessage('SPOL_TPL_CHANGE_PAY_TYPE') ?></a>
											<?
										}
										if ($order['ORDER']['IS_ALLOW_PAY'] == 'N' && $payment['PAID'] !== 'Y')
										{
											?>
											<div class="sale-order-list-status-restricted-message-block">
												<span class="sale-order-list-status-restricted-message"><?=Loc::getMessage('SOPL_TPL_RESTRICTED_PAID_MESSAGE')?></span>
											</div>
											<?
										}
										?>
									</div>
									<?
									if ($payment['PAID'] === 'N' && $payment['IS_CASH'] !== 'Y')
									{
										if ($order['ORDER']['IS_ALLOW_PAY'] == 'N')
										{
											?>
											<div class="col-sm-auto sale-order-list-button-container">
												<a class="btn btn-primary disabled"><?=Loc::getMessage('SPOL_TPL_PAY')?></a>
											</div>
											<?
										}
										elseif ($payment['NEW_WINDOW'] === 'Y')
										{
											?>
											<div class="col-sm-auto  sale-order-list-button-container">
												<a class="btn btn-primary" target="_blank" href="<?=htmlspecialcharsbx($payment['PSA_ACTION_FILE'])?>"><?=Loc::getMessage('SPOL_TPL_PAY')?></a>
											</div>
											<?
										}
										else
										{
											?>
											<div class="col-sm-auto  sale-order-list-button-container">
												<a class="btn-primary ajax_reload" href="<?=htmlspecialcharsbx($payment['PSA_ACTION_FILE'])?>"><?=Loc::getMessage('SPOL_TPL_PAY')?></a>
											</div>
											<?
										}
									}
									?>
								</div>
							</div>
							<div class="col sale-order-list-inner-row-template js-payment-btn">
								<a class="sale-order-list-cancel-payment" href="">
									<i class="fa fa-long-arrow-left"></i> <?=Loc::getMessage('SPOL_CANCEL_PAYMENT')?>
								</a>
							</div>
						</div>
						<?
					}
					/*
						if (!empty($order['SHIPMENT']))
						{
							?>
							<div class="row mb-3 align-items-center">
								<div class="col-auto">
									<span class="sale-order-list-inner-title-line-item"><?=Loc::getMessage('SPOL_TPL_DELIVERY')?></span>
								</div>
								<div class="col">
									<hr class="sale-order-list-inner-title-line" />
								</div>
							</div>
							<?
						}
						$showDelimeter = false;
						foreach ($order['SHIPMENT'] as $shipment)
						{
							if (empty($shipment))
							{
								continue;
							}
							?>
							<?
							if ($showDelimeter)
							{
								?>
								<div class="row mb-3">
									<div class="col">
										<hr class="sale-order-list-inner-title-line" />
									</div>
								</div>
								<?
							}
							else
							{
								$showDelimeter = true;
							}
							?>
							<div class="row mb-3">
								<div class="col">
									<div class="mb-1 sale-order-list-shipment-title">
										<span class="sale-order-list-shipment-element">
											<?=Loc::getMessage('SPOL_TPL_LOAD')?>
											<?
											$shipmentSubTitle = Loc::getMessage('SPOL_TPL_NUMBER_SIGN').htmlspecialcharsbx($shipment['ACCOUNT_NUMBER']);
											if ($shipment['DATE_DEDUCTED'])
											{
												$shipmentSubTitle .= " ".Loc::getMessage('SPOL_TPL_FROM_DATE')." ".$shipment['DATE_DEDUCTED']->format($arParams['ACTIVE_DATE_FORMAT']);
											}

											if ($shipment['FORMATED_DELIVERY_PRICE'])
											{
												$shipmentSubTitle .= ", ".Loc::getMessage('SPOL_TPL_DELIVERY_COST')." ".$shipment['FORMATED_DELIVERY_PRICE'];
											}
											echo $shipmentSubTitle;
											?>
										</span>
										<?
										if ($shipment['DEDUCTED'] == 'Y')
										{
											?>
											<span class="sale-order-list-status-success"><?=Loc::getMessage('SPOL_TPL_LOADED');?></span>
											<?
										}
										else
										{
											?>
											<span class="sale-order-list-status-alert"><?=Loc::getMessage('SPOL_TPL_NOTLOADED');?></span>
											<?
										}
										?>
									</div>

									<div class="mb-1 sale-order-list-shipment-status">
										<span class="sale-order-list-shipment-status-item"><?=Loc::getMessage('SPOL_ORDER_SHIPMENT_STATUS');?>:</span>
										<span class="sale-order-list-shipment-status-block"><?=htmlspecialcharsbx($shipment['DELIVERY_STATUS_NAME'])?></span>
									</div>

									<?
									if (!empty($shipment['DELIVERY_ID']))
									{
										?>
										<div class="mb-1 sale-order-list-shipment-item"><?=Loc::getMessage('SPOL_TPL_DELIVERY_SERVICE')?>: <?=$arResult['INFO']['DELIVERY'][$shipment['DELIVERY_ID']]['NAME']?></div>
										<?
									}

									if (!empty($shipment['TRACKING_NUMBER']))
									{
										?>
										<div class="mb-1 sale-order-list-shipment-item">
											<span class="sale-order-list-shipment-id-name"><?=Loc::getMessage('SPOL_TPL_POSTID')?>:</span>
											<span class="sale-order-list-shipment-id"><?=htmlspecialcharsbx($shipment['TRACKING_NUMBER'])?></span>
											<span class="sale-order-list-shipment-id-icon"></span>
										</div>
										<?
									}
									?>
								</div>
								<?
								if (strlen($shipment['TRACKING_URL']) > 0)
								{
									?>
									<div class="col-md-2 col-md-offset-1 col-sm-12 sale-order-list-shipment-button-container">
										<a class="sale-order-list-shipment-button" target="_blank" href="<?=$shipment['TRACKING_URL']?>">
											<?=Loc::getMessage('SPOL_TPL_CHECK_POSTID')?>
										</a>
									</div>
									<?
								}
								?>
							</div>
							<?
						}
						*/
						?>

						<div class="row mb-3">
							<div class="col">
								<hr class="sale-order-list-inner-title-line" />
							</div>
						</div>

						<div class="row pb-3 sale-order-list-inner-row">
							<div class="col-sm-4 sale-order-list-about-container mb-sm-0 mb-2 text-sm-left text-center">
								<a class="g-font-size-15 sale-order-list-about-link link-green-border sale-order-link" href="<?=htmlspecialcharsbx($order["ORDER"]["URL_TO_DETAIL"])?>"><?=Loc::getMessage('SPOL_TPL_MORE_ON_ORDER')?></a>
							</div>
							<div class="col-sm-4 sale-order-list-repeat-container mb-sm-0 mb-2 text-center">
								<a class="g-font-size-15 sale-order-list-repeat-link link-green-border sale-order-link" href="<?=htmlspecialcharsbx($order["ORDER"]["URL_TO_COPY"])?>"><?=Loc::getMessage('SPOL_TPL_REPEAT_ORDER')?></a>
							</div>
							<?
							if ($order['ORDER']['CAN_CANCEL'] !== 'N' && $show_cancel = false) // Убираем ссылку !-----------------------
							{
								?>
								<div class="col-sm-4 sale-order-list-cancel-container text-sm-right text-center">
									<a class="g-font-size-15 sale-order-list-cancel-link" href="<?=htmlspecialcharsbx($order["ORDER"]["URL_TO_CANCEL"])?>"><?=Loc::getMessage('SPOL_TPL_CANCEL_ORDER')?></a>
								</div>
								<?
							}
							?>
						</div>
					</div>
				</div>
			<?
		}
	}
	else
	{
		$orderHeaderStatus = null;

		if ($_REQUEST["show_canceled"] === 'Y' && count($arResult['ORDERS']))
		{
			?>
			<div class="row mb-3">
				<div class="col">
					<h2><?= Loc::getMessage('SPOL_TPL_ORDERS_CANCELED_HEADER') ?></h2>
				</div>
			</div>
			<?
		}

		foreach ($arResult['ORDERS'] as $key => $order)
		{
			if ($orderHeaderStatus !== $order['ORDER']['STATUS_ID'] && $_REQUEST["show_canceled"] !== 'Y')
			{
				$orderHeaderStatus = $order['ORDER']['STATUS_ID'];
				?>
				<h2 class="sale-order-title mt-4">
					<?= Loc::getMessage('SPOL_TPL_ORDER_IN_STATUSES') ?> &laquo;<?=htmlspecialcharsbx($arResult['INFO']['STATUS'][$orderHeaderStatus]['NAME'])?>&raquo;
				</h2>
				<?
			}
			?>
			<div class="row mx-0 p-2 sale-order-list-accomplished-title-container">
				<h3 class="g-font-size-20 mb-1 mt-1 col-sm">
					<?= Loc::getMessage('SPOL_TPL_ORDER') ?>
					<?= Loc::getMessage('SPOL_TPL_NUMBER_SIGN') ?>
					<?= htmlspecialcharsbx($order['ORDER']['ACCOUNT_NUMBER'])?>
					<?= Loc::getMessage('SPOL_TPL_FROM_DATE') ?>
					<span class="text-nowrap"><?= $order['ORDER']['DATE_INSERT'] ?>,</span>
					<?= count($order['BASKET_ITEMS']); ?>
					<?
					$count = substr(count($order['BASKET_ITEMS']), -1);
					if ($count == '1')
					{
						echo Loc::getMessage('SPOL_TPL_GOOD');
					}
					elseif ($count >= '2' || $count <= '4')
					{
						echo Loc::getMessage('SPOL_TPL_TWO_GOODS');
					}
					else
					{
						echo Loc::getMessage('SPOL_TPL_GOODS');
					}
					?>
					<?= Loc::getMessage('SPOL_TPL_SUMOF') ?>
					<span class="text-nowrap"><?= $order['ORDER']['FORMATED_PRICE'] ?></span>
				</h3>
				<div class="col-sm-auto">
					<?
					if ($_REQUEST["show_canceled"] !== 'Y')
					{
						?>
						<span class="sale-order-list-accomplished-date m-0">
									<?= Loc::getMessage('SPOL_TPL_ORDER_FINISHED')?>
								</span>
						<?
					}
					else
					{
						?>
						<span class="sale-order-list-accomplished-date m-0 canceled-order">
									<?= Loc::getMessage('SPOL_TPL_ORDER_CANCELED')?>
								</span>
						<?
					}
					?>
					<span class="sale-order-list-accomplished-date m-0  "><?= $order['ORDER']['DATE_STATUS_FORMATED'] ?></span>
				</div>
			</div>
			<div class="row ml-0 mr-0 mb-5">
				<div class="col pt-3 sale-order-list-inner-container">
					<div class="row pb-3 sale-order-list-inner-row">
						<div class="col-auto col-auto sale-order-list-about-container">
							<a class="g-font-size-15 sale-order-list-about-link sale-order-link " href="<?=htmlspecialcharsbx($order["ORDER"]["URL_TO_DETAIL"])?>"><?=Loc::getMessage('SPOL_TPL_MORE_ON_ORDER')?></a>
						</div>
						<div class="col"></div>
						<div class="col-auto sale-order-list-repeat-container">
							<a class="g-font-size-15 sale-order-list-cancel-link sale-order-link    " href="<?=htmlspecialcharsbx($order["ORDER"]["URL_TO_COPY"])?>"><?=Loc::getMessage('SPOL_TPL_REPEAT_ORDER')?></a>
						</div>
					</div>
				</div>
			</div>
			<?
		}
	}

	echo $arResult["NAV_STRING"];

	if ($_REQUEST["filter_history"] !== 'Y')
	{
		$javascriptParams = array(
			"url" => CUtil::JSEscape($this->__component->GetPath().'/ajax.php'),
			"templateFolder" => CUtil::JSEscape($templateFolder),
			"templateName" => $this->__component->GetTemplateName(),
			"paymentList" => $paymentChangeData
		);
		$javascriptParams = CUtil::PhpToJSObject($javascriptParams);
		?>
		<script>
			BX.Sale.PersonalOrderComponent.PersonalOrderList.init(<?=$javascriptParams?>);
		</script>
		<?
	}
}
?>
