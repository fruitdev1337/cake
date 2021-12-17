<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();                        
if(\Bitrix\Main\Loader::includeSharewareModule("krayt.retail") == \Bitrix\Main\Loader::MODULE_DEMO_EXPIRED || 
   \Bitrix\Main\Loader::includeSharewareModule("krayt.retail") ==  \Bitrix\Main\Loader::MODULE_NOT_FOUND
    )
{ return false;}
/** @var array $templateData */
/** @var @global CMain $APPLICATION */
use Bitrix\Main\Loader;
global $APPLICATION;

$loadCurrency = Loader::includeModule('currency');
CJSCore::Init(array('popup', 'currency'));
if (isset($templateData['TEMPLATE_THEME']))
	$APPLICATION->SetAdditionalCSS($templateData['TEMPLATE_THEME']);
?>
<script type="text/javascript">
	BX.Currency.setCurrencies(<? echo $templateData['CURRENCIES']; ?>);
</script>