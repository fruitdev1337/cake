<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();                        
if(\Bitrix\Main\Loader::includeSharewareModule("krayt.retail") == \Bitrix\Main\Loader::MODULE_DEMO_EXPIRED || 
   \Bitrix\Main\Loader::includeSharewareModule("krayt.retail") ==  \Bitrix\Main\Loader::MODULE_NOT_FOUND
    )
{ return false;}

if($arParams['SECTIONS'])
{
    $aMenuLinksNew = array();
    $menuIndex = 0;
    $previousDepthLevel = 1;
    foreach($arParams['SECTIONS'] as $arSection)
    {
        if ($menuIndex > 0)
            $aMenuLinksNew[$menuIndex - 1]["IS_PARENT"] = $arSection["DEPTH_LEVEL"] > $previousDepthLevel;
        $previousDepthLevel = $arSection["DEPTH_LEVEL"];


        $aMenuLinksNew[$menuIndex++] = array(
            "TEXT" => htmlspecialcharsbx($arSection["~NAME"]),
            "LINK" => $arSection["SECTION_PAGE_URL"],
            "IS_PARENT" => false,
            "DEPTH_LEVEL" => $arSection["DEPTH_LEVEL"],
            'ELEMENT_CNT' => $arSection['ELEMENT_CNT'],
            'SELECTED' => ($arParams['CURRENT_SECTION_ID'] == $arSection['ID'])?true:false
        );
    }
    $arResult = array_merge($aMenuLinksNew, $arResult);
}
