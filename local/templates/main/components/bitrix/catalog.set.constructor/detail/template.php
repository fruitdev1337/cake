<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();                        
if(\Bitrix\Main\Loader::includeSharewareModule("krayt.retail") == \Bitrix\Main\Loader::MODULE_DEMO_EXPIRED || 
   \Bitrix\Main\Loader::includeSharewareModule("krayt.retail") ==  \Bitrix\Main\Loader::MODULE_NOT_FOUND
    )
{ return false;}
/** @var array $arParams */
/** @var array $arResult */
/** @global CMain $APPLICATION */
/** @global CUser $USER */
/** @global CDatabase $DB */
/** @var CBitrixComponentTemplate $this */
/** @var string $templateName */
/** @var string $templateFile */
/** @var string $templateFolder */
/** @var string $componentPath */
/** @var CBitrixComponent $component */
$this->setFrameMode(true);
$this->addExternalCss("/bitrix/css/main/bootstrap.css");

$templateData = array(
	'TEMPLATE_THEME' => $this->GetFolder().'/themes/'.$arParams['TEMPLATE_THEME'].'/style.css',
	'TEMPLATE_CLASS' => 'bx-'.$arParams['TEMPLATE_THEME'],
	'CURRENCIES' => CUtil::PhpToJSObject($arResult['CURRENCIES'], false, true, true)
);
$curJsId = $this->randString();
$first = true;
?>

<div class="sets">
	<h2><?=GetMessage('SETS_TITLE');?></h2>
	<div id="bx-set-const-<?=$curJsId?>"  class="sets__wrapper">
		<div class="set_container" data-role="set-items">
			<div class="set_item main-item">
				<div class="set_image__wrap">
					<a style="pointer-events: none" title="<?=$arResult['ELEMENT']["NAME"]?>"><img src="<?=$arResult['ELEMENT']["DETAIL_PICTURE"]["src"]?>" alt=""></a>
				</div>
				<div class="set_info">
                    <div class="set_check-in active"><span></span></div>
					<div class="set_name">
                        <span class="name"><span class="brand_name"><?=$arResult['ELEMENT']["NAME"]?></span></span>
                        <div class="price">
                            <div class="current_price"><?=$arResult["ELEMENT"]["PRICE_PRINT_DISCOUNT_VALUE"]?></div>
                            <?if (!($arResult["ELEMENT"]["PRICE_VALUE"] == $arResult["ELEMENT"]["PRICE_DISCOUNT_VALUE"])):?>
                                <div class="old_price"><span><?=$arResult["ELEMENT"]["PRICE_PRINT_VALUE"]?></span></div>
                            <?endif?>
                        </div>

					</div>
				</div>
			</div>
			<?php foreach($arResult["SET_ITEMS"]["DEFAULT"] as $key => $arItem ){?>
				<div class="set_item"
					 data-id="<?=$arItem["ID"]?>"
					 data-img="<?=$arItem["DETAIL_PICTURE"]["src"]?>"
					 data-url="<?=$arItem["DETAIL_PAGE_URL"]?>"
					 data-name="<?=$arItem["NAME"]?>"
					 data-price="<?=$arItem["PRICE_DISCOUNT_VALUE"]?>"
					 data-print-price="<?=$arItem["PRICE_PRINT_DISCOUNT_VALUE"]?>"
					 data-old-price="<?=$arItem["PRICE_VALUE"]?>"
					 data-print-old-price="<?=$arItem["PRICE_PRINT_VALUE"]?>"
					 data-diff-price="<?=$arItem["PRICE_DISCOUNT_DIFFERENCE_VALUE"]?>"
					 data-measure="<?=$arItem["MEASURE"]["SYMBOL_RUS"];?>"
					 data-quantity="<?=$arItem["BASKET_QUANTITY"];?>"
					 data-count="<?=$key + 2;?>"
					 data-active="Y">
					<?php
					if (!$arItem['CAN_BUY'] && $first)
					{
						echo 'data-not-avail="yes"';
						$first = false;
					}
					?>
					<div class="set_image__wrap">
						<a href="<?=$arItem["DETAIL_PAGE_URL"]?>" title="<?=$arItem["NAME"]?>"><img src="<?=$arItem["DETAIL_PICTURE"]["src"]?>" alt=""></a>
                        <div class="set_plus"></div>
					</div>
					<div class="set_info">
						<label for="check-in<?=$key?>" class="set_check-in active js-active">
							<input type="checkbox" id="check-in<?=$key?>">
							<span data-role="set-delete-btn" data-serial="<?=$key+1?>"></span>

						</label>
						<div class="set_name">
							<a href="<?=$arItem["DETAIL_PAGE_URL"]?>" title="<?=$arItem["NAME"]?>">
								<span class="name"><span class="brand_name"><?=$arItem["NAME"]?></span></span>
                            </a>
                            <div class="price">
                                <div class="current_price"><?=$arItem["PRICE_PRINT_DISCOUNT_VALUE"]?></div>
                                <?if ($arItem["PRICE_VALUE"] != $arItem["PRICE_DISCOUNT_VALUE"]):?>
                                    <div class="old_price"><span><?=$arItem["PRICE_PRINT_VALUE"]?></span></div>
                                <?endif?>
                            </div>
						</div>
					</div>
				</div>
			<?php }?>
		</div>
		<div class="set_result">
			<div class="result_box">
				<div class="result_sum">
					<span>Итого</span>
                    <span class="set-price" data-role="set-price">
                        <?=$arResult["SET_ITEMS"]["PRICE"]?>
                    </span>
                    <?if ($arResult['SHOW_DEFAULT_SET_DISCOUNT']):?>
                        <div class="old_price">
                            <span data-role="set-old-price"><?=$arResult["SET_ITEMS"]["OLD_PRICE"]?></span>
                        </div>
                    <?endif?>
                </div>
                <a href="javascript:void(0)" data-role="set-buy-btn" class="btn-green-border set_to-cart"
                    <?=($arResult["ELEMENT"]["CAN_BUY"] ? '' : 'style="display: none;"')?>>
                    <span><?=GetMessage("CATALOG_SET_BUY")?></span>
                </a>
                <div class="btn-green-gradient set_to-cart btn-loader">
                    <span class="fa fa-spinner fa-spin"></span>
                </div>
                <a href="<?=SITE_DIR;?>basket/" class="btn-green-gradient set_to-cart kit"
                    <?=($arResult["ELEMENT"]["CAN_BUY"] ? 'style="display: none;"' : '')?>>
                    <?=GetMessage("CATALOG_SET_IN_CART");?>
                </a>
<!--				<button class="btn-green-border set_to-cart" data-role="set-buy-btn">Купить</button>-->
<!--				<a href="/personal/basket/" class="btn-green-gradient set_to-cart kit">Набор в корзине</a>-->
			</div>
		</div>
	</div>
</div>
<?
$arJsParams = array(
	"numSliderItems" => count($arResult["SET_ITEMS"]["OTHER"]),
	"numSetItems" => count($arResult["SET_ITEMS"]["DEFAULT"]),
	"jsId" => $curJsId,
	"parentContId" => "bx-set-const-".$curJsId,
	"ajaxPath" => $this->GetFolder().'/ajax.php',
	"canBuy" => $arResult["ELEMENT"]["CAN_BUY"],
	"currency" => $arResult["ELEMENT"]["PRICE_CURRENCY"],
	"mainElementPrice" => $arResult["ELEMENT"]["PRICE_DISCOUNT_VALUE"],
	"mainElementOldPrice" => $arResult["ELEMENT"]["PRICE_VALUE"],
	"mainElementDiffPrice" => $arResult["ELEMENT"]["PRICE_DISCOUNT_DIFFERENCE_VALUE"],
	"mainElementBasketQuantity" => $arResult["ELEMENT"]["BASKET_QUANTITY"],
	"lid" => SITE_ID,
	"iblockId" => $arParams["IBLOCK_ID"],
	"basketUrl" => $arParams["BASKET_URL"],
	"setIds" => $arResult["DEFAULT_SET_IDS"],
	"offersCartProps" => $arParams["OFFERS_CART_PROPERTIES"],
	"itemsRatio" => $arResult["BASKET_QUANTITY"],
	"noFotoSrc" => $this->GetFolder().'/images/no_foto.png',
	"messages" => array(
		"EMPTY_SET" => GetMessage('CT_BCE_CATALOG_MESS_EMPTY_SET'),
		"ADD_BUTTON" => GetMessage("CATALOG_SET_BUTTON_ADD")
	)
);
?>
<script type="text/javascript">
	BX.ready(function(){
		new BX.Catalog.SetConstructor(<?=CUtil::PhpToJSObject($arJsParams, false, true, true)?>);
	});
</script>
