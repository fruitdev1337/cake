<? if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

/**
 * @var CBitrixComponentTemplate $this
 * @var CatalogSectionComponent $component
 */

$component = $this->getComponent();
$arParams = $component->applyTemplateModifications();

if($arParams['ACTION_SECTION'] && (!empty($arParams['ACTION_SECTION'])))
{

    if(CModule::IncludeModule('krayt.retail') && CModule::IncludeModule('iblock'))
    {
       $arResult['ACTIONS'] = CKray_retail::getActionBySectionId($arResult['ORIGINAL_PARAMETERS']['IBLOCK_ID'],$arResult['ORIGINAL_PARAMETERS']['SECTION_ID']);
    }
}
