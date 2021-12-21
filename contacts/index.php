<?
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/header.php");
$APPLICATION->SetTitle("????????");
?><div class="contacts_wrapper">
	<div class="title_box">
		<h1 class="title">????????</h1>
	</div>
	<div class="contacts_content">
		<div class="contacts__adress">
            <?php $APPLICATION->IncludeFile(SITE_DIR.'contacts/include/addresses.php') ?>
		</div>
	</div>
</div>
 <!-- end wrapper -->
<div class="map_content">
	<div class="map_wrapper" style="text-align: center;">
		 <?$APPLICATION->IncludeComponent(
	"bitrix:map.yandex.view",
	".default",
	array(
		"API_KEY" => "",
		"COMPONENT_TEMPLATE" => ".default",
		"CONTROLS" => array(
			0 => "ZOOM",
			1 => "SCALELINE",
		),
		"INIT_MAP_TYPE" => "MAP",
		"MAP_DATA" => "a:4:{s:10:\"yandex_lat\";d:55.75865587066672;s:10:\"yandex_lon\";d:37.618755716545984;s:12:\"yandex_scale\";i:12;s:10:\"PLACEMARKS\";a:3:{i:0;a:3:{s:3:\"LON\";d:37.589390210976;s:3:\"LAT\";d:55.767707116829;s:4:\"TEXT\";s:90:\"?. ??????, ??????? ????? ?.1, ?????? 4, ???? ?? ?????\";}i:1;a:3:{s:3:\"LON\";d:37.645822559525;s:3:\"LAT\";d:55.74600849525;s:4:\"TEXT\";s:52:\"?. ??????, ????????? ????? ?.3\";}i:2;a:3:{s:3:\"LON\";d:30.37466246627;s:3:\"LAT\";d:59.927331359761;s:4:\"TEXT\";s:73:\"?. ?????-?????????, ??????? ???????? ?.125\";}}}",
		"MAP_HEIGHT" => "500",
		"MAP_ID" => "yam_1",
		"MAP_WIDTH" => "600",
		"OPTIONS" => array(
			0 => "ENABLE_DBLCLICK_ZOOM",
			1 => "ENABLE_DRAGGING",
		)
	),
	false
);?>
        </div>
    </div>


<? require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/footer.php"); ?>