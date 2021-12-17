<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

use Bitrix\Main\ModuleManager;
use Bitrix\Iblock;
if(!CModule::IncludeModule("iblock"))
	return;

$mediaProperty = array(
	"" => GetMessage("MAIN_NO"),
);
$sliderProperty = array(
	"" => GetMessage("MAIN_NO"),
);
$propertyList = CIBlockProperty::GetList(
	array("sort"=>"asc", "name"=>"asc"),
	array("ACTIVE"=>"Y", "IBLOCK_ID"=>$arCurrentValues["IBLOCK_ID"])
);
while ($property = $propertyList->Fetch())
{
	$arProperty[$property["CODE"]] = "[".$property["CODE"]."] ".$property["NAME"];
	$id = $property["CODE"]? $property["CODE"]: $property["ID"];
	if ($property["PROPERTY_TYPE"] == "S")
	{
		$mediaProperty[$id] = "[".$id."] ".$property["NAME"];
	}
	if ($property["PROPERTY_TYPE"] == "F")
	{
		$sliderProperty[$id] = "[".$id."] ".$property["NAME"];
	}
}
//catalog
CModule::IncludeModule("catalog");
$aRiBlock = [];
$dbIBlock = CIBlock::GetList(array('SORT' => 'ASC', 'ID' => 'ASC'), ['ACTIVE' => "Y"]);
while($arIBlock = $dbIBlock->GetNext())
{
    $aRiBlock[$arIBlock['ID']] = $arIBlock['NAME'];
}

$arTemplateParameters = array(
	"DISPLAY_DATE" => array(
		"NAME" => GetMessage("T_IBLOCK_DESC_NEWS_DATE"),
		"TYPE" => "CHECKBOX",
		"DEFAULT" => "Y",
	),
	"DISPLAY_PICTURE" => array(
		"NAME" => GetMessage("T_IBLOCK_DESC_NEWS_PICTURE"),
		"TYPE" => "CHECKBOX",
		"DEFAULT" => "Y",
	),
	"DISPLAY_PREVIEW_TEXT" => array(
		"NAME" => GetMessage("T_IBLOCK_DESC_NEWS_TEXT"),
		"TYPE" => "CHECKBOX",
		"DEFAULT" => "Y",
	),
	"USE_SHARE" => array(
		"NAME" => GetMessage("T_IBLOCK_DESC_NEWS_USE_SHARE"),
		"TYPE" => "CHECKBOX",
		"MULTIPLE" => "N",
		"VALUE" => "Y",
		"DEFAULT" =>"N",
		"REFRESH"=> "Y",
	),
	"MEDIA_PROPERTY" => array(
		"NAME" => GetMessage("TP_BN_MEDIA_PROPERTY"),
		"TYPE" => "LIST",
		"VALUES" => $mediaProperty,
	),
	"SLIDER_PROPERTY" => array(
		"NAME" => GetMessage("TP_BN_SLIDER_PROPERTY"),
		"TYPE" => "LIST",
		"VALUES" => $sliderProperty,
	),
    "CATALOG_IBLOCK_ID" => array(
        "NAME" => GetMessage("TP_CATALOG_IBLOCK_ID"),
        "TYPE" => "LIST",
        "VALUES" => $aRiBlock,
        "REFRESH"=> "Y",
        "DEFAULT" =>"",
        "PARENT" => "DETAIL_SETTINGS"
    ),
    "PRODUCT_PROPERTY" => array(
        "NAME" => GetMessage("K_PRODUCT_PROPERTY"),
        "TYPE" => "LIST",
        "VALUES" => $arProperty,
        "PARENT" => "DETAIL_SETTINGS"
    ),
);

$defaultValue = array('-' => GetMessage('CP_BCS_EMPTY'));

$arPropertySALE = array();
$arProperty_N = array();
$arProperty_X = array();
$listProperties = array();

if($arCurrentValues["CATALOG_IBLOCK_ID"])
{
    $propertyIterator = Iblock\PropertyTable::getList(array(
        'select' => array('ID', 'IBLOCK_ID', 'NAME', 'CODE', 'PROPERTY_TYPE', 'MULTIPLE', 'LINK_IBLOCK_ID', 'USER_TYPE', 'SORT'),
        'filter' => array('=IBLOCK_ID' => $arCurrentValues['CATALOG_IBLOCK_ID'], '=ACTIVE' => 'Y'),
        'order' => array('SORT' => 'ASC', 'NAME' => 'ASC')
    ));
    while ($property = $propertyIterator->fetch())
    {
        $propertyCode = (string)$property['CODE'];

        if ($propertyCode === '')
        {
            $propertyCode = $property['ID'];
        }

        $propertyName = '['.$propertyCode.'] '.$property['NAME'];

        if ($property['PROPERTY_TYPE'] != Iblock\PropertyTable::TYPE_FILE)
        {
            $arPropertySALE[$propertyCode] = $propertyName;

            if ($property['MULTIPLE'] === 'Y')
            {
                $arProperty_X[$propertyCode] = $propertyName;
            }
            elseif ($property['PROPERTY_TYPE'] == Iblock\PropertyTable::TYPE_LIST)
            {
                $arProperty_X[$propertyCode] = $propertyName;
            }
            elseif ($property['PROPERTY_TYPE'] == Iblock\PropertyTable::TYPE_ELEMENT && (int)$property['LINK_IBLOCK_ID'] > 0)
            {
                $arProperty_X[$propertyCode] = $propertyName;
            }
        }

        if ($property['PROPERTY_TYPE'] == Iblock\PropertyTable::TYPE_NUMBER)
        {
            $arProperty_N[$propertyCode] = $propertyName;
        }
    }
    unset($propertyCode, $propertyName, $property, $propertyIterator);


    $arTemplateParameters["CATALOG_PROPPERTY"] = array(
        "NAME" => GetMessage("TP_CATALOG_PROPPERTY"),
        "TYPE" => "LIST",
        "VALUES" => $arPropertySALE,
        "PARENT" => "DETAIL_SETTINGS",
        "MULTIPLE" => "Y",
        "SIZE" => 10,
    );
}
$offers = false;
$filterDataValues = array();
$arProperty_Offers = array();
$arProperty_OffersWithoutFile = array();

if ($arCurrentValues["CATALOG_IBLOCK_ID"])
{
    $filterDataValues['iblockId'] = (int)$arCurrentValues['CATALOG_IBLOCK_ID'];
    $offers = CCatalogSku::GetInfoByProductIBlock($arCurrentValues['CATALOG_IBLOCK_ID']);
    if (!empty($offers))
    {
        $filterDataValues['offersIblockId'] = $offers['IBLOCK_ID'];
        $propertyIterator = Iblock\PropertyTable::getList(array(
            'select' => array('ID', 'IBLOCK_ID', 'NAME', 'CODE', 'PROPERTY_TYPE', 'MULTIPLE', 'LINK_IBLOCK_ID', 'USER_TYPE', 'SORT'),
            'filter' => array('=IBLOCK_ID' => $offers['IBLOCK_ID'], '=ACTIVE' => 'Y', '!=ID' => $offers['SKU_PROPERTY_ID']),
            'order' => array('SORT' => 'ASC', 'NAME' => 'ASC')
        ));
        while ($property = $propertyIterator->fetch())
        {
            $propertyCode = (string)$property['CODE'];

            if ($propertyCode === '')
            {
                $propertyCode = $property['ID'];
            }

            $propertyName = '['.$propertyCode.'] '.$property['NAME'];
            $arProperty_Offers[$propertyCode] = $propertyName;

            if ($property['PROPERTY_TYPE'] != Iblock\PropertyTable::TYPE_FILE)
            {
                $arProperty_OffersWithoutFile[$propertyCode] = $propertyName;
            }
        }
        unset($propertyCode, $propertyName, $property, $propertyIterator);
    }

}
$arTemplateParameters['OFFERS_PROPERTY_CODE'] = array(
    'PARENT' => 'DETAIL_SETTINGS',
    'NAME' => GetMessage('CP_BCS_OFFERS_PROPERTY_CODE'),
    'TYPE' => 'LIST',
    'MULTIPLE' => 'Y',
    'VALUES' => $arProperty_Offers,
    'ADDITIONAL_VALUES' => 'Y',
);

$arSort = CIBlockParameters::GetElementSortFields(
    array('SHOWS', 'SORT', 'TIMESTAMP_X', 'NAME', 'ID', 'ACTIVE_FROM', 'ACTIVE_TO'),
    array('KEY_LOWERCASE' => 'Y')
);

$arPrice = array();
$arOfferSort = array_merge($arSort, CCatalogIBlockParameters::GetCatalogSortFields());
if (isset($arSort['CATALOG_AVAILABLE']))
    unset($arSort['CATALOG_AVAILABLE']);
$arPrice = CCatalogIBlockParameters::getPriceTypesList();


$arTemplateParameters['PRICE_CODE'] = array(
    'PARENT' => 'DETAIL_SETTINGS',
    'NAME' => GetMessage('IBLOCK_PRICE_CODE'),
    'TYPE' => 'LIST',
    'MULTIPLE' => 'Y',
    'VALUES' => $arPrice,
);