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

$themeClass = isset($arParams['TEMPLATE_THEME']) ? ' bx-'.$arParams['TEMPLATE_THEME'] : '';
?>

<?if($arParams["DISPLAY_TOP_PAGER"]):?>
<div class="row mb-4">
    <div class="col text-center">
        <?=$arResult["NAV_STRING"]?>
    </div>
</div>
<?endif;?>

<div class="receipt-list row">
    <?
    $num = 1;
    foreach($arResult["ITEMS"] as $arItem):?>
        <div class="receipt-list-col col-lg-4 col-sm-6 col-12">
            <div class="receipt-list-item news-list-item" id="<?=$this->GetEditAreaId($arItem['ID']);?>">
                <div class="receipt-item-row">
                    <div class="receipt-item-col">
                        <?if($arParams["DISPLAY_PICTURE"]!="N"):?>
                            <?
                            if (is_array($arItem["PREVIEW_PICTURE"]))
                            {
                                if (!$arParams["HIDE_LINK_WHEN_NO_DETAIL"] || ($arItem["DETAIL_TEXT"] && $arResult["USER_HAVE_ACCESS"]))
                                {
                                    ?>
                                    <a href="<?= $arItem["DETAIL_PAGE_URL"] ?>"
                                       title="<?= $arItem["PREVIEW_PICTURE"]["TITLE"] ?>">
                                        <div class="receipt-item-image-wrapper embed-responsive embed-responsive-4by3">
                                            <div class="receipt-item-image embed-responsive-item"
                                                 style="background-image: url(<?= $arItem["PREVIEW_PICTURE"]["SRC"] ?>);"></div>
                                        </div>
                                    </a>
                                    <?
                                }
                                else
                                {
                                    ?>
                                    <div class="receipt-item-image-wrapper embed-responsive embed-responsive-4by3">
                                        <div class="receipt-item-image embed-responsive-item"
                                             style="background-image: url(<?= $arItem["PREVIEW_PICTURE"]["SRC"] ?>);"></div>
                                    </div>
                                    <?
                                }
                            }
                            ?>
                        <?endif;?>
                    </div>
                    <div class="receipt-item-col">
                        <div class="receipt-item-content" style="<?=(($num % 2) == 0 ? 'border-right: 0;' : 'border-left: 0;');?>">
                            <div class="receipt-item-top">
                                <?if($arParams["DISPLAY_NAME"]!="N" && $arItem["NAME"]):?>
                                    <h4 class="receipt-item-title">
                                        <?if(!$arParams["HIDE_LINK_WHEN_NO_DETAIL"] || ($arItem["DETAIL_TEXT"] && $arResult["USER_HAVE_ACCESS"])):?>
                                            <a href="<?echo $arItem["DETAIL_PAGE_URL"]?>"><?echo $arItem["NAME"]?></a>
                                        <?else:?>
                                            <?echo $arItem["NAME"]?>
                                        <?endif;?>
                                    </h4>
                                <?endif;?>
                                <?if($arParams["DISPLAY_PREVIEW_TEXT"]!="N" && $arItem["PREVIEW_TEXT"]):?>
                                    <div class="receipt-item-text"><?echo $arItem["PREVIEW_TEXT"];?></div>
                                <?endif;?>
                            </div>
                            <div class="receipt-item-bottom">
                                <div class="row justify-content-between m-0">
                                    <?if($arItem['PROPERTIES']['TIME_RECEIPT']['VALUE']):?>
                                        <div class="receipt-time col-auto p-0">
                                            <span class="receipt-time-icon"></span>
                                            <span class="receipt-time-name"><?=$arItem['PROPERTIES']['TIME_RECEIPT']['VALUE']?></span>
                                        </div>
                                    <?endif;?>
                                    <?if($arItem['PROPERTIES']['COUNT_RECEIPT']['VALUE']):?>
                                        <div class="receipt-person col-auto p-0">
                                            <span class="receipt-person-icon"></span>
                                            <span class="receipt-person-name"><?=($arItem['PROPERTIES']['COUNT_RECEIPT']['VALUE'])?></span>
                                        </div>
                                    <?endif;?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <?
    $num++;
    endforeach;?>
</div>

<?if($arParams["DISPLAY_BOTTOM_PAGER"]):?>
    <div class="row">
        <div class="col text-center">
            <?=$arResult["NAV_STRING"]?>
        </div>
    </div>
<?endif;?>
