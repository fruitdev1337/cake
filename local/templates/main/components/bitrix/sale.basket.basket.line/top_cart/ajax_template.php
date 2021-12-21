<?if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED!==true) die();

$this->IncludeLangFile('template.php');

$cartId = $arParams['cartId'];
$arDataJsonCart = array();
require(realpath(dirname(__FILE__)).'/top_template.php');

if ($arParams["SHOW_PRODUCTS"] == "Y" && ($arResult['NUM_PRODUCTS'] > 0 || !empty($arResult['CATEGORIES']['DELAY'])))
{
?>
    <div data-role="basket-item-list" class="cartline_wrapper">
        <div class="cartline_wrapper-wrp">
            <div class="cart-list-wrapper">
                <div id="<?=$cartId?>products">
                    <?foreach ($arResult["CATEGORIES"] as $category => $items):
                        if (empty($items))
                            continue;
                        ?>
                        <?foreach ($items as $v):
                        $arDataJsonCart[] = [
                            'QUANTITY' => $v['QUANTITY'],
                            'PRODUCT_ID' => $v['PRODUCT_ID'],
                            'ID' => $v['ID']
                        ];
                        ?>
                        <div class="cart-list-item">
                            <div class="close-btn" onclick="<?=$cartId?>.removeItemFromCart(<?=$v['ID']?>,<?=$v['PRODUCT_ID']?>)"></div>
                            <div class="row m-0">
                                <?if ($arParams["SHOW_IMAGE"] == "Y" && $v["PICTURE_SRC"]):?>
                                    <div class="p-0 col-auto cart-list-item-img">
                                        <?if($v["DETAIL_PAGE_URL"]):?>
                                            <a class="product_item-link" href="<?=$v["DETAIL_PAGE_URL"]?>" title="<?=$v["NAME"]?>">
                                                <div class="cart-list-item-wrapper-img">
                                                    <img class="cart-list-item-img-bg" src="<?=$v['SRC_PREVIEW_PICTURE']?>">
                                                </div>
                                            </a>
                                        <?else:?>
                                            <div class="cart-list-item-wrapper-img">
                                                <img class="cart-list-item-img-bg" src="<?= $v['SRC_PREVIEW_PICTURE'] ?>">
                                            </div>
                                        <?endif?>
                                    </div>
                                <?endif?>
                                <div class="p-0 col cart-list-item-name-box">
                                    <?if ($v["DETAIL_PAGE_URL"]):?>
                                        <a class="item_name" href="<?=$v["DETAIL_PAGE_URL"]?>"><?=$v["NAME"]?></a>
                                    <?else:?>
                                        <p class="item_name"><?=$v["NAME"]?></p>
                                    <?endif?>

                                    <div class="cart-list-item-price">
                                        <?if ($arParams["SHOW_PRICE"] == "Y"):?>
                                            <div class="price"><span><?=$v["PRICE_FMT"]?></span> <span style="color: #8f8f8f; font-size: 12px; font-weight: normal;">x <?=$v["QUANTITY"]?> <?=$v["MEASURE_NAME"]?></span></div>
                                        <?endif?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?endforeach?>
                    <?endforeach?>
                </div>
            </div>
            <div class="cartline_footer">
                <div class="btn-goods">
                    <a href="<?=$arParams['PATH_TO_BASKET'];?>" class="btn-goods-link btn btn-primary"><?=\Bitrix\Main\Localization\Loc::getMessage('TSB1_BTN_BASKET')?></a>
                </div>
            </div>
        </div>
    </div>

	<script>
		BX.ready(function(){
			<?=$cartId?>.fixCart();
			<?=$cartId?>.setProductAr(<?=CUtil::PhpToJSObject($arDataJsonCart)?>);

            $('.cart-list-wrapper').mCustomScrollbar({
                scrollInertia:100,
                advanced:{autoScrollOnFocus:false},
                updateOnContentResize: true
            });
		});
	</script>
<?
   // arSh($arDataJsonCart);
}