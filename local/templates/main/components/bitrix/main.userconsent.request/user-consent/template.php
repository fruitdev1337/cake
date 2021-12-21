<?
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();                        
if(\Bitrix\Main\Loader::includeSharewareModule("krayt.retail") == \Bitrix\Main\Loader::MODULE_DEMO_EXPIRED || 
   \Bitrix\Main\Loader::includeSharewareModule("krayt.retail") ==  \Bitrix\Main\Loader::MODULE_NOT_FOUND
    )
{ return false;}

/** @var array $arParams */
/** @var array $arResult */

$config = \Bitrix\Main\Web\Json::encode($arResult['CONFIG']);
$randParamsKey = \Bitrix\Main\Security\Random::getString(5);
?>
<label  data-bx-user-consent="<?=htmlspecialcharsbx($config)?>" class="main-user-consent-request">
	<input type="checkbox" value="Y" <?=($arParams['IS_CHECKED'] ? 'checked' : '')?> name="<?=htmlspecialcharsbx($arParams['INPUT_NAME'])?>">
	<div class="main-user-consent-request-announce"><?=htmlspecialcharsbx($arResult['INPUT_LABEL'])?></div>
</label>
<template type="text/html" data-bx-template="main-user-consent-request-loader">
	<div class="main-user-consent-request-popup">
		<div class="main-user-consent-request-popup-cont">
			<div data-bx-head="" class="main-user-consent-request-popup-header"></div>
			<div class="main-user-consent-request-popup-body">
				<div data-bx-loader="" class="main-user-consent-request-loader">
					<svg class="main-user-consent-request-circular" viewBox="25 25 50 50">
						<circle class="main-user-consent-request-path" cx="50" cy="50" r="20" fill="none" stroke-width="1" stroke-miterlimit="10"></circle>
					</svg>
				</div>
				<div data-bx-content="" class="main-user-consent-request-popup-content">
					<div class="main-user-consent-request-popup-textarea-block">
						<textarea data-bx-textarea="" class="main-user-consent-request-popup-text scroll_bar_main" disabled></textarea>
					</div>
					<div class="main-user-consent-request-popup-buttons row">
                            <div class="col-sm-6 col-12 mb-sm-0 mb-2">
                                <span data-bx-btn-accept="" class="btn-primary main-user-consent-request-popup-button main-user-consent-request-popup-button-acc">Y</span>
                            </div>
                            <div class="col-sm-6 col-12">
                                <span data-bx-btn-reject="" class="btn-green-border main-user-consent-request-popup-button main-user-consent-request-popup-button-rej">N</span>
                            </div>
					</div>
				</div>
			</div>
		</div>
	</div>
</template>
<script>
    BX.ready(function () {
        BX.UserConsent.loadFromForms();
    });

</script>