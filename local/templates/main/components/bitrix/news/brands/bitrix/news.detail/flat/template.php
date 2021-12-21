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

<div class="brand_detail" id="<?echo $this->GetEditAreaId($arResult['ID'])?>">

    <?if($arParams["DISPLAY_PICTURE"]!="N"):?>
        <?if(is_array($arResult["DETAIL_PICTURE"])):?>
            <div class="title_image_wrapper">
                <img
                        src="<?=$arResult["DETAIL_PICTURE"]["SRC"]?>"
                        width="<?=$arResult["DETAIL_PICTURE"]["WIDTH"]?>"
                        height="<?=$arResult["DETAIL_PICTURE"]["HEIGHT"]?>"
                        alt="<?=$arResult["DETAIL_PICTURE"]["ALT"]?>"
                        title="<?=$arResult["DETAIL_PICTURE"]["TITLE"]?>"
                />
            </div>
        <?else:?>
            <div class="title_image_wrapper">
                <img
                        src="<?=$arResult["PREVIEW_PICTURE"]["SRC"]?>"
                        width="<?=$arResult["PREVIEW_PICTURE"]["WIDTH"]?>"
                        height="<?=$arResult["PREVIEW_PICTURE"]["HEIGHT"]?>"
                        alt="<?=$arResult["PREVIEW_PICTURE"]["ALT"]?>"
                        title="<?=$arResult["PREVIEW_PICTURE"]["TITLE"]?>"
                />
            </div>
        <?endif;?>
    <?endif;?>
        <div class="title_box">
            <?if($arParams["DISPLAY_NAME"]!="N" && $arResult["NAME"]):?>
                <h1 class="brand_name"><?=$arResult["NAME"]?></h1>
            <?endif;?>
        </div>
        <div class="text_box">
            <div class="brand_content">
            <?
            if(strlen($arResult["DETAIL_TEXT"])>0):?>
                <?echo $arResult["DETAIL_TEXT"];?>
            <?else:?>
		        <?echo $arResult["PREVIEW_TEXT"];?>
	        <?endif?>
            </div>
        </div>


</div>
