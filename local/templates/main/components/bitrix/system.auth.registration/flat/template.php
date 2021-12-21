<?
/**
 * Bitrix Framework
 * @package bitrix
 * @subpackage main
 * @copyright 2001-2014 Bitrix
 */

/**
 * Bitrix vars
 * @global CMain $APPLICATION
 * @var array $arParams
 * @var array $arResult
 * @var CBitrixComponentTemplate $this
 */

if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();                        
if(\Bitrix\Main\Loader::includeSharewareModule("krayt.retail") == \Bitrix\Main\Loader::MODULE_DEMO_EXPIRED || 
   \Bitrix\Main\Loader::includeSharewareModule("krayt.retail") ==  \Bitrix\Main\Loader::MODULE_NOT_FOUND
    )
{ return false;}

use Bitrix\Main\Localization\Loc;

//one css for all system.auth.* forms
$APPLICATION->SetAdditionalCSS("/bitrix/css/main/system.auth/flat/style.css");
?>
<div class="title_box">
    <h1><?=Loc::getMessage('AUTH_REGISTER_TITLE');?></h1>
</div>

<div class="auth-form-box auth-form">

<?
if(!empty($arParams["~AUTH_RESULT"])):
	$text = str_replace(array("<br>", "<br />"), "\n", $arParams["~AUTH_RESULT"]["MESSAGE"]);
?>
	<div class="alert <?=($arParams["~AUTH_RESULT"]["TYPE"] == "OK"? "alert-success":"alert-danger")?>"><?=nl2br(htmlspecialcharsbx($text))?></div>
<?endif?>

<?if($arResult["USE_EMAIL_CONFIRMATION"] === "Y" && is_array($arParams["AUTH_RESULT"]) &&  $arParams["AUTH_RESULT"]["TYPE"] === "OK"):?>
	<div class="alert alert-success"><?echo GetMessage("AUTH_EMAIL_SENT")?></div>
<?else:?>

<?if($arResult["USE_EMAIL_CONFIRMATION"] === "Y"):?>
	<div class="alert alert-warning"><?echo GetMessage("AUTH_EMAIL_WILL_BE_SENT")?></div>
<?endif?>

<noindex>
	<form method="post" action="<?=$arResult["AUTH_URL"]?>" name="bform" enctype="multipart/form-data" class="account-form">
<?if($arResult["BACKURL"] <> ''):?>
		<input type="hidden" name="backurl" value="<?=$arResult["BACKURL"]?>" />
<?endif?>
		<input type="hidden" name="AUTH_FORM" value="Y" />
		<input type="hidden" name="TYPE" value="REGISTRATION" />

        <div class="form__widget">
            <div class="form__widget-box">
                <div class="form__widget-label"><?=GetMessage("AUTH_LAST_NAME")?></div>
                <input class="text-field" type="text" name="USER_LAST_NAME" maxlength="255" value="<?=$arResult["USER_LAST_NAME"]?>" />
            </div>
        </div>

        <div class="form__widget">
            <div class="form__widget-box">
                <div class="form__widget-label"><?=GetMessage("AUTH_NAME")?></div>
				<input class="text-field" type="text" name="USER_NAME" maxlength="255" value="<?=$arResult["USER_NAME"]?>" />
			</div>
		</div>

        <div class="form__widget">
            <div class="form__widget-box">
                <div class="form__widget-label"><?=GetMessage("AUTH_LOGIN_MIN")?><span class="bx-authform-starrequired">*</span></div>
				<input class="text-field" type="text" name="USER_LOGIN" maxlength="255" value="<?=$arResult["USER_LOGIN"]?>" />
			</div>
		</div>

        <div class="form__widget">
            <div class="form__widget-box">
                <div class="form__widget-label"><?=GetMessage("AUTH_PASSWORD_REQ")?><span class="bx-authform-starrequired">*</span></div>
<?if($arResult["SECURE_AUTH"]):?>
				<div class="bx-authform-psw-protected" id="bx_auth_secure" style="display:none"><div class="bx-authform-psw-protected-desc"><span></span><?echo GetMessage("AUTH_SECURE_NOTE")?></div></div>

<script type="text/javascript">
document.getElementById('bx_auth_secure').style.display = '';
</script>
<?endif?>
				<input class="text-field" type="password" name="USER_PASSWORD" maxlength="255" value="<?=$arResult["USER_PASSWORD"]?>" autocomplete="off" />

                <div class="bx-authform-description-container">
                    <?echo $arResult["GROUP_POLICY"]["PASSWORD_REQUIREMENTS"];?>
                </div>
			</div>
		</div>

        <div class="form__widget">
            <div class="form__widget-box">
                <div class="form__widget-label"><?=GetMessage("AUTH_CONFIRM")?><span class="bx-authform-starrequired">*</span></div>

<?if($arResult["SECURE_AUTH"]):?>
				<div class="bx-authform-psw-protected" id="bx_auth_secure_conf" style="display:none"><div class="bx-authform-psw-protected-desc"><span></span><?echo GetMessage("AUTH_SECURE_NOTE")?></div></div>

<script type="text/javascript">
document.getElementById('bx_auth_secure_conf').style.display = '';
</script>
<?endif?>
				<input class="text-field" type="password" name="USER_CONFIRM_PASSWORD" maxlength="255" value="<?=$arResult["USER_CONFIRM_PASSWORD"]?>" autocomplete="off" />
			</div>
		</div>

        <div class="form__widget">
            <div class="form__widget-box">
                <div class="form__widget-label"><?=GetMessage("AUTH_EMAIL")?><?if($arResult["EMAIL_REQUIRED"]):?><span class="bx-authform-starrequired">*</span><?endif?></div>
				<input class="text-field" type="text" name="USER_EMAIL" maxlength="255" value="<?=$arResult["USER_EMAIL"]?>" />
			</div>
		</div>

<?if($arResult["USER_PROPERTIES"]["SHOW"] == "Y"):?>
	<?foreach ($arResult["USER_PROPERTIES"]["DATA"] as $FIELD_NAME => $arUserField):?>

		<div class="bx-authform-formgroup-container">
			<div class="bx-authform-label-container"><?if ($arUserField["MANDATORY"]=="Y"):?><span class="bx-authform-starrequired">*</span><?endif?><?=$arUserField["EDIT_FORM_LABEL"]?></div>
			<div class="bx-authform-input-container">
<?
$APPLICATION->IncludeComponent(
	"bitrix:system.field.edit",
	$arUserField["USER_TYPE"]["USER_TYPE_ID"],
	array(
		"bVarsFromForm" => $arResult["bVarsFromForm"],
		"arUserField" => $arUserField,
		"form_name" => "bform"
	),
	null,
	array("HIDE_ICONS"=>"Y")
);
?>
			</div>
		</div>

	<?endforeach;?>
<?endif;?>
<?if ($arResult["USE_CAPTCHA"] == "Y"):?>
		<input type="hidden" name="captcha_sid" value="<?=$arResult["CAPTCHA_CODE"]?>" />

		<div class="bx-authform-formgroup-container">
			<div class="bx-authform-label-container">
				<span class="bx-authform-starrequired">*</span><?=GetMessage("CAPTCHA_REGF_PROMT")?>
			</div>
			<div class="bx-captcha"><img src="/bitrix/tools/captcha.php?captcha_sid=<?=$arResult["CAPTCHA_CODE"]?>" width="180" height="40" alt="CAPTCHA" /></div>
			<div class="bx-authform-input-container">
				<input type="text" name="captcha_word" maxlength="50" value="" autocomplete="off"/>
			</div>
		</div>

<?endif?>
		<div class="form__widget-box">
			<div class="bx-authform-input-container">
				<?$APPLICATION->IncludeComponent("bitrix:main.userconsent.request", "",
					array(
						"ID" => COption::getOptionString("main", "new_user_agreement", ""),
						"IS_CHECKED" => "Y",
						"AUTO_SAVE" => "N",
						"IS_LOADED" => "Y",
						"ORIGINATOR_ID" => $arResult["AGREEMENT_ORIGINATOR_ID"],
						"ORIGIN_ID" => $arResult["AGREEMENT_ORIGIN_ID"],
						"INPUT_NAME" => $arResult["AGREEMENT_INPUT_NAME"],
						"REPLACE" => array(
							"button_caption" => GetMessage("AUTH_REGISTER"),
							"fields" => array(
								rtrim(GetMessage("AUTH_NAME"), ":"),
								rtrim(GetMessage("AUTH_LAST_NAME"), ":"),
								rtrim(GetMessage("AUTH_LOGIN_MIN"), ":"),
								rtrim(GetMessage("AUTH_PASSWORD_REQ"), ":"),
								rtrim(GetMessage("AUTH_EMAIL"), ":"),
							)
						),
					)
				);?>
			</div>
		</div>

        <div class="clearfix">
            <div class="bx-authform-description-container pull-left bx-authform-required"><span class="bx-authform-starrequired">*</span><?=GetMessage("AUTH_REQ")?></div>
            <a href="<?=$arResult["AUTH_AUTH_URL"]?>" rel="nofollow" class="login-link reg-form-link"><span><?=GetMessage("AUTH_AUTH")?></span></a>
        </div>

        <div class="form__controls">
            <div class="form__widget-box">
			    <input type="submit" class="btn-primary btn-form__control" name="Register" value="<?=GetMessage("AUTH_REGISTER")?>" />
            </div>
		</div>

	</form>
</noindex>

<script type="text/javascript">
document.bform.USER_NAME.focus();
</script>

<?endif?>
</div>