<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();                        
if(\Bitrix\Main\Loader::includeSharewareModule("krayt.retail") == \Bitrix\Main\Loader::MODULE_DEMO_EXPIRED || 
   \Bitrix\Main\Loader::includeSharewareModule("krayt.retail") ==  \Bitrix\Main\Loader::MODULE_NOT_FOUND
    )
{ return false;}
// navigation section

if(CModule::IncludeModule("iblock"))
{
    $arFilter = array('IBLOCK_ID' => 3, 'DEPTH_LEVEL' => 2, 'PROPERTY' => array('PRODUCT_BRAND' => $arResult['PROPERTIES']['FILTER_BRANDS']['VALUE'])); // выберет потомков без учета активности
    $rsSect = CIBlockSection::GetList(array(),$arFilter);
    while ($arSect = $rsSect->GetNext())
    {
        $arResult['SCT'][] = $arSect;
    }
}
