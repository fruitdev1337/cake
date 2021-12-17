<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Избранное");
?>

<?
$mas_forewer_cookie = explode("|", $_COOKIE['FOREVER']);
$mas_ok = array();
foreach ($mas_forewer_cookie as $value) {
    if (!empty($value)) {
        $mas_ok[] = $value;
    }
}
global $arrFilterForever;
if($mas_ok)
{
    $arrFilterForever = array(
        'ID' =>$mas_ok
    );
}else
{
    $arrFilterForever = array(
        'ID' =>false
    );
}?>

    <div class="favorite-element-container">
        <?if (!empty($mas_ok)):?>

        <div class="title_box">
            <div class="row align-items-center">
                <h1 class="col"><?=$APPLICATION->ShowTitle(false);?></h1>
                <div class="col-auto sorting_box">
                    <?php
                    //default
                    global $APPLICATION;
                    $section_dir = $APPLICATION->GetCurDir();

                    //set filter
                    if (!empty($_REQUEST['sort']))  {
                        $section_sort = intval($_GET['sort']);
                    }
                    $dbPriceType = CCatalogGroup::GetList(
                        array("SORT" => "ASC"),
                        array("NAME" => "ru")
                    )->Fetch();
                    $ID_PRICE = $dbPriceType['ID'];

                    if (!$section_sort) {
                        $section_sort = 1;
                    }

                    switch ($section_sort) {
                        case '1':
                            $sortField = "shows";
                            $sortOrder = "asc";
                            break;
                        case '2':
                            $sortField = "shows";
                            $sortOrder = "desc";
                            break;
                        case '3':
                            $sortField = "CATALOG_PRICE_".$ID_PRICE;
                            $sortOrder = "asc";
                            break;
                        case '4':
                            $sortField = "CATALOG_PRICE_".$ID_PRICE;
                            $sortOrder = "desc";
                            break;
                        case '5':
                            $sortField = "name";
                            $sortOrder = "asc";
                            break;
                        case '6':
                            $sortField = "name";
                            $sortOrder = "desc";
                            break;
                    }?>
                    <div class="sorting">
                        <div class="sorting-row row">
                            <div class="sorting-title col-auto pr-0">
                                <span>Сортировать по:</span>
                            </div>
                            <div class="sorting-list col-auto"><div class="sorting_item <?=(($section_sort == 1) || ($section_sort == 2))?'active':'';?>">
                                    <a href="<?php
                                    $tempSort = ($section_sort == 1)?2:1;
                                    echo $APPLICATION->GetCurPageParam("sort=".$tempSort, array("sort"));
                                    ?>">
                                        <span>Популярности</span>
                                    </a>
                                </div>

                                <div class="sorting_item <?=(($section_sort == 3) || ($section_sort == 4))?'active':'';?>">
                                    <a href="<?php
                                    $tempSort = ($section_sort == 3)?4:3;
                                    echo $APPLICATION->GetCurPageParam("sort=".$tempSort, array("sort"));
                                    ?>">
                                        <span>Цене</span> <?
                                        if($section_sort == 3){
                                            ?><span class="fa fa-long-arrow-up"<?
                                        }elseif($section_sort == 4){
                                            ?><span class="fa fa-long-arrow-down"<?}?>
                                    </a>
                                </div>

                                <div class="sorting_item <?=(($section_sort == 5) || ($section_sort == 6))?'active':'';?>">
                                    <a href="<?php
                                    $tempSort = ($section_sort == 5)?6:5;
                                    echo $APPLICATION->GetCurPageParam("sort=".$tempSort, array("sort"));
                                    ?>">
                                        <span>Алфавиту</span> <?
                                        if($section_sort == 5){
                                            ?><span class="fa fa-long-arrow-up"<?
                                        }elseif($section_sort == 6){
                                            ?><span class="fa fa-long-arrow-down"<?}?>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

            <?$APPLICATION->IncludeComponent(
	"bitrix:catalog.section", 
	"favour-list", 
	array(
		"ACTION_VARIABLE" => "action",
		"ADD_PICT_PROP" => "MORE_PHOTO",
		"ADD_PROPERTIES_TO_BASKET" => "Y",
		"ADD_SECTIONS_CHAIN" => "N",
		"ADD_TO_BASKET_ACTION" => "ADD",
		"AJAX_MODE" => "N",
		"AJAX_OPTION_ADDITIONAL" => "",
		"AJAX_OPTION_HISTORY" => "N",
		"AJAX_OPTION_JUMP" => "N",
		"AJAX_OPTION_STYLE" => "Y",
		"BACKGROUND_IMAGE" => "-",
		"BASKET_URL" => SITE_DIR."basket/",
		"BROWSER_TITLE" => "-",
		"CACHE_FILTER" => "N",
		"CACHE_GROUPS" => "Y",
		"CACHE_TIME" => "36000000",
		"CACHE_TYPE" => "N",
		"COMPATIBLE_MODE" => "Y",
		"CONVERT_CURRENCY" => "N",
		"N_CUSTOM_FILTER" => "",
		"DETAIL_URL" => "",
		"DISABLE_INIT_JS_IN_COMPONENT" => "N",
		"DISPLAY_BOTTOM_PAGER" => "Y",
		"DISPLAY_COMPARE" => "N",
		"DISPLAY_TOP_PAGER" => "N",
		"ELEMENT_SORT_FIELD" => $sortField,
		"ELEMENT_SORT_ORDER" => $sortOrder,
		"ELEMENT_SORT_FIELD2" => "id",
		"ELEMENT_SORT_ORDER2" => "desc",
		"ENLARGE_PRODUCT" => "STRICT",
		"FILTER_NAME" => "arrFilterForever",
		"HIDE_NOT_AVAILABLE" => "L",
		"HIDE_NOT_AVAILABLE_OFFERS" => "N",
		"IBLOCK_ID" => "4",
		"IBLOCK_TYPE" => "catalog",
		"INCLUDE_SUBSECTIONS" => "Y",
		"LABEL_PROP" => array(
			0 => "SPECIAL_OFFER",
			1 => "PRODUCT_HIT",
			2 => "NEW",
			3 => "WITHOUT_GMO",
		),
		"LABEL_PROP_MOBILE" => array(
			0 => "SPECIAL_OFFER",
			1 => "PRODUCT_HIT",
			2 => "NEW",
			3 => "WITHOUT_GMO",
		),
		"LABEL_PROP_POSITION" => "top-right",
		"LAZY_LOAD" => "N",
		"LINE_ELEMENT_COUNT" => "4",
		"LOAD_ON_SCROLL" => "N",
		"MESSAGE_404" => "",
		"MESS_BTN_ADD_TO_BASKET" => "В корзину",
		"MESS_BTN_BUY" => "Купить",
		"MESS_BTN_DETAIL" => "Выбрать",
		"MESS_BTN_SUBSCRIBE" => "Подписаться",
		"MESS_NOT_AVAILABLE" => "Нет в наличии",
		"META_DESCRIPTION" => "-",
		"META_KEYWORDS" => "-",
		"OFFERS_LIMIT" => "0",
		"PAGER_BASE_LINK_ENABLE" => "N",
		"PAGER_DESC_NUMBERING" => "N",
		"PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",
		"PAGER_SHOW_ALL" => "N",
		"PAGER_SHOW_ALWAYS" => "N",
		"PAGER_TEMPLATE" => "visual_1",
		"PAGER_TITLE" => "Товары",
		"PAGE_ELEMENT_COUNT" => "20",
		"PARTIAL_PRODUCT_PROPERTIES" => "Y",
		"PRICE_CODE" => array(
			0 => "ru",
		),
		"PRICE_VAT_INCLUDE" => "Y",
		"PRODUCT_BLOCKS_ORDER" => "price,props,sku,quantityLimit,quantity,buttons",
		"PRODUCT_ID_VARIABLE" => "id",
		"PRODUCT_PROPERTIES" => array(
		),
		"PRODUCT_PROPS_VARIABLE" => "prop",
		"PRODUCT_QUANTITY_VARIABLE" => "quantity",
		"PRODUCT_ROW_VARIANTS" => "[{'VARIANT':'3','BIG_DATA':false},{'VARIANT':'3','BIG_DATA':false},{'VARIANT':'3','BIG_DATA':false},{'VARIANT':'3','BIG_DATA':false},{'VARIANT':'3','BIG_DATA':false}]",
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
		"SECTION_URL" => "",
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
		"SHOW_CLOSE_POPUP" => "Y",
		"SHOW_DISCOUNT_PERCENT" => "Y",
		"SHOW_FROM_SECTION" => "N",
		"SHOW_MAX_QUANTITY" => "N",
		"SHOW_OLD_PRICE" => "Y",
		"SHOW_PRICE_COUNT" => "1",
		"SHOW_SLIDER" => "Y",
		"SLIDER_INTERVAL" => "3000",
		"SLIDER_PROGRESS" => "N",
		"TEMPLATE_THEME" => "",
		"USE_ENHANCED_ECOMMERCE" => "N",
		"USE_MAIN_ELEMENT_SECTION" => "N",
		"USE_PRICE_COUNT" => "N",
		"USE_PRODUCT_QUANTITY" => "Y",
		"COMPONENT_TEMPLATE" => "favour-list",
		"MESS_BTN_COMPARE" => "Сравнить",
		"OFFERS_SORT_FIELD" => "sort",
		"OFFERS_SORT_ORDER" => "asc",
		"OFFERS_SORT_FIELD2" => "id",
		"OFFERS_SORT_ORDER2" => "desc",
		"OFFERS_FIELD_CODE" => array(
			0 => "",
			1 => "",
		),
		"OFFERS_PROPERTY_CODE" => array(
			0 => "WEIGHT",
			1 => "VOLUME",
			2 => "",
		),
		"PRODUCT_DISPLAY_MODE" => "Y",
		"OFFERS_CART_PROPERTIES" => array(
		),
		"DISCOUNT_PERCENT_POSITION" => "bottom-right",
		"OFFER_ADD_PICT_PROP" => "MORE_PHOTO",
		"OFFER_TREE_PROPS" => array(
			0 => "WEIGHT",
			1 => "VOLUME",
		)
	),
	false
);?>

            <div class="favor-delete-btn btn-green-border">
                <span>Удалить все товары</span>
            </div>
        <?else:?>

        <div class="title_box">
            <div class="row align-items-center">
                <h1 class="col"><?=$APPLICATION->ShowTitle(false);?></h1>
            </div>
        </div>
        <div class="bx-sbb-empty-cart-container">

            <div class="bx-sbb-empty-cart-text">
                <p class="big-text">У Вас нет избранных товаров</p>
                <p class="small-text">Для добавления товаров в избранные используйте кнопку <span class="fa fa-heart"></span></p>
            </div>
            <div class="bx-sbb-empty-cart-btn">
                <a class="btn-primary catalog-link" href="<?=SITE_DIR;?>catalog/">Перейти в каталог</a>
            </div>

        </div>


        <?endif;?>

    </div>

<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>