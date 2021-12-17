<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();                        
if(\Bitrix\Main\Loader::includeSharewareModule("krayt.retail") == \Bitrix\Main\Loader::MODULE_DEMO_EXPIRED || 
   \Bitrix\Main\Loader::includeSharewareModule("krayt.retail") ==  \Bitrix\Main\Loader::MODULE_NOT_FOUND
    )
{ return false;}                        
if(\Bitrix\Main\Loader::includeSharewareModule("krayt.retail") == \Bitrix\Main\Loader::MODULE_DEMO_EXPIRED || 
   \Bitrix\Main\Loader::includeSharewareModule("krayt.retail") ==  \Bitrix\Main\Loader::MODULE_NOT_FOUND
    )
{ return false;}                        
if(\Bitrix\Main\Loader::includeSharewareModule("krayt.retail") == \Bitrix\Main\Loader::MODULE_DEMO_EXPIRED || 
   \Bitrix\Main\Loader::includeSharewareModule("krayt.retail") ==  \Bitrix\Main\Loader::MODULE_NOT_FOUND
    )
{ return false;}                        
if(\Bitrix\Main\Loader::includeSharewareModule("krayt.retail") == \Bitrix\Main\Loader::MODULE_DEMO_EXPIRED || 
   \Bitrix\Main\Loader::includeSharewareModule("krayt.retail") ==  \Bitrix\Main\Loader::MODULE_NOT_FOUND
    )
{ return false;}                        
if(\Bitrix\Main\Loader::includeSharewareModule("krayt.retail") == \Bitrix\Main\Loader::MODULE_DEMO_EXPIRED || 
   \Bitrix\Main\Loader::includeSharewareModule("krayt.retail") ==  \Bitrix\Main\Loader::MODULE_NOT_FOUND
    )
{ return false;}                        
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

$themeClass = isset($arParams['TEMPLATE_THEME']) ? ' bx-'.$arParams['TEMPLATE_THEME'] : '';

$templateData = array(
	'CURRENCIES' => CUtil::PhpToJSObject($arResult['CURRENCIES'], false, true, true)
);
$curJsId = $this->randString();
?>
<!---->
<div class="catalog-set-wrapper">
    <h2 class="catalog-set-constructor-title"><?=GetMessage("CATALOG_SET_BUY_SET")?></h2>
		<div id="bx-set-const-<?=$curJsId?>" class="catalog-set-constructor">
			<div class="catalog-set-constructor-row row">
				<div class="col-lg-3 col-12">
                    <div class="catalog-set-constructor-product-item-container">
                        <div class="product-item-container">
                            <div class="product_item product-item">
                                <div class="row align-items-lg-baseline align-items-center no-gutters">
                                    <div class="product_item_img">
                                        <div class="product-item-image-wrapper">
                                            <div class="product-item-image-slider-slide-container">
                                                <?if ($arResult["ELEMENT"]["DETAIL_PICTURE"]["src"]):?>
                                                    <img src="<?=$arResult["ELEMENT"]["DETAIL_PICTURE"]["src"]?>" class="product_item_img-bg" alt="">
                                                <?else:?>
                                                    <img src="<?=$this->GetFolder().'/images/no_foto.png'?>" class="product_item_img-bg" alt="">
                                                <?endif?>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="product_item_name_box col-lg-12 col">
                                        <div class="product_item_title">
                                            <div class="name"><?=$arResult["ELEMENT"]["NAME"]?></div>
                                        </div>
                                    </div>
                                    <div class="price-block-col">
                                        <div class="product_item__price product-item-info-container product_item__price">
                                            <div class="catalog-set-constructor-product-new-price price product-item-price-current">
                                                <span><?=$arResult["ELEMENT"]["PRICE_PRINT_DISCOUNT_VALUE"]?></span> <span class="set-item-quantity">x <?=$arResult["ELEMENT"]["BASKET_QUANTITY"];?> <?=$arResult["ELEMENT"]["MEASURE"]["SYMBOL_RUS"];?></span>
                                            </div>
                                            <div class="catalog-set-constructor-product-old-price old_price product-item-price-old">
                                                <span><?=$arResult["ELEMENT"]["PRICE_PRINT_VALUE"]?></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="catalog-set-constructor-product-info" style="display: none;">

                            <?if ($arResult["ELEMENT"]["DETAIL_PICTURE"]["src"]):?>
                                <img src="<?=$arResult["ELEMENT"]["DETAIL_PICTURE"]["src"]?>" class="catalog-set-constructor-product-item-image mb-2 float-none float-sm-left float-md-none mr-0 mr-sm-2 mr-md-0" alt="">
                            <?else:?>
                                <img src="<?=$this->GetFolder().'/images/no_foto.png'?>" class="catalog-set-constructor-product-item-image mb-2 float-none float-sm-left float-md-none mr-0 mr-sm-2 mr-md-0" alt="">
                            <?endif?>
                            <div class="catalog-set-constructor-product-name"><?=$arResult["ELEMENT"]["NAME"]?></div>
                            <span class="catalog-set-constructor-product-new-price">
								<strong><?=$arResult["ELEMENT"]["PRICE_PRINT_DISCOUNT_VALUE"]?></strong>
								* <?=$arResult["ELEMENT"]["BASKET_QUANTITY"];?> <?=$arResult["ELEMENT"]["MEASURE"]["SYMBOL_RUS"];?>
							</span>
                            <?if (!($arResult["ELEMENT"]["PRICE_VALUE"] == $arResult["ELEMENT"]["PRICE_DISCOUNT_VALUE"])):?>
                                <span class="catalog-set-constructor-product-old-price">
									<strong><?=$arResult["ELEMENT"]["PRICE_PRINT_VALUE"]?></strong>
								</span>
                            <?endif?>
                        </div>
                    </div>
                    <div class="plus" style="font-size: 40px;display: flex;align-items: center;color:#8c8c8c;">+</div>
				</div>
				<div class="col-lg-9 col-12">
					<div class="catalog-set-constructor-items-list">
                        <div class="catalog-set-constructor-items-list-container">
                            <table class="catalog-set-constructor-items-list-table">
                                <tbody data-role="set-items">
                                <?foreach($arResult["SET_ITEMS"]["DEFAULT"] as $key => $arItem):
                                    $print_price = strip_tags($arItem["PRICE_PRINT_DISCOUNT_VALUE"],"<sup>");
                                    $print_oldprice = strip_tags($arItem["PRICE_PRINT_VALUE"],"<sup>");?>
                                    <tr data-id="<?=$arItem["ID"]?>"
                                        data-img="<?=$arItem["DETAIL_PICTURE"]["src"]?>"
                                        data-url="<?=$arItem["DETAIL_PAGE_URL"]?>"
                                        data-name="<?=$arItem["NAME"]?>"
                                        data-price="<?=$arItem["PRICE_DISCOUNT_VALUE"]?>"
                                        data-print-price="<?=$print_price?>"
                                        data-old-price="<?=$arItem["PRICE_VALUE"]?>"
                                        data-print-old-price="<?=$print_oldprice;?>"
                                        data-diff-price="<?=$arItem["PRICE_DISCOUNT_DIFFERENCE_VALUE"]?>"
                                        data-measure="<?=$arItem["MEASURE"]["SYMBOL_RUS"];?>"
                                        data-quantity="<?=$arItem["BASKET_QUANTITY"];?>"
                                    >
                                        <td class="catalog-set-constructor-items-list-table-cell-img">
                                            <?if ($arItem["DETAIL_PICTURE"]["src"]):?>
                                                <img src="<?=$arItem["DETAIL_PICTURE"]["src"]?>" class="img-responsive" alt="">
                                            <?else:?>
                                                <img src="<?=$this->GetFolder().'/images/no_foto.png'?>" class="img-responsive" alt="">
                                            <?endif?>
                                        </td>
                                        <td class="catalog-set-constructor-items-list-table-cell-name">
                                            <a class="" target="_blank" href="<?=$arItem["DETAIL_PAGE_URL"]?>"><?=$arItem["NAME"]?></a>
                                        </td>
                                        <td class="catalog-set-constructor-items-list-table-cell-price">
										<span class="catalog-set-constructor-product-new-price price">
                                            <span><?=$print_price?> <i class="fa fa-rub"></i></span> <span class="set-item-quantity">x <?=$arItem["BASKET_QUANTITY"];?> <?=$arItem["MEASURE"]["SYMBOL_RUS"];?></span>
										</span>
                                            <?if ($arItem["PRICE_VALUE"] != $arItem["PRICE_DISCOUNT_VALUE"]):?>
                                                <span class="catalog-set-constructor-product-old-price old_price">
                                                    <span><?=$print_oldprice;?> <i class="fa fa-rub"></i></span>
                                                </span>
                                            <?endif?>
                                        </td>
                                        <td class="catalog-set-constructor-items-list-table-cell-del">
                                            <span class="catalog-set-constructor-items-list-table-cell-delete-btn" data-role="set-delete-btn"></span>
                                        </td>
                                    </tr>
                                <?endforeach?>
                                </tbody>
                            </table>
                            <div style="display: none;margin:20px;" data-set-message="empty-set"></div>
                        </div>
					</div>
				</div>

			</div>
            <div class="row">
                <div class="col-lg-3 hidden-xs"></div>
                <div class="col-lg-9 col-12">
                    <div class="catalog-set-constructor-result-container mt-3 pt-3">
                        <div class="catalog-set-constructor-result">
                            <div class="row align-items-center">
                                <div class="col-sm col-12">
                                    <table class="catalog-set-constructor-result-table" style="display: none;">
                                        <tr>
                                            <td class="catalog-set-constructor-result-table-title"><?=GetMessage("CATALOG_SET_SET_PRICE")?>:</td>
                                            <td class="catalog-set-constructor-result-table-value">
                                                <strong data-role="set-price"><?=$arResult["SET_ITEMS"]["PRICE"]?></strong>
                                            </td>
                                        </tr>
                                        <tr style="display: <?=($arResult['SHOW_DEFAULT_SET_DISCOUNT'] ? 'table-row' : 'none'); ?>">
                                            <td class="catalog-set-constructor-result-table-title"><?=GetMessage("CATALOG_SET_ECONOMY_PRICE")?>:</td>
                                            <td class="catalog-set-constructor-result-table-value">
                                                <strong data-role="set-diff-price"><?=$arResult["SET_ITEMS"]["PRICE_DISCOUNT_DIFFERENCE"]?></strong>
                                            </td>
                                        </tr>
                                    </table>
                                    <div class="catalog-set-constructor-result-btn-container row">
                                        <div class="col-auto catalog-set-constructor-result-text"><?=GetMessage("CATALOG_SET_SET_PRICE")?>:</div>
                                        <div class="col-auto catalog-set-constructor-result-prices">
                                            <div class="catalog-set-constructor-result-price-old old_price" data-role="set-old-price">
                                                <span><?=$arResult["SET_ITEMS"]["OLD_PRICE"]?></span>
                                            </div>
                                            <div class="catalog-set-constructor-result-price price" data-role="set-price-duplicate">
                                                <span><?=$arResult["SET_ITEMS"]["PRICE"]?></span>
                                            </div>
                                            <div class="catalog-set-constructor-result-diff-price">
                                                <span><?=GetMessage("CATALOG_SET_ECONOMY_PRICE")?>:</span>
                                                <span data-role="set-diff-price"><?=$arResult["SET_ITEMS"]["PRICE_DISCOUNT_DIFFERENCE"]?></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-auto col-12">
                                    <div class="catalog-set-constructor-result-btn-container">
                                        <a href="javascript:void(0)" data-role="set-buy-btn" class="btn btn-primary basket_icon product-item-detail-buy-button"
                                            <?=($arResult["ELEMENT"]["CAN_BUY"] ? '' : 'style="display: none;"')?>>
                                            <span class="img_basket"></span>
                                            <span><?=GetMessage("CATALOG_SET_BUY")?></span>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="catalog-set-constructor-slider"
                 data-role="slider-parent-container"<?=(empty($arResult["SET_ITEMS"]["OTHER"]) ? 'style="display:none;"' : '')?>>
                <div class="title-set">
                    <h3>
                        <span class="fa fa-angle-up"></span>
                        <div><?=GetMessage('CATALOG_SET_CONSTRUCT')?></div>
                    </h3>
                </div>
                <div class="catalog-set-constructor-slider-box">
                    <div class="catalog-set-constructor-slider-container">
                        <div class="catalog-set-constructor-slider-slide catalog-set-constructor-slider-slide-<?=$curJsId?>" data-role="set-other-items">
                            <?
                            $first = true;
                            foreach($arResult["SET_ITEMS"]["OTHER"] as $key => $arItem):
                                $print_price = strip_tags($arItem["PRICE_PRINT_DISCOUNT_VALUE"],"<sup>");
                                $print_oldprice = strip_tags($arItem["PRICE_PRINT_VALUE"],"<sup>");?>
                                <div class="catalog-set-constructor-slider-item-container catalog-set-constructor-slider-item-container-<?=$curJsId?>"
                                     data-id="<?=$arItem["ID"]?>"
                                     data-img="<?=$arItem["DETAIL_PICTURE"]["src"]?>"
                                     data-url="<?=$arItem["DETAIL_PAGE_URL"]?>"
                                     data-name="<?=$arItem["NAME"]?>"
                                     data-price="<?=$arItem["PRICE_DISCOUNT_VALUE"]?>"
                                     data-print-price="<?=$print_price?>"
                                     data-old-price="<?=$arItem["PRICE_VALUE"]?>"
                                     data-print-old-price="<?=$print_oldprice;?>"
                                     data-diff-price="<?=$arItem["PRICE_DISCOUNT_DIFFERENCE_VALUE"]?>"
                                     data-measure="<?=$arItem["MEASURE"]["SYMBOL_RUS"];?>"
                                     data-quantity="<?=$arItem["BASKET_QUANTITY"];?>"<?
                                if (!$arItem['CAN_BUY'] && $first)
                                {?>
                                    data-not-avail="yes"
                                    <?
                                    $first = false;
                                }
                                ?>
                                >
                                    <div class="catalog-set-constructor-slider-item">
                                        <div class="catalog-set-constructor-slider-item-img">
                                            <div class="catalog-set-constructor-slider-item-img-container">
                                                <?if ($arItem["DETAIL_PICTURE"]["src"]):?>
                                                    <img src="<?=$arItem["DETAIL_PICTURE"]["src"]?>" class="img-responsive" alt=""/>
                                                <?else:?>
                                                    <img src="<?=$this->GetFolder().'/images/no_foto.png'?>" class="img-responsive"/>
                                                <?endif?>
                                            </div>
                                        </div>
                                        <div class="catalog-set-constructor-slider-item-title">
                                            <a target="_blank" href="<?=$arItem["DETAIL_PAGE_URL"]?>"><?=$arItem["NAME"]?></a>
                                        </div>
                                        <div class="catalog-set-constructor-slider-item-price product_item__price">
                                            <div class="catalog-set-constructor-product-new-price price">
                                                <span><?=$print_price?> <i class="fa fa-rub"></i></span> <span class="set-item-quantity">x <?=$arItem["BASKET_QUANTITY"];?> <?=$arItem["MEASURE"]["SYMBOL_RUS"];?></span>
                                            </div>
                                            <?if ($arItem["PRICE_VALUE"] != $arItem["PRICE_DISCOUNT_VALUE"]):?>
                                                <div class="catalog-set-constructor-product-old-price old_price">
                                                    <span><?=$print_oldprice;?> <i class="fa fa-rub"></i></span>
                                                </div>
                                            <?endif?>
                                        </div>
                                        <div class="catalog-set-constructor-slider-item-add-btn">
                                            <?
                                            if ($arItem['CAN_BUY'])
                                            {
                                                ?><a href="javascript:void(0)" data-role="set-add-btn" class="btn btn-primary">
                                                <span class="fa fa-plus"></span>
                                                <span><?=GetMessage("CATALOG_SET_BUTTON_ADD")?></span>
                                                </a><?
                                            }
                                            else
                                            {
                                                ?><span class="catalog-set-constructor-slider-item-notavailable"><?=GetMessage('CATALOG_SET_MESS_NOT_AVAILABLE');?></span><?
                                            }
                                            ?>
                                        </div>
                                    </div>
                                </div>
                            <?endforeach?>
                        </div>
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

</div>
<!--/-->