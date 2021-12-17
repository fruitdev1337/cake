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
if($arResult['SECTIONS'])
{?>
    <div class="catalog__section-list">
        <div class="title visible-xs">
            <span><?=\Bitrix\Main\Localization\Loc::getMessage('K_TITLE_SECTION')?></span>
            <button class="open_list fa fa-angle-down" data-id="categories"></button>
        </div>
        <div id="categories" class="hidden_list">
        <div class="title">
            <a href="<?=$arResult['PARENT_SECTION']['SECTION_PAGE_URL']?>">
                <?if($arResult['PARENT_SECTION']['ICON']):?>
                    <span class="bx-nav-icon">
                        <img src="<?=$arResult['PARENT_SECTION']['ICON']?>" title="<?=$arResult['PARENT_SECTION']['NAME']?>" alt="<?=$arResult['PARENT_SECTION']['NAME']?>">
                    </span>
                <?endif;?>
                <span class="bx-nav-title"><?=$arResult['PARENT_SECTION']['NAME']?></span>
            </a>
        </div>
        <div class="section__list-wrapper">
                <?$APPLICATION->IncludeComponent(
                "bitrix:menu",
                "section-menu",
                array(
                    "ALLOW_MULTI_SELECT" => "N",
                    "CHILD_MENU_TYPE" => "",
                    "DELAY" => "N",
                    "MAX_LEVEL" => "3",
                    "MENU_CACHE_GET_VARS" => array(
                    ),
                    "MENU_CACHE_TIME" => "3600",
                    "MENU_CACHE_TYPE" => "A",
                    "MENU_CACHE_USE_GROUPS" => "Y",
                    "MENU_THEME" => "site",
                    "ROOT_MENU_TYPE" => "catalog",
                    "USE_EXT" => "Y",
                    "SECTIONS" => $arResult['SECTIONS'],
                    "CURRENT_SECTION_ID" => $arParams['CURRENT_SECTION_ID'],
                ),
                $component
            );?>
        </div>
        </div>
    </div>


<?}
