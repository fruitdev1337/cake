<? if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

use \Bitrix\Main\Localization\Loc;

/**
 * @global CMain $APPLICATION
 * @var array $arParams
 * @var array $arResult
 * @var CatalogSectionComponent $component
 * @var CBitrixComponentTemplate $this
 * @var string $templateName
 * @var string $componentPath
 * @var string $templateFolder
 */

$this->setFrameMode(true);

$templateLibrary = array('popup', 'fx');
$currencyList = '';
if (!empty($arResult['CURRENCIES']))
{
    $templateLibrary[] = 'currency';
    $currencyList = CUtil::PhpToJSObject($arResult['CURRENCIES'], false, true, true);
}

$templateData = array(
    'TEMPLATE_THEME' => $arParams['TEMPLATE_THEME'],
    'TEMPLATE_LIBRARY' => $templateLibrary,
    'CURRENCIES' => $currencyList,
    'ITEM' => array(
        'ID' => $arResult['ID'],
        'IBLOCK_ID' => $arResult['IBLOCK_ID'],
        'OFFERS_SELECTED' => $arResult['OFFERS_SELECTED'],
        'JS_OFFERS' => $arResult['JS_OFFERS']
    )
);
unset($currencyList, $templateLibrary);

$mainId = $this->GetEditAreaId($arResult['ID']);
$itemIds = array(
    'ID' => $mainId,
    'DISCOUNT_PERCENT_ID' => $mainId.'_dsc_pict',
    'STICKER_ID' => $mainId.'_sticker',
    'BIG_SLIDER_ID' => $mainId.'_big_slider',
    'BIG_IMG_CONT_ID' => $mainId.'_bigimg_cont',
    'SLIDER_CONT_ID' => $mainId.'_slider_cont',
    'SLIDER_THUMB' => $mainId.'_slider',
    'OLD_PRICE_ID' => $mainId.'_old_price',
    'PRICE_ID' => $mainId.'_price',
    'DISCOUNT_PRICE_ID' => $mainId.'_price_discount',
    'PRICE_TOTAL' => $mainId.'_price_total',
    'SLIDER_CONT_OF_ID' => $mainId.'_slider_cont_',
    'QUANTITY_ID' => $mainId.'_quantity',
    'QUANTITY_DOWN_ID' => $mainId.'_quant_down',
    'QUANTITY_UP_ID' => $mainId.'_quant_up',
    'QUANTITY_MEASURE' => $mainId.'_quant_measure',
    'QUANTITY_LIMIT' => $mainId.'_quant_limit',
    'BUY_LINK' => $mainId.'_buy_link',
    'ADD_BASKET_LINK' => $mainId.'_add_basket_link',
    'BASKET_ACTIONS_ID' => $mainId.'_basket_actions',
    'NOT_AVAILABLE_MESS' => $mainId.'_not_avail',
    'COMPARE_LINK' => $mainId.'_compare_link',
    'TREE_ID' => $mainId.'_skudiv',
    'DISPLAY_PROP_DIV' => $mainId.'_sku_prop',
    'DISPLAY_MAIN_PROP_DIV' => $mainId.'_main_sku_prop',
    'OFFER_GROUP' => $mainId.'_set_group_',
    'BASKET_PROP_DIV' => $mainId.'_basket_prop',
    'SUBSCRIBE_LINK' => $mainId.'_subscribe',
    'TABS_ID' => $mainId.'_tabs',
    'TAB_CONTAINERS_ID' => $mainId.'_tab_containers',
    'SMALL_CARD_PANEL_ID' => $mainId.'_small_card_panel',
    'TABS_PANEL_ID' => $mainId.'_tabs_panel',
	'DISPLAY_READY_TIME_DIV' => $mainId.'_sku_prop_ready_time',
	'DISPLAY_PRICE_PER_KG_DIV' => $mainId.'_sku_prop_price_per_kg',
);
$obName = $templateData['JS_OBJ'] = 'ob'.preg_replace('/[^a-zA-Z0-9_]/', 'x', $mainId);
$name = !empty($arResult['IPROPERTY_VALUES']['ELEMENT_PAGE_TITLE'])
    ? $arResult['IPROPERTY_VALUES']['ELEMENT_PAGE_TITLE']
    : $arResult['NAME'];
$title = !empty($arResult['IPROPERTY_VALUES']['ELEMENT_DETAIL_PICTURE_FILE_TITLE'])
    ? $arResult['IPROPERTY_VALUES']['ELEMENT_DETAIL_PICTURE_FILE_TITLE']
    : $arResult['NAME'];
$alt = !empty($arResult['IPROPERTY_VALUES']['ELEMENT_DETAIL_PICTURE_FILE_ALT'])
    ? $arResult['IPROPERTY_VALUES']['ELEMENT_DETAIL_PICTURE_FILE_ALT']
    : $arResult['NAME'];

$haveOffers = !empty($arResult['OFFERS']);
if ($haveOffers)
{
    $actualItem = isset($arResult['OFFERS'][$arResult['OFFERS_SELECTED']])
        ? $arResult['OFFERS'][$arResult['OFFERS_SELECTED']]
        : reset($arResult['OFFERS']);
    $showSliderControls = false;

    foreach ($arResult['OFFERS'] as $offer)
    {
        if ($offer['MORE_PHOTO_COUNT'] >= 1)
        {
            $showSliderControls = true;
            break;
        }
    }
}
else
{
    $actualItem = $arResult;
    $showSliderControls = $arResult['MORE_PHOTO_COUNT'] >= 1;
}

$skuProps = array();
$price = $actualItem['ITEM_PRICES'][$actualItem['ITEM_PRICE_SELECTED']];
$measureRatio = $actualItem['ITEM_MEASURE_RATIOS'][$actualItem['ITEM_MEASURE_RATIO_SELECTED']]['RATIO'];
$showDiscount = $price['PERCENT'] > 0;

$showDescription = !empty($arResult['PREVIEW_TEXT']) || !empty($arResult['DETAIL_TEXT']);
$showBuyBtn = in_array('BUY', $arParams['ADD_TO_BASKET_ACTION']);
$buyButtonClassName = in_array('BUY', $arParams['ADD_TO_BASKET_ACTION_PRIMARY']) ? 'btn-primary' : 'btn-link';
$showAddBtn = in_array('ADD', $arParams['ADD_TO_BASKET_ACTION']);
$showButtonClassName = in_array('ADD', $arParams['ADD_TO_BASKET_ACTION_PRIMARY']) ? 'btn-primary' : 'btn-link';
$showSubscribe = $arParams['PRODUCT_SUBSCRIPTION'] === 'Y' && ($arResult['CATALOG_SUBSCRIBE'] === 'Y' || $haveOffers);

$arParams['MESS_BTN_BUY'] = $arParams['MESS_BTN_BUY'] ?: Loc::getMessage('CT_BCE_CATALOG_BUY');
$arParams['MESS_BTN_ADD_TO_BASKET'] = $arParams['MESS_BTN_ADD_TO_BASKET'] ?: Loc::getMessage('CT_BCE_CATALOG_ADD');
$arParams['MESS_NOT_AVAILABLE'] = $arParams['MESS_NOT_AVAILABLE'] ?: Loc::getMessage('CT_BCE_CATALOG_NOT_AVAILABLE');
$arParams['MESS_BTN_COMPARE'] = $arParams['MESS_BTN_COMPARE'] ?: Loc::getMessage('CT_BCE_CATALOG_COMPARE');
$arParams['MESS_PRICE_RANGES_TITLE'] = $arParams['MESS_PRICE_RANGES_TITLE'] ?: Loc::getMessage('CT_BCE_CATALOG_PRICE_RANGES_TITLE');
$arParams['MESS_DESCRIPTION_TAB'] = $arParams['MESS_DESCRIPTION_TAB'] ?: Loc::getMessage('CT_BCE_CATALOG_DESCRIPTION_TAB');
$arParams['MESS_PROPERTIES_TAB'] = $arParams['MESS_PROPERTIES_TAB'] ?: Loc::getMessage('CT_BCE_CATALOG_PROPERTIES_TAB');
$arParams['MESS_COMMENTS_TAB'] = $arParams['MESS_COMMENTS_TAB'] ?: Loc::getMessage('CT_BCE_CATALOG_COMMENTS_TAB');
$arParams['MESS_SHOW_MAX_QUANTITY'] = $arParams['MESS_SHOW_MAX_QUANTITY'] ?: Loc::getMessage('CT_BCE_CATALOG_SHOW_MAX_QUANTITY');
$arParams['MESS_RELATIVE_QUANTITY_MANY'] = $arParams['MESS_RELATIVE_QUANTITY_MANY'] ?: Loc::getMessage('CT_BCE_CATALOG_RELATIVE_QUANTITY_MANY');
$arParams['MESS_RELATIVE_QUANTITY_FEW'] = $arParams['MESS_RELATIVE_QUANTITY_FEW'] ?: Loc::getMessage('CT_BCE_CATALOG_RELATIVE_QUANTITY_FEW');

$positionClassMap = array(
    'left' => 'product-item-label-left',
    'center' => 'product-item-label-center',
    'right' => 'product-item-label-right',
    'bottom' => 'product-item-label-bottom',
    'middle' => 'product-item-label-middle',
    'top' => 'product-item-label-top'
);

$discountPositionClass = 'product-item-label-small';
if ($arParams['SHOW_DISCOUNT_PERCENT'] === 'Y' && !empty($arParams['DISCOUNT_PERCENT_POSITION']))
{
    foreach (explode('-', $arParams['DISCOUNT_PERCENT_POSITION']) as $pos)
    {
        $discountPositionClass .= isset($positionClassMap[$pos]) ? ' '.$positionClassMap[$pos] : '';
    }
}

$labelPositionClass = 'product-item-label-big';
if (!empty($arParams['LABEL_PROP_POSITION']))
{
    foreach (explode('-', $arParams['LABEL_PROP_POSITION']) as $pos)
    {
        $labelPositionClass .= isset($positionClassMap[$pos]) ? ' '.$positionClassMap[$pos] : '';
    }
}

$themeClass = isset($arParams['TEMPLATE_THEME']) ? ' bx-'.$arParams['TEMPLATE_THEME'] : '';

if(!empty($actualItem['PRODUCT']['WEIGHT'])){
	$price_per_kg = ($price["RATIO_PRICE"] / $actualItem['PRODUCT']['WEIGHT']) * 1000;
	$price_per_kg = number_format($price_per_kg, 0, '', ' ');
}
?>

    <div class="bx-catalog-element<?=$themeClass?> product_item__cart-<?=isset($arResult['JS_OFFERS'][0])?$arResult['JS_OFFERS'][0]['ID']:$arResult['ID']?>" id="<?=$itemIds['ID']?>" itemscope itemtype="http://schema.org/Product"
         data-measure="<?=$actualItem['ITEM_MEASURE']['TITLE']?>">

        <div class="visible-xs product_card__title">
            <?
            if ($arParams['DISPLAY_NAME'] === 'Y')
            {
                ?>
                <h1 class="mb-1"><?=$name?></h1>
                <?
            }
            ?>
            <div class="row">
                <div class="col">
                    <div class="product_rating">
                        <span class="count_title"><?=Loc::getMessage('K_RATING_TITLE');?></span>
                        <span><?=getStars($arResult['PROPERTIES']['PRODUCT_RATING']['VALUE']*2)?></span>
                        <span class="count_rating">(<?=$arResult['PROPERTIES']['PRODUCT_RATING']['VALUE']?>)</span>
                    </div>
                    <?if( $arResult['DISPLAY_PROPERTIES']['TIME_MANUFACTURING']['VALUE'] && $arResult['MOD_TIME_READY_NEW']):?>
                        <div class="product_time">
                            <?=Loc::getMessage("MESS_PRODUCTION_TIME")?> <span><?echo $arResult['DISPLAY_PROPERTIES']['TIME_MANUFACTURING']['VALUE']?> <?echo format_by_count($arResult['DISPLAY_PROPERTIES']['TIME_MANUFACTURING']['VALUE'], "час", "часа", "часов")?></span>
                        </div>

                        <div class="ready-time" id="<?=$itemIds['DISPLAY_READY_TIME_DIV']?>">
                            <?
//                            $dateTime = new \Bitrix\Main\Type\DateTime();
//                            if(!empty($arResult['MOD_TIME_READY'])){
//                                $dateTime->add($arResult['MOD_TIME_READY']. " hours");
//                            }
//                            else{
//                                $dateTime->add($arResult['DISPLAY_PROPERTIES']['TIME_MANUFACTURING']['VALUE']. " hours");
//                            }
                            $dateTime = $arResult['MOD_TIME_READY_NEW'];
                            $time = $dateTime->format("Y-m-d H:i");
                            echo Loc::getMessage('MESS_READY_TIME', array("#TIME#"=>$time));
                            ?>
                        </div>
                    <?endif;?>
                </div>
                <div class="col-auto">
                    <?
                    if ($arParams['SHOW_MAX_QUANTITY'] !== 'N')
                    {
                        if ($haveOffers)
                        {
                            ?>
                            <div class="product-item-quantity-container" id="<?=$itemIds['QUANTITY_LIMIT']?>" style="display: none;">
                                <span class="product-item-quantity" data-entity="quantity-limit-value"></span>
                            </div>
                            <?
                        }
                        else
                        {
                            if (
                                $measureRatio
                                && (float)$actualItem['CATALOG_QUANTITY'] > 0
                                && $actualItem['CATALOG_QUANTITY_TRACE'] === 'Y'
                                && $actualItem['CATALOG_CAN_BUY_ZERO'] === 'N'
                            )
                            {
                                ?>
                                <div class="product-item-quantity-container" id="<?=$itemIds['QUANTITY_LIMIT']?>">
                                            <span class="product-item-quantity" data-entity="quantity-limit-value">
														<?
                                                        if ($arParams['SHOW_MAX_QUANTITY'] === 'M')
                                                        {
                                                            if ((float)$actualItem['CATALOG_QUANTITY'] / $measureRatio >= $arParams['RELATIVE_QUANTITY_FACTOR'])
                                                            {
                                                                echo $arParams['MESS_RELATIVE_QUANTITY_MANY'];
                                                            }
                                                            else
                                                            {
                                                                echo $arParams['MESS_RELATIVE_QUANTITY_FEW'];
                                                            }
                                                        }
                                                        else
                                                        {
                                                            echo $actualItem['CATALOG_QUANTITY'].' '.$actualItem['ITEM_MEASURE']['TITLE'];
                                                        }
                                                        ?>
													</span>
                                </div>
                                <?
                            } else {
                                ?>
                                <div class="product-item-quantity-container" id="<?=$itemIds['QUANTITY_LIMIT']?>">
                                    <span class="product-item-quantity empty" data-entity="quantity-limit-value"><?=Loc::getMessage('K_QUANTITY_TITLE')?></span>
                                </div>
                                <?
                            }
                        }
                    }
                    ?>
                </div>
            </div>
        </div>

        <div class="product-detail-info-top row">
            <div class="product-item-detail-gallery col-lg-6">
                <div class="product-item-detail-slider-container" id="<?=$itemIds['BIG_SLIDER_ID']?>">
                    <span class="product-item-detail-slider-close" data-entity="close-popup"></span>
                    <?
                    if ($showSliderControls)
                    {
                        if ($haveOffers)
                        {
                            foreach ($arResult['OFFERS'] as $keyOffer => $offer)
                            {
                                if (!isset($offer['MORE_PHOTO_COUNT']) || 0 >= $offer['MORE_PHOTO_COUNT'])
                                    continue;

                                $strVisible = $arResult['OFFERS_SELECTED'] == $keyOffer ? '' : 'none';
                                ?>
                                <div class="product-item-detail-slider-controls-block" id="<?=$itemIds['SLIDER_CONT_OF_ID'].$offer['ID']?>" style="display: <?=$strVisible?>;">
                                    <div class="swiper-container <?=$itemIds['SLIDER_THUMB'];?>" data-id="<?=$itemIds['SLIDER_THUMB'];?>">
                                        <div class="swiper-wrapper">
                                            <?
                                            foreach ($offer['MORE_PHOTO'] as $keyPhoto => $photo)
                                            {
                                                $file = CFile::ResizeImageGet($photo['ID'], array('width'=>'105', 'height'=>'160'), BX_RESIZE_IMAGE_PROPORTIONAL, true);
                                                ?>
                                                <div class="swiper-slide product-item-detail-slider-controls-image<?=($keyPhoto == 0 ? ' active' : '')?>"
                                                     data-entity="slider-control" data-value="<?=$offer['ID'].'_'.$photo['ID']?>">
                                                    <img src="<?=$photo['SRC']?>" width="<?=$file["width"]?>" height="<?=$file["height"]?>" alt="<?=$arResult["NAME"]?>" title="<?=$arResult["NAME"]?>" />
                                                </div>
                                                <?
                                            }
                                            ?>
                                        </div>
                                    </div>
                                    <div class="swiper-next swiper-arrow"<?=(count($offer['MORE_PHOTO']) <= 4 ? ' style="display:none;"' : '');?>></div>
                                    <div class="swiper-prev swiper-arrow"<?=(count($offer['MORE_PHOTO']) <= 4 ? ' style="display:none;"' : '');?>></div>
                                </div>
                                <?
                            }
                        }
                        else
                        {
                            ?>
                            <div class="product-item-detail-slider-controls-block" id="<?=$itemIds['SLIDER_CONT_ID']?>">
                                <div class="swiper-container <?=$itemIds['SLIDER_THUMB'];?>" data-id="<?=$itemIds['SLIDER_THUMB'];?>">
                                    <div class="swiper-wrapper">
                                        <?
                                        if (!empty($actualItem['MORE_PHOTO']))
                                        {
                                            foreach ($actualItem['MORE_PHOTO'] as $key => $photo)
                                            {
                                                $file = CFile::ResizeImageGet($photo['ID'], array('width'=>'105', 'height'=>'160'), BX_RESIZE_IMAGE_PROPORTIONAL, true);
                                                ?>
                                                <div class="swiper-slide product-item-detail-slider-controls-image<?=($key == 0 ? ' active' : '')?>"
                                                     data-entity="slider-control" data-value="<?=$photo['ID']?>">
                                                    <img src="<?=$photo['SRC']?>" width="<?=$file["width"]?>" height="<?=$file["height"]?>" alt="<?=$arResult["NAME"]?>" title="<?=$arResult["NAME"]?>" />
                                                </div>
                                                <?
                                            }
                                        } else {

                                        }
                                        ?>
                                    </div>
                                </div>
                                <div class="swiper-next swiper-arrow"<?=(count($actualItem['MORE_PHOTO']) <= 4 ? ' style="display:none;"' : '');?>></div>
                                <div class="swiper-prev swiper-arrow"<?=(count($actualItem['MORE_PHOTO']) <= 4 ? ' style="display:none;"' : '');?>></div>
                            </div>
                            <?
                        }
                    }
                    ?>
                    <div class="product-item-detail-slider-block <?=($arParams['IMAGE_RESOLUTION'] === '1by1' ? 'product-item-detail-slider-block-square' : '')?>"
                         data-entity="images-slider-block">
                        <span class="product-item-detail-slider-left" data-entity="slider-control-left" style="display: none;"></span>
                        <span class="product-item-detail-slider-right" data-entity="slider-control-right" style="display: none;"></span>

                        <a href="" class="product_add-favour to_favorites d-sm-none d-block mobile-fav" data-cookieid="<?=$arResult['ID']?>" onclick ="dataLayer.push({'event': 'favourites'});">
                            <span class="fa fa-heart-o"></span>
                        </a>

                        <div class="product_card-flags product-item-label-text" id="<?=$itemIds['STICKER_ID']?>"
                            <?=(!$arResult['LABEL'] ? 'style="display: none;"' : '' )?>>
                            <?
                            if ($arResult['LABEL'] && !empty($arResult['LABEL_ARRAY_VALUE']))
                            {
                                foreach ($arResult['LABEL_ARRAY_VALUE'] as $code => $value)
                                {
                                    ?>
                                    <div class="flag-item <?=strtolower($code);?><?=(!isset($arParams['LABEL_PROP_MOBILE'][$code]) ? ' hidden-xs' : '')?>"><?=$value?></div>
                                    <?
                                }
                            }
                            ?>
                        </div>
                        <?
                        if ($arParams['SHOW_DISCOUNT_PERCENT'] === 'Y')
                        {
                            if ($haveOffers)
                            {
                                ?>
                                <div class="product-item-label-ring <?=$discountPositionClass?>"
                                     id="<?=$itemIds['DISCOUNT_PERCENT_ID']?>"
                                     style="display: none;">
                                </div>
                                <?
                            }
                            else
                            {
                                if ($price['DISCOUNT'] > 0)
                                {
                                    ?>
                                    <div class="product-item-label-ring <?=$discountPositionClass?>"
                                         id="<?=$itemIds['DISCOUNT_PERCENT_ID']?>"
                                         title="<?=-$price['PERCENT']?>%">
                                        <span><?=-$price['PERCENT']?>%</span>
                                    </div>
                                    <?
                                }
                            }
                        }
                        ?>

                        <div class="product-item-detail-slider-images-container" data-entity="images-container">
                            <?
                            if (!empty($actualItem['MORE_PHOTO']))
                            {
                                foreach ($actualItem['MORE_PHOTO'] as $key => $photo)
                                {
                                    $file = CFile::ResizeImageGet($photo['ID'], array('width'=>'430', 'height'=>'558'), BX_RESIZE_IMAGE_PROPORTIONAL, true);
                                    ?>
                                    <div class="product-item-detail-slider-image<?=($key == 0 ? ' active' : '')?>" data-entity="image" data-id="<?=$photo['ID']?>">
                                        <a href="<?=$photo['SRC']?>" data-fancybox="images" class="fancybox-prev">
                                            <img src="<?=$photo['SRC']?>" width="<?=$file["width"]?>" height="<?=$file["height"]?>" alt="<?=$alt?>" title="<?=$title?>"<?=($key == 0 ? ' itemprop="image"' : '')?>>
                                        </a>
                                    </div>
                                    <?
                                }
                            }?>
                        </div>
                    </div>
                </div>
            </div>

            <?
            $showOffersBlock = $haveOffers && !empty($arResult['OFFERS_PROP']);
            $showPropsBlock = !empty($arResult['DISPLAY_PROPERTIES']) || $arResult['SHOW_OFFERS_PROPS'];
            $showBlockWithOffersAndProps = $showOffersBlock || $showPropsBlock;
            ?>
            <div class="product-item-detail-main-info col-lg-6">
                <div class="hidden-xs product_card__title">
                    <?
                    if ($arParams['DISPLAY_NAME'] === 'Y')
                    {
                        ?>
                        <h1 class="mb-1"><?=$name?></h1>
                        <?
                    }
                    ?>
                    <div class="row">
                        <div class="col">
                            <div class="product_rating">
                                <span class="count_title"><?=Loc::getMessage('K_RATING_TITLE');?></span>
                                <span><?=getStars($arResult['PROPERTIES']['PRODUCT_RATING']['VALUE']*2)?></span>
                                <span class="count_rating">(<?=$arResult['PROPERTIES']['PRODUCT_RATING']['VALUE']?>)</span>
                            </div>
							<?if( $arResult['DISPLAY_PROPERTIES']['TIME_MANUFACTURING']['VALUE'] && $arResult['MOD_TIME_READY_NEW']):?>
								<div class="product_time">
									<?=Loc::getMessage("MESS_PRODUCTION_TIME")?> <span><?echo $arResult['DISPLAY_PROPERTIES']['TIME_MANUFACTURING']['VALUE']?> <?echo format_by_count($arResult['DISPLAY_PROPERTIES']['TIME_MANUFACTURING']['VALUE'], "час", "часа", "часов")?></span>
								</div>

								<div class="ready-time" id="<?=$itemIds['DISPLAY_READY_TIME_DIV']?>">
									<?
//									$dateTime = new \Bitrix\Main\Type\DateTime();
//									if(!empty($arResult['MOD_TIME_READY'])){
//										$dateTime->add($arResult['MOD_TIME_READY']. " hours");
//									}
//									else{
//										$dateTime->add($arResult['DISPLAY_PROPERTIES']['TIME_MANUFACTURING']['VALUE']. " hours");
//									}
                                    $dateTime = $arResult['MOD_TIME_READY_NEW'];
									$time = $dateTime->format("Y-m-d H:i");
									echo Loc::getMessage('MESS_READY_TIME', array("#TIME#"=>$time));
									?>
								</div>
							<?endif;?>
                        </div>
                        <div class="col-auto">
                            <?
                            if ($arParams['SHOW_MAX_QUANTITY'] !== 'N')
                            {
                                if ($haveOffers)
                                {
                                    ?>
                                    <div class="product-item-quantity-container" id="<?=$itemIds['QUANTITY_LIMIT']?>" style="display: none;">
                                        <span class="product-item-quantity" data-entity="quantity-limit-value"></span>
                                    </div>
                                    <?
                                }
                                else
                                {
                                    if (
                                        $measureRatio
                                        && (float)$actualItem['CATALOG_QUANTITY'] > 0
                                        && $actualItem['CATALOG_QUANTITY_TRACE'] === 'Y'
                                        && $actualItem['CATALOG_CAN_BUY_ZERO'] === 'N'
                                    )
                                    {
                                        ?>
                                        <div class="product-item-quantity-container" id="<?=$itemIds['QUANTITY_LIMIT']?>">
                                            <span class="product-item-quantity" data-entity="quantity-limit-value">
														<?
                                                        if ($arParams['SHOW_MAX_QUANTITY'] === 'M')
                                                        {
                                                            if ((float)$actualItem['CATALOG_QUANTITY'] / $measureRatio >= $arParams['RELATIVE_QUANTITY_FACTOR'])
                                                            {
                                                                echo $arParams['MESS_RELATIVE_QUANTITY_MANY'];
                                                            }
                                                            else
                                                            {
                                                                echo $arParams['MESS_RELATIVE_QUANTITY_FEW'];
                                                            }
                                                        }
                                                        else
                                                        {
                                                            echo $actualItem['CATALOG_QUANTITY'].' '.$actualItem['ITEM_MEASURE']['TITLE'];
                                                        }
                                                        ?>
													</span>
                                        </div>
                                        <?
                                    } else {
                                        ?>
                                        <div class="product-item-quantity-container" id="<?=$itemIds['QUANTITY_LIMIT']?>">
                                            <span class="product-item-quantity empty" data-entity="quantity-limit-value"><?=Loc::getMessage('K_QUANTITY_TITLE')?></span>
                                        </div>
                                        <?
                                    }
                                }
                            }
                            ?>
                        </div>
                    </div>
                </div>

				<div class="product-detail-description">
					<?if($arResult['PRODUCT_COMPOSITION']):?>
						<p><?=$arResult['PRODUCT_COMPOSITION']['VALUE'];?></p>
					<?endif;?>
					<p>Кондитерская: <?echo $arResult["DISPLAY_PROPERTIES"]["BRAND"]["DISPLAY_VALUE"]?></p>
				</div>
                <div class="product-detail-byu-container">
                    <?
                    if ($showOffersBlock):?>
                        <div class="product-detail-sku-container" id="<?=$itemIds['TREE_ID']?>">
                            <?
                            foreach ($arResult['SKU_PROPS'] as $skuProperty)
                            {
                                if (!isset($arResult['OFFERS_PROP'][$skuProperty['CODE']]))
                                    continue;

                                $propertyId = $skuProperty['ID'];
                                $skuProps[] = array(
                                    'ID' => $propertyId,
                                    'SHOW_MODE' => $skuProperty['SHOW_MODE'],
                                    'VALUES' => $skuProperty['VALUES'],
                                    'VALUES_COUNT' => $skuProperty['VALUES_COUNT']
                                );
                                ?>
                                <div data-entity="sku-line-block" class="sku-line-block">
                                    <div class="product-item-scu-container-title mb-2"><?=GetMessage('K_CHOISE');?> <?=mb_strtolower(htmlspecialcharsEx($skuProperty['NAME']))?>:</div>
                                    <div class="product-item-scu-container">
                                        <div class="product-item-scu-block">
                                            <div class="product-item-scu-list">
                                                <ul class="product-item-scu-item-list">
                                                    <?
                                                    foreach ($skuProperty['VALUES'] as &$value)
                                                    {
                                                        $value['NAME'] = htmlspecialcharsbx($value['NAME']);

                                                        if ($skuProperty['SHOW_MODE'] === 'PICT' && $skuProperty['CODE'] != 'WEIGHT' && $skuProperty['CODE'] != 'NUMBER_LAYERS')
                                                        {
                                                            ?>
                                                            <li class="product-item-scu-item-color-container" title="<?=$value['NAME']?>"
                                                                data-treevalue="<?=$propertyId?>_<?=$value['ID']?>"
                                                                data-onevalue="<?=$value['ID']?>">
                                                                <div class="product-item-scu-item-color-block">
                                                                    <div class="product-item-scu-item-color" title="<?=$value['NAME']?>"
                                                                         style="background-image: url('<?=$value['PICT']['SRC']?>');">
                                                                    </div>
                                                                </div>
                                                            </li>
                                                            <?
                                                        }
                                                        else
                                                        {
                                                            ?>
                                                            <li class="product-item-scu-item-text-container" title="<?=$value['NAME']?>"
                                                                data-treevalue="<?=$propertyId?>_<?=$value['ID']?>"
                                                                data-onevalue="<?=$value['ID']?>">
                                                                <div class="product-item-scu-item-text-block">
                                                                    <div class="product-item-scu-item-text"><?=$value['NAME']?></div>
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
                    <?endif;?>
                    <div class="byu-container-row row m-0 align-items-center justify-content-between">
					
						<?if($arResult["DISPLAY_PROPERTIES"]["APPLICATION"]["DISPLAY_VALUE"]):?>
							<div class="product-item-option">
								<div class="product-item-option__image">
									<img src="<?=SITE_TEMPLATE_PATH?>/img/icon-add.png" alt="">
								</div>

								<div class="product-item-option__text">
									<?=Loc::getMessage('MESS_APPLY_TEXT')?>
								</div>
							</div>
						<?endif;?>
											
                        <div class="col-auto price-col p-0">
                            <div class="product-item-detail-price">
                                <div class="product-detail-price-item product-item-detail-price-current">
                                    <span id="<?=$itemIds['PRICE_ID']?>"><?echo $price['PRINT_RATIO_PRICE']?></span>
                                    <?if(!$haveOffers):?>
                                        /<span class="item-measure">
										<?=Loc::getMessage('K_TITLE_MEASURE');?> <span class="quantity-measure" id="<?=$itemIds['QUANTITY_MEASURE']?>"><?
                                               echo $measureRatio.' '.$actualItem['ITEM_MEASURE']['TITLE'];?></span>
										</span>
                                    <?endif;?>
                                </div>
                                <?
                                if ($arParams['SHOW_OLD_PRICE'] === 'Y')
                                {
                                    ?>
                                    <div class="product-detail-price-item product-item-detail-price-old"<?
                                    echo ($showDiscount ? '' : 'style="display: none;"')?>>
                                        <span id="<?=$itemIds['OLD_PRICE_ID']?>"><?=($showDiscount ? $price['PRINT_RATIO_BASE_PRICE'] : '')?></span>
                                    </div>
                                    <?
                                }
                                ?>
								<?if (!empty($price_per_kg))
								{	
									?>
									<div id="<?=$itemIds["DISPLAY_PRICE_PER_KG_DIV"]?>" class="product-item-detail-price__weight"><?echo $price_per_kg?> <i class="fa fa-rub"></i> за 1кг</div>
									<?
								}
								?>
                            </div>
                        </div>
                        <div class="col-auto button-quantity-col p-0">
                            <div class="row align-items-center justify-content-sm-center my-sm-0 my-2">
                                <div class="col-auto">
                                    <!-- buttons -->
                                    <div data-entity="main-button-container" class="main-button-container">
                                        <? if($actualItem['CAN_BUY'])
                                        {
                                            ?>
                                            <div id="<?=$itemIds['BASKET_ACTIONS_ID']?>">
                                                <?if ($showAddBtn)
                                                {
                                                    ?>
                                                    <a class="btn btn-primary product-item-detail-buy-button btn-buy"
                                                       id="<?=$itemIds['ADD_BASKET_LINK']?>"
                                                       href="javascript:void(0);"
													    onclick ="dataLayer.push({'event': 'korzina'});">
                                                        <span class="img_basket"></span>
                                                        <span><?=$arParams['MESS_BTN_ADD_TO_BASKET']?></span>
                                                    </a>
                                                    <?
                                                }

                                                if ($showBuyBtn)
                                                {
                                                    ?>
                                                    <a class="btn btn-primary product-item-detail-buy-button btn-buy"
                                                       id="<?=$itemIds['BUY_LINK']?>"
                                                       href="javascript:void(0);">
                                                        <span class="img_basket"></span>
                                                        <span><?=$arParams['MESS_BTN_BUY']?></span>
                                                    </a>
                                                    <?
                                                }?>
                                            </div>

                                            <?
                                        }

                                        if ($showSubscribe)
                                        {
                                            ?>
                                            <div class="btn-subscribe">
                                                <?
                                                $APPLICATION->IncludeComponent(
                                                    'bitrix:catalog.product.subscribe',
                                                    '',
                                                    array(
                                                        'CUSTOM_SITE_ID' => isset($arParams['CUSTOM_SITE_ID']) ? $arParams['CUSTOM_SITE_ID'] : null,
                                                        'PRODUCT_ID' => $arResult['ID'],
                                                        'BUTTON_ID' => $itemIds['SUBSCRIBE_LINK'],
                                                        'BUTTON_CLASS' => 'btn u-btn-outline-primary product-item-detail-buy-button',
                                                        'DEFAULT_DISPLAY' => !$actualItem['CAN_BUY'],
                                                        'MESS_BTN_SUBSCRIBE' => $arParams['~MESS_BTN_SUBSCRIBE'],
                                                    ),
                                                    $component,
                                                    array('HIDE_ICONS' => 'Y')
                                                );
                                                ?>
                                            </div>
                                            <?
                                        }

                                        if(!$actualItem['CAN_BUY'])
                                        {
                                            ?>
                                            <div class="btn-not-avaliable" id="<?=$itemIds['NOT_AVAILABLE_MESS']?>">
                                                <a class="btn disabled" href="javascript:void(0)" rel="nofollow"><?=$arParams['MESS_NOT_AVAILABLE']?></a>
                                            </div>
                                            <?
                                        }?>
                                    </div>

                                    <!-- quantity -->
                                    <?
                                    if ($arParams['USE_PRODUCT_QUANTITY'])
                                    {
                                        ?>
                                        <div class="quantity-block" <?= (!$actualItem['CAN_BUY'] ? ' style="display: none;"' : '') ?> data-entity="quantity-block">
                                            <div class="product-item-amount">
                                                <div class="product-item-amount-field-container">
                                                    <span class="product-item-amount-field-btn-minus no-select" id="<?=$itemIds['QUANTITY_DOWN_ID']?>"></span>
                                                    <span class="count_input">
                                                    <input class="product-item-amount-field" id="<?=$itemIds['QUANTITY_ID']?>" type="text" data-min="<?=$price['MIN_QUANTITY']?>" value="<?=$price['MIN_QUANTITY']?>">
                                                    <span style="display: none;" id="<?=$itemIds['QUANTITY_MEASURE']?>"><?=$actualItem['ITEM_MEASURE']['TITLE']?></span>
                                                </span>
                                                    <span class="product-item-amount-field-btn-plus no-select" id="<?=$itemIds['QUANTITY_UP_ID']?>"></span>
                                                    <span style="display: none;" class="product-item-amount-description-container"><span id="<?=$itemIds['PRICE_TOTAL']?>"></span></span>
                                                </div>
                                            </div>
                                        </div>
                                        <?
                                    }
                                    ?>
                                </div>
                                <div class="col-auto pl-0 d-sm-block d-none">
                                    <a href="" class="product_add-favour to_favorites" data-cookieid="<?=$arResult['ID']?>" onclick ="dataLayer.push({'event': 'favourites'});">
                                        <span class="fa fa-heart-o"></span>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="sale-prediction-container">
                        <div class="sale-prediction-content" id="sale_prediction"></div>
                    </div>
					
                </div>

                <?/*
				<div class="product-detail-composite-container mb-3">
                    <?if($arResult['PRODUCT_COMPOSITION']):?>
                        <span class="composite_name"><?=$arResult['PRODUCT_COMPOSITION']['NAME'];?>:</span>
                        <span class="composite_value"><?=$arResult['PRODUCT_COMPOSITION']['VALUE'];?></span>
                    <?endif;?>
                </div>
				*/?>

                <?if((!empty($arResult['CARB'])) || (!empty($arResult['FAT'])) || (!empty($arResult['PROTEIN'])) || (!empty($arResult['ENERGY_VALUE']))):?>
                    <div class="product-detail-nutrition-container">
                        <div class="nutrition-title"><?=Loc::getMessage('K_ENERGY_KBZHU_TITLE');?></div>
                        <div class="nutrition-row row">
                            <?if($arResult['ENERGY_VALUE']):?>
                                <div class="nutrition-col col-auto pr-0">
                                    <div class="nutrition-item">
                                        <div class="nutrition_name"><?=Loc::getMessage('K_ENERGY_VALUE_TITLE');?></div>
                                        <div class="nutrition_value"><?=$arResult['ENERGY_VALUE'];?></div>
                                        <?if($arResult['ENERGY_VALUE_PERCENT']):?>
                                            <div class="nutrition_percent"><?=$arResult['ENERGY_VALUE_PERCENT'];?></div>

                                        <?endif;?>
                                    </div>
                                </div>
                            <?endif;?>
                            <?if($arResult['PROTEIN']):?>
                                <div class="nutrition-col col-auto pr-0 pl-4">
                                    <div class="nutrition-item">
                                        <div class="nutrition_name"><?=Loc::getMessage('K_PROTEIN_TITLE');?></div>
                                        <div class="nutrition_value"><?=$arResult['PROTEIN'];?></div>
                                        <?if($arResult['PROTEIN_PERCENT']):?>
                                            <div class="nutrition_percent"><?=$arResult['PROTEIN_PERCENT'];?></div>
                                        <?endif;?>
                                    </div>
                                </div>
                            <?endif;?>
                            <?if($arResult['FAT']):?>
                                <div class="nutrition-col col-auto pr-0 pl-4">
                                    <div class="nutrition-item">
                                        <div class="nutrition_name"><?=Loc::getMessage('K_FAT_TITLE');?></div>
                                        <div class="nutrition_value"><?=$arResult['FAT'];?></div>
                                        <?if($arResult['FAT_PERCENT']):?>
                                            <div class="nutrition_percent"><?=$arResult['FAT_PERCENT'];?></div>

                                        <?endif;?>
                                    </div>
                                </div>
                            <?endif;?>
                            <?if($arResult['CARB']):?>
                                <div class="nutrition-col col-auto pr-0 pl-4">
                                    <div class="nutrition-item">
                                        <div class="nutrition_name"><?=Loc::getMessage('K_CARB_TITLE');?></div>
                                        <div class="nutrition_value"><?=$arResult['CARB'];?></div>
                                        <?if($arResult['CARB_PERCENT']):?>
                                            <div class="nutrition_percent"><?=$arResult['CARB_PERCENT'];?></div>
                                        <?endif;?>
                                    </div>
                                </div>
                            <?endif;?>
                        </div>
                    </div>
                <?endif;?>
            </div>
        </div>

        <div class="product-detail-slider product-detail-sales-slider">
            <div class="slider_wrapper">
                <h2><?=GetMessage('K_SALE_GOODS')?></h2>
                <div class="slider inner-slider special_offer">
                    <?
                    $APPLICATION->IncludeComponent(
                        "bitrix:catalog.section",
                        "product-slider",
                        array(
                            "ACTION_VARIABLE" => "action",
                            "ADD_PICT_PROP" => "MORE_PHOTO",
                            "ADD_PROPERTIES_TO_BASKET" => $arParams['ADD_PROPERTIES_TO_BASKET'],
                            "ADD_SECTIONS_CHAIN" => "N",
                            "ADD_TO_BASKET_ACTION" => $arParams['ADD_TO_BASKET_ACTION'],
                            "AJAX_MODE" => "N",
                            "AJAX_OPTION_ADDITIONAL" => "",
                            "AJAX_OPTION_HISTORY" => "N",
                            "AJAX_OPTION_JUMP" => "N",
                            "AJAX_OPTION_STYLE" => "Y",
                            "BACKGROUND_IMAGE" => "",
                            "BASKET_URL" => SITE_DIR."basket/",
                            "BRAND_PROPERTY" => "-",
                            "BROWSER_TITLE" => "-",
                            "CACHE_FILTER" => "N",
                            "CACHE_GROUPS" => $arParams['CACHE_GROUPS'],
                            "CACHE_TIME" => $arParams['CACHE_TIME'],
                            "CACHE_TYPE" => $arParams['CACHE_TYPE'],
                            "COMPATIBLE_MODE" => "Y",
                            "CONVERT_CURRENCY" => "Y",
                            "CURRENCY_ID" => "RUB",
                            "CUSTOM_FILTER" => "{\"CLASS_ID\":\"CondGroup\",\"DATA\":{\"All\":\"OR\",\"True\":\"True\"},\"CHILDREN\":[{\"CLASS_ID\":\"CondIBProp:3:75\",\"DATA\":{\"logic\":\"Equal\",\"value\":69}}]}",
                            "DATA_LAYER_NAME" => "dataLayer",
                            "DETAIL_URL" => "",
                            "DISABLE_INIT_JS_IN_COMPONENT" => "N",
                            "DISCOUNT_PERCENT_POSITION" => $arParams['DISCOUNT_PERCENT_POSITION'],
                            "DISPLAY_COMPARE" => $arParams['DISPLAY_COMPARE'],
                            "DISPLAY_TOP_PAGER" => "N",
                            "ELEMENT_SORT_FIELD" => "RAND",
                            "ELEMENT_SORT_FIELD2" => "id",
                            "ELEMENT_SORT_ORDER" => "asc",
                            "ELEMENT_SORT_ORDER2" => "desc",
                            "ENLARGE_PRODUCT" => "STRICT",
                            "FILTER_NAME" => "arrFilterSpecial",
                            "HIDE_NOT_AVAILABLE" => "N",
                            "HIDE_NOT_AVAILABLE_OFFERS" => "N",
                            "IBLOCK_ID" => $arParams['IBLOCK_ID'],
                            "IBLOCK_TYPE" => $arParams['IBLOCK_TYPE'],
                            "INCLUDE_SUBSECTIONS" => "N",
                            "LABEL_PROP" => array(),
                            "LAZY_LOAD" => "N",
                            "LINE_ELEMENT_COUNT" => "4",
                            "LOAD_ON_SCROLL" => "N",
                            "MESSAGE_404" => "",
                            "MESS_BTN_ADD_TO_BASKET" => $arParams['MESS_BTN_ADD_TO_BASKET'],
                            "MESS_BTN_BUY" => $arParams['MESS_BTN_BUY'],
                            "MESS_BTN_DETAIL" => $arParams['MESS_BTN_DETAIL'],
                            "MESS_BTN_SUBSCRIBE" => $arParams['MESS_BTN_SUBSCRIBE'],
                            "MESS_NOT_AVAILABLE" => $arParams['MESS_NOT_AVAILABLE'],
                            "META_DESCRIPTION" => "-",
                            "META_KEYWORDS" => "-",
                            "OFFERS_CART_PROPERTIES" => $arParams['OFFERS_CART_PROPERTIES'],
                            "OFFERS_FIELD_CODE" => $arParams['OFFERS_FIELD_CODE'],
                            "OFFERS_LIMIT" => "0",
                            "OFFERS_PROPERTY_CODE" => $arParams['OFFERS_PROPERTY_CODE'],
                            "OFFERS_SORT_FIELD" => "sort",
                            "OFFERS_SORT_FIELD2" => "id",
                            "OFFERS_SORT_ORDER" => "asc",
                            "OFFERS_SORT_ORDER2" => "desc",
                            "PAGER_BASE_LINK_ENABLE" => "N",
                            "PAGER_DESC_NUMBERING" => "N",
                            "PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",
                            "PAGER_SHOW_ALL" => "N",
                            "PAGER_SHOW_ALWAYS" => "N",
                            "PAGER_TEMPLATE" => ".default",
                            "PAGER_TITLE" => "Товары",
                            "PAGE_ELEMENT_COUNT" => "20",
                            'PARTIAL_PRODUCT_PROPERTIES' => (isset($arParams['PARTIAL_PRODUCT_PROPERTIES']) ? $arParams['PARTIAL_PRODUCT_PROPERTIES'] : ''),
                            "PRICE_CODE" => $arParams['PRICE_CODE'],
                            'PRICE_VAT_INCLUDE' => $arParams['PRICE_VAT_INCLUDE'],
                            "PRODUCT_BLOCKS_ORDER" => "price,props,sku,quantityLimit,quantity,buttons,compare",
                            "PRODUCT_DISPLAY_MODE" => "N",
                            "PRODUCT_ID_VARIABLE" => "id",
                            "PRODUCT_PROPERTIES" => array(
                            ),
                            "PRODUCT_PROPS_VARIABLE" => "prop",
                            "PRODUCT_QUANTITY_VARIABLE" => "quantity",
                            "PRODUCT_ROW_VARIANTS" => "",
                            "PRODUCT_SUBSCRIPTION" => "Y",
                            "PROPERTY_CODE" => $arParams['PROPERTY_CODE'],
                            "PROPERTY_CODE_MOBILE" => array(
                                0 => "",
                            ),
                            "RCM_PROD_ID" => "",
                            "RCM_TYPE" => "personal",
                            "SECTION_CODE" => "",
                            "SECTION_ID" => "", //$arResult['IBLOCK_SECTION_ID'], //"", //$arParams["IBLOCK_SECTION_ID"],
                            "SECTION_ID_VARIABLE" => "SECTION_ID",
                            "SECTION_URL" => "",
                            "SECTION_USER_FIELDS" => array(
                                0 => "",
                                1 => "",
                            ),
                            "SEF_MODE" => "Y",
                            "SET_BROWSER_TITLE" => "Y",
                            "SET_LAST_MODIFIED" => "N",
                            "SET_META_DESCRIPTION" => "Y",
                            "SET_META_KEYWORDS" => "Y",
                            "SET_STATUS_404" => "N",
                            "SET_TITLE" => "Y",
                            "SHOW_404" => "N",
                            "SHOW_ALL_WO_SECTION" => "Y",
                            "SHOW_CLOSE_POPUP" => $arParams['SHOW_CLOSE_POPUP'],
                            "SHOW_DISCOUNT_PERCENT" => $arParams['SHOW_DISCOUNT_PERCENT'],
                            "SHOW_FROM_SECTION" => "N",
                            "SHOW_MAX_QUANTITY" => $arParams['SHOW_MAX_QUANTITY'],
                            "SHOW_OLD_PRICE" => "Y",
                            "SHOW_PRICE_COUNT" => "1",
                            "SHOW_SLIDER" => "N",
                            "SLIDER_INTERVAL" => "3000",
                            "SLIDER_PROGRESS" => "N",
                            "TEMPLATE_THEME" => "blue",
                            "USE_ENHANCED_ECOMMERCE" => "N",
                            "USE_MAIN_ELEMENT_SECTION" => "N",
                            "USE_PRICE_COUNT" => "Y",
                            'USE_PRODUCT_QUANTITY' => "Y", //$arParams['USE_PRODUCT_QUANTITY'],
                            "USE_FILTER" => "Y",
                            "COMPONENT_TEMPLATE" => "product-slider",
                            "OFFER_ADD_PICT_PROP" => "PRODUCT_IMAGE",
                            "OFFER_TREE_PROPS" => array(
                            ),
                            "SEF_RULE" => "",
                            "SECTION_CODE_PATH" => "",
                            "LABEL_PROP_MOBILE" => $arParams['LABEL_PROP_MOBILE'],
                            "LABEL_PROP_POSITION" => "top-right",
                        ),
                        false //$component
                    );?>
                </div>
            </div>
        </div>

        <div class="product-item-detail-tabs">
            <div class="product-item-detail-tabs-container" id="<?=$itemIds['TABS_ID']?>">
                <ul class="nav nav-tabs product-item-detail-tabs-list" role="tablist">
                    <?
                    if ($showDescription || !empty($arResult['DISPLAY_PROPERTIES']) || $arResult['SHOW_OFFERS_PROPS'])
                    {
                        ?>
                        <li class="nav-item product-item-detail-tab" data-entity="tab">
                            <a class="nav-link active product-item-detail-tab-link"
                               id="description-tab" data-toggle="tab" href="#description" role="tab" aria-controls="description" aria-selected="true">
                                <span><?=$arParams['MESS_DESCRIPTION_TAB']?></span>
                            </a>
                        </li>
                        <?
                    }

                    if ($arParams['USE_COMMENTS'] === 'Y')
                    {
                        ?>
                        <li class="nav-item product-item-detail-tab" data-entity="tab">
                            <a class="nav-link product-item-detail-tab-link"
                               id="comments-tab" data-toggle="tab" href="#comments" role="tab" aria-controls="comments" aria-selected="false">
                                <span><?=$arParams['MESS_COMMENTS_TAB']?></span>
                            </a>
                        </li>
                        <?
                    }
                    ?>
                </ul>
            </div>
            <div class="tab-content product-item-detail-tabs-content" id="<?=$itemIds['TAB_CONTAINERS_ID']?>">
                <?
                if ($showDescription || !empty($arResult['DISPLAY_PROPERTIES']) || $arResult['SHOW_OFFERS_PROPS'])
                {
                    ?>
                    <div class="tab-pane product-item-detail-tab-content active" id="description" role="tabpanel" aria-labelledby="description-tab" itemprop="description">
                        <h3 class="mobile-title-tab"><?=$arParams['MESS_DESCRIPTION_TAB']?></h3>
                        <?if ($showDescription):?>
                            <div class="description-tab">
                                <div class="sub-title-tab"><?=GetMessage('K_DESCRIPTION_TITLE');?>:</div>
                                <div class="content-tab">
                                    <?
                                    if ($arResult['PREVIEW_TEXT'] != '' && (
                                            $arParams['DISPLAY_PREVIEW_TEXT_MODE'] === 'S'
                                            || ($arParams['DISPLAY_PREVIEW_TEXT_MODE'] === 'E' && $arResult['DETAIL_TEXT'] == '')
                                        )
                                    )
                                    {
                                        echo $arResult['PREVIEW_TEXT_TYPE'] === 'html' ? $arResult['PREVIEW_TEXT'] : '<p>'.$arResult['PREVIEW_TEXT'].'</p>';
                                    }

                                    if ($arResult['DETAIL_TEXT'] != '')
                                    {
                                        echo $arResult['DETAIL_TEXT_TYPE'] === 'html' ? $arResult['DETAIL_TEXT'] : '<p>'.$arResult['DETAIL_TEXT'].'</p>';
                                    }
                                    ?>
                                </div>
                            </div>
                        <?endif;?>

                        <?if (!empty($arResult['DISPLAY_PROPERTIES']) || $arResult['SHOW_OFFERS_PROPS']):?>
                            <div class="properties-tab">
                                <div class="sub-title-tab"><?=GetMessage('K_INFO_TITLE');?>:</div>
                                <div class="content-tab">
                                    <?
                                    if (!empty($arResult['DISPLAY_PROPERTIES']))
                                    {
                                        ?>
                                        <ul class="product-item-detail-properties row">
                                            <?
                                            foreach ($arResult['DISPLAY_PROPERTIES'] as $property)
                                            {
                                                ?>
                                                <li class="product-item-detail-properties-item col-lg-6 col-12">
                                                    <div class="properties-item row no-gutters">
                                                        <span class="product-item-detail-properties-name col-lg-7 col"><?=$property['NAME']?></span>
                                                        <span class="product-item-detail-properties-value col-lg-5 col-auto"><?=(
                                                            is_array($property['DISPLAY_VALUE'])
                                                                ? implode(' / ', $property['DISPLAY_VALUE'])
                                                                : $property['DISPLAY_VALUE']
                                                            )?>
														</span>
                                                    </div>
                                                </li>
                                                <?
                                            }
                                            unset($property);
                                            ?>
											<?if(!empty($arResult['TAGS'])):?>
											<li class="product-item-detail-properties-item col-lg-6 col-12">
												<div class="properties-item row no-gutters">
													<span class="product-item-detail-properties-name col-lg-7 col">#Тег</span>
													<span class="product-item-detail-properties-value col-lg-5 col-auto">
														<?=$arResult['TAGS']?>
													</span>
												</div>
											</li>
											<?endif;?>
                                        </ul>
                                        <?
                                    }

                                    if ($arResult['SHOW_OFFERS_PROPS'])
                                    {
                                        ?>
                                        <ul class="product-item-detail-properties" id="<?=$itemIds['DISPLAY_PROP_DIV']?>"></ul>
                                        <?
                                    }
                                    ?>
                                </div>
                            </div>
                        <?endif;?>
                    </div>
                    <?
                }

                if ($arParams['USE_COMMENTS'] === 'Y')
                {
                    ?>
                    <div class="tab-pane product-item-detail-tab-content" id="comments" role="tabpanel" aria-labelledby="comments-tab">
                        <h3 class="mobile-title-tab"><?=$arParams['MESS_COMMENTS_TAB']?></h3>

                        <div id="spy-reviews" class="element_description">
                            <?
                            if ('Y' == $arParams['USE_COMMENTS']) {?>
                                <?$APPLICATION->IncludeComponent(
                                    "krayt:emarket.comments",
                                    "",
                                    Array(
                                        "IBLOCK_TYPE" => $arParams['IBLOCK_TYPE_ID'],
                                        "IBLOCK_ID" => $arResult['IBLOCK_ID'],
                                        "ELEMENT_ID" => $arResult["ID"],
                                        "ELEMENT_CODE" => '',
                                        "HLBLOCK_PROP_CODE" => $arParams['BLOG_HLBLOCK_PROP_CODE'],
                                        "HLBLOCK_CR_PROP_CODE" => $arParams['BLOG_HLBLOCK_CR_PROP_CODE'],
                                        "EMARKET_COMMENT_PREMODERATION" => "Y",
                                        "EMARKET_CUR_RATING" => $arResult['PROPERTIES']['PRODUCT_RATING']['VALUE'],
                                    ),
                                    $component
                                );?>
                            <?}?>
                        </div>
                    </div>
                    <?
                }
                ?>
            </div>
        </div>

        <?
        if ($haveOffers)
        {
            if ($arResult['OFFER_GROUP'])
            {
                ?>
                <div class="product-detail-set">
                    <?
                    foreach ($arResult['OFFER_GROUP_VALUES'] as $offerId)
                    {
                        ?>
                        <span id="<?=$itemIds['OFFER_GROUP'].$offerId?>" style="display: none;">
								<?
                                $APPLICATION->IncludeComponent('bitrix:catalog.set.constructor', 'main', array(
                                    'CUSTOM_SITE_ID' => isset($arParams['CUSTOM_SITE_ID']) ? $arParams['CUSTOM_SITE_ID'] : null,
                                    'IBLOCK_ID' => $arResult['OFFERS_IBLOCK'],
                                    'ELEMENT_ID' => $offerId,
                                    'PRICE_CODE' => $arParams['PRICE_CODE'],
                                    'BASKET_URL' => $arParams['BASKET_URL'],
                                    'OFFERS_CART_PROPERTIES' => $arParams['OFFERS_CART_PROPERTIES'],
                                    'CACHE_TYPE' => $arParams['CACHE_TYPE'],
                                    'CACHE_TIME' => $arParams['CACHE_TIME'],
                                    'CACHE_GROUPS' => $arParams['CACHE_GROUPS'],
                                    'TEMPLATE_THEME' => $arParams['~TEMPLATE_THEME'],
                                    'CONVERT_CURRENCY' => $arParams['CONVERT_CURRENCY'],
                                    'CURRENCY_ID' => $arParams['CURRENCY_ID']
                                ),
                                    $component,
                                    array('HIDE_ICONS' => 'Y')
                                );
                                ?>
							</span>
                        <?
                    }
                    ?>
                </div>
                <?
            }
        }
        else
        {
            if ($arResult['MODULES']['catalog'] && $arResult['OFFER_GROUP'])
            {
                ?>
                <div class="product-detail-set">
                    <? $APPLICATION->IncludeComponent('bitrix:catalog.set.constructor', 'main',array(
                        'CUSTOM_SITE_ID' => isset($arParams['CUSTOM_SITE_ID']) ? $arParams['CUSTOM_SITE_ID'] : null,
                        'IBLOCK_ID' => $arParams['IBLOCK_ID'],
                        'ELEMENT_ID' => $arResult['ID'],
                        'PRICE_CODE' => $arParams['PRICE_CODE'],
                        'BASKET_URL' => $arParams['BASKET_URL'],
                        'CACHE_TYPE' => $arParams['CACHE_TYPE'],
                        'CACHE_TIME' => $arParams['CACHE_TIME'],
                        'CACHE_GROUPS' => $arParams['CACHE_GROUPS'],
                        'TEMPLATE_THEME' => $arParams['~TEMPLATE_THEME'],
                        'CONVERT_CURRENCY' => $arParams['CONVERT_CURRENCY'],
                        'CURRENCY_ID' => $arParams['CURRENCY_ID']
                    ),
                        $component,
                        array('HIDE_ICONS' => 'Y')
                    );
                    ?>
                </div>
                <?
            }
        }
        ?>

        <div class="product-detail-slider product-detail-similar-slider mini-quantity-btn-slider">
            <div class="slider_wrapper">
                <h2><?=Loc::getMessage('K_MORE_PRODUCT_2')?></h2>
                <div class="slider inner-slider">
                    <?php $GLOBALS['NotItItem'] = array(
                        '!ID' => $arResult["ID"],
                        'IBLOCK_SECTION_ID' => $arResult['IBLOCK_SECTION_ID']
                    )?>
                    <?$APPLICATION->IncludeComponent(
                        "bitrix:catalog.section",
                        "product-slider",
                        array(
                            "ACTION_VARIABLE" => "action",
                            "ADD_PICT_PROP" => $arParams["ADD_PICT_PROP"],
                            "ADD_PROPERTIES_TO_BASKET" => $arParams['ADD_PROPERTIES_TO_BASKET'],
                            "ADD_SECTIONS_CHAIN" => $arParams["ADD_SECTIONS_CHAIN"],
                            "ADD_TO_BASKET_ACTION" => $arParams['ADD_TO_BASKET_ACTION'],
                            "AJAX_MODE" => $arParams["AJAX_MODE"],
                            "AJAX_OPTION_ADDITIONAL" => $arParams["AJAX_OPTION_ADDITIONAL"],
                            "AJAX_OPTION_HISTORY" => $arParams["AJAX_OPTION_HISTORY"],
                            "AJAX_OPTION_JUMP" => $arParams["AJAX_OPTION_JUMP"],
                            "AJAX_OPTION_STYLE" => $arParams["AJAX_OPTION_STYLE"],
                            "BACKGROUND_IMAGE" => $arParams["BACKGROUND_IMAGE"],
                            "BASKET_URL" => SITE_DIR."basket/",
                            "BROWSER_TITLE" => $arParams["BROWSER_TITLE"],
                            "CACHE_FILTER" => $arParams["CACHE_FILTER"],
                            "CACHE_GROUPS" => $arParams['CACHE_GROUPS'],
                            "CACHE_TIME" => $arParams['CACHE_TIME'],
                            "CACHE_TYPE" => $arParams['CACHE_TYPE'],
                            "COMPATIBLE_MODE" => $arParams["COMPATIBLE_MODE"],
                            "CONVERT_CURRENCY" => $arParams["CONVERT_CURRENCY"],
                            "CUSTOM_FILTER" => $arParams["CUSTOM_FILTER"],
                            "DETAIL_URL" => $arParams["DETAIL_URL"],
                            "DISABLE_INIT_JS_IN_COMPONENT" => $arParams["DISABLE_INIT_JS_IN_COMPONENT"],
                            "DISPLAY_BOTTOM_PAGER" => $arParams["DISPLAY_BOTTOM_PAGER"],
                            "DISPLAY_COMPARE" => $arParams['DISPLAY_COMPARE'],
                            "DISPLAY_TOP_PAGER" => $arParams["DISPLAY_TOP_PAGER"],
                            "ELEMENT_SORT_FIELD" => $arParams["ELEMENT_SORT_FIELD"],
                            "ELEMENT_SORT_FIELD2" => $arParams["ELEMENT_SORT_FIELD2"],
                            "ELEMENT_SORT_ORDER" => $arParams["ELEMENT_SORT_ORDER"],
                            "ELEMENT_SORT_ORDER2" => $arParams["ELEMENT_SORT_ORDER2"],
                            "ENLARGE_PRODUCT" => $arParams["ENLARGE_PRODUCT"],
                            "FILTER_NAME" => "NotItItem",
                            "HIDE_NOT_AVAILABLE" => $arParams["HIDE_NOT_AVAILABLE"],
                            "HIDE_NOT_AVAILABLE_OFFERS" => $arParams["HIDE_NOT_AVAILABLE_OFFERS"],
                            "IBLOCK_ID" => $arParams['IBLOCK_ID'],
                            "IBLOCK_TYPE" => $arParams['IBLOCK_TYPE'],
                            "INCLUDE_SUBSECTIONS" => $arParams["INCLUDE_SUBSECTIONS"],
                            "LABEL_PROP" => $arParams['LABEL_PROP'],
                            "LAZY_LOAD" => $arParams["LAZY_LOAD"],
                            "LINE_ELEMENT_COUNT" => $arParams["LINE_ELEMENT_COUNT"],
                            "LOAD_ON_SCROLL" => $arParams["LOAD_ON_SCROLL"],
                            "MESSAGE_404" => $arParams["MESSAGE_404"],
                            "MESS_BTN_ADD_TO_BASKET" => $arParams['MESS_BTN_ADD_TO_BASKET'],
                            "MESS_BTN_BUY" => $arParams['MESS_BTN_BUY'],
                            "MESS_BTN_DETAIL" => $arParams['MESS_BTN_DETAIL'],
                            "MESS_BTN_SUBSCRIBE" => $arParams['MESS_BTN_SUBSCRIBE'],
                            "MESS_NOT_AVAILABLE" => $arParams['MESS_NOT_AVAILABLE'],
                            "META_DESCRIPTION" => $arParams["META_DESCRIPTION"],
                            "META_KEYWORDS" => $arParams["META_KEYWORDS"],
                            "OFFERS_CART_PROPERTIES" => $arParams['OFFERS_CART_PROPERTIES'],
                            "OFFERS_FIELD_CODE" => $arParams['OFFERS_FIELD_CODE'],
                            "OFFERS_LIMIT" => $arParams["OFFERS_LIMIT"],
                            "OFFERS_PROPERTY_CODE" => $arParams['OFFERS_PROPERTY_CODE'],
                            "OFFERS_SORT_FIELD" => $arParams["OFFERS_SORT_FIELD"],
                            "OFFERS_SORT_FIELD2" => $arParams["OFFERS_SORT_FIELD2"],
                            "OFFERS_SORT_ORDER" => $arParams["OFFERS_SORT_ORDER"],
                            "OFFERS_SORT_ORDER2" => $arParams["OFFERS_SORT_ORDER2"],
                            "PAGER_BASE_LINK_ENABLE" => $arParams["PAGER_BASE_LINK_ENABLE"],
                            "PAGER_DESC_NUMBERING" => $arParams["PAGER_DESC_NUMBERING"],
                            "PAGER_DESC_NUMBERING_CACHE_TIME" => $arParams["PAGER_DESC_NUMBERING_CACHE_TIME"],
                            "PAGER_SHOW_ALL" => $arParams["PAGER_SHOW_ALL"],
                            "PAGER_SHOW_ALWAYS" => $arParams["PAGER_SHOW_ALWAYS"],
                            "PAGER_TEMPLATE" => $arParams["PAGER_TEMPLATE"],
                            "PAGER_TITLE" => $arParams["PAGER_TITLE"],
                            "PAGE_ELEMENT_COUNT" => $arParams["PAGE_ELEMENT_COUNT"],
                            "PARTIAL_PRODUCT_PROPERTIES" => $arParams["PARTIAL_PRODUCT_PROPERTIES"],
                            "PRICE_CODE" => $arParams['PRICE_CODE'],
                            "PRICE_VAT_INCLUDE" => $arParams["PRICE_VAT_INCLUDE"],
                            "PRODUCT_BLOCKS_ORDER" => $arParams["PRODUCT_BLOCKS_ORDER"],
                            "PRODUCT_DISPLAY_MODE" => "N",
                            "PRODUCT_ID_VARIABLE" => $arParams["PRODUCT_ID_VARIABLE"],
                            "PRODUCT_PROPERTIES" => $arParams["PRODUCT_PROPERTIES"],
                            "PRODUCT_PROPS_VARIABLE" => $arParams["PRODUCT_PROPS_VARIABLE"],
                            "PRODUCT_QUANTITY_VARIABLE" => $arParams["PRODUCT_QUANTITY_VARIABLE"],
                            "PRODUCT_ROW_VARIANTS" => $arParams["PRODUCT_ROW_VARIANTS"],
                            "PRODUCT_SUBSCRIPTION" => $arParams["PRODUCT_SUBSCRIPTION"],
                            "PROPERTY_CODE" => $arParams['PROPERTY_CODE'],
                            "PROPERTY_CODE_MOBILE" => $arParams["PROPERTY_CODE_MOBILE"],
                            "RCM_PROD_ID" => $arParams["RCM_PROD_ID"],
                            "RCM_TYPE" => $arParams["RCM_TYPE"],
                            "SECTION_CODE" => $arParams["SECTION_CODE"],
                            "SECTION_ID" => "", //$arResult['IBLOCK_SECTION_ID'], //"", //$arParams["IBLOCK_SECTION_ID"],
                            "SECTION_ID_VARIABLE" => $arParams["SECTION_ID_VARIABLE"],
                            "SECTION_URL" => $arParams["SECTION_URL"],
                            "SECTION_USER_FIELDS" => $arParams["SECTION_USER_FIELDS"],
                            "SEF_MODE" => $arParams["SEF_MODE"],
                            "SET_BROWSER_TITLE" => $arParams["SET_BROWSER_TITLE"],
                            "SET_LAST_MODIFIED" => $arParams["SET_LAST_MODIFIED"],
                            "SET_META_DESCRIPTION" => $arParams["SET_META_DESCRIPTION"],
                            "SET_META_KEYWORDS" => $arParams["SET_META_KEYWORDS"],
                            "SET_STATUS_404" => $arParams["SET_STATUS_404"],
                            "SET_TITLE" => $arParams["SET_TITLE"],
                            "SHOW_404" => $arParams["SHOW_404"],
                            "SHOW_ALL_WO_SECTION" => $arParams["SHOW_ALL_WO_SECTION"],
                            "SHOW_CLOSE_POPUP" => $arParams['SHOW_CLOSE_POPUP'],
                            "SHOW_DISCOUNT_PERCENT" => $arParams['SHOW_DISCOUNT_PERCENT'],
                            "SHOW_FROM_SECTION" => $arParams["SHOW_FROM_SECTION"],
                            "SHOW_MAX_QUANTITY" => $arParams['SHOW_MAX_QUANTITY'],
                            "SHOW_OLD_PRICE" => $arParams["SHOW_OLD_PRICE"],
                            "SHOW_PRICE_COUNT" => $arParams["SHOW_PRICE_COUNT"],
                            "SHOW_SLIDER" => $arParams["SHOW_SLIDER"],
                            "SLIDER_INTERVAL" => $arParams["SLIDER_INTERVAL"],
                            "SLIDER_PROGRESS" => $arParams["SLIDER_PROGRESS"],
                            "TEMPLATE_THEME" => $arParams["TEMPLATE_THEME"],
                            "USE_ENHANCED_ECOMMERCE" => $arParams["USE_ENHANCED_ECOMMERCE"],
                            "USE_MAIN_ELEMENT_SECTION" => $arParams["USE_MAIN_ELEMENT_SECTION"],
                            "USE_PRICE_COUNT" => $arParams["USE_PRICE_COUNT"],
                            "USE_PRODUCT_QUANTITY" => "Y",
                            "USE_FILTER" => $arParams["USE_FILTER"],
                            "COMPONENT_TEMPLATE" => $arParams["COMPONENT_TEMPLATE"],
                            "OFFER_ADD_PICT_PROP" => $arParams["OFFER_ADD_PICT_PROP"],
                            "OFFER_TREE_PROPS" => $arParams["OFFER_TREE_PROPS"],
                            "DISCOUNT_PERCENT_POSITION" => $arParams["DISCOUNT_PERCENT_POSITION"],
                            "SEF_RULE" => $arParams["SEF_RULE"],
                            "SECTION_CODE_PATH" => $arParams["SECTION_CODE_PATH"],
                            "LABEL_PROP_MOBILE" => $arParams["LABEL_PROP_MOBILE"],
                            "LABEL_PROP_POSITION" => $arParams["LABEL_PROP_POSITION"]
                        ),
                        $component
                    );?>
                </div>
            </div>
        </div>

        <?php if(!empty($arResult['PROPERTIES']['RECOMEND_PRODUCT']['VALUE'])){?>
            <div class="product-detail-slider product-detail-recommend-slider mini-quantity-btn-slider">
                <div class="slider_wrapper">
                    <h2><?=Loc::getMessage('K_MORE_BUY_TITLE')?></h2>
                    <div class="slider inner-slider">
                        <?php $GLOBALS['arrFilterRe'] = array('ID' => $arResult['PROPERTIES']['RECOMEND_PRODUCT']['VALUE'])?>
                        <?$APPLICATION->IncludeComponent(
                            "bitrix:catalog.section",
                            "product-slider",
                            array(
                                "ACTION_VARIABLE" => "action",
                                "ADD_PICT_PROP" => $arParams["ADD_PICT_PROP"],
                                "ADD_PROPERTIES_TO_BASKET" => $arParams['ADD_PROPERTIES_TO_BASKET'],
                                "ADD_SECTIONS_CHAIN" => $arParams["ADD_SECTIONS_CHAIN"],
                                "ADD_TO_BASKET_ACTION" => $arParams['ADD_TO_BASKET_ACTION'],
                                "AJAX_MODE" => $arParams["AJAX_MODE"],
                                "AJAX_OPTION_ADDITIONAL" => $arParams["AJAX_OPTION_ADDITIONAL"],
                                "AJAX_OPTION_HISTORY" => $arParams["AJAX_OPTION_HISTORY"],
                                "AJAX_OPTION_JUMP" => $arParams["AJAX_OPTION_JUMP"],
                                "AJAX_OPTION_STYLE" => $arParams["AJAX_OPTION_STYLE"],
                                "BACKGROUND_IMAGE" => $arParams["BACKGROUND_IMAGE"],
                                "BASKET_URL" => SITE_DIR."basket/",
                                "BROWSER_TITLE" => $arParams["BROWSER_TITLE"],
                                "CACHE_FILTER" => $arParams["CACHE_FILTER"],
                                "CACHE_GROUPS" => $arParams['CACHE_GROUPS'],
                                "CACHE_TIME" => $arParams['CACHE_TIME'],
                                "CACHE_TYPE" => $arParams['CACHE_TYPE'],
                                "COMPATIBLE_MODE" => $arParams["COMPATIBLE_MODE"],
                                "CONVERT_CURRENCY" => $arParams["CONVERT_CURRENCY"],
                                "CUSTOM_FILTER" => $arParams["CUSTOM_FILTER"],
                                "DETAIL_URL" => $arParams["DETAIL_URL"],
                                "DISABLE_INIT_JS_IN_COMPONENT" => $arParams["DISABLE_INIT_JS_IN_COMPONENT"],
                                "DISPLAY_BOTTOM_PAGER" => $arParams["DISPLAY_BOTTOM_PAGER"],
                                "DISPLAY_COMPARE" => $arParams['DISPLAY_COMPARE'],
                                "DISPLAY_TOP_PAGER" => $arParams["DISPLAY_TOP_PAGER"],
                                "ELEMENT_SORT_FIELD" => $arParams["ELEMENT_SORT_FIELD"],
                                "ELEMENT_SORT_FIELD2" => $arParams["ELEMENT_SORT_FIELD2"],
                                "ELEMENT_SORT_ORDER" => $arParams["ELEMENT_SORT_ORDER"],
                                "ELEMENT_SORT_ORDER2" => $arParams["ELEMENT_SORT_ORDER2"],
                                "ENLARGE_PRODUCT" => $arParams["ENLARGE_PRODUCT"],
                                "FILTER_NAME" => "arrFilterRe",
                                "HIDE_NOT_AVAILABLE" => $arParams["HIDE_NOT_AVAILABLE"],
                                "HIDE_NOT_AVAILABLE_OFFERS" => $arParams["HIDE_NOT_AVAILABLE_OFFERS"],
                                "IBLOCK_ID" => $arParams['IBLOCK_ID'],
                                "IBLOCK_TYPE" => $arParams['IBLOCK_TYPE'],
                                "INCLUDE_SUBSECTIONS" => $arParams["INCLUDE_SUBSECTIONS"],
                                "LABEL_PROP" => $arParams['LABEL_PROP'],
                                "LAZY_LOAD" => $arParams["LAZY_LOAD"],
                                "LINE_ELEMENT_COUNT" => $arParams["LINE_ELEMENT_COUNT"],
                                "LOAD_ON_SCROLL" => $arParams["LOAD_ON_SCROLL"],
                                "MESSAGE_404" => $arParams["MESSAGE_404"],
                                "MESS_BTN_ADD_TO_BASKET" => $arParams['MESS_BTN_ADD_TO_BASKET'],
                                "MESS_BTN_BUY" => $arParams['MESS_BTN_BUY'],
                                "MESS_BTN_DETAIL" => $arParams['MESS_BTN_DETAIL'],
                                "MESS_BTN_SUBSCRIBE" => $arParams['MESS_BTN_SUBSCRIBE'],
                                "MESS_NOT_AVAILABLE" => $arParams['MESS_NOT_AVAILABLE'],
                                "META_DESCRIPTION" => $arParams["META_DESCRIPTION"],
                                "META_KEYWORDS" => $arParams["META_KEYWORDS"],
                                "OFFERS_CART_PROPERTIES" => $arParams['OFFERS_CART_PROPERTIES'],
                                "OFFERS_FIELD_CODE" => $arParams['OFFERS_FIELD_CODE'],
                                "OFFERS_LIMIT" => $arParams["OFFERS_LIMIT"],
                                "OFFERS_PROPERTY_CODE" => $arParams['OFFERS_PROPERTY_CODE'],
                                "OFFERS_SORT_FIELD" => $arParams["OFFERS_SORT_FIELD"],
                                "OFFERS_SORT_FIELD2" => $arParams["OFFERS_SORT_FIELD2"],
                                "OFFERS_SORT_ORDER" => $arParams["OFFERS_SORT_ORDER"],
                                "OFFERS_SORT_ORDER2" => $arParams["OFFERS_SORT_ORDER2"],
                                "PAGER_BASE_LINK_ENABLE" => $arParams["PAGER_BASE_LINK_ENABLE"],
                                "PAGER_DESC_NUMBERING" => $arParams["PAGER_DESC_NUMBERING"],
                                "PAGER_DESC_NUMBERING_CACHE_TIME" => $arParams["PAGER_DESC_NUMBERING_CACHE_TIME"],
                                "PAGER_SHOW_ALL" => $arParams["PAGER_SHOW_ALL"],
                                "PAGER_SHOW_ALWAYS" => $arParams["PAGER_SHOW_ALWAYS"],
                                "PAGER_TEMPLATE" => $arParams["PAGER_TEMPLATE"],
                                "PAGER_TITLE" => $arParams["PAGER_TITLE"],
                                "PAGE_ELEMENT_COUNT" => $arParams["PAGE_ELEMENT_COUNT"],
                                "PARTIAL_PRODUCT_PROPERTIES" => $arParams["PARTIAL_PRODUCT_PROPERTIES"],
                                "PRICE_CODE" => $arParams['PRICE_CODE'],
                                "PRICE_VAT_INCLUDE" => $arParams["PRICE_VAT_INCLUDE"],
                                "PRODUCT_BLOCKS_ORDER" => $arParams["PRODUCT_BLOCKS_ORDER"],
                                "PRODUCT_DISPLAY_MODE" => $arParams["PRODUCT_DISPLAY_MODE"],
                                "PRODUCT_ID_VARIABLE" => $arParams["PRODUCT_ID_VARIABLE"],
                                "PRODUCT_PROPERTIES" => $arParams["PRODUCT_PROPERTIES"],
                                "PRODUCT_PROPS_VARIABLE" => $arParams["PRODUCT_PROPS_VARIABLE"],
                                "PRODUCT_QUANTITY_VARIABLE" => $arParams["PRODUCT_QUANTITY_VARIABLE"],
                                "PRODUCT_ROW_VARIANTS" => $arParams["PRODUCT_ROW_VARIANTS"],
                                "PRODUCT_SUBSCRIPTION" => $arParams["PRODUCT_SUBSCRIPTION"],
                                "PROPERTY_CODE" => $arParams['PROPERTY_CODE'],
                                "PROPERTY_CODE_MOBILE" => $arParams["PROPERTY_CODE_MOBILE"],
                                "RCM_PROD_ID" => $arParams["RCM_PROD_ID"],
                                "RCM_TYPE" => $arParams["RCM_TYPE"],
                                "SECTION_CODE" => "",
                                "SECTION_ID" => "",
                                "SECTION_ID_VARIABLE" => "SECTION_ID",
                                "SECTION_URL" => "",
                                "SECTION_USER_FIELDS" => array(
                                    0 => "",
                                    1 => "",
                                ),
                                "SEF_MODE" => $arParams["SEF_MODE"],
                                "SET_BROWSER_TITLE" => $arParams["SET_BROWSER_TITLE"],
                                "SET_LAST_MODIFIED" => $arParams["SET_LAST_MODIFIED"],
                                "SET_META_DESCRIPTION" => $arParams["SET_META_DESCRIPTION"],
                                "SET_META_KEYWORDS" => $arParams["SET_META_KEYWORDS"],
                                "SET_STATUS_404" => $arParams["SET_STATUS_404"],
                                "SET_TITLE" => $arParams["SET_TITLE"],
                                "SHOW_404" => $arParams["SHOW_404"],
                                "SHOW_ALL_WO_SECTION" => "Y",
                                "SHOW_CLOSE_POPUP" => $arParams['SHOW_CLOSE_POPUP'],
                                "SHOW_DISCOUNT_PERCENT" => $arParams['SHOW_DISCOUNT_PERCENT'],
                                "SHOW_FROM_SECTION" => $arParams["SHOW_FROM_SECTION"],
                                "SHOW_MAX_QUANTITY" => $arParams['SHOW_MAX_QUANTITY'],
                                "SHOW_OLD_PRICE" => $arParams["SHOW_OLD_PRICE"],
                                "SHOW_PRICE_COUNT" => $arParams["SHOW_PRICE_COUNT"],
                                "SHOW_SLIDER" => $arParams["SHOW_SLIDER"],
                                "SLIDER_INTERVAL" => $arParams["SLIDER_INTERVAL"],
                                "SLIDER_PROGRESS" => $arParams["SLIDER_PROGRESS"],
                                "TEMPLATE_THEME" => $arParams["TEMPLATE_THEME"],
                                "USE_ENHANCED_ECOMMERCE" => $arParams["USE_ENHANCED_ECOMMERCE"],
                                "USE_MAIN_ELEMENT_SECTION" => $arParams["USE_MAIN_ELEMENT_SECTION"],
                                "USE_PRICE_COUNT" => $arParams["USE_PRICE_COUNT"],
                                "USE_PRODUCT_QUANTITY" => "Y",
                                "USE_FILTER" => $arParams["USE_FILTER"],
                                "COMPONENT_TEMPLATE" => $arParams["COMPONENT_TEMPLATE"],
                                "OFFER_ADD_PICT_PROP" => $arParams["OFFER_ADD_PICT_PROP"],
                                "OFFER_TREE_PROPS" => $arParams["OFFER_TREE_PROPS"],
                                "DISCOUNT_PERCENT_POSITION" => $arParams["DISCOUNT_PERCENT_POSITION"],
                                "SEF_RULE" => $arParams["SEF_RULE"],
                                "SECTION_CODE_PATH" => $arParams["SECTION_CODE_PATH"],
                                "LABEL_PROP_MOBILE" => $arParams["LABEL_PROP_MOBILE"],
                                "LABEL_PROP_POSITION" => $arParams["LABEL_PROP_POSITION"]
                            ),
                            $component
                        );?>
                    </div>
                </div>
            </div>

        <?php }?>

        <?
        if ($arParams['BRAND_USE'] === 'Y')
        {
            ?>
            <div class="col-sm-4 col-md-3" style="display: none;">
                <? $APPLICATION->IncludeComponent('bitrix:catalog.brandblock', 'bootstrap_v4', array(
                    'IBLOCK_TYPE' => $arParams['IBLOCK_TYPE'],
                    'IBLOCK_ID' => $arParams['IBLOCK_ID'],
                    'ELEMENT_ID' => $arResult['ID'],
                    'ELEMENT_CODE' => '',
                    'PROP_CODE' => $arParams['BRAND_PROP_CODE'],
                    'CACHE_TYPE' => $arParams['CACHE_TYPE'],
                    'CACHE_TIME' => $arParams['CACHE_TIME'],
                    'CACHE_GROUPS' => $arParams['CACHE_GROUPS'],
                    'WIDTH' => '',
                    'HEIGHT' => ''
                ),
                    $component,
                    array('HIDE_ICONS' => 'Y')
                );
                ?>
            </div>
            <?
        }
        ?>

        <?
        if ($arResult['CATALOG'] && $actualItem['CAN_BUY'] && \Bitrix\Main\ModuleManager::isModuleInstalled('sale'))
        {
            $APPLICATION->IncludeComponent(
                'bitrix:sale.prediction.product.detail',
                'main',
                array(
                    'CUSTOM_SITE_ID' => isset($arParams['CUSTOM_SITE_ID']) ? $arParams['CUSTOM_SITE_ID'] : null,
                    'BUTTON_ID' => 'sale_prediction',
                    'POTENTIAL_PRODUCT_TO_BUY' => array(
                        'ID' => isset($arResult['ID']) ? $arResult['ID'] : null,
                        'MODULE' => isset($arResult['MODULE']) ? $arResult['MODULE'] : 'catalog',
                        'PRODUCT_PROVIDER_CLASS' => isset($arResult['PRODUCT_PROVIDER_CLASS']) ? $arResult['PRODUCT_PROVIDER_CLASS'] : 'CCatalogProductProvider',
                        'QUANTITY' => isset($arResult['QUANTITY']) ? $arResult['QUANTITY'] : null,
                        'IBLOCK_ID' => isset($arResult['IBLOCK_ID']) ? $arResult['IBLOCK_ID'] : null,

                        'PRIMARY_OFFER_ID' => isset($arResult['OFFERS'][0]['ID']) ? $arResult['OFFERS'][0]['ID'] : null,
                        'SECTION' => array(
                            'ID' => isset($arResult['SECTION']['ID']) ? $arResult['SECTION']['ID'] : null,
                            'IBLOCK_ID' => isset($arResult['SECTION']['IBLOCK_ID']) ? $arResult['SECTION']['IBLOCK_ID'] : null,
                            'LEFT_MARGIN' => isset($arResult['SECTION']['LEFT_MARGIN']) ? $arResult['SECTION']['LEFT_MARGIN'] : null,
                            'RIGHT_MARGIN' => isset($arResult['SECTION']['RIGHT_MARGIN']) ? $arResult['SECTION']['RIGHT_MARGIN'] : null,
                        ),
                    )
                ),
                $component,
                array('HIDE_ICONS' => 'Y')
            );
        }

        if ($arResult['CATALOG'] && $arParams['USE_GIFTS_DETAIL'] == 'Y' && \Bitrix\Main\ModuleManager::isModuleInstalled('sale'))
        {
            ?>
            <div data-entity="parent-container">
                <?
                if (!isset($arParams['GIFTS_DETAIL_HIDE_BLOCK_TITLE']) || $arParams['GIFTS_DETAIL_HIDE_BLOCK_TITLE'] !== 'Y')
                {
                    ?>
                    <div class="catalog-block-header" data-entity="header" data-showed="false" style="display: none; opacity: 0;">
                        <?=($arParams['GIFTS_DETAIL_BLOCK_TITLE'] ?: Loc::getMessage('CT_BCE_CATALOG_GIFT_BLOCK_TITLE_DEFAULT'))?>
                    </div>
                    <?
                }

                CBitrixComponent::includeComponentClass('bitrix:sale.products.gift');
                $APPLICATION->IncludeComponent('bitrix:sale.products.gift', 'bootstrap_v4', array(
                    'CUSTOM_SITE_ID' => isset($arParams['CUSTOM_SITE_ID']) ? $arParams['CUSTOM_SITE_ID'] : null,
                    'PRODUCT_ID_VARIABLE' => $arParams['PRODUCT_ID_VARIABLE'],
                    'ACTION_VARIABLE' => $arParams['ACTION_VARIABLE'],

                    'PRODUCT_ROW_VARIANTS' => "",
                    'PAGE_ELEMENT_COUNT' => 0,
                    'DEFERRED_PRODUCT_ROW_VARIANTS' => \Bitrix\Main\Web\Json::encode(
                        SaleProductsGiftComponent::predictRowVariants(
                            $arParams['GIFTS_DETAIL_PAGE_ELEMENT_COUNT'],
                            $arParams['GIFTS_DETAIL_PAGE_ELEMENT_COUNT']
                        )
                    ),
                    'DEFERRED_PAGE_ELEMENT_COUNT' => $arParams['GIFTS_DETAIL_PAGE_ELEMENT_COUNT'],

                    'SHOW_DISCOUNT_PERCENT' => $arParams['GIFTS_SHOW_DISCOUNT_PERCENT'],
                    'DISCOUNT_PERCENT_POSITION' => $arParams['DISCOUNT_PERCENT_POSITION'],
                    'SHOW_OLD_PRICE' => $arParams['GIFTS_SHOW_OLD_PRICE'],
                    'PRODUCT_DISPLAY_MODE' => 'Y',
                    'PRODUCT_BLOCKS_ORDER' => $arParams['GIFTS_PRODUCT_BLOCKS_ORDER'],
                    'SHOW_SLIDER' => $arParams['GIFTS_SHOW_SLIDER'],
                    'SLIDER_INTERVAL' => isset($arParams['GIFTS_SLIDER_INTERVAL']) ? $arParams['GIFTS_SLIDER_INTERVAL'] : '',
                    'SLIDER_PROGRESS' => isset($arParams['GIFTS_SLIDER_PROGRESS']) ? $arParams['GIFTS_SLIDER_PROGRESS'] : '',

                    'TEXT_LABEL_GIFT' => $arParams['GIFTS_DETAIL_TEXT_LABEL_GIFT'],

                    'LABEL_PROP_'.$arParams['IBLOCK_ID'] => array(),
                    'LABEL_PROP_MOBILE_'.$arParams['IBLOCK_ID'] => array(),
                    'LABEL_PROP_POSITION' => $arParams['LABEL_PROP_POSITION'],

                    'ADD_TO_BASKET_ACTION' => (isset($arParams['ADD_TO_BASKET_ACTION']) ? $arParams['ADD_TO_BASKET_ACTION'] : ''),
                    'MESS_BTN_BUY' => $arParams['~GIFTS_MESS_BTN_BUY'],
                    'MESS_BTN_ADD_TO_BASKET' => $arParams['~GIFTS_MESS_BTN_BUY'],
                    'MESS_BTN_DETAIL' => $arParams['~MESS_BTN_DETAIL'],
                    'MESS_BTN_SUBSCRIBE' => $arParams['~MESS_BTN_SUBSCRIBE'],

                    'SHOW_PRODUCTS_'.$arParams['IBLOCK_ID'] => 'Y',
                    'PROPERTY_CODE_'.$arParams['IBLOCK_ID'] => $arParams['LIST_PROPERTY_CODE'],
                    'PROPERTY_CODE_MOBILE'.$arParams['IBLOCK_ID'] => $arParams['LIST_PROPERTY_CODE_MOBILE'],
                    'PROPERTY_CODE_'.$arResult['OFFERS_IBLOCK'] => $arParams['OFFER_TREE_PROPS'],
                    'OFFER_TREE_PROPS_'.$arResult['OFFERS_IBLOCK'] => $arParams['OFFER_TREE_PROPS'],
                    'CART_PROPERTIES_'.$arResult['OFFERS_IBLOCK'] => $arParams['OFFERS_CART_PROPERTIES'],
                    'ADDITIONAL_PICT_PROP_'.$arParams['IBLOCK_ID'] => (isset($arParams['ADD_PICT_PROP']) ? $arParams['ADD_PICT_PROP'] : ''),
                    'ADDITIONAL_PICT_PROP_'.$arResult['OFFERS_IBLOCK'] => (isset($arParams['OFFER_ADD_PICT_PROP']) ? $arParams['OFFER_ADD_PICT_PROP'] : ''),

                    'HIDE_NOT_AVAILABLE' => 'Y',
                    'HIDE_NOT_AVAILABLE_OFFERS' => 'Y',
                    'PRODUCT_SUBSCRIPTION' => $arParams['PRODUCT_SUBSCRIPTION'],
                    'TEMPLATE_THEME' => $arParams['TEMPLATE_THEME'],
                    'PRICE_CODE' => $arParams['PRICE_CODE'],
                    'SHOW_PRICE_COUNT' => $arParams['SHOW_PRICE_COUNT'],
                    'PRICE_VAT_INCLUDE' => $arParams['PRICE_VAT_INCLUDE'],
                    'CONVERT_CURRENCY' => $arParams['CONVERT_CURRENCY'],
                    'BASKET_URL' => $arParams['BASKET_URL'],
                    'ADD_PROPERTIES_TO_BASKET' => $arParams['ADD_PROPERTIES_TO_BASKET'],
                    'PRODUCT_PROPS_VARIABLE' => $arParams['PRODUCT_PROPS_VARIABLE'],
                    'PARTIAL_PRODUCT_PROPERTIES' => $arParams['PARTIAL_PRODUCT_PROPERTIES'],
                    'USE_PRODUCT_QUANTITY' => "Y", //$arParams['USE_PRODUCT_QUANTITY'],
                    'PRODUCT_QUANTITY_VARIABLE' => $arParams['PRODUCT_QUANTITY_VARIABLE'],
                    'CACHE_GROUPS' => $arParams['CACHE_GROUPS'],
                    'POTENTIAL_PRODUCT_TO_BUY' => array(
                        'ID' => isset($arResult['ID']) ? $arResult['ID'] : null,
                        'MODULE' => isset($arResult['MODULE']) ? $arResult['MODULE'] : 'catalog',
                        'PRODUCT_PROVIDER_CLASS' => isset($arResult['PRODUCT_PROVIDER_CLASS']) ? $arResult['PRODUCT_PROVIDER_CLASS'] : 'CCatalogProductProvider',
                        'QUANTITY' => isset($arResult['QUANTITY']) ? $arResult['QUANTITY'] : null,
                        'IBLOCK_ID' => isset($arResult['IBLOCK_ID']) ? $arResult['IBLOCK_ID'] : null,

                        'PRIMARY_OFFER_ID' => isset($arResult['OFFERS'][$arResult['OFFERS_SELECTED']]['ID'])
                            ? $arResult['OFFERS'][$arResult['OFFERS_SELECTED']]['ID']
                            : null,
                        'SECTION' => array(
                            'ID' => isset($arResult['SECTION']['ID']) ? $arResult['SECTION']['ID'] : null,
                            'IBLOCK_ID' => isset($arResult['SECTION']['IBLOCK_ID']) ? $arResult['SECTION']['IBLOCK_ID'] : null,
                            'LEFT_MARGIN' => isset($arResult['SECTION']['LEFT_MARGIN']) ? $arResult['SECTION']['LEFT_MARGIN'] : null,
                            'RIGHT_MARGIN' => isset($arResult['SECTION']['RIGHT_MARGIN']) ? $arResult['SECTION']['RIGHT_MARGIN'] : null,
                        ),
                    ),

                    'USE_ENHANCED_ECOMMERCE' => $arParams['USE_ENHANCED_ECOMMERCE'],
                    'DATA_LAYER_NAME' => $arParams['DATA_LAYER_NAME'],
                    'BRAND_PROPERTY' => $arParams['BRAND_PROPERTY']
                ),
                    $component,
                    array('HIDE_ICONS' => 'Y')
                );
                ?>
            </div>
            <?
        }

        if ($arResult['CATALOG'] && $arParams['USE_GIFTS_MAIN_PR_SECTION_LIST'] == 'Y' && \Bitrix\Main\ModuleManager::isModuleInstalled('sale'))
        {
            ?>
            <div data-entity="parent-container">
                <?
                if (!isset($arParams['GIFTS_MAIN_PRODUCT_DETAIL_HIDE_BLOCK_TITLE']) || $arParams['GIFTS_MAIN_PRODUCT_DETAIL_HIDE_BLOCK_TITLE'] !== 'Y')
                {
                    ?>
                    <div class="catalog-block-header" data-entity="header" data-showed="false" style="display: none; opacity: 0;">
                        <?=($arParams['GIFTS_MAIN_PRODUCT_DETAIL_BLOCK_TITLE'] ?: Loc::getMessage('CT_BCE_CATALOG_GIFTS_MAIN_BLOCK_TITLE_DEFAULT'))?>
                    </div>
                    <?
                }

                $APPLICATION->IncludeComponent('bitrix:sale.gift.main.products', 'bootstrap_v4', array(
                        'CUSTOM_SITE_ID' => isset($arParams['CUSTOM_SITE_ID']) ? $arParams['CUSTOM_SITE_ID'] : null,
                        'PAGE_ELEMENT_COUNT' => $arParams['GIFTS_MAIN_PRODUCT_DETAIL_PAGE_ELEMENT_COUNT'],
                        'LINE_ELEMENT_COUNT' => $arParams['GIFTS_MAIN_PRODUCT_DETAIL_PAGE_ELEMENT_COUNT'],
                        'HIDE_BLOCK_TITLE' => 'Y',
                        'BLOCK_TITLE' => $arParams['GIFTS_MAIN_PRODUCT_DETAIL_BLOCK_TITLE'],

                        'OFFERS_FIELD_CODE' => $arParams['OFFERS_FIELD_CODE'],
                        'OFFERS_PROPERTY_CODE' => $arParams['OFFERS_PROPERTY_CODE'],

                        'AJAX_MODE' => $arParams['AJAX_MODE'],
                        'IBLOCK_TYPE' => $arParams['IBLOCK_TYPE'],
                        'IBLOCK_ID' => $arParams['IBLOCK_ID'],

                        'ELEMENT_SORT_FIELD' => 'ID',
                        'ELEMENT_SORT_ORDER' => 'DESC',
                        //'ELEMENT_SORT_FIELD2' => $arParams['ELEMENT_SORT_FIELD2'],
                        //'ELEMENT_SORT_ORDER2' => $arParams['ELEMENT_SORT_ORDER2'],
                        'FILTER_NAME' => 'searchFilter',
                        'SECTION_URL' => $arParams['SECTION_URL'],
                        'DETAIL_URL' => $arParams['DETAIL_URL'],
                        'BASKET_URL' => $arParams['BASKET_URL'],
                        'ACTION_VARIABLE' => $arParams['ACTION_VARIABLE'],
                        'PRODUCT_ID_VARIABLE' => $arParams['PRODUCT_ID_VARIABLE'],
                        'SECTION_ID_VARIABLE' => $arParams['SECTION_ID_VARIABLE'],

                        'CACHE_TYPE' => $arParams['CACHE_TYPE'],
                        'CACHE_TIME' => $arParams['CACHE_TIME'],

                        'CACHE_GROUPS' => $arParams['CACHE_GROUPS'],
                        'SET_TITLE' => $arParams['SET_TITLE'],
                        'PROPERTY_CODE' => $arParams['PROPERTY_CODE'],
                        'PRICE_CODE' => $arParams['PRICE_CODE'],
                        'USE_PRICE_COUNT' => $arParams['USE_PRICE_COUNT'],
                        'SHOW_PRICE_COUNT' => $arParams['SHOW_PRICE_COUNT'],

                        'PRICE_VAT_INCLUDE' => $arParams['PRICE_VAT_INCLUDE'],
                        'CONVERT_CURRENCY' => $arParams['CONVERT_CURRENCY'],
                        'CURRENCY_ID' => $arParams['CURRENCY_ID'],
                        'HIDE_NOT_AVAILABLE' => 'Y',
                        'HIDE_NOT_AVAILABLE_OFFERS' => 'Y',
                        'TEMPLATE_THEME' => (isset($arParams['TEMPLATE_THEME']) ? $arParams['TEMPLATE_THEME'] : ''),
                        'PRODUCT_BLOCKS_ORDER' => $arParams['GIFTS_PRODUCT_BLOCKS_ORDER'],

                        'SHOW_SLIDER' => $arParams['GIFTS_SHOW_SLIDER'],
                        'SLIDER_INTERVAL' => isset($arParams['GIFTS_SLIDER_INTERVAL']) ? $arParams['GIFTS_SLIDER_INTERVAL'] : '',
                        'SLIDER_PROGRESS' => isset($arParams['GIFTS_SLIDER_PROGRESS']) ? $arParams['GIFTS_SLIDER_PROGRESS'] : '',

                        'ADD_PICT_PROP' => (isset($arParams['ADD_PICT_PROP']) ? $arParams['ADD_PICT_PROP'] : ''),
                        'LABEL_PROP' => (isset($arParams['LABEL_PROP']) ? $arParams['LABEL_PROP'] : ''),
                        'LABEL_PROP_MOBILE' => (isset($arParams['LABEL_PROP_MOBILE']) ? $arParams['LABEL_PROP_MOBILE'] : ''),
                        'LABEL_PROP_POSITION' => (isset($arParams['LABEL_PROP_POSITION']) ? $arParams['LABEL_PROP_POSITION'] : ''),
                        'OFFER_ADD_PICT_PROP' => (isset($arParams['OFFER_ADD_PICT_PROP']) ? $arParams['OFFER_ADD_PICT_PROP'] : ''),
                        'OFFER_TREE_PROPS' => (isset($arParams['OFFER_TREE_PROPS']) ? $arParams['OFFER_TREE_PROPS'] : ''),
                        'SHOW_DISCOUNT_PERCENT' => (isset($arParams['SHOW_DISCOUNT_PERCENT']) ? $arParams['SHOW_DISCOUNT_PERCENT'] : ''),
                        'DISCOUNT_PERCENT_POSITION' => (isset($arParams['DISCOUNT_PERCENT_POSITION']) ? $arParams['DISCOUNT_PERCENT_POSITION'] : ''),
                        'SHOW_OLD_PRICE' => (isset($arParams['SHOW_OLD_PRICE']) ? $arParams['SHOW_OLD_PRICE'] : ''),
                        'MESS_BTN_BUY' => (isset($arParams['~MESS_BTN_BUY']) ? $arParams['~MESS_BTN_BUY'] : ''),
                        'MESS_BTN_ADD_TO_BASKET' => (isset($arParams['~MESS_BTN_ADD_TO_BASKET']) ? $arParams['~MESS_BTN_ADD_TO_BASKET'] : ''),
                        'MESS_BTN_DETAIL' => (isset($arParams['~MESS_BTN_DETAIL']) ? $arParams['~MESS_BTN_DETAIL'] : ''),
                        'MESS_NOT_AVAILABLE' => (isset($arParams['~MESS_NOT_AVAILABLE']) ? $arParams['~MESS_NOT_AVAILABLE'] : ''),
                        'ADD_TO_BASKET_ACTION' => (isset($arParams['ADD_TO_BASKET_ACTION']) ? $arParams['ADD_TO_BASKET_ACTION'] : ''),
                        'SHOW_CLOSE_POPUP' => (isset($arParams['SHOW_CLOSE_POPUP']) ? $arParams['SHOW_CLOSE_POPUP'] : ''),
                        'DISPLAY_COMPARE' => (isset($arParams['DISPLAY_COMPARE']) ? $arParams['DISPLAY_COMPARE'] : ''),
                        'COMPARE_PATH' => (isset($arParams['COMPARE_PATH']) ? $arParams['COMPARE_PATH'] : ''),
                    )
                    + array(
                        'OFFER_ID' => empty($arResult['OFFERS'][$arResult['OFFERS_SELECTED']]['ID'])
                            ? $arResult['ID']
                            : $arResult['OFFERS'][$arResult['OFFERS_SELECTED']]['ID'],
                        'SECTION_ID' => $arResult['SECTION']['ID'],
                        'ELEMENT_ID' => $arResult['ID'],

                        'USE_ENHANCED_ECOMMERCE' => $arParams['USE_ENHANCED_ECOMMERCE'],
                        'DATA_LAYER_NAME' => $arParams['DATA_LAYER_NAME'],
                        'BRAND_PROPERTY' => $arParams['BRAND_PROPERTY']
                    ),
                    $component,
                    array('HIDE_ICONS' => 'Y')
                );
                ?>
            </div>
            <?
        }
        ?>

        <meta itemprop="name" content="<?=$name?>" />
        <meta itemprop="category" content="<?=$arResult['CATEGORY_PATH']?>" />
        <?
        if ($haveOffers)
        {
            foreach ($arResult['JS_OFFERS'] as $offer)
            {
                $currentOffersList = array();

                if (!empty($offer['TREE']) && is_array($offer['TREE']))
                {
                    foreach ($offer['TREE'] as $propName => $skuId)
                    {
                        $propId = (int)substr($propName, 5);

                        foreach ($skuProps as $prop)
                        {
                            if ($prop['ID'] == $propId)
                            {
                                foreach ($prop['VALUES'] as $propId => $propValue)
                                {
                                    if ($propId == $skuId)
                                    {
                                        $currentOffersList[] = $propValue['NAME'];
                                        break;
                                    }
                                }
                            }
                        }
                    }
                }

                $offerPrice = $offer['ITEM_PRICES'][$offer['ITEM_PRICE_SELECTED']];
                ?>
                <span itemprop="offers" itemscope itemtype="http://schema.org/Offer">
				<meta itemprop="sku" content="<?=htmlspecialcharsbx(implode('/', $currentOffersList))?>" />
				<meta itemprop="price" content="<?=$offerPrice['RATIO_PRICE']?>" />
				<meta itemprop="priceCurrency" content="<?=$offerPrice['CURRENCY']?>" />
				<link itemprop="availability" href="http://schema.org/<?=($offer['CAN_BUY'] ? 'InStock' : 'OutOfStock')?>" />
			</span>
                <?
            }

            unset($offerPrice, $currentOffersList);
        }
        else
        {
            ?>
            <span itemprop="offers" itemscope itemtype="http://schema.org/Offer">
			<meta itemprop="price" content="<?=$price['RATIO_PRICE']?>" />
			<meta itemprop="priceCurrency" content="<?=$price['CURRENCY']?>" />
			<link itemprop="availability" href="http://schema.org/<?=($actualItem['CAN_BUY'] ? 'InStock' : 'OutOfStock')?>" />
		</span>
            <?
        }
        ?>
        <?
        if ($haveOffers)
        {
            $offerIds = array();
            $offerCodes = array();

            $useRatio = $arParams['USE_RATIO_IN_RANGES'] === 'Y';

            foreach ($arResult['JS_OFFERS'] as $ind => &$jsOffer)
            {
                $offerIds[] = (int)$jsOffer['ID'];
                $offerCodes[] = $jsOffer['CODE'];

                $fullOffer = $arResult['OFFERS'][$ind];
                $measureName = $fullOffer['ITEM_MEASURE']['TITLE'];

                $strAllProps = '';
                $strMainProps = '';
                $strPriceRangesRatio = '';
                $strPriceRanges = '';
				$strPricePerKg = '';

                if ($arResult['SHOW_OFFERS_PROPS'])
                {
                    if (!empty($jsOffer['DISPLAY_PROPERTIES']))
                    {
                        foreach ($jsOffer['DISPLAY_PROPERTIES'] as $property)
                        {
                            $current = '<li class="product-item-detail-properties-item">
									<span class="product-item-detail-properties-name">'.$property['NAME'].'</span>
									<span class="product-item-detail-properties-dots"></span>
									<span class="product-item-detail-properties-value">'.(
                                is_array($property['VALUE'])
                                    ? implode(' / ', $property['VALUE'])
                                    : $property['VALUE']
                                ).'</span></li>';
                            $strAllProps .= $current;

                            if (isset($arParams['MAIN_BLOCK_OFFERS_PROPERTY_CODE'][$property['CODE']]))
                            {
                                $strMainProps .= $current;
                            }
							if ($property['CODE'] == 'TIME_MANUFACTURING')
							{
								$dateTime = new \Bitrix\Main\Type\DateTime();
								if(!empty($arResult['MOD_TIME_READY'])){
									$dateTime->add($arResult['MOD_TIME_READY']. " hours");
								}
								else{
									$dateTime->add($arResult['DISPLAY_PROPERTIES']['TIME_MANUFACTURING']['VALUE']. " hours");
								}
								$time = $dateTime->format("Y-m-d H:i");
								echo Loc::getMessage('MESS_READY_TIME', array("#TIME#"=>$time));
							}
                        }

                        unset($current);
                    }
                }

                if ($arParams['USE_PRICE_COUNT'] && count($jsOffer['ITEM_QUANTITY_RANGES']) > 1)
                {
                    $strPriceRangesRatio = '('.Loc::getMessage(
                            'CT_BCE_CATALOG_RATIO_PRICE',
                            array('#RATIO#' => ($useRatio
                                    ? $fullOffer['ITEM_MEASURE_RATIOS'][$fullOffer['ITEM_MEASURE_RATIO_SELECTED']]['RATIO']
                                    : '1'
                                ).' '.$measureName)
                        ).')';

                    foreach ($jsOffer['ITEM_QUANTITY_RANGES'] as $range)
                    {
                        if ($range['HASH'] !== 'ZERO-INF')
                        {
                            $itemPrice = false;

                            foreach ($jsOffer['ITEM_PRICES'] as $itemPrice)
                            {
                                if ($itemPrice['QUANTITY_HASH'] === $range['HASH'])
                                {
                                    break;
                                }
                            }

                            if ($itemPrice)
                            {
                                $strPriceRanges .= '<dt>'.Loc::getMessage(
                                        'CT_BCE_CATALOG_RANGE_FROM',
                                        array('#FROM#' => $range['SORT_FROM'].' '.$measureName)
                                    ).' ';

                                if (is_infinite($range['SORT_TO']))
                                {
                                    $strPriceRanges .= Loc::getMessage('CT_BCE_CATALOG_RANGE_MORE');
                                }
                                else
                                {
                                    $strPriceRanges .= Loc::getMessage(
                                        'CT_BCE_CATALOG_RANGE_TO',
                                        array('#TO#' => $range['SORT_TO'].' '.$measureName)
                                    );
                                }

                                $strPriceRanges .= '</dt><dd>'.($useRatio ? $itemPrice['PRINT_RATIO_PRICE'] : $itemPrice['PRINT_PRICE']).'</dd>';
                            }
                        }
                    }

                    unset($range, $itemPrice);
                }

				$offerPrice = $jsOffer['ITEM_PRICES'][$jsOffer['ITEM_PRICE_SELECTED']]['RATIO_PRICE'];
				if($fullOffer['PRODUCT']['WEIGHT'] && $offerPrice){
					$price_per_kg = ($offerPrice / $fullOffer['PRODUCT']['WEIGHT']) * 1000;
					$price_per_kg = number_format($price_per_kg, 0, '', ' ');
					$strPricePerKg = $price_per_kg. '<i class="fa fa-rub"></i> за 1кг';
				}

                $jsOffer['DISPLAY_READY_TIME_HTML'] = $strReadyTime;
				$jsOffer['DISPLAY_PRICE_PER_KG_HTML'] = $strPricePerKg;
                $jsOffer['DISPLAY_PROPERTIES'] = $strAllProps;
                $jsOffer['DISPLAY_PROPERTIES_MAIN_BLOCK'] = $strMainProps;
                $jsOffer['PRICE_RANGES_RATIO_HTML'] = $strPriceRangesRatio;
                $jsOffer['PRICE_RANGES_HTML'] = $strPriceRanges;
            }

            $templateData['OFFER_IDS'] = $offerIds;
            $templateData['OFFER_CODES'] = $offerCodes;
            unset($jsOffer, $strAllProps, $strReadyTime, $strPricePerKg, $strMainProps, $strPriceRanges, $strPriceRangesRatio, $useRatio);

            $jsParams = array(
                'CONFIG' => array(
                    'USE_CATALOG' => $arResult['CATALOG'],
                    'SHOW_QUANTITY' => $arParams['USE_PRODUCT_QUANTITY'],
                    'SHOW_PRICE' => true,
                    'SHOW_DISCOUNT_PERCENT' => $arParams['SHOW_DISCOUNT_PERCENT'] === 'Y',
                    'SHOW_OLD_PRICE' => $arParams['SHOW_OLD_PRICE'] === 'Y',
                    'USE_PRICE_COUNT' => $arParams['USE_PRICE_COUNT'],
                    'DISPLAY_COMPARE' => $arParams['DISPLAY_COMPARE'],
                    'SHOW_SKU_PROPS' => $arResult['SHOW_OFFERS_PROPS'],
                    'OFFER_GROUP' => $arResult['OFFER_GROUP'],
                    'MAIN_PICTURE_MODE' => $arParams['DETAIL_PICTURE_MODE'],
                    'ADD_TO_BASKET_ACTION' => $arParams['ADD_TO_BASKET_ACTION'],
                    'SHOW_CLOSE_POPUP' => $arParams['SHOW_CLOSE_POPUP'] === 'Y',
                    'SHOW_MAX_QUANTITY' => $arParams['SHOW_MAX_QUANTITY'],
                    'RELATIVE_QUANTITY_FACTOR' => $arParams['RELATIVE_QUANTITY_FACTOR'],
                    'TEMPLATE_THEME' => $arParams['TEMPLATE_THEME'],
                    'USE_STICKERS' => true,
                    'USE_SUBSCRIBE' => $showSubscribe,
                    'SHOW_SLIDER' => $arParams['SHOW_SLIDER'],
                    'SLIDER_INTERVAL' => $arParams['SLIDER_INTERVAL'],
                    'ALT' => $alt,
                    'TITLE' => $title,
                    'MAGNIFIER_ZOOM_PERCENT' => 200,
                    'USE_ENHANCED_ECOMMERCE' => $arParams['USE_ENHANCED_ECOMMERCE'],
                    'DATA_LAYER_NAME' => $arParams['DATA_LAYER_NAME'],
                    'BRAND_PROPERTY' => !empty($arResult['DISPLAY_PROPERTIES'][$arParams['BRAND_PROPERTY']])
                        ? $arResult['DISPLAY_PROPERTIES'][$arParams['BRAND_PROPERTY']]['DISPLAY_VALUE']
                        : null
                ),
                'PRODUCT_TYPE' => $arResult['CATALOG_TYPE'],
                'VISUAL' => $itemIds,
                'DEFAULT_PICTURE' => array(
                    'PREVIEW_PICTURE' => $arResult['DEFAULT_PICTURE'],
                    'DETAIL_PICTURE' => $arResult['DEFAULT_PICTURE']
                ),
                'PRODUCT' => array(
                    'ID' => $arResult['ID'],
                    'ACTIVE' => $arResult['ACTIVE'],
                    'NAME' => $arResult['~NAME'],
                    'CATEGORY' => $arResult['CATEGORY_PATH']
                ),
                'BASKET' => array(
                    'QUANTITY' => $arParams['PRODUCT_QUANTITY_VARIABLE'],
                    'BASKET_URL' => $arParams['BASKET_URL'],
                    'SKU_PROPS' => $arResult['OFFERS_PROP_CODES'],
                    'ADD_URL_TEMPLATE' => $arResult['~ADD_URL_TEMPLATE'],
                    'BUY_URL_TEMPLATE' => $arResult['~BUY_URL_TEMPLATE']
                ),
                'OFFERS' => $arResult['JS_OFFERS'],
                'OFFER_SELECTED' => $arResult['OFFERS_SELECTED'],
                'TREE_PROPS' => $skuProps
            );
        }
        else
        {
            $emptyProductProperties = empty($arResult['PRODUCT_PROPERTIES']);
            if ($arParams['ADD_PROPERTIES_TO_BASKET'] === 'Y' && !$emptyProductProperties)
            {
                ?>
                <div id="<?=$itemIds['BASKET_PROP_DIV']?>" style="display: none;">
                    <?
                    if (!empty($arResult['PRODUCT_PROPERTIES_FILL']))
                    {
                        foreach ($arResult['PRODUCT_PROPERTIES_FILL'] as $propId => $propInfo)
                        {
                            ?>
                            <input type="hidden" name="<?=$arParams['PRODUCT_PROPS_VARIABLE']?>[<?=$propId?>]" value="<?=htmlspecialcharsbx($propInfo['ID'])?>">
                            <?
                            unset($arResult['PRODUCT_PROPERTIES'][$propId]);
                        }
                    }

                    $emptyProductProperties = empty($arResult['PRODUCT_PROPERTIES']);
                    if (!$emptyProductProperties)
                    {
                        ?>
                        <table>
                            <?
                            foreach ($arResult['PRODUCT_PROPERTIES'] as $propId => $propInfo)
                            {
                                ?>
                                <tr>
                                    <td><?=$arResult['PROPERTIES'][$propId]['NAME']?></td>
                                    <td>
                                        <?
                                        if (
                                            $arResult['PROPERTIES'][$propId]['PROPERTY_TYPE'] === 'L'
                                            && $arResult['PROPERTIES'][$propId]['LIST_TYPE'] === 'C'
                                        )
                                        {
                                            foreach ($propInfo['VALUES'] as $valueId => $value)
                                            {
                                                ?>
                                                <label>
                                                    <input type="radio" name="<?=$arParams['PRODUCT_PROPS_VARIABLE']?>[<?=$propId?>]"
                                                           value="<?=$valueId?>" <?=($valueId == $propInfo['SELECTED'] ? '"checked"' : '')?>>
                                                    <?=$value?>
                                                </label>
                                                <br>
                                                <?
                                            }
                                        }
                                        else
                                        {
                                            ?>
                                            <select name="<?=$arParams['PRODUCT_PROPS_VARIABLE']?>[<?=$propId?>]">
                                                <?
                                                foreach ($propInfo['VALUES'] as $valueId => $value)
                                                {
                                                    ?>
                                                    <option value="<?=$valueId?>" <?=($valueId == $propInfo['SELECTED'] ? '"selected"' : '')?>>
                                                        <?=$value?>
                                                    </option>
                                                    <?
                                                }
                                                ?>
                                            </select>
                                            <?
                                        }
                                        ?>
                                    </td>
                                </tr>
                                <?
                            }
                            ?>
                        </table>
                        <?
                    }
                    ?>
                </div>
                <?
            }

            $jsParams = array(
                'CONFIG' => array(
                    'USE_CATALOG' => $arResult['CATALOG'],
                    'SHOW_QUANTITY' => $arParams['USE_PRODUCT_QUANTITY'],
                    'SHOW_PRICE' => !empty($arResult['ITEM_PRICES']),
                    'SHOW_DISCOUNT_PERCENT' => $arParams['SHOW_DISCOUNT_PERCENT'] === 'Y',
                    'SHOW_OLD_PRICE' => $arParams['SHOW_OLD_PRICE'] === 'Y',
                    'USE_PRICE_COUNT' => $arParams['USE_PRICE_COUNT'],
                    'DISPLAY_COMPARE' => $arParams['DISPLAY_COMPARE'],
                    'MAIN_PICTURE_MODE' => $arParams['DETAIL_PICTURE_MODE'],
                    'ADD_TO_BASKET_ACTION' => $arParams['ADD_TO_BASKET_ACTION'],
                    'SHOW_CLOSE_POPUP' => $arParams['SHOW_CLOSE_POPUP'] === 'Y',
                    'SHOW_MAX_QUANTITY' => $arParams['SHOW_MAX_QUANTITY'],
                    'RELATIVE_QUANTITY_FACTOR' => $arParams['RELATIVE_QUANTITY_FACTOR'],
                    'TEMPLATE_THEME' => $arParams['TEMPLATE_THEME'],
                    'USE_STICKERS' => true,
                    'USE_SUBSCRIBE' => $showSubscribe,
                    'SHOW_SLIDER' => $arParams['SHOW_SLIDER'],
                    'SLIDER_INTERVAL' => $arParams['SLIDER_INTERVAL'],
                    'ALT' => $alt,
                    'TITLE' => $title,
                    'MAGNIFIER_ZOOM_PERCENT' => 200,
                    'USE_ENHANCED_ECOMMERCE' => $arParams['USE_ENHANCED_ECOMMERCE'],
                    'DATA_LAYER_NAME' => $arParams['DATA_LAYER_NAME'],
                    'BRAND_PROPERTY' => !empty($arResult['DISPLAY_PROPERTIES'][$arParams['BRAND_PROPERTY']])
                        ? $arResult['DISPLAY_PROPERTIES'][$arParams['BRAND_PROPERTY']]['DISPLAY_VALUE']
                        : null
                ),
                'VISUAL' => $itemIds,
                'PRODUCT_TYPE' => $arResult['CATALOG_TYPE'],
                'PRODUCT' => array(
                    'ID' => $arResult['ID'],
                    'ACTIVE' => $arResult['ACTIVE'],
                    'PICT' => reset($arResult['MORE_PHOTO']),
                    'NAME' => $arResult['~NAME'],
                    'SUBSCRIPTION' => true,
                    'ITEM_PRICE_MODE' => $arResult['ITEM_PRICE_MODE'],
                    'ITEM_PRICES' => $arResult['ITEM_PRICES'],
                    'ITEM_PRICE_SELECTED' => $arResult['ITEM_PRICE_SELECTED'],
                    'ITEM_QUANTITY_RANGES' => $arResult['ITEM_QUANTITY_RANGES'],
                    'ITEM_QUANTITY_RANGE_SELECTED' => $arResult['ITEM_QUANTITY_RANGE_SELECTED'],
                    'ITEM_MEASURE_RATIOS' => $arResult['ITEM_MEASURE_RATIOS'],
                    'ITEM_MEASURE_RATIO_SELECTED' => $arResult['ITEM_MEASURE_RATIO_SELECTED'],
                    'SLIDER_COUNT' => $arResult['MORE_PHOTO_COUNT'],
                    'SLIDER' => $arResult['MORE_PHOTO'],
                    'CAN_BUY' => $arResult['CAN_BUY'],
                    'CHECK_QUANTITY' => $arResult['CHECK_QUANTITY'],
                    'QUANTITY_FLOAT' => is_float($arResult['ITEM_MEASURE_RATIOS'][$arResult['ITEM_MEASURE_RATIO_SELECTED']]['RATIO']),
                    'MAX_QUANTITY' => $arResult['CATALOG_QUANTITY'],
                    'STEP_QUANTITY' => $arResult['ITEM_MEASURE_RATIOS'][$arResult['ITEM_MEASURE_RATIO_SELECTED']]['RATIO'],
                    'CATEGORY' => $arResult['CATEGORY_PATH']
                ),
                'BASKET' => array(
                    'ADD_PROPS' => $arParams['ADD_PROPERTIES_TO_BASKET'] === 'Y',
                    'QUANTITY' => $arParams['PRODUCT_QUANTITY_VARIABLE'],
                    'PROPS' => $arParams['PRODUCT_PROPS_VARIABLE'],
                    'EMPTY_PROPS' => $emptyProductProperties,
                    'BASKET_URL' => $arParams['BASKET_URL'],
                    'ADD_URL_TEMPLATE' => $arResult['~ADD_URL_TEMPLATE'],
                    'BUY_URL_TEMPLATE' => $arResult['~BUY_URL_TEMPLATE']
                )
            );
            unset($emptyProductProperties);
        }

        if ($arParams['DISPLAY_COMPARE'])
        {
            $jsParams['COMPARE'] = array(
                'COMPARE_URL_TEMPLATE' => $arResult['~COMPARE_URL_TEMPLATE'],
                'COMPARE_DELETE_URL_TEMPLATE' => $arResult['~COMPARE_DELETE_URL_TEMPLATE'],
                'COMPARE_PATH' => $arParams['COMPARE_PATH']
            );
        }
        ?>
    </div>
    <script>
        BX.message({
            ECONOMY_INFO_MESSAGE: '<?=GetMessageJS('CT_BCE_CATALOG_ECONOMY_INFO2')?>',
            TITLE_ERROR: '<?=GetMessageJS('CT_BCE_CATALOG_TITLE_ERROR')?>',
            TITLE_BASKET_PROPS: '<?=GetMessageJS('CT_BCE_CATALOG_TITLE_BASKET_PROPS')?>',
            BASKET_UNKNOWN_ERROR: '<?=GetMessageJS('CT_BCE_CATALOG_BASKET_UNKNOWN_ERROR')?>',
            BTN_SEND_PROPS: '<?=GetMessageJS('CT_BCE_CATALOG_BTN_SEND_PROPS')?>',
            BTN_MESSAGE_BASKET_REDIRECT: '<?=GetMessageJS('CT_BCE_CATALOG_BTN_MESSAGE_BASKET_REDIRECT')?>',
            BTN_MESSAGE_CLOSE: '<?=GetMessageJS('CT_BCE_CATALOG_BTN_MESSAGE_CLOSE')?>',
            BTN_MESSAGE_CLOSE_POPUP: '<?=GetMessageJS('CT_BCE_CATALOG_BTN_MESSAGE_CLOSE_POPUP')?>',
            TITLE_SUCCESSFUL: '<?=GetMessageJS('CT_BCE_CATALOG_ADD_TO_BASKET_OK')?>',
            COMPARE_MESSAGE_OK: '<?=GetMessageJS('CT_BCE_CATALOG_MESS_COMPARE_OK')?>',
            COMPARE_UNKNOWN_ERROR: '<?=GetMessageJS('CT_BCE_CATALOG_MESS_COMPARE_UNKNOWN_ERROR')?>',
            COMPARE_TITLE: '<?=GetMessageJS('CT_BCE_CATALOG_MESS_COMPARE_TITLE')?>',
            BTN_MESSAGE_COMPARE_REDIRECT: '<?=GetMessageJS('CT_BCE_CATALOG_BTN_MESSAGE_COMPARE_REDIRECT')?>',
            PRODUCT_GIFT_LABEL: '<?=GetMessageJS('CT_BCE_CATALOG_PRODUCT_GIFT_LABEL')?>',
            PRICE_TOTAL_PREFIX: '<?=GetMessageJS('CT_BCE_CATALOG_MESS_PRICE_TOTAL_PREFIX')?>',
            RELATIVE_QUANTITY_MANY: '<?=CUtil::JSEscape($arParams['MESS_RELATIVE_QUANTITY_MANY'])?>',
            RELATIVE_QUANTITY_FEW: '<?=CUtil::JSEscape($arParams['MESS_RELATIVE_QUANTITY_FEW'])?>',
            SITE_ID: '<?=CUtil::JSEscape($component->getSiteId())?>'
        });

        var <?=$obName?> = new JCCatalogElement(<?=CUtil::PhpToJSObject($jsParams, false, true)?>);
    </script>

<?
unset($actualItem, $itemIds, $jsParams);