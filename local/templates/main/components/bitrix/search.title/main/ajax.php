<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();                        
if(\Bitrix\Main\Loader::includeSharewareModule("krayt.retail") == \Bitrix\Main\Loader::MODULE_DEMO_EXPIRED || 
   \Bitrix\Main\Loader::includeSharewareModule("krayt.retail") ==  \Bitrix\Main\Loader::MODULE_NOT_FOUND
    )
{ return false;}
if (empty($arResult["CATEGORIES"]) || !$arResult['CATEGORIES_ITEMS_EXISTS'])
	return;
?>
<div class="bx_searche">
<?foreach($arResult["CATEGORIES"] as $category_id => $arCategory):?>
	<?foreach($arCategory["ITEMS"] as $i => $arItem):?>
		<?//echo $arCategory["TITLE"]?>
		<?if($category_id === "all"):?>
			<div class="bx_item_block all_result ">
                <a class="all_result_title btn-primary" href="<?echo $arItem["URL"]?>"><?echo $arItem["NAME"]?></a>
			</div>
		<?elseif(isset($arResult["ELEMENTS"][$arItem["ITEM_ID"]])):
			$arElement = $arResult["ELEMENTS"][$arItem["ITEM_ID"]];?>
			<div class="bx_item_block">
                <div class="row no-gutters">
                    <?if (is_array($arElement["PICTURE"])):?>
                        <div class="col-auto mr-3">
                            <div class="bx_img_element">
                                <div class="bx_image" style="background-image: url('<?echo $arElement["PICTURE"]["src"]?>')"></div>
                            </div>
                        </div>
                    <?endif;?>
                    <div class="bx_item_element col">
                        <a href="<?echo $arItem["URL"]?>"><?echo $arItem["NAME"]?></a>
                        <div class="bx_item_price">
                            <?
                            foreach($arElement["PRICES"] as $code=>$arPrice)
                            {
                                if ($arPrice["MIN_PRICE"] != "Y")
                                    continue;

                                if($arPrice["CAN_ACCESS"] && $arElement['CATALOG_TYPE'] == 1)
                                {
                                    if($arPrice["DISCOUNT_VALUE"] < $arPrice["VALUE"]):?>
                                        <div class="bx_price">
                                            <?=$arPrice["PRINT_DISCOUNT_VALUE"]?>
                                            <span class="old"><?=$arPrice["PRINT_VALUE"]?></span>
                                        </div>
                                    <?else:?>
                                        <div class="bx_price"><?=$arPrice["PRINT_VALUE"]?></div>
                                    <?endif;
                                }?>
                            <?if($arElement['MEASURE']['SYMBOL_RUS'] && $arElement['CATALOG_TYPE'] == 1):?>
                                <span class="bx_measure"><?=$arElement['MEASURE']['TEXT']?></span>
                            <?endif;?>
                              <?  if ($arPrice["MIN_PRICE"] == "Y")
                                    break;
                            }
                            ?>
                        </div>
                    </div>
                </div>
			</div>
		<?else:?>
			<div class="bx_item_block others_result">
				<div class="bx_item_element">
					<a href="<?echo $arItem["URL"]?>"><?echo $arItem["NAME"]?></a>
				</div>
			</div>
		<?endif;?>
	<?endforeach;?>
<?endforeach;?>
</div>