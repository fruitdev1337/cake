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
?>

<? if(!empty($arResult['DESCRIPTION'])) {?>
    <div class="text_box"><?=$arResult['DESCRIPTION']?></div>
<?}?>

<div class="brands_container">
<?if($arParams["DISPLAY_TOP_PAGER"]):?>
    <div class="row mb-4">
        <div class="col text-center">
	        <?=$arResult["NAV_STRING"]?>
        </div>
    </div>
<?endif;?>
        <div class="brands_wrapper row">
            <?foreach($arResult["ITEMS"] as $arItem):?>
                <?
                $this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_EDIT"));
                $this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));
                ?>
                <div class="brand_item col-lg-3 col-md-4 col-sm-6 col-12" id="<?=$this->GetEditAreaId($arItem['ID']);?>">
                    <div class="brand_item_wrapper">
                        <?
                        if($arParams["DISPLAY_PICTURE"]!="N" || is_array($arItem["PREVIEW_PICTURE"])):?>
                            <?
                            if(!$arParams["HIDE_LINK_WHEN_NO_DETAIL"] || ($arItem["DETAIL_TEXT"] && $arResult["USER_HAVE_ACCESS"])):?>
                                <a href="<?=$arItem['DETAIL_PAGE_URL']?>" title="<?=\Bitrix\Main\Localization\Loc::getMessage('K_TITLE_LINK')?> <?echo $arItem["NAME"]?>">
                                    <div class="brand_item_image embed-responsive embed-responsive-16by9">
                                        <img class="embed-responsive-item"
                                                src="<?=$arItem["PREVIEW_PICTURE"]["SRC"]?>"
                                                width="<?=$arItem["PREVIEW_PICTURE"]["WIDTH"]?>"
                                                height="<?=$arItem["PREVIEW_PICTURE"]["HEIGHT"]?>"
                                                alt="<?=$arItem["PREVIEW_PICTURE"]["ALT"]?>"
                                                title="<?=$arItem["PREVIEW_PICTURE"]["TITLE"]?>">
                                    </div>
                                </a>
                            <?else:?>
                                <div class="brand_item_image embed-responsive embed-responsive-16by9">
                                    <img class="embed-responsive-item"
                                            src="<?=$arItem["PREVIEW_PICTURE"]["SRC"]?>"
                                            width="<?=$arItem["PREVIEW_PICTURE"]["WIDTH"]?>"
                                            height="<?=$arItem["PREVIEW_PICTURE"]["HEIGHT"]?>"
                                            alt="<?=$arItem["PREVIEW_PICTURE"]["ALT"]?>"
                                            title="<?=$arItem["PREVIEW_PICTURE"]["TITLE"]?>">
                                </div>
                            <?endif;?>
                        <?endif;?>
                        <?
                        if($arParams["DISPLAY_NAME"]!="N" && $arItem["NAME"]):?>
                            <h3 class="brand_item_name">
                                <?if(!$arParams["HIDE_LINK_WHEN_NO_DETAIL"] || ($arItem["DETAIL_TEXT"] && $arResult["USER_HAVE_ACCESS"])):?>
                                    <a href="<?echo $arItem["DETAIL_PAGE_URL"]?>" title="<?=\Bitrix\Main\Localization\Loc::getMessage('K_TITLE_LINK')?> <?echo $arItem["NAME"]?>"><?echo $arItem["NAME"]?></a>
                                <?else:?>
                                    <?echo $arItem["NAME"]?>
                                <?endif;?>
                            </h3>
                        <?endif;?>
                    </div>
                </div>
            <?endforeach;?>

        </div>


<?if($arParams["DISPLAY_BOTTOM_PAGER"]):?>
    <div class="row mb-4">
        <div class="col text-center">
	        <?=$arResult["NAV_STRING"]?>
        </div>
    </div>
<?endif;?>
</div>
