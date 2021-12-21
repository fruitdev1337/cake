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
//print_r($arResult)
?>
<div class="receipt-list row">
    <?if($arResult['left']):?>
		<div class="row-cell-left col-sm-6 col-12">
            <div class="receipt-list-item news-list-item" id="<?=$this->GetEditAreaId($arResult['left']['ID']);?>">
                <div class="receipt-item-row row m-0">
                    <div class="receipt-item-col col-sm-6 col-12 p-0">
                        <?if($arParams["DISPLAY_PICTURE"]!="N"):?>
                            <?
                            if (is_array($arResult['left']["PREVIEW_PICTURE"]))
                            {
                                if (!$arParams["HIDE_LINK_WHEN_NO_DETAIL"] || ($arResult['left']["DETAIL_TEXT"] && $arResult["USER_HAVE_ACCESS"]))
                                {
                                    ?>
                                    <a href="<?= $arResult['left']["DETAIL_PAGE_URL"] ?>"
                                       title="<?= $arResult['left']["PREVIEW_PICTURE"]["TITLE"] ?>">
                                        <div class="receipt-item-image-wrapper embed-responsive">
                                            <div class="receipt-item-image embed-responsive-item"
                                                 style="background-image: url(<?= $arResult['left']["PREVIEW_PICTURE"]["SRC"] ?>);"></div>
                                        </div>
                                    </a>
                                    <?
                                }
                                else
                                {
                                    ?>
                                    <div class="receipt-item-image-wrapper embed-responsive embed-responsive-1by1">
                                        <div class="receipt-item-image embed-responsive-item"
                                             style="background-image: url(<?= $arResult['left']["PREVIEW_PICTURE"]["SRC"] ?>);"></div>
                                    </div>
                                    <?
                                }
                            }
                            ?>
                        <?endif;?>
                    </div>
                    <div class="receipt-item-col col-sm-6 col-12 p-0">
                        <div class="receipt-item-content">
                            <?if($arParams["DISPLAY_NAME"]!="N" && $arResult['left']["NAME"]):?>
                                <h4 class="receipt-item-title">
                                    <?if(!$arParams["HIDE_LINK_WHEN_NO_DETAIL"] || ($arResult['left']["DETAIL_TEXT"] && $arResult["USER_HAVE_ACCESS"])):?>
                                        <a href="<?echo $arResult['left']["DETAIL_PAGE_URL"]?>"><?echo $arResult['left']["NAME"]?></a>
                                    <?else:?>
                                        <?echo $arResult['left']["NAME"]?>
                                    <?endif;?>
                                </h4>
                            <?endif;?>
                            <?if($arParams["DISPLAY_PREVIEW_TEXT"]!="N" && $arResult['left']["PREVIEW_TEXT"]):?>
                                <div class="receipt-item-text"><?echo $arResult['left']["PREVIEW_TEXT"];?></div>
                            <?endif;?>
                            <div class="receipt-item-bottom">
                                <div class="row">
                                    <?if($arResult['left']['PROPERTIES']['TIME_RECEIPT']['VALUE']):?>
                                        <div class="receipt-time col-6">
                                            <span class="receipt-time-icon"></span>
                                            <span class="receipt-time-name"><?=$arResult['left']['PROPERTIES']['TIME_RECEIPT']['VALUE']?></span>
                                        </div>
                                    <?endif;?>
                                    <?if($arResult['left']['PROPERTIES']['COUNT_RECEIPT']['VALUE']):?>
                                        <div class="receipt-person col-6">
                                            <span class="receipt-person-icon"></span>
                                            <span class="receipt-person-name"><?=($arResult['left']['PROPERTIES']['COUNT_RECEIPT']['VALUE'])?></span>
                                        </div>
                                    <?endif;?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
		</div>
    <?endif;?>
        <?if($arResult['rigth1']):?>
    <div class="row-cell-right right-1 col-sm-3 col-12 pl-0">
            <div class="receipt-list-item news-list-item" id="<?=$this->GetEditAreaId($arResult['rigth1']['ID']);?>">
                <div class="receipt-item-row">
                    <div class="receipt-item-col">
                        <?if($arParams["DISPLAY_PICTURE"]!="N"):?>
                            <?
                            if (is_array($arResult['rigth1']["PREVIEW_PICTURE"]))
                            {
                                if (!$arParams["HIDE_LINK_WHEN_NO_DETAIL"] || ($arResult['rigth1']["DETAIL_TEXT"] && $arResult["USER_HAVE_ACCESS"]))
                                {
                                    ?>
                                    <a href="<?= $arResult['rigth1']["DETAIL_PAGE_URL"] ?>"
                                       title="<?= $arResult['rigth1']["PREVIEW_PICTURE"]["TITLE"] ?>">
                                        <div class="receipt-item-image-wrapper embed-responsive embed-responsive-4by3">
                                            <div class="receipt-item-image embed-responsive-item"
                                                 style="background-image: url(<?= $arResult['rigth1']["PREVIEW_PICTURE"]["SRC"] ?>);"></div>
                                        </div>
                                    </a>
                                    <?
                                }
                                else
                                {
                                    ?>
                                    <div class="receipt-item-image-wrapper embed-responsive embed-responsive-4by3">
                                        <div class="receipt-item-image embed-responsive-item"
                                             style="background-image: url(<?= $arResult['rigth1']["PREVIEW_PICTURE"]["SRC"] ?>);"></div>
                                    </div>
                                    <?
                                }
                            }
                            ?>
                        <?endif;?>
                    </div>
                    <div class="receipt-item-col">
                        <div class="receipt-item-content">
                            <?if($arParams["DISPLAY_NAME"]!="N" && $arResult['rigth1']["NAME"]):?>
                                <h4 class="receipt-item-title">
                                    <?if(!$arParams["HIDE_LINK_WHEN_NO_DETAIL"] || ($arResult['rigth1']["DETAIL_TEXT"] && $arResult["USER_HAVE_ACCESS"])):?>
                                        <a href="<?echo $arResult['rigth1']["DETAIL_PAGE_URL"]?>"><?echo $arResult['rigth1']["NAME"]?></a>
                                    <?else:?>
                                        <?echo $arResult['rigth1']["NAME"]?>
                                    <?endif;?>
                                </h4>
                            <?endif;?>
                            <?if($arParams["DISPLAY_PREVIEW_TEXT"]!="N" && $arResult['rigth1']["PREVIEW_TEXT"]):?>
                                <div class="receipt-item-text"><?echo $arResult['rigth1']["PREVIEW_TEXT"];?></div>
                            <?endif;?>
                            <div class="receipt-item-bottom">
                                <div class="row">
                                    <?if($arResult['rigth1']['PROPERTIES']['TIME_RECEIPT']['VALUE']):?>
                                        <div class="receipt-time col-6">
                                            <span class="receipt-time-icon"></span>
                                            <span class="receipt-time-name"><?=$arResult['rigth1']['PROPERTIES']['TIME_RECEIPT']['VALUE']?></span>
                                        </div>
                                    <?endif;?>
                                    <?if($arResult['rigth1']['PROPERTIES']['COUNT_RECEIPT']['VALUE']):?>
                                        <div class="receipt-person col-6">
                                            <span class="receipt-person-icon"></span>
                                            <span class="receipt-person-name"><?=($arResult['rigth1']['PROPERTIES']['COUNT_RECEIPT']['VALUE'])?></span>
                                        </div>
                                    <?endif;?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
    </div>
        <?endif;?>
        <?if($arResult['rigth2']):?>
    <div class="row-cell-right right-2 col-sm-3 col-12 pl-0">
        <div class="receipt-list-item news-list-item" id="<?=$this->GetEditAreaId($arResult['rigth2']['ID']);?>">
            <div class="receipt-item-row">
                <div class="receipt-item-col">
                    <?if($arParams["DISPLAY_PICTURE"]!="N"):?>
                        <?
                        if (is_array($arResult['rigth2']["PREVIEW_PICTURE"]))
                        {
                            if (!$arParams["HIDE_LINK_WHEN_NO_DETAIL"] || ($arResult['rigth2']["DETAIL_TEXT"] && $arResult["USER_HAVE_ACCESS"]))
                            {
                                ?>
                                <a href="<?= $arResult['rigth2']["DETAIL_PAGE_URL"] ?>"
                                   title="<?= $arResult['rigth2']["PREVIEW_PICTURE"]["TITLE"] ?>">
                                    <div class="receipt-item-image-wrapper embed-responsive embed-responsive-4by3">
                                        <div class="receipt-item-image embed-responsive-item"
                                             style="background-image: url(<?= $arResult['rigth2']["PREVIEW_PICTURE"]["SRC"] ?>);"></div>
                                    </div>
                                </a>
                                <?
                            }
                            else
                            {
                                ?>
                                <div class="receipt-item-image-wrapper embed-responsive embed-responsive-4by3">
                                    <div class="receipt-item-image embed-responsive-item"
                                         style="background-image: url(<?= $arResult['rigth2']["PREVIEW_PICTURE"]["SRC"] ?>);"></div>
                                </div>
                                <?
                            }
                        }
                        ?>
                    <?endif;?>
                </div>
                <div class="receipt-item-col">
                    <div class="receipt-item-content">
                        <?if($arParams["DISPLAY_NAME"]!="N" && $arResult['rigth2']["NAME"]):?>
                            <h4 class="receipt-item-title">
                                <?if(!$arParams["HIDE_LINK_WHEN_NO_DETAIL"] || ($arResult['rigth2']["DETAIL_TEXT"] && $arResult["USER_HAVE_ACCESS"])):?>
                                    <a href="<?echo $arResult['rigth2']["DETAIL_PAGE_URL"]?>"><?echo $arResult['rigth2']["NAME"]?></a>
                                <?else:?>
                                    <?echo $arResult['rigth2']["NAME"]?>
                                <?endif;?>
                            </h4>
                        <?endif;?>
                        <?if($arParams["DISPLAY_PREVIEW_TEXT"]!="N" && $arResult['rigth2']["PREVIEW_TEXT"]):?>
                            <div class="receipt-item-text"><?echo $arResult['rigth2']["PREVIEW_TEXT"];?></div>
                        <?endif;?>
                        <div class="receipt-item-bottom">
                            <div class="row">
                                <?if($arResult['rigth2']['PROPERTIES']['TIME_RECEIPT']['VALUE']):?>
                                    <div class="receipt-time col-6">
                                        <span class="receipt-time-icon"></span>
                                        <span class="receipt-time-name"><?=$arResult['rigth2']['PROPERTIES']['TIME_RECEIPT']['VALUE']?></span>
                                    </div>
                                <?endif;?>
                                <?if($arResult['rigth2']['PROPERTIES']['COUNT_RECEIPT']['VALUE']):?>
                                    <div class="receipt-person col-6">
                                        <span class="receipt-person-icon"></span>
                                        <span class="receipt-person-name"><?=($arResult['rigth2']['PROPERTIES']['COUNT_RECEIPT']['VALUE'])?></span>
                                    </div>
                                <?endif;?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
        <?endif;?>
</div>


<div style="display: none;" class="receipt-list-container">

    <div class="receipt-list">
        <?if($arResult['rigth2']):?>
            <div class="row-cell-left">
                <div class="receipt-list-item first"  id="<?=$this->GetEditAreaId($arResult['left']['ID']);?>">
                    <div class="sales_img_wrapper">
                        <?if($arParams['LOAD_IMG_JS'] == 'Y'):?>
                            <a href="<?=$arResult['left']["DETAIL_PAGE_URL"]?>" class="sales_link">
                                <div class="sales_img LOAD_IMG_JS_STOCK"
                                     data-src = "<?=$arResult['left']["PREVIEW_PICTURE"]["SRC"]?>"
                                     style="background-image:url('<?=$templateFolder?>/images/fon.svg');"
                                     title="<?=$arResult['left']["PREVIEW_PICTURE"]["TITLE"]?>"></div>
                            </a>
                        <?else:?>
                            <a href="<?=$arResult['left']["DETAIL_PAGE_URL"]?>" class="sales_link">
                                <div class="sales_img"
                                     style="background-image:url(<?=$arResult['left']["PREVIEW_PICTURE"]["SRC"]?>);"
                                     title="<?=$arResult['left']["PREVIEW_PICTURE"]["TITLE"]?>"></div>
                            </a>
                        <?endif;?>
                    </div>
                </div>
            </div>
        <?endif;?>

        <div class="row-cell-right">
            <?if($arResult['rigth1']):?>
                <div class="receipt-list-item col-top"  id="<?=$this->GetEditAreaId($arResult['rigth1']['ID']);?>">
                    <div class="sales_img_wrapper">
                        <?if($arParams['LOAD_IMG_JS'] == 'Y'):?>
                            <a href="<?=$arResult['rigth1']["DETAIL_PAGE_URL"]?>" class="sales_link">
                                <div class="sales_img LOAD_IMG_JS_STOCK"
                                     data-src = "<?=$arResult['rigth1']["PREVIEW_PICTURE"]["SRC"]?>"
                                     style="background-image:url('<?=$templateFolder?>/images/fon.svg');"
                                     title="<?=$arResult['rigth1']["PREVIEW_PICTURE"]["TITLE"]?>"></div>
                            </a>
                        <?else:?>
                            <a href="<?=$arResult['rigth1']["DETAIL_PAGE_URL"]?>" class="sales_link">
                                <div class="sales_img"
                                     style="background-image:url(<?=$arResult['rigth1']["PREVIEW_PICTURE"]["SRC"]?>);"
                                     title="<?=$arResult['rigth1']["PREVIEW_PICTURE"]["TITLE"]?>"></div>
                            </a>
                        <?endif;?>
                    </div>
                </div>
            <?endif;?>
            <?if($arResult['rigth2']):?>
                <div class="receipt-list-item col-bottom"  id="<?=$this->GetEditAreaId($arResult['rigth2']['ID']);?>">
                    <div class="sales_img_wrapper">
                        <?if($arParams['LOAD_IMG_JS'] == 'Y'):?>
                            <a href="<?=$arResult['rigth2']["DETAIL_PAGE_URL"]?>" class="sales_link">
                                <div class="sales_img LOAD_IMG_JS_STOCK"
                                     data-src = "<?=$arResult['rigth2']["PREVIEW_PICTURE"]["SRC"]?>"
                                     style="background-image:url('<?=$templateFolder?>/images/fon.svg');"
                                     title="<?=$arResult['rigth2']["PREVIEW_PICTURE"]["TITLE"]?>"></div>
                            </a>
                        <?else:?>
                            <a href="<?=$arResult['rigth2']["DETAIL_PAGE_URL"]?>" class="sales_link">
                                <div class="sales_img"
                                     style="background-image:url(<?=$arResult['rigth2']["PREVIEW_PICTURE"]["SRC"]?>);"
                                     title="<?=$arResult['rigth2']["PREVIEW_PICTURE"]["TITLE"]?>"></div>
                            </a>
                        <?endif;?>
                    </div>
                </div>
            <?endif;?>
        </div>
    </div>
</div>