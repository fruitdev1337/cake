<?php

$arParams['PATH_TO_DELIVERY'] = trim($arParams['PATH_TO_DELIVERY']);
if ($arParams['PATH_TO_DELIVERY'] == '')
    $arParams['PATH_TO_DELIVERY'] = SITE_DIR.'delivery_and_pay/';


$arParams['MESS_MIN_PRICE_TITLE'] = (int)$arParams['MESS_MIN_PRICE_TITLE'];
if ($arParams['MESS_MIN_PRICE_TITLE'] == '')
    $arParams['MESS_MIN_PRICE_TITLE'] = '5000';
