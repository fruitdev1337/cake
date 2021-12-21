<?php
require_once($_SERVER['DOCUMENT_ROOT']. "/bitrix/modules/main/include/prolog_before.php");

if(!empty($_REQUEST['id']) && CModule::IncludeModule('sale'))
{
    $id = htmlspecialchars($_REQUEST['id']);

    if(!empty($_REQUEST['quantity']))
        $quantity = $_REQUEST['quantity'];
    else
        $quantity = 1;

    $arItems = CSaleBasket::GetByID($id);
    if(!empty($arItems))
    {
        $arFields = array("QUANTITY" => $quantity);
        $result = CSaleBasket::Update($id, $arFields);
    }
    echo $result;
}