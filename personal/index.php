<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetPageProperty("title", "Личный кабинет - Cakeaway - маркетплейс тортов и кондитерских изделий");
$APPLICATION->SetTitle("Личный кабинет");
?><?php
global $USER;
if($APPLICATION->GetCurPage(false) === '/personal/orders/' && !$USER->IsAuthorized()){
    if($_COOKIE['order_pay_acces']){
        LocalRedirect("/personal/pay/");
    }
}
?>
<?php //if($APPLICATION->GetCurDir() != SITE_DIR.'personal/'){?>
<!---->
<!--    <div class="lk_wrapper">-->
<!--        <div class="lk__nav-wrap">-->
<!---->
<!--        --><?//$APPLICATION->IncludeComponent(
//        "bitrix:menu",
//        "personal",
//        Array(
//            "ALLOW_MULTI_SELECT" => "N",
//            "CHILD_MENU_TYPE" => "",
//            "DELAY" => "N",
//            "MAX_LEVEL" => "3",
//            "MENU_CACHE_GET_VARS" => array(""),
//            "MENU_CACHE_TIME" => "3600",
//            "MENU_CACHE_TYPE" => "N",
//            "MENU_CACHE_USE_GROUPS" => "Y",
//            "ROOT_MENU_TYPE" => "personal",
//            "USE_EXT" => "Y"
//        )
//    );?>
<!--    </div>-->
<!--    <div class="lk__content">-->
<!--    --><?//
//}
//
?>
<?$APPLICATION->IncludeComponent(
	"bitrix:sale.personal.section", 
	"bootstrap_v4", 
	array(
		"ACCOUNT_PAYMENT_ELIMINATED_PAY_SYSTEMS" => array(
			0 => "0",
		),
		"ACCOUNT_PAYMENT_PERSON_TYPE" => "1",
		"ACCOUNT_PAYMENT_SELL_CURRENCY" => "RUB",
		"ACCOUNT_PAYMENT_SELL_SHOW_FIXED_VALUES" => "N",
		"ACCOUNT_PAYMENT_SELL_TOTAL" => array(
			0 => "100",
			1 => "200",
			2 => "500",
			3 => "1000",
			4 => "5000",
			5 => "",
		),
		"ACCOUNT_PAYMENT_SELL_USER_INPUT" => "Y",
		"ACTIVE_DATE_FORMAT" => "d.m.Y",
		"ALLOW_INNER" => "Y",
		"CACHE_GROUPS" => "Y",
		"CACHE_TIME" => "3600",
		"CACHE_TYPE" => "A",
		"CHECK_RIGHTS_PRIVATE" => "N",
		"COMPATIBLE_LOCATION_MODE_PROFILE" => "N",
		"COMPONENT_TEMPLATE" => "bootstrap_v4",
		"CUSTOM_PAGES" => "[]",
		"CUSTOM_SELECT_PROPS" => array(
		),
		"MAIN_CHAIN_NAME" => "Личный кабинет",
		"NAV_TEMPLATE" => "",
		"ONLY_INNER_FULL" => "Y",
		"ORDERS_PER_PAGE" => "20",
		"ORDER_DEFAULT_SORT" => "STATUS",
		"ORDER_DISALLOW_CANCEL" => "N",
		"ORDER_HIDE_USER_INFO" => array(
			0 => "0",
		),
		"ORDER_HISTORIC_STATUSES" => array(
		),
		"ORDER_REFRESH_PRICES" => "N",
		"ORDER_RESTRICT_CHANGE_PAYSYSTEM" => array(
			0 => "F",
		),
		"PATH_TO_BASKET" => "/basket/",
		"PATH_TO_CATALOG" => "/catalog/",
		"PATH_TO_CONTACT" => "/about/contacts/",
		"PATH_TO_PAYMENT" => "/personal/order/payment/",
		"PROFILES_PER_PAGE" => "20",
		"PROP_1" => array(
		),
		"PROP_2" => array(
		),
		"SAVE_IN_SESSION" => "Y",
		"SEF_FOLDER" => "/personal/",
		"SEF_MODE" => "Y",
		"SEND_INFO_PRIVATE" => "N",
		"SET_TITLE" => "Y",
		"SHOW_ACCOUNT_COMPONENT" => "Y",
		"SHOW_ACCOUNT_PAGE" => "Y",
		"SHOW_ACCOUNT_PAY_COMPONENT" => "Y",
		"SHOW_BASKET_PAGE" => "N",
		"SHOW_CONTACT_PAGE" => "N",
		"SHOW_ORDER_PAGE" => "Y",
		"SHOW_PRIVATE_PAGE" => "Y",
		"SHOW_PROFILE_PAGE" => "N",
		"SHOW_SUBSCRIBE_PAGE" => "N",
		"USE_AJAX_LOCATIONS_PROFILE" => "N",
		"SEF_URL_TEMPLATES" => array(
			"index" => "index.php",
			"orders" => "orders/",
			"account" => "account/",
			"subscribe" => "subscribe/",
			"profile" => "profiles/",
			"profile_detail" => "profiles/#ID#",
			"private" => "private/",
			"order_detail" => "orders/#ID#",
			"order_cancel" => "cancel/#ID#",
		)
	),
	false
);?>
<?php if($APPLICATION->GetCurDir() != SITE_DIR.'personal/'){?><?}?><?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>