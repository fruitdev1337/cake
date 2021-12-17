<?
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/header.php");
$APPLICATION->SetPageProperty("title", "Контакты - Cakeaway - маркетплейс тортов и кондитерских изделий");
$APPLICATION->SetTitle("Контакты");
?>


    <div class="stores mb-5">
        <h1 class="title_box"><?=$APPLICATION->ShowTitle(false);?></h1>
        <?$APPLICATION->IncludeComponent(
	"bitrix:catalog.store", 
	"stores", 
	array(
		"SEF_MODE" => "Y",
		"PHONE" => "Y",
		"SCHEDULE" => "Y",
		"SET_TITLE" => "Y",
		"TITLE" => "Наши магазины",
		"MAP_TYPE" => "0",
		"CACHE_TYPE" => "A",
		"CACHE_TIME" => "3600",
		"CACHE_NOTES" => "",
		"SEF_FOLDER" => "#SITE_DIR#stores/",
		"COMPONENT_TEMPLATE" => "stores",
		"SEF_URL_TEMPLATES" => array(
			"liststores" => "index.php",
			"element" => "#store_id#",
		)
	),
	false
);?>
    </div>


<? require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/footer.php"); ?>