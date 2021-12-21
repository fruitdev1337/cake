<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();                        
if(\Bitrix\Main\Loader::includeSharewareModule("krayt.retail") == \Bitrix\Main\Loader::MODULE_DEMO_EXPIRED || 
   \Bitrix\Main\Loader::includeSharewareModule("krayt.retail") ==  \Bitrix\Main\Loader::MODULE_NOT_FOUND
    )
{ return false;}

$arTemplateParameters = array(
	'POSITION_FIXED' => array(
		'PARENT' => 'VISUAL',
		'NAME' => GetMessage('CP_BCCL_TPL_PARAM_TITLE_POSITION_FIXED'),
		'TYPE' => 'CHECKBOX',
		'DEFAULT' => 'Y',
		'REFRESH' => 'Y'
	)
);

if (!isset($arCurrentValues['POSITION_FIXED']) || $arCurrentValues['POSITION_FIXED'] == 'Y')
{
	$positionList = array(
		'top left' => GetMessage('CP_BCCL_TPL_PARAM_POSITION_TOP_LEFT'),
		'top right' => GetMessage('CP_BCCL_TPL_PARAM_POSITION_TOP_RIGHT'),
		'bottom left' => GetMessage('CP_BCCL_TPL_PARAM_POSITION_BOTTOM_LEFT'),
		'bottom right' => GetMessage('CP_BCCL_TPL_PARAM_POSITION_BOTTOM_RIGHT')
	);
	$arTemplateParameters['POSITION'] = array(
		'PARENT' => 'VISUAL',
		'NAME' => GetMessage('CP_BCCL_TPL_PARAM_TITLE_POSITION'),
		'TYPE' => 'LIST',
		'VALUES' => $positionList,
		'DEFAULT' => 'top left'
	);
	unset($positionList);
}
?>