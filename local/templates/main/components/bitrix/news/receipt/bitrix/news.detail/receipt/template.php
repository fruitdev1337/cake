<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();                        
if(\Bitrix\Main\Loader::includeSharewareModule("krayt.retail") == \Bitrix\Main\Loader::MODULE_DEMO_EXPIRED || 
   \Bitrix\Main\Loader::includeSharewareModule("krayt.retail") ==  \Bitrix\Main\Loader::MODULE_NOT_FOUND
    )
{ return false;}
use \Bitrix\Main\Localization\Loc;

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
CUtil::InitJSCore(array('fx'));
?>
<div class="receipt-detail" id="<?echo $this->GetEditAreaId($arResult['ID'])?>">
    <div class="receipt-detail-top">
        <div class="receipt-detail-top-row row">
            <div class="receipt-detail-top-col col-lg-12 col-md-7 col-12">
                <div class="receipt-detail-content">
                    <?if(strlen($arResult["DETAIL_TEXT"])>0):?>
                        <?echo $arResult["DETAIL_TEXT"];?>
                    <?else:?>
                        <?echo $arResult["PREVIEW_TEXT"];?>
                    <?endif?>
                    <div class="row">
                        <?if($arResult['PROPERTIES']['TIME_RECEIPT']['VALUE']):?>
                            <div class="receipt-time col-auto">
                                <span class="receipt-time-icon"></span>
                                <span class="receipt-time-name"><?=$arResult['PROPERTIES']['TIME_RECEIPT']['VALUE']?></span>
                            </div>
                        <?endif;?>
                        <?if($arResult['PROPERTIES']['COUNT_RECEIPT']['VALUE']):?>
                            <div class="receipt-person col-auto">
                                <span class="receipt-person-icon"></span>
                                <span class="receipt-person-name"><?=($arResult['PROPERTIES']['COUNT_RECEIPT']['VALUE'])?></span>
                            </div>
                        <?endif;?>
                    </div>
                </div>
            </div>
            <?/*?>
            <div class="receipt-detail-top-col col-lg-4 col-md-5 col-12 mt-md-0 mt-3">
                <?if($arParams["DISPLAY_PICTURE"]!="N"):?>
                    <? if (is_array($arResult["DETAIL_PICTURE"]))
                    {
                        ?>
                        <div class="receipt-detail-image-wrapper embed-responsive embed-responsive-4by3">
                            <div class="receipt-detail-image embed-responsive-item"
                                 style="background-image: url(<?= $arResult["DETAIL_PICTURE"]["SRC"] ?>);"></div>
                        </div>
                        <?
                    }
                    ?>
                <?endif?>
            </div>
            <?*/?>
        </div>
    </div>
    <div class="receipt-detail-bottom">
        <div class="receipt-detail-content">
            <?if($arResult['PROPERTIES']['INGREDIENTS']['VALUE']):?>
                <div class="receipt-ingredients">
                    <div class="receipt-bottom-title"><?=$arResult['PROPERTIES']['INGREDIENTS']['NAME']?>:</div>
                    <div class="receipt-bottom-content"><?=$arResult['PROPERTIES']['INGREDIENTS']['VALUE']?></div>
                </div>
            <?endif;?>
            <?if($arResult['PROPERTIES']['INSTRUCTION']['VALUE']):?>
                <div class="receipt-instruction">
                    <div class="receipt-bottom-title"><?=$arResult['PROPERTIES']['INSTRUCTION']['NAME']?>:</div>
                    <div class="receipt-bottom-content"><?=$arResult['PROPERTIES']['INSTRUCTION']['VALUE']?></div>
                </div>
            <?endif;?>
        </div>
    </div>
</div>

<script type="text/javascript">
	BX.ready(function() {
		var slider = new JCNewsSlider('<?=CUtil::JSEscape($this->GetEditAreaId($arResult['ID']));?>', {
			imagesContainerClassName: 'news-detail-slider-container',
			leftArrowClassName: 'news-detail-slider-arrow-container-left',
			rightArrowClassName: 'news-detail-slider-arrow-container-right',
			controlContainerClassName: 'news-detail-slider-control'
		});
	});
</script>
