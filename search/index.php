<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("?????");
?><? $elIds = $APPLICATION->IncludeComponent(
	"bitrix:search.page",
	"search_page",
	Array(
		"AJAX_MODE" => "N",	// ???????? ????? AJAX
		"AJAX_OPTION_ADDITIONAL" => "",	// ?????????????? ?????????????
		"AJAX_OPTION_HISTORY" => "N",	// ???????? ???????? ????????? ????????
		"AJAX_OPTION_JUMP" => "N",	// ???????? ????????? ? ?????? ??????????
		"AJAX_OPTION_STYLE" => "Y",	// ???????? ????????? ??????
		"CACHE_TIME" => "3600",	// ????? ??????????? (???.)
		"CACHE_TYPE" => "A",	// ??? ???????????
		"CHECK_DATES" => "N",	// ?????? ?????? ? ???????? ?? ???? ??????????
		"DEFAULT_SORT" => "rank",	// ?????????? ?? ?????????
		"DISPLAY_BOTTOM_PAGER" => "Y",	// ???????? ??? ????????????
		"DISPLAY_TOP_PAGER" => "N",	// ???????? ??? ????????????
		"FILTER_NAME" => "",	// ?????????????? ??????
		"NO_WORD_LOGIC" => "Y",	// ????????? ????????? ???? ??? ?????????? ??????????
		"PAGER_SHOW_ALWAYS" => "Y",	// ???????? ??????
		"PAGER_TEMPLATE" => "",	// ???????? ???????
		"PAGER_TITLE" => "?????????? ??????",	// ???????? ??????????? ??????
		"PAGE_RESULT_COUNT" => "50",	// ?????????? ??????????? ?? ????????
		"RESTART" => "N",	// ?????? ??? ????? ?????????? (??? ?????????? ?????????? ??????)
		"SHOW_WHEN" => "N",	// ?????????? ?????? ?? ?????
		"SHOW_WHERE" => "N",	// ?????????? ?????????? ?????? "??? ??????"
		"USE_LANGUAGE_GUESS" => "Y",	// ???????? ??????????????? ????????? ??????????
		"USE_SUGGEST" => "N",	// ?????????? ????????? ? ?????????? ???????
		"USE_TITLE_RANK" => "N",	// ??? ???????????? ?????????? ????????? ?????????
		"arrFILTER" => array(	// ??????????? ??????? ??????
			0 => "iblock_offers",
			1 => "iblock_catalog",
		),
		"arrFILTER_iblock_catalog" => array(	// ?????? ? ?????????????? ?????? ???? "iblock_catalog"
			0 => "all",
		),
		"arrFILTER_iblock_offers" => array(	// ?????? ? ?????????????? ?????? ???? "iblock_offers"
			0 => "all",
		),
		"arrWHERE" => ""
	),
	false
);
?>
<?php if(!empty($elIds)){?>
    <?php $GLOBALS['arrFilterSearch'] = array("ID" => $elIds);?>
    <div class="title_box">
        <h1>?????????? ??????</h1>
    </div>
    <?$APPLICATION->IncludeComponent(
	"bitrix:catalog.section", 
	"catalog-list", 
	array(
		"ACTION_VARIABLE" => "action",
		"ADD_PICT_PROP" => "-",
		"ADD_PROPERTIES_TO_BASKET" => "Y",
		"ADD_SECTIONS_CHAIN" => "N",
		"ADD_TO_BASKET_ACTION" => "ADD",
		"AJAX_MODE" => "N",
		"AJAX_OPTION_ADDITIONAL" => "",
		"AJAX_OPTION_HISTORY" => "N",
		"AJAX_OPTION_JUMP" => "N",
		"AJAX_OPTION_STYLE" => "Y",
		"BACKGROUND_IMAGE" => "-",
		"BASKET_URL" => SITE_DIR."personal/basket/",
		"BROWSER_TITLE" => "-",
		"CACHE_FILTER" => "N",
		"CACHE_GROUPS" => "Y",
		"CACHE_TIME" => "36000000",
		"CACHE_TYPE" => "A",
		"COMPATIBLE_MODE" => "Y",
		"CONVERT_CURRENCY" => "N",
		"N_N_N_N_N_N_N_N_N_N_N_N_N_N_N_N_N_N_CUSTOM_FILTER" => "",
		"DETAIL_URL" => SITE_DIR."catalog/#SECTION_CODE_PATH#/#ELEMENT_CODE#/",
		"DISABLE_INIT_JS_IN_COMPONENT" => "N",
		"DISPLAY_BOTTOM_PAGER" => "Y",
		"DISPLAY_COMPARE" => "N",
		"DISPLAY_TOP_PAGER" => "N",
		"ELEMENT_SORT_FIELD" => "sort",
		"ELEMENT_SORT_FIELD2" => "id",
		"ELEMENT_SORT_ORDER" => "asc",
		"ELEMENT_SORT_ORDER2" => "desc",
		"ENLARGE_PRODUCT" => "STRICT",
		"FILTER_NAME" => "arrFilterSearch",
		"HIDE_NOT_AVAILABLE" => "N",
		"HIDE_NOT_AVAILABLE_OFFERS" => "N",
		"IBLOCK_ID" => "#CODE_3#",
		"IBLOCK_TYPE" => "catalog",
		"INCLUDE_SUBSECTIONS" => "Y",
		"LABEL_PROP" => array(
			0 => "PRODUCT_HIT",
			1 => "NEW",
		),
		"LABEL_PROP_MOBILE" => array(
			0 => "PRODUCT_HIT",
			1 => "NEW",
		),
		"LABEL_PROP_POSITION" => "top-left",
		"LAZY_LOAD" => "N",
		"LINE_ELEMENT_COUNT" => "3",
		"LOAD_ON_SCROLL" => "N",
		"MESSAGE_404" => "",
		"MESS_BTN_ADD_TO_BASKET" => "? ???????",
		"MESS_BTN_BUY" => "??????",
		"MESS_BTN_DETAIL" => "?????????",
		"MESS_BTN_SUBSCRIBE" => "???????????",
		"MESS_NOT_AVAILABLE" => "??? ? ???????",
		"META_DESCRIPTION" => "-",
		"META_KEYWORDS" => "-",
		"OFFERS_CART_PROPERTIES" => array(
		),
		"OFFERS_FIELD_CODE" => array(
			0 => "",
			1 => "",
		),
		"OFFERS_LIMIT" => "0",
		"OFFERS_PROPERTY_CODE" => array(
			0 => "",
			1 => "PRODUCT_IMAGE",
			2 => "PRODUCT_HIPS_SIZE",
			3 => "PRODUCT_CHEST_SIZE",
			4 => "PRODUCT_WAIST_SIZE",
			5 => "PRODUCT_SIZE",
			6 => "PRODUCT_SIZE_CUP",
			7 => "PRODUCT_RUS_SIZE",
			8 => "PRODUCT_COLOR",
			9 => "",
		),
		"OFFERS_SORT_FIELD" => "sort",
		"OFFERS_SORT_FIELD2" => "id",
		"OFFERS_SORT_ORDER" => "asc",
		"OFFERS_SORT_ORDER2" => "desc",
		"OFFER_ADD_PICT_PROP" => "-",
		"OFFER_TREE_PROPS" => array(
		),
		"PAGER_BASE_LINK_ENABLE" => "N",
		"PAGER_DESC_NUMBERING" => "N",
		"PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",
		"PAGER_SHOW_ALL" => "N",
		"PAGER_SHOW_ALWAYS" => "N",
		"PAGER_TEMPLATE" => ".default",
		"PAGER_TITLE" => "??????",
		"PAGE_ELEMENT_COUNT" => "18",
		"PARTIAL_PRODUCT_PROPERTIES" => "N",
		"PRICE_CODE" => array(
			0 => "ru",
		),
		"PRICE_VAT_INCLUDE" => "Y",
		"PRODUCT_BLOCKS_ORDER" => "price,props,sku,quantityLimit,quantity,buttons,compare",
		"PRODUCT_DISPLAY_MODE" => "Y",
		"PRODUCT_ID_VARIABLE" => "id",
		"PRODUCT_PROPERTIES" => array(
		),
		"PRODUCT_PROPS_VARIABLE" => "prop",
		"PRODUCT_QUANTITY_VARIABLE" => "quantity",
		"PRODUCT_ROW_VARIANTS" => "[{'VARIANT':'2','BIG_DATA':false},{'VARIANT':'2','BIG_DATA':false},{'VARIANT':'2','BIG_DATA':false},{'VARIANT':'2','BIG_DATA':false},{'VARIANT':'2','BIG_DATA':false},{'VARIANT':'2','BIG_DATA':false}]",
		"PRODUCT_SUBSCRIPTION" => "Y",
		"PROPERTY_CODE" => array(
			0 => "",
			1 => "",
		),
		"PROPERTY_CODE_MOBILE" => array(
		),
		"RCM_PROD_ID" => $_REQUEST["PRODUCT_ID"],
		"RCM_TYPE" => "personal",
		"SECTION_CODE" => "",
		"SECTION_ID" => "",
		"SECTION_ID_VARIABLE" => "SECTION_ID",
		"SECTION_URL" => SITE_DIR."catalog/#SECTION_CODE_PATH#/",
		"SECTION_USER_FIELDS" => array(
			0 => "",
			1 => "",
		),
		"SEF_MODE" => "N",
		"SET_BROWSER_TITLE" => "N",
		"SET_LAST_MODIFIED" => "N",
		"SET_META_DESCRIPTION" => "N",
		"SET_META_KEYWORDS" => "N",
		"SET_STATUS_404" => "N",
		"SET_TITLE" => "N",
		"SHOW_404" => "N",
		"SHOW_ALL_WO_SECTION" => "Y",
		"SHOW_CLOSE_POPUP" => "N",
		"SHOW_DISCOUNT_PERCENT" => "N",
		"SHOW_FROM_SECTION" => "N",
		"SHOW_MAX_QUANTITY" => "N",
		"SHOW_OLD_PRICE" => "Y",
		"SHOW_PRICE_COUNT" => "1",
		"SHOW_SLIDER" => "N",
		"SLIDER_INTERVAL" => "3000",
		"SLIDER_PROGRESS" => "N",
		"TEMPLATE_THEME" => "blue",
		"USE_ENHANCED_ECOMMERCE" => "N",
		"USE_MAIN_ELEMENT_SECTION" => "N",
		"USE_PRICE_COUNT" => "N",
		"USE_PRODUCT_QUANTITY" => "N",
		"COMPONENT_TEMPLATE" => "catalog-list",
		"SEF_RULE" => "",
		"SECTION_CODE_PATH" => "catalog/#SECTION_CODE_PATH#/#ELEMENT_CODE#/"
	),
	false
);?>


    <div class="main-receipts-list">
        <h2><a href="/receipts/">??????? ???????</a></h2>
        <?$APPLICATION->IncludeComponent(
            "bitrix:news.list",
            "receipt-list",
            array(
                "ACTIVE_DATE_FORMAT" => "d.m.Y",
                "ADD_SECTIONS_CHAIN" => "Y",
                "AJAX_MODE" => "N",
                "AJAX_OPTION_ADDITIONAL" => "",
                "AJAX_OPTION_HISTORY" => "N",
                "AJAX_OPTION_JUMP" => "N",
                "AJAX_OPTION_STYLE" => "Y",
                "CACHE_FILTER" => "N",
                "CACHE_GROUPS" => "Y",
                "CACHE_TIME" => "36000000",
                "CACHE_TYPE" => "A",
                "CHECK_DATES" => "Y",
                "DETAIL_URL" => "",
                "DISPLAY_BOTTOM_PAGER" => "Y",
                "DISPLAY_DATE" => "Y",
                "DISPLAY_NAME" => "Y",
                "DISPLAY_PICTURE" => "Y",
                "DISPLAY_PREVIEW_TEXT" => "Y",
                "DISPLAY_TOP_PAGER" => "N",
                "FIELD_CODE" => array(
                    0 => "",
                    1 => "",
                ),
                "FILTER_NAME" => "arrFilterSearch",
                "HIDE_LINK_WHEN_NO_DETAIL" => "N",
                "IBLOCK_ID" => "#CODE_8#",
                "IBLOCK_TYPE" => "info",
                "INCLUDE_IBLOCK_INTO_CHAIN" => "Y",
                "INCLUDE_SUBSECTIONS" => "Y",
                "MEDIA_PROPERTY" => "",
                "MESSAGE_404" => "",
                "NEWS_COUNT" => "3",
                "PAGER_BASE_LINK_ENABLE" => "N",
                "PAGER_DESC_NUMBERING" => "N",
                "PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",
                "PAGER_SHOW_ALL" => "N",
                "PAGER_SHOW_ALWAYS" => "N",
                "PAGER_TEMPLATE" => ".default",
                "PAGER_TITLE" => "???????",
                "PARENT_SECTION" => "",
                "PARENT_SECTION_CODE" => "",
                "PREVIEW_TRUNCATE_LEN" => "",
                "PROPERTY_CODE" => array(
                    0 => "TIME_RECEIPT",
                    1 => "COUNT_RECEIPT",
                    2 => "SHOW_PLACE",
                    3 => "",
                ),
                "SEARCH_PAGE" => "/search/",
                "SET_BROWSER_TITLE" => "Y",
                "SET_LAST_MODIFIED" => "N",
                "SET_META_DESCRIPTION" => "Y",
                "SET_META_KEYWORDS" => "Y",
                "SET_STATUS_404" => "N",
                "SET_TITLE" => "Y",
                "SHOW_404" => "N",
                "SLIDER_PROPERTY" => "",
                "SORT_BY1" => "ACTIVE_FROM",
                "SORT_BY2" => "SORT",
                "SORT_ORDER1" => "DESC",
                "SORT_ORDER2" => "ASC",
                "STRICT_SECTION_CHECK" => "N",
                "TEMPLATE_THEME" => "blue",
                "USE_RATING" => "N",
                "USE_SHARE" => "N",
                "COMPONENT_TEMPLATE" => "receipt-list"
            ),
            false
        );?>
    </div>
<?php }?>
<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>