<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 25.10.2019
 * Time: 10:50
 */

use Bitrix\Main\Loader;

$request = \Bitrix\Main\Application::getInstance()->getContext()->getRequest();

if ($request->get('clear') !== null && Loader::includeModule("sale")) {
    CSaleBasket::DeleteAll(CSaleBasket::GetBasketUserID());

    $redirect = $APPLICATION->GetCurPageParam('', ['clear']);

    LocalRedirect($redirect);
}