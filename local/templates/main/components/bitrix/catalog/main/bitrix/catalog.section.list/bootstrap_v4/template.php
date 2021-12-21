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

if($arResult['SECTION']) {
    $arViewModeList = $arResult['VIEW_MODE_LIST'];

    $arViewStyles = array(
        'LIST' => array(
            'CONT' => 'bx_sitemap',
            'TITLE' => 'bx_sitemap_title',
            'LIST' => 'bx_sitemap_ul',
        ),
        'LINE' => array(
            'CONT' => 'bx_catalog_line',
            'TITLE' => 'bx_catalog_line_category_title',
            'LIST' => 'bx_catalog_line_ul',
            'EMPTY_IMG' => $this->GetFolder() . '/images/line-empty.png'
        ),
        'TEXT' => array(
            'CONT' => 'bx_catalog_text',
            'TITLE' => 'bx_catalog_text_category_title',
            'LIST' => 'bx_catalog_text_ul'
        ),
        'TILE' => array(
            'CONT' => 'bx_catalog_tile',
            'TITLE' => 'bx_catalog_tile_category_title',
            'LIST' => 'bx_catalog_tile_ul',
            'EMPTY_IMG' => $this->GetFolder() . '/images/tile-empty.png'
        )
    );
    $arCurView = $arViewStyles[$arParams['VIEW_MODE']];

    $strSectionEdit = CIBlock::GetArrayByID($arParams["IBLOCK_ID"], "SECTION_EDIT");
    $strSectionDelete = CIBlock::GetArrayByID($arParams["IBLOCK_ID"], "SECTION_DELETE");
    $arSectionDeleteParams = array("CONFIRM" => GetMessage('CT_BCSL_ELEMENT_DELETE_CONFIRM'));

    ?>

    <div class="catalog_section_list">
        <? if ('Y' == $arParams['SHOW_PARENT_NAME'] && 0 < $arResult['SECTION']['ID']) {
            $this->AddEditAction($arResult['SECTION']['ID'], $arResult['SECTION']['EDIT_LINK'], $strSectionEdit);
            $this->AddDeleteAction($arResult['SECTION']['ID'], $arResult['SECTION']['DELETE_LINK'], $strSectionDelete, $arSectionDeleteParams);

            ?><h2 class="mb-3" id="<? echo $this->GetEditAreaId($arResult['SECTION']['ID']); ?>" ><?
            echo(
            isset($arResult['SECTION']["IPROPERTY_VALUES"]["SECTION_PAGE_TITLE"]) && $arResult['SECTION']["IPROPERTY_VALUES"]["SECTION_PAGE_TITLE"] != ""
                ? $arResult['SECTION']["IPROPERTY_VALUES"]["SECTION_PAGE_TITLE"]
                : $arResult['SECTION']['NAME']
            );
            ?>
            </h2><?
        }

            ?>
            <div class="mb-4 row <? echo $arCurView['LIST']; ?>"><?
            foreach ($arResult['SECTIONS'] as &$arSection) {
                $this->AddEditAction($arSection['ID'], $arSection['EDIT_LINK'], $strSectionEdit);
                $this->AddDeleteAction($arSection['ID'], $arSection['DELETE_LINK'], $strSectionDelete, $arSectionDeleteParams);

                if (false === $arSection['PICTURE'])
                    $arSection['PICTURE'] = array(
                        'SRC' => $arCurView['EMPTY_IMG'],
                        'ALT' => (
                        '' != $arSection["IPROPERTY_VALUES"]["SECTION_PICTURE_FILE_ALT"]
                            ? $arSection["IPROPERTY_VALUES"]["SECTION_PICTURE_FILE_ALT"]
                            : $arSection["NAME"]
                        ),
                        'TITLE' => (
                        '' != $arSection["IPROPERTY_VALUES"]["SECTION_PICTURE_FILE_TITLE"]
                            ? $arSection["IPROPERTY_VALUES"]["SECTION_PICTURE_FILE_TITLE"]
                            : $arSection["NAME"]
                        )
                    );
                ?>
                <div id="<? echo $this->GetEditAreaId($arSection['ID']); ?>"
                     class="col-sm-6 col-md-4 col-lg-3 catalog-section-list-item">
                    <div class="catalog-section-list-item-wrapper">
                        <div class="catalog-section-list-tile-img-container embed-responsive embed-responsive-16by9">
                            <a href="<? echo $arSection['SECTION_PAGE_URL']; ?>">
                                <div    class="catalog-section-list-item-img embed-responsive-item"
                                        style="background-image:url('<? echo $arSection['PICTURE']['SRC']; ?>');"
                                        title="<? echo $arSection['PICTURE']['TITLE']; ?>"
                                ></div>
                            </a>
                        </div>
                        <? if ('Y' != $arParams['HIDE_SECTION_NAME']) {
                            ?>
                            <div class="catalog-section-list-item-inner">
                                <a href="<? echo $arSection['SECTION_PAGE_URL']; ?>">
                                <h3 class="catalog-section-list-item-title">
                                        <? echo $arSection['NAME']; ?>

                                    <? if ($arParams["COUNT_ELEMENTS"]) {
                                        ?>
                                        <span class="catalog-section-list-item-counter" style="display: none;">(<? echo $arSection['ELEMENT_CNT']; ?>
                                            )</span>
                                        <?
                                    }
                                    ?>
                                </h3>
                                </a>
                                <? if (!empty($arSection["DESCRIPTION"]))
                                {
                                    ?>
                                    <div style="display: none;" class="catalog-section-list-item-description"><? echo $arSection['DESCRIPTION']; ?></div>
                                    <?
                                }?>
                            </div>
                            <?
                        }
                        ?>
                    </div>
                </div>
                <?
            }
            unset($arSection);

            ?>
            </div>  </div>
        <?
        }
        ?>


