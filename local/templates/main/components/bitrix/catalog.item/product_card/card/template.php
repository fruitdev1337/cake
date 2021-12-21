<? if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

use \Bitrix\Main\Localization\Loc;

/**
 * @global CMain $APPLICATION
 * @var array $arParams
 * @var array $item
 * @var array $actualItem
 * @var array $minOffer
 * @var array $itemIds
 * @var array $price
 * @var array $measureRatio
 * @var bool $haveOffers
 * @var bool $showSubscribe
 * @var array $morePhoto
 * @var bool $showSlider
 * @var bool $itemHasDetailUrl
 * @var string $imgTitle
 * @var string $productTitle
 * @var string $buttonSizeClass
 * @var CatalogSectionComponent $component
 */
$item_scu = 'item_scu_'.$this->randString();
?>

<div class="product_item product-item">
    <div class="product_item_img">
        <? if ($itemHasDetailUrl): ?>
        <a class="product-item-image-wrapper" href="<?=$item['DETAIL_PAGE_URL']?>" title="<?=$imgTitle?>"
           data-entity="image-wrapper">
            <? else: ?>
            <span class="product-item-image-wrapper" data-entity="image-wrapper">
	<? endif; ?>
                <span class="product-item-image-slider-slide-container slide" id="<?=$itemIds['PICT_SLIDER']?>"
                    <?=($showSlider ? '' : 'style="display: none;"')?>
                      data-slider-interval="<?=$arParams['SLIDER_INTERVAL']?>" data-slider-wrap="true">
			<?
            if ($showSlider)
            {
                foreach ($morePhoto as $key => $photo)
                {
                    $file = CFile::ResizeImageGet($photo['ID'], array('width'=>'250', 'height'=>'250'), BX_RESIZE_IMAGE_PROPORTIONAL, true);
                    ?>
                    <span class="product-item-image-slide item <?=($key == 0 ? 'active' : '')?>" >
                        <img class="product_item_img-bg" src="<?=$file['src']?>"
                             width="<?=$file["width"]?>" height="<?=$file["height"]?>"
                             alt="<?=$productTitle?>" title="<?=$productTitle?>">
                    </span>
                    <?
                }
            }
            ?>
		</span>
                <?
                if($item['PREVIEW_PICTURE']['ID']) {
                    $file = CFile::ResizeImageGet($item['PREVIEW_PICTURE']['ID'], array('width' => '250', 'height' => '250'), BX_RESIZE_IMAGE_PROPORTIONAL, true);
                }else{
                    $file = [];
                    $file['src'] = $item['PREVIEW_PICTURE']['SRC'];
                }
                    ?>
                <span class="product-item-image-original" id="<?=$itemIds['PICT']?>" style="background-image: url('<?=$file['src']?>'); <?=($showSlider ? 'display: none;' : '')?>"></span>
                <?
                if ($item['SECOND_PICT'])
                {
                    $bgImage = !empty($item['PREVIEW_PICTURE_SECOND']) ? $item['PREVIEW_PICTURE_SECOND']['SRC'] : $item['PREVIEW_PICTURE']['SRC'];

                    ?>
                    <span class="product-item-image-alternative" id="<?=$itemIds['SECOND_PICT']?>">
                        <img class="product_item_img-bg" src="<?=$file['src']?>"
                             width="<?=$file["width"]?>" height="<?=$file["height"]?>"
                             alt="<?=$productTitle?>" title="<?=$productTitle?>">
                    </span>
                    <?
                }

                ?>
                <span class="product-item-image-slider-control-container" id="<?=$itemIds['PICT_SLIDER']?>_indicator"
                    <?=($showSlider ? '' : 'style="display: none;"')?>>
			<?
            if ($showSlider)
            {
                foreach ($morePhoto as $key => $photo)
                {
                    ?>
                    <span class="product-item-image-slider-control<?=($key == 0 ? ' active' : '')?>" data-go-to="<?=$key?>"></span>
                    <?
                }
            }
            ?>
		</span>
                <?
                if ($arParams['SLIDER_PROGRESS'] === 'Y')
                {
                    ?>
                    <span class="product-item-image-slider-progress-bar-container">
				<span class="product-item-image-slider-progress-bar" id="<?=$itemIds['PICT_SLIDER']?>_progress_bar" style="width: 0;"></span>
			</span>
                    <?
                }
                ?>
                <? if ($itemHasDetailUrl): ?>
        </a>
    <? else: ?>
        </span>
    <? endif; ?>

        <div class="product_card-flags <?=$labelPositionClass?>" id="<?=$itemIds['STICKER_ID']?>">
            <?
            if ($item['LABEL'])
            {
                ?>
                <?
                if (!empty($item['LABEL_ARRAY_VALUE']))
                {
                    foreach ($item['LABEL_ARRAY_VALUE'] as $code => $value)
                    {
                        ?>
                        <div class="flag-item <?=strtolower($code);?><?=(!isset($item['LABEL_PROP_MOBILE'][$code]) ? ' hidden-xs' : '')?>">
                            <span class="flag-icon"></span>
                            <span title="<?=$value?>"><?=$value?></span>
                        </div>
                        <?
                    }
                }
                ?>
                <?
            }
            ?>
        </div>

        <?

        if ($arParams['SHOW_DISCOUNT_PERCENT'] === 'Y')
        {
            ?>
            <div class="product-item-label-ring <?=$discountPositionClass?>" id="<?=$itemIds['DSC_PERC']?>"
                <?=($price['PERCENT'] > 0 ? '' : 'style="display: none;"')?>>
                <span><?=-$price['PERCENT']?>%</span>
            </div>
            <?
        }
        ?>

        <div class="product_item__ico favour-in to_favorites" data-cookieid="<?= $item['ID']; ?>" onclick ="dataLayer.push({'event': 'favourites'});">
            <svg class="heart" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" id="Capa_1" x="0px" y="0px" viewBox="0 0 471.701 471.701" style="enable-background:new 0 0 471.701 471.701;" xml:space="preserve" width="20px" height="20px">
                            <g>
                                <path d="M433.601,67.001c-24.7-24.7-57.4-38.2-92.3-38.2s-67.7,13.6-92.4,38.3l-12.9,12.9l-13.1-13.1   c-24.7-24.7-57.6-38.4-92.5-38.4c-34.8,0-67.6,13.6-92.2,38.2c-24.7,24.7-38.3,57.5-38.2,92.4c0,34.9,13.7,67.6,38.4,92.3   l187.8,187.8c2.6,2.6,6.1,4,9.5,4c3.4,0,6.9-1.3,9.5-3.9l188.2-187.5c24.7-24.7,38.3-57.5,38.3-92.4   C471.801,124.501,458.301,91.701,433.601,67.001z M414.401,232.701l-178.7,178l-178.3-178.3c-19.6-19.6-30.4-45.6-30.4-73.3   s10.7-53.7,30.3-73.2c19.5-19.5,45.5-30.3,73.1-30.3c27.7,0,53.8,10.8,73.4,30.4l22.6,22.6c5.3,5.3,13.8,5.3,19.1,0l22.4-22.4   c19.6-19.6,45.7-30.4,73.3-30.4c27.6,0,53.6,10.8,73.2,30.3c19.6,19.6,30.3,45.6,30.3,73.3   C444.801,187.101,434.001,213.101,414.401,232.701z"/>
                            </g>
                <g>
                </g>
                <g>
                </g>
                <g>
                </g>
                <g>
                </g>
                <g>
                </g>
                <g>
                </g>
                <g>
                </g>
                <g>
                </g>
                <g>
                </g>
                <g>
                </g>
                <g>
                </g>
                <g>
                </g>
                <g>
                </g>
                <g>
                </g>
                <g>
                </g>
</svg>
                        <svg class="heart active" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" id="Capa_1" x="0px" y="0px" width="20px" height="20px" viewBox="0 0 32 32" style="enable-background:new 0 0 32 32;" xml:space="preserve">
                            <g>
                                <g>
                                    <path d="M14.708,15.847C14.252,14.864,14,13.742,14,12.5s0.252-2.489,0.708-3.659c0.455-1.171,1.114-2.266,1.929-3.205    c0.814-0.938,1.784-1.723,2.86-2.271C20.574,2.814,21.758,2.5,23,2.5s2.426,0.252,3.503,0.707c1.077,0.456,2.046,1.115,2.86,1.929    c0.813,0.814,1.474,1.784,1.929,2.861C31.749,9.073,32,10.258,32,11.5s-0.252,2.427-0.708,3.503    c-0.455,1.077-1.114,2.047-1.929,2.861C28.55,18.678,17.077,29.044,16,29.5l0,0l0,0C14.923,29.044,3.45,18.678,2.636,17.864    c-0.814-0.814-1.473-1.784-1.929-2.861C0.252,13.927,0,12.742,0,11.5s0.252-2.427,0.707-3.503C1.163,6.92,1.821,5.95,2.636,5.136    C3.45,4.322,4.42,3.663,5.497,3.207C6.573,2.752,7.757,2.5,9,2.5s2.427,0.314,3.503,0.863c1.077,0.55,2.046,1.334,2.861,2.272    c0.814,0.939,1.473,2.034,1.929,3.205C17.748,10.011,18,11.258,18,12.5s-0.252,2.364-0.707,3.347    c-0.456,0.983-1.113,1.828-1.929,2.518" fill="#600B3F"/>
                                </g>
                            </g>
                            <g>
                            </g>
                            <g>
                            </g>
                            <g>
                            </g>
                            <g>
                            </g>
                            <g>
                            </g>
                            <g>
                            </g>
                            <g>
                            </g>
                            <g>
                            </g>
                            <g>
                            </g>
                            <g>
                            </g>
                            <g>
                            </g>
                            <g>
                            </g>
                            <g>
                            </g>
                            <g>
                            </g>
                            <g>
                            </g>
                        </svg>
        </div>

        <div class="fast_view btn-primary"  data-href="<?=$item['DETAIL_PAGE_URL']?>">
            <span class="title"><?=GetMessage('FAST_VIEW_TITLE');?></span>
        </div>
    </div>

    <div class="product_item_name_box">
        <div class="product_item_title">
            <? if ($itemHasDetailUrl): ?>
            <a href="<?=$item['DETAIL_PAGE_URL']?>" title="<?=$productTitle?>">
                <? endif; ?>
                <div class="name"><?=$productTitle?></div>
                <? if ($itemHasDetailUrl): ?>
            </a>
        <? endif; ?>
        </div>

        <?
        if ($arParams['PRODUCT_DISPLAY_MODE'] === 'Y' && $haveOffers && !empty($item['OFFERS_PROP']))
        {
            ?>
            <div class="product-item-info-container product-item-hidden" id="<?=$itemIds['PROP_DIV']?>">
                <?
                foreach ($arParams['SKU_PROPS'] as $skuProperty)
                {
                    $propertyId = $skuProperty['ID'];
                    $skuProperty['NAME'] = htmlspecialcharsbx($skuProperty['NAME']);
                    if (!isset($item['SKU_TREE_VALUES'][$propertyId]))
                        continue;
                    ?>
                    <div class="product_item_sku" data-entity="sku-block">
                        <div class="product-item-scu-container" data-entity="sku-line-block">
                            <!--                        <div class="product-item-scu-block-title text-muted">--><?//=$skuProperty['NAME']?><!--</div>-->
                            <div class="product-item-scu-block">
                                <div class="product-item-scu-list<?
                                if(count($skuProperty['VALUES']) > 5){?> wrapper-select-block" id="<?=$item_scu?><?}?>">
                                    <span class="select-val">Выберите <?=strtolower($skuProperty['NAME'])?>:</span>
                                    <ul class="product-item-scu-item-list<?
                                    if(count($skuProperty['VALUES']) > 5){?> select-block<?}?>">
                                        <?
                                        foreach ($skuProperty['VALUES'] as $value)
                                        {
                                            if (!isset($item['SKU_TREE_VALUES'][$propertyId][$value['ID']]))
                                                continue;

                                            $value['NAME'] = htmlspecialcharsbx($value['NAME']);

                                            if ($skuProperty['SHOW_MODE'] === 'PICT' && $skuProperty['CODE'] != 'WEIGHT' && $skuProperty['CODE'] != 'NUMBER_LAYERS')
                                            {
                                                ?>
                                                <li class="product-item-scu-item-color-container" title="<?=$value['NAME']?>" data-treevalue="<?=$propertyId?>_<?=$value['ID']?>" data-onevalue="<?=$value['ID']?>">
                                                    <div class="product-item-scu-item-color-block product-item-scu-item">
                                                        <div class="product-item-scu-item-color select-item" title="<?=$value['NAME']?>" style="background-image: url('<?=$value['PICT']['SRC']?>');"></div>
                                                    </div>
                                                </li>
                                                <?
                                            }
                                            else
                                            {
                                                ?>
                                                <li class="product-item-scu-item-text-container" title="<?=$value['NAME']?>"
                                                    data-treevalue="<?=$propertyId?>_<?=$value['ID']?>" data-onevalue="<?=$value['ID']?>">
                                                    <div class="product-item-scu-item-text-block product-item-scu-item">
                                                        <div class="product-item-scu-item-text select-item"><?=$value['NAME']?></div>
                                                    </div>
                                                </li>
                                                <?
                                            }
                                        }
                                        ?>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?
                }
                ?>
            </div>
            <?
            foreach ($arParams['SKU_PROPS'] as $skuProperty)
            {
                if (!isset($item['OFFERS_PROP'][$skuProperty['CODE']]))
                    continue;

                $skuProps[] = array(
                    'ID' => $skuProperty['ID'],
                    'SHOW_MODE' => $skuProperty['SHOW_MODE'],
                    'VALUES' => $skuProperty['VALUES'],
                    'VALUES_COUNT' => $skuProperty['VALUES_COUNT']
                );
            }

            unset($skuProperty, $value);

            if ($item['OFFERS_PROPS_DISPLAY'])
            {
                foreach ($item['JS_OFFERS'] as $keyOffer => $jsOffer)
                {
                    $strProps = '';

                    if (!empty($jsOffer['DISPLAY_PROPERTIES']))
                    {
                        foreach ($jsOffer['DISPLAY_PROPERTIES'] as $displayProperty)
                        {
                            $strProps .= '<dt>'.$displayProperty['NAME'].'</dt><dd>'
                                .(is_array($displayProperty['VALUE'])
                                    ? implode(' / ', $displayProperty['VALUE'])
                                    : $displayProperty['VALUE'])
                                .'</dd>';
                        }
                    }

                    $item['JS_OFFERS'][$keyOffer]['DISPLAY_PROPERTIES'] = $strProps;
                }
                unset($jsOffer, $strProps);
            }
        }?>

        <div class="product_item_buy_box">
            <div class="row align-items-center">
                <div class="col-md-auto col-12 price-block-col">
                    <div class="product_item__price" data-entity="price-block">
                        <div class="price product-item-price-current">
                            <?
                            if (!empty($price))
                            {
                                if ($arParams['PRODUCT_DISPLAY_MODE'] === 'N' && $haveOffers)
                                {?>
									<?/*
                                    <div class="price-unit">
                                        <span id="<?=$itemIds['PRICE']?>"><?echo Loc::getMessage(
                                                'CT_BCI_TPL_MESS_PRICE_SIMPLE_MODE',
                                                array(
                                                    '#PRICE#' => $price['PRINT_RATIO_PRICE'],
                                                    '#VALUE#' => $measureRatio,
                                                    '#UNIT#' => $minOffer['ITEM_MEASURE']['TITLE']
                                                )
                                            );?>
                                        </span>
                                    </div>
									*/?>
                                    <span id="<?=$itemIds['PRICE']?>"><?echo Loc::getMessage('CT_BCI_TPL_MESS_PRICE_SIMPLE_MODE', array('#PRICE#' => $price['PRINT_RATIO_PRICE']))?></span>
									<div class="price-unit">
										<?=Loc::getMessage('K_TITLE_WEIGHT');?> <span id="<?=$itemIds['QUANTITY_MEASURE']?>"><?
											//echo $measureRatio.' '.$actualItem['ITEM_MEASURE']['TITLE'];
											if($actualItem['CATALOG_WEIGHT'] < 1000)
												echo $actualItem['CATALOG_WEIGHT'] .' '. Loc::getMessage('K_TITLE_WEIGHT_GRAMM') ;
											else
												echo number_format($actualItem['CATALOG_WEIGHT'] / 1000, 2, '.', ' ') .' '. Loc::getMessage('K_TITLE_WEIGHT_KG') ;
											?>
										</span>
                                    </div>
                                    <?
                                }
                                else
                                {?>
                                    <span id="<?=$itemIds['PRICE']?>"><?echo $price['PRINT_RATIO_PRICE'];?></span>
                                    <div class="price-unit">
										<?=Loc::getMessage('K_TITLE_WEIGHT');?> <span id="<?=$itemIds['QUANTITY_MEASURE']?>"><?
											//echo $measureRatio.' '.$actualItem['ITEM_MEASURE']['TITLE'];
											if($actualItem['CATALOG_WEIGHT'] < 1000)
												echo $actualItem['CATALOG_WEIGHT'] .' '. Loc::getMessage('K_TITLE_WEIGHT_GRAMM') ;
											else
												echo number_format($actualItem['CATALOG_WEIGHT'] / 1000, 2, '.', ' ') .' '. Loc::getMessage('K_TITLE_WEIGHT_KG') ;
											?>
										</span>
                                    </div><?
                                }
                            }
                            ?>
                        </div>
                        <?
                        if ($arParams['SHOW_OLD_PRICE'] === 'Y')
                        {
                            ?>
                            <div class="old_price product-item-price-old"
                                <?=($price['RATIO_PRICE'] >= $price['RATIO_BASE_PRICE'] ? 'style="display: none;"' : '')?>>
                                <span id="<?=$itemIds['PRICE_OLD']?>"><?=$price['PRINT_RATIO_BASE_PRICE']?></span>
                            </div>
                            <?
                        }
                        ?>
                    </div>
                </div>
                <div class="col-md col-12 pl-md-0 pl-3 btn-block-col">
                    <div  class="product_item__cart product_item__cart-<?= $item['ID']; ?>"
                          data-measure="<?=$item['ITEM_MEASURE']['TITLE']?>"
                          data-entity="buttons-block">
                        <?
                        if (!$haveOffers)
                        {
                            if ($actualItem['CAN_BUY'])
                            {
                                ?>
                                <div class="product-item-button-container" id="<?=$itemIds['BASKET_ACTIONS']?>">
                                    <button class="basket_icon btn-primary btn-buy" id="<?=$itemIds['BUY_LINK']?>"
                                            rel="nofollow" onclick ="dataLayer.push({'event': 'korzina'});">
                                        <span class="img_basket"></span>
                                        <span><?=($arParams['ADD_TO_BASKET_ACTION'] === 'BUY' ? $arParams['MESS_BTN_BUY'] : $arParams['MESS_BTN_ADD_TO_BASKET'])?></span>
                                    </button>
                                </div>
                                <?
                                if ($arParams['USE_PRODUCT_QUANTITY'])
                                {
                                    ?>
                                    <div class="product-item-quantity-block" data-entity="quantity-block">
                                        <div class="product-item-amount">
                                            <div class="product-item-amount-field-container">
                                                <span class="product-item-amount-field-btn-minus no-select" id="<?=$itemIds['QUANTITY_DOWN']?>"></span>
                                                <span class="count_input">
                                                    <input class="product-item-amount-field" id="<?=$itemIds['QUANTITY']?>" type="text"
                                                           name="<?=$arParams['PRODUCT_QUANTITY_VARIABLE']?>"
                                                           data-min="<?=$measureRatio?>"
                                                           value="<?=$measureRatio?>">
                                                    <span style="display: none;" id="<?=$itemIds['QUANTITY_MEASURE']?>_f"><?=$actualItem['ITEM_MEASURE']['TITLE']?></span>
                                                </span>
                                                <span class="product-item-amount-field-btn-plus no-select" id="<?=$itemIds['QUANTITY_UP']?>"></span>
                                                <span class="product-item-amount-description-container" style="display: none;">
                                        <span id="<?=$itemIds['QUANTITY_MEASURE']?>">
                                            <?=$actualItem['ITEM_MEASURE']['TITLE']?>
                                        </span>
                                        <span id="<?=$itemIds['PRICE_TOTAL']?>"></span>
                                    </span>
                                            </div>
                                        </div>
                                    </div>
                                    <?
                                }
                            }
                            else
                            {
                                ?>
                                <div class="product-item-button-container">
                                    <?
                                    if ($showSubscribe)
                                    {
                                        $APPLICATION->IncludeComponent(
                                            'bitrix:catalog.product.subscribe',
                                            '',
                                            array(
                                                'PRODUCT_ID' => $actualItem['ID'],
                                                'BUTTON_ID' => $itemIds['SUBSCRIBE_LINK'],
                                                'BUTTON_CLASS' => 'btn btn-primary '.$buttonSizeClass,
                                                'DEFAULT_DISPLAY' => true,
                                                'MESS_BTN_SUBSCRIBE' => $arParams['~MESS_BTN_SUBSCRIBE'],
                                            ),
                                            $component,
                                            array('HIDE_ICONS' => 'Y')
                                        );
                                    }
                                    ?>
                                    <a class="basket_icon btn btn-not-avaliable"
                                       id="<?=$itemIds['NOT_AVAILABLE_MESS']?>" href="javascript:void(0)" rel="nofollow">
                                        <span class="img_basket fa fa-ban"></span>
                                        <span><?=$arParams['MESS_NOT_AVAILABLE']?></span>
                                    </a>
                                </div>
                                <?
                            }
                        }
                        else
                        {
                            if ($arParams['PRODUCT_DISPLAY_MODE'] === 'Y')
                            {
                                ?>
                                <div class="product-item-button-container">
                                    <?
                                    if ($showSubscribe)
                                    {
                                        $APPLICATION->IncludeComponent(
                                            'bitrix:catalog.product.subscribe',
                                            '',
                                            array(
                                                'PRODUCT_ID' => $item['ID'],
                                                'BUTTON_ID' => $itemIds['SUBSCRIBE_LINK'],
                                                'BUTTON_CLASS' => 'btn btn-primary '.$buttonSizeClass,
                                                'DEFAULT_DISPLAY' => !$actualItem['CAN_BUY'],
                                                'MESS_BTN_SUBSCRIBE' => $arParams['~MESS_BTN_SUBSCRIBE'],
                                            ),
                                            $component,
                                            array('HIDE_ICONS' => 'Y')
                                        );
                                    }
                                    ?>
                                    <button class="btn btn-link"
                                            id="<?=$itemIds['NOT_AVAILABLE_MESS']?>" href="javascript:void(0)" rel="nofollow"
                                        <?=($actualItem['CAN_BUY'] ? 'style="display: none;"' : '')?>>
                                        <span class="img_basket"></span>
                                        <span><?=$arParams['MESS_NOT_AVAILABLE']?></span>
                                    </button>
                                    <div id="<?=$itemIds['BASKET_ACTIONS']?>" <?=($actualItem['CAN_BUY'] ? '' : 'style="display: none;"')?>>
                                        <button class="basket_icon btn-primary btn-buy" id="<?=$itemIds['BUY_LINK']?>"
                                                rel="nofollow">
                                            <span class="img_basket"></span>
                                            <span><?=($arParams['ADD_TO_BASKET_ACTION'] === 'BUY' ? $arParams['MESS_BTN_BUY'] : $arParams['MESS_BTN_ADD_TO_BASKET'])?></span>
                                        </button>
                                    </div>
                                </div>
                                <?
                                if ($arParams['USE_PRODUCT_QUANTITY'])
                                {
                                    ?>
                                    <div class="product-item-quantity-block" data-entity="quantity-block">
                                        <div class="product-item-amount">
                                            <div class="product-item-amount-field-container">
                                                <span class="product-item-amount-field-btn-minus no-select" id="<?=$itemIds['QUANTITY_DOWN']?>"></span>
                                                <span class="count_input">
                                                    <input class="product-item-amount-field" id="<?=$itemIds['QUANTITY']?>" type="text"
                                                           name="<?=$arParams['PRODUCT_QUANTITY_VARIABLE']?>"
                                                           data-min="<?=$measureRatio?>"
                                                           value="<?=$measureRatio?>">
											            <span style="display: none;" id="<?=$itemIds['QUANTITY_MEASURE']?>_f"><?=$actualItem['ITEM_MEASURE']['TITLE']?></span>
                                                </span>
                                                <span class="product-item-amount-field-btn-plus no-select" id="<?=$itemIds['QUANTITY_UP']?>"></span>
                                                <span class="product-item-amount-description-container" style="display: none;">
											<span id="<?=$itemIds['PRICE_TOTAL']?>"></span>
										</span>
                                            </div>
                                        </div>
                                    </div>
                                    <?
                                }
                            }
                            else
                            {
                                ?>
                                <div class="product-item-button-container">
                                    <a class="btn btn-primary offers-item-link" href="<?=$item['DETAIL_PAGE_URL']?>">
                                        <span><?=$arParams['MESS_BTN_DETAIL']?></span>
                                        <span class="fa fa-angle-right"></span>
                                    </a>
                                </div>
                                <?
                            }
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?
    if (
        $arParams['DISPLAY_COMPARE']
        && (!$haveOffers || $arParams['PRODUCT_DISPLAY_MODE'] === 'Y')
    )
    {
        ?>
        <div style="display: none;"  class="product-item-compare-container">
            <div class="product-item-compare">
                <div class="checkbox">
                    <label id="<?=$itemIds['COMPARE_LINK']?>">
                        <input type="checkbox" data-entity="compare-checkbox">
                        <span data-entity="compare-title"><?=$arParams['MESS_BTN_COMPARE']?></span>
                    </label>
                </div>
            </div>
        </div>
        <?
    }
    ?>
</div>

<script>

</script>