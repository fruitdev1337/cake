<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();                        
if(\Bitrix\Main\Loader::includeSharewareModule("krayt.retail") == \Bitrix\Main\Loader::MODULE_DEMO_EXPIRED || 
   \Bitrix\Main\Loader::includeSharewareModule("krayt.retail") ==  \Bitrix\Main\Loader::MODULE_NOT_FOUND
    )
{ return false;}

function parsePhone ($phone){
    $phone = str_replace("-","", $phone);
    $phone = str_replace(" ","", $phone);
    $phone = str_replace("(","", $phone);
    $phone = str_replace(")","", $phone);
    return $phone;
}

$dbResult = CCatalogStore::GetList(
    array('ID' => "ASC"),
    array('ACTIVE' => 'Y'),
    false,
    false,
    array("ID", "TITLE", "ADDRESS", "PHONE", "GPS_S", "GPS_N", "DESCRIPTION")
);
while ($ar = $dbResult->fetch()) {

    $arADDR[$ar['ID']]["ADDRESS"] = $ar["ADDRESS"];
    $arADDR[$ar['ID']]["TITLE"] = $ar["TITLE"];
    $arADDR[$ar['ID']]["PHONE"] = $ar["PHONE"];
    $arADDR[$ar['ID']]["GPS_S"] = $ar["GPS_S"];
    $arADDR[$ar['ID']]["GPS_N"] = $ar["GPS_N"];
    $arADDR[$ar['ID']]["DESCRIPTION"] = $ar["DESCRIPTION"];
}
foreach ($arResult["STORES"] as &$STORE) {
    $STORE['TITLE'] = $arADDR[$STORE['ID']]["TITLE"];
    $STORE['ADDRESS'] = $arADDR[$STORE['ID']]["ADDRESS"];
    $STORE['PHONE_URL'] = parsePhone($arADDR[$STORE['ID']]["PHONE"]);
    $STORE["GPS_S"] = $arADDR[$STORE['ID']]["GPS_S"];
    $STORE["GPS_N"] = $arADDR[$STORE['ID']]["GPS_N"];
    $STORE["DESCRIPTION"] = $arADDR[$STORE['ID']]["DESCRIPTION"];
}

//PR($arResult);