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
<div class="promo-list">
            <?if($arParams["DISPLAY_TOP_PAGER"]):?>
    <div class="row">
        <div class="col text-center">
                <?=$arResult["NAV_STRING"]?>
        </div>
    </div>
            <?endif;?>
<div class="promo-list-row row">
    <?foreach($arResult["ITEMS"] as $arItem):?>
        <?
        $this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_EDIT"));
        $this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));
        //print_r($arItem)
        ?>
        <div class="promo-list-item-container col-lg-6 col-12" id="<?=$this->GetEditAreaId($arItem['ID']);?>">
            <div class="promo-list-item">

                <div class="promo-list-img-container">
                    <?if($arParams["DISPLAY_PICTURE"]!="N"):?>
                        <?if (is_array($arItem["PREVIEW_PICTURE"])):
                            $file = CFile::ResizeImageGet(
                                $arItem["PREVIEW_PICTURE"]['ID'],
                                array('width'=>'700', 'height'=>'500'),
                                BX_RESIZE_IMAGE_PROPORTIONAL,
                                true
                            );
                            ?>
                            <?if(!$arParams["HIDE_LINK_WHEN_NO_DETAIL"] || ($arItem["DETAIL_TEXT"] && $arResult["USER_HAVE_ACCESS"])):?>
                                <a href="<?=$arItem["DETAIL_PAGE_URL"]?>">
                                    <div class="promo-list-item-img-wrapper embed-responsive embed-responsive-16by9">
                                        <div class="promo-list-item-img embed-responsive-item"
                                             style="background-image: url(<?=$file["src"]?>); background-image: -webkit-image-set(url(<?=$file["src"]?>) 1x,url(<?=$arItem["PREVIEW_PICTURE"]['SRC']?>) 2x);"></div>
                                    </div>
                                </a>
                            <?else:?>
                                <div class="promo-list-item-img-wrapper embed-responsive embed-responsive-16by9">
                                    <div class="promo-list-item-img embed-responsive-item"
                                         style="background-image: url(<?=$file["src"]?>);"></div>
                                </div>
                            <?endif;?>
                        <?endif;?>
                    <?endif;?>
                </div>

                <div class="promo-list-item-block">
                    <div class="promo-list-item-dates">
                        <span class="fa fa-calendar"></span> <span>c <?=$arItem['DATE_ACTIVE_FROM']?> по <?=$arItem['DATE_ACTIVE_TO']?></span>
                    </div>

                    <?
                    if ($arParams["USE_SHARE"] == "Y")
                    {
                        ?>
                        <div class="text-right">
                            <noindex>
                                <?
                                $APPLICATION->IncludeComponent("bitrix:main.share", $arParams["SHARE_TEMPLATE"], array(
                                    "HANDLERS" => $arParams["SHARE_HANDLERS"],
                                    "PAGE_URL" => $arItem["~DETAIL_PAGE_URL"],
                                    "PAGE_TITLE" => $arItem["~NAME"],
                                    "SHORTEN_URL_LOGIN" => $arParams["SHARE_SHORTEN_URL_LOGIN"],
                                    "SHORTEN_URL_KEY" => $arParams["SHARE_SHORTEN_URL_KEY"],
                                    "HIDE" => $arParams["SHARE_HIDE"],
                                ),
                                    $component,
                                    array("HIDE_ICONS" => "Y")
                                );
                                ?>
                            </noindex>
                        </div>
                        <?
                    }
                    ?>
                </div>
            </div>
        </div>
    <?endforeach;?>
</div>
            <?if($arParams["DISPLAY_BOTTOM_PAGER"]):?>
                <div class="row">
                    <div class="col text-center">
                        <?=$arResult["NAV_STRING"]?>
                    </div>
                </div>
            <?endif;?>
</div>

