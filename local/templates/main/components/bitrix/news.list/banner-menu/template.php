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
<div class="bx-top-nav-banner">
    <div class="bx-top-nav-banner-row row mr-0">
        <?foreach($arResult["ITEMS"] as $arItem):?>
            <?
            $this->AddEditAction(
                $arItem['ID'],
                $arItem['EDIT_LINK'],
                CIBlock::GetArrayByID(
                    $arItem["IBLOCK_ID"],
                    "ELEMENT_EDIT"
                )
            );
            $this->AddDeleteAction(
                $arItem['ID'],
                $arItem['DELETE_LINK'],
                CIBlock::GetArrayByID(
                    $arItem["IBLOCK_ID"],
                    "ELEMENT_DELETE"),
                array("CONFIRM" => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM'))
            );
//            print_r($arResult);
            ?>
            <div class="top-nav-banner-item col-4 pr-0" id="<?=$this->GetEditAreaId($arItem['ID']);?>">
                <div class="card">
                    <?if($arParams["DISPLAY_NAME"]!="N" && $arItem["NAME"]):?>
                        <h4 class="card-title">
                            <?if(!$arParams["HIDE_LINK_WHEN_NO_DETAIL"] || ($arItem["DETAIL_TEXT"] && $arResult["USER_HAVE_ACCESS"])):?>
                                <a href="<?echo $arItem["DETAIL_PAGE_URL"]?>"><?echo $arItem["NAME"]?></a>
                            <?else:?>
                                <?echo $arItem["NAME"]?>
                            <?endif;?>
                        </h4>
                    <?endif;?>
                    <?if($arParams["DISPLAY_PICTURE"]!="N"):?>

                        <?
                        if (is_array($arItem["PREVIEW_PICTURE"]))
                        {
                            if (!empty($arItem["DISPLAY_PROPERTIES"]['MENU_BANNER_LINK']['VALUE']))
                            {
                                $file = CFile::ResizeImageGet(
                                        $arItem["PREVIEW_PICTURE"]['ID'],
                                        array('width'=>'500', 'height'=>'740'),
                                        BX_RESIZE_IMAGE_PROPORTIONAL,
                                        true
                                );
                                ?>
                                <a href="<?=SITE_DIR;?><?=$arItem['DISPLAY_PROPERTIES']['MENU_BANNER_LINK']['VALUE'] ?>">
                                    <div class="card-img-top-wrapper embed-responsive">
                                        <div style="background-image: url(<?=$file["src"]?>); background-image: -webkit-image-set(url(<?=$file["src"]?>) 1x,url(<?=$arItem["PREVIEW_PICTURE"]['SRC']?>) 2x);"
                                             class="card-img-top embed-responsive-item">
                                        </div>
                                    </div>
                                </a>
                                <?
                            }
                            else
                            {
                                ?>
                                <div class="card-img-top-wrapper">
                                    <div style="background-image: url(<?= $arItem["PREVIEW_PICTURE"]["SRC"] ?>);"
                                         class="card-img-top">
                                    </div>
                                </div>
                                <?
                            }
                        }
                        ?>

                    <?endif;?>
                </div>
            </div>
        <?endforeach;?>
    </div>
</div>
