<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();                        
if(\Bitrix\Main\Loader::includeSharewareModule("krayt.retail") == \Bitrix\Main\Loader::MODULE_DEMO_EXPIRED || 
   \Bitrix\Main\Loader::includeSharewareModule("krayt.retail") ==  \Bitrix\Main\Loader::MODULE_NOT_FOUND
    )
{ return false;}



use Bitrix\Main\Loader;
use Bitrix\Main\ModuleManager;
use Bitrix\Main\Web\Json;

if (!Loader::includeModule('iblock'))
    return;

$aRiBlock = [];

$dbIBlock = CIBlock::GetList(array('SORT' => 'ASC', 'ID' => 'ASC'), ['ACTIVE' => "Y"]);
while($arIBlock = $dbIBlock->GetNext())
{
    $aRiBlock[$arIBlock['ID']] = $arIBlock['NAME'];
}
$arTemplateParameters = array(
		"IBLOCK_ID"=> array(
		"NAME" => GetMessage("MENU_IBLOCK_ID"),
		"TYPE" => "LIST",
		"VALUES" => $aRiBlock,
		"PARENT" => "BASE",
	)
);
if($arCurrentValues['IBLOCK_ID'])
{
	$arPropFiles = [
		'' => ' - '
	];
    $arPropLinkElemet = [
        '' => ' - '
    ];
    $rsData = CUserTypeEntity::GetList( array($by=>$order),
        array(
            "LANG" => "ru",
            "ENTITY_ID" => "IBLOCK_{$arCurrentValues['IBLOCK_ID']}_SECTION"
        ) );
    while($arRes = $rsData->Fetch())
    {

    	if($arRes['USER_TYPE_ID'] == 'file')
		{
            $arPropFiles[$arRes['FIELD_NAME']] = $arRes['EDIT_FORM_LABEL']?$arRes['EDIT_FORM_LABEL']:$arRes['FIELD_NAME'];
		}
		if($arRes['USER_TYPE_ID'] == 'iblock_element')
		{
            $arPropLinkElemet[$arRes['FIELD_NAME']] = $arRes['EDIT_FORM_LABEL']?$arRes['EDIT_FORM_LABEL']:$arRes['FIELD_NAME'];
		}

    }

    $arTemplateParameters['ICON_MENU'] = array(
        "NAME" => GetMessage("MENU_ICON_MENU_PROP"),
        "TYPE" => "LIST",
        "VALUES" => $arPropFiles,
        "PARENT" => "BASE"
	);

    $arTemplateParameters['ACTION_MENU'] = array(
        "NAME" => GetMessage("ACTION_MENU_PROP"),
        "TYPE" => "LIST",
        "VALUES" => $arPropLinkElemet,
        "PARENT" => "BASE"
    );

}

?>
