<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<?
$arResult["FORM_HEADER"] = str_replace('method', 'class="form" method', $arResult["FORM_HEADER"]);

foreach($arResult['QUESTIONS'] as $FIELD_SID=>&$arQuestion){
	if($FIELD_SID == 'email'){
		$arQuestion['HTML_CODE'] = str_replace('type="text"', 'type="email"', $arQuestion["HTML_CODE"]);
	}
}
?>