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

<div class="sales_container">
    <div class="sales__wrapper row">
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
            ?>

            <div class="sales__item col-sm-4 col-12"  id="<?=$this->GetEditAreaId($arResult['ID']);?>">
                <div class="sales_img_wrapper">
                    <?if($arParams["DISPLAY_PICTURE"]!="N"):?>
                        <?if (is_array($arItem["PREVIEW_PICTURE"]))
                        {
                            $file = CFile::ResizeImageGet(
                                $arItem["PREVIEW_PICTURE"]['ID'],
                                array('width'=>'500', 'height'=>'300'),
                                BX_RESIZE_IMAGE_PROPORTIONAL,
                                true
                            );

                            if (!$arParams["HIDE_LINK_WHEN_NO_DETAIL"] || ($arItem["DETAIL_TEXT"] && $arResult["USER_HAVE_ACCESS"]))
                            {
                                ?>
                                <?if($arParams['LOAD_IMG_JS'] == 'Y'):?>
                                    <a href="<?=$arItem["DETAIL_PAGE_URL"]?>" class="sales_link">
                                        <img class="sales_img LOAD_IMG_JS_STOCK"
                                             data-src="<?=$file["src"]?>"
                                             width="<?=$file["width"]?>"
                                             height="<?=$file["height"]?>"
                                             src="<?=$templateFolder?>/images/fon.svg"
                                             title="<?=$arItem["PREVIEW_PICTURE"]["TITLE"]?>">
                                    </a>
                                <?else:?>
                                    <a href="<?=$arItem["DETAIL_PAGE_URL"]?>" class="sales_link">
                                        <img class="sales_img"
                                             src="<?=$file["src"]?>"
                                             width="<?=$file["width"]?>"
                                             height="<?=$file["height"]?>"
                                             title="<?=$arItem["PREVIEW_PICTURE"]["TITLE"]?>">
                                    </a>
                                <?
                                endif;
                            }
                            else
                            {
                                ?>
                                <div class="sales_link">
                                    <img class="sales_img"
                                         src="<?=$file["src"]?>"
                                         width="<?=$file["width"]?>"
                                         height="<?=$file["height"]?>"
                                         title="<?=$arItem["PREVIEW_PICTURE"]["TITLE"]?>">
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
