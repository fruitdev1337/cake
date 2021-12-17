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

<div class="offers_box row">
<?php foreach($arResult['ITEMS'] as $key => $val){?>
    <div class="offers_box_item col-sm-4 col-6">
        <div class="row">
            <div class="col-auto">
                <?if($arParams['LOAD_IMG_JS'] == 'Y'):?>
                    <div data-src="<?=$val['PREVIEW_PICTURE']['SRC']?>" class="img_box LOAD_IMG_JS" style="background-image: url('<?=$templateFolder?>/images/fon.svg');"></div>
                <?else:?>
                    <div class="img_box" style="background-image: url('<?=$val['PREVIEW_PICTURE']['SRC']?>');"></div>
                <?endif;?>
            </div>
            <div class="col">
                <div class="text_box">
                    <b><?=$val['NAME']?></b>
                    <?=$val['PREVIEW_TEXT']?>
                </div>
            </div>
        </div>
    </div>
<?php }?>
</div>
