<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();                        
if(\Bitrix\Main\Loader::includeSharewareModule("krayt.retail") == \Bitrix\Main\Loader::MODULE_DEMO_EXPIRED || 
   \Bitrix\Main\Loader::includeSharewareModule("krayt.retail") ==  \Bitrix\Main\Loader::MODULE_NOT_FOUND
    )
{ return false;}?><?
IncludeTemplateLangFile(__FILE__);
$TEMPLATE["standard.php"] = Array("name"=>GetMessage("standart"), "sort"=>2);
$TEMPLATE["static_page.php"] = Array("name"=>GetMessage("static_page"), "sort"=>1);
?>