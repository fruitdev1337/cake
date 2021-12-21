<?if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED!==true) die();
use \Bitrix\Main\Localization\Loc;

$this->IncludeLangFile('template.php');

$cartId = $arParams['cartId'];

require(realpath(dirname(__FILE__)).'/top_template.php');

if ($arParams["SHOW_PRODUCTS"] == "Y" && ($arResult['NUM_PRODUCTS'] > 0 || !empty($arResult['CATEGORIES']['DELAY'])))
{
?>
<div class="basket-item-list-wrapper">
    <div data-role="basket-item-list" class="basket-item-list">
                    <?if ($arParams["POSITION_FIXED"] == "Y"):?>
                        <div id="<?=$cartId?>status" class="basket-item-list-action" onclick="<?=$cartId?>.toggleOpenCloseCart()"><?=Loc::getMessage("TSB1_COLLAPSE")?></div>
                    <?endif?>

                    <div id="<?=$cartId?>products" class="basket-item-list-container">
                        <?foreach ($arResult["CATEGORIES"] as $category => $items):
                            if (empty($items))
                                continue;
                            ?>
                            <?foreach ($items as $v):?>
                            <div class="basket-item-list-item">
                                <?if ($arParams["SHOW_IMAGE"] == "Y" && $v["PICTURE_SRC"]):?>
                                    <div class="basket-item-list-item-img">
                                        <?if($v["DETAIL_PAGE_URL"]):?>
                                            <a href="<?=$v["DETAIL_PAGE_URL"]?>"><img src="<?=$v["PICTURE_SRC"]?>" alt="<?=$v["NAME"]?>"></a>
                                        <?else:?>
                                            <img src="<?=$v["PICTURE_SRC"]?>" alt="<?=$v["NAME"]?>" />
                                        <?endif?>
                                    </div>
                                <?endif?>
                                <div class="basket-item-list-item-name">
                                    <div class="row align-items-start m-0">
                                        <div class="pl-0 col">
                                            <?if ($v["DETAIL_PAGE_URL"]):?>
                                                <a href="<?=$v["DETAIL_PAGE_URL"]?>"><?=$v["NAME"]?></a>
                                            <?else:?>
                                                <span><?=$v["NAME"]?></span>
                                            <?endif?>
                                        </div>
                                        <div class="p-0 col-auto">
                                            <span class="basket-item-remove" onclick="<?=$cartId?>.removeItemFromCart(<?=$v['ID']?>,<?=$v['PRODUCT_ID']?>)" title="<?=Loc::getMessage("TSB1_DELETE")?>"></span>
                                        </div>
                                    </div>
                                </div>
                                <?if (true):/*$category != "SUBSCRIBE") TODO */?>
                                    <div class="basket-item-list-item-price-block">
                                        <?if ($arParams["SHOW_PRICE"] == "Y"):?>
                                            <div class="basket-item-list-item-price"><strong><?=$v["PRICE_FMT"]?></strong></div>
                                            <?if ($v["FULL_PRICE"] != $v["PRICE_FMT"]):?>
                                                <div class="basket-item-list-item-price-old"><?=$v["FULL_PRICE"]?></div>
                                            <?endif?>
                                        <?endif?>
                                        <?if ($arParams["SHOW_SUMMARY"] == "Y"):?>
                                            <div class="basket-item-list-item-price-summ">
                                                <div class="row m-0">
                                                    <span class="p-0 col-auto">
                                                        <strong><?=$v["QUANTITY"]?> <?=$v["MEASURE_NAME"]?></strong>
                                                    </span>
                                                    <span class="p-0 col text-right"><?=$v["SUM"]?></span>
                                                </div>
                                            </div>
                                        <?endif?>
                                    </div>
                                <?endif?>
                            </div>
                        <?endforeach?>
                        <?endforeach?>
                    </div>
        </div>
</div>

    <?if ($arParams["PATH_TO_ORDER"] && $arResult["CATEGORIES"]["READY"]):?>
        <div class="basket-item-list-button-container<?
        if ($arParams['SHOW_TOTAL_PRICE'] == 'Y') {
            if ($arParams['MESS_MIN_PRICE_TITLE'] >= $arResult["TOTAL_PRICE"]) {?> btn-active<?
            }
        }?>">
            <a href="<?=$arParams["PATH_TO_BASKET"]?>" class="btn btn-primary"><?=Loc::getMessage("TSB1_2ORDER")?></a>
        </div>
    <?endif?>

	<script>
		BX.ready(function(){
			<?=$cartId?>.fixCart();
		});
        $('.catalog__cart .basket-item-list-wrapper').mCustomScrollbar({
            scrollInertia:100,
            advanced:{autoScrollOnFocus:false},
            updateOnContentResize: true
        });
	</script>
<?
} else {
    ?>
    <div class="basket-item-list-wrapper basket-empty">
        <div class="basket-item-list"><?=Loc::getMessage("TSB2_CART_EMPTY")?></div>
    </div>
<?
}
?>

<div class="basket-item-delivery-container">
    <?if (\Bitrix\Main\Loader::includeModule("krayt.retail") && \Bitrix\Main\Loader::includeModule('currency')){

        $MIN_PRICE  = \CKray_retail::getMinPriceOrder(SITE_ID);
        if($MIN_PRICE['VALUE']):
        ?>
        <div class="basket-item-delivery">
            <p><?=Loc::getMessage('MIN_SUM_TITLE')?> – <?=CCurrencyLang::CurrencyFormat($MIN_PRICE['VALUE'],$MIN_PRICE['CURRENCY']);?></p>
        </div>
        <?endif;?>
    <?}?>
    <? if ($arParams["PATH_TO_DELIVERY"]) {?>
        <div class="basket-item-delivery">
            <a href="<?=$arParams["PATH_TO_DELIVERY"]?>"><?=Loc::GetMessage('DELIVERY_AND_PAY')?></a>
        </div>
    <?}?>
</div>
