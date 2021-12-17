<?
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true)
	die();

use Bitrix\Main\Localization\Loc;
?>

<div class="bx_profile">
	<?
	ShowError($arResult["strProfileError"]);

	if ($arResult['DATA_SAVED'] == 'Y')
	{
		ShowNote(Loc::getMessage('PROFILE_DATA_SAVED'));
	}

	?>
	<form class="lk_form account-form" method="post" name="form1" action="<?=$APPLICATION->GetCurUri()?>" enctype="multipart/form-data" role="form">
		<?=$arResult["BX_SESSION_CHECK"]?>
		<input type="hidden" name="lang" value="<?=LANG?>" />
		<input type="hidden" name="ID" value="<?=$arResult["ID"]?>" />
		<input type="hidden" name="LOGIN" value="<?=$arResult["arUser"]["LOGIN"]?>" />
		<div class="account-form__wrapper main-profile-block-shown" id="user_div_reg">
			<div class="main-profile-block-date-info">
				<?
				if($arResult["ID"]>0)
				{
					if (strlen($arResult["arUser"]["TIMESTAMP_X"])>0)
					{
						?>
						<div class="small">
							<strong><?=Loc::getMessage('LAST_UPDATE')?></strong>
							<strong><?=$arResult["arUser"]["TIMESTAMP_X"]?></strong>
						</div>
						<?
					}

					if (strlen($arResult["arUser"]["LAST_LOGIN"])>0)
					{
						?>
						<div class="small">
							<strong><?=Loc::getMessage('LAST_LOGIN')?></strong>
							<strong><?=$arResult["arUser"]["LAST_LOGIN"]?></strong>
						</div>
						<?
					}
				}
				?>
			</div>
			<?
			if (!in_array(LANGUAGE_ID,array('ru', 'ua')))
			{
				?>
				<div class="form-group">
					<label class="form__widget-label" for="main-profile-title"><?=Loc::getMessage('main_profile_title')?></label>
					<div class="col-sm-12">
						<input class="text-field" type="text" name="TITLE" maxlength="50" id="main-profile-title" value="<?=$arResult["arUser"]["TITLE"]?>" />
					</div>
				</div>
				<?
			}
			?>

            <div class="form__widget form__widget_fio">
                <div class="">
                    <div class="account-form__widget form__widget-box">
                        <label class="form__widget-label" for="main-profile-last-name"><?=Loc::getMessage('LAST_NAME')?></label>
                        <input class="text-field" type="text" name="LAST_NAME" maxlength="50" id="main-profile-last-name" value="<?=$arResult["arUser"]["LAST_NAME"]?>" />
                    </div>
                </div>
            </div>
            <div class="form__widget form__widget_fio">
                <div class="">
                    <div class="account-form__widget form__widget-box">
                        <label class="form__widget-label" for="main-profile-name"><?=Loc::getMessage('NAME')?></label>
                        <input class="text-field" type="text" name="NAME" maxlength="50" id="main-profile-name" value="<?=$arResult["arUser"]["NAME"]?>" />
                    </div>
                </div>
            </div>
            <div class="form__widget form__widget_fio">
                <div class="">
                    <div class="account-form__widget form__widget-box">
                        <label class="form__widget-label" for="main-profile-second-name"><?=Loc::getMessage('SECOND_NAME')?></label>
                        <input class="text-field" type="text" name="SECOND_NAME" maxlength="50" id="main-profile-second-name" value="<?=$arResult["arUser"]["SECOND_NAME"]?>" />
                    </div>
                </div>
            </div>

            <div class="form__widget form__widget_birthday">
                <div class="">
                    <div class="account-form__widget form__widget-box">
                        <label class="form__widget-label" for="PERSONAL_BIRTHDAY"><?=Loc::getMessage('PERSONAL_BIRTHDAY')?></label>
                        <div class="form__widget-input">
                            <?
                            $APPLICATION->IncludeComponent(
                                'bitrix:main.calendar',
                                '.default',
                                array(
                                    'SHOW_INPUT' => 'Y',
                                    'FORM_NAME' => 'form1',
                                    'INPUT_NAME' => 'PERSONAL_BIRTHDAY',
                                    'INPUT_VALUE' => $arResult["arUser"]["PERSONAL_BIRTHDAY"],
                                    'SHOW_TIME' => 'N'
                                ),
                                null,
                                array('HIDE_ICONS' => 'Y')
                            );

                            ?>
                        </div>
                    </div>
                </div>
            </div>
            <div class="form__widget form__widget_gender">
                <div class="">
                    <div class="account-form__widget form__widget-box">
                        <div class="form__widget-label"><?=GetMessage('K_SEX')?></div>
                        <ul class="tabs_gender">
                            <li class="tabs__item">
                                <input id="female" type="radio" name="PERSONAL_GENDER" value="F" <?=$arResult["arUser"]["PERSONAL_GENDER"] == "F" ? "checked" : ""?>>
                                <label for="female" class="tabs__item-btn female"><span><?=GetMessage('K_FEMALE')?></span></label>
                            </li>
                            <li class="tabs__item">
                                <input id="male" type="radio" name="PERSONAL_GENDER" value="M" <?=$arResult["arUser"]["PERSONAL_GENDER"] == "M" ? "checked" : ""?>>
                                <label for="male" class="tabs__item-btn male"><span><?=GetMessage('K_MALE')?></span></label>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="form__widget form__widget_email">
                <div class="">
                    <div class="account-form__widget form__widget-box">
                        <label class="form__widget-label" for="main-profile-email"><?=Loc::getMessage('EMAIL')?></label>
                        <input class="text-field" type="text" name="EMAIL" maxlength="50" id="main-profile-email" value="<?=$arResult["arUser"]["EMAIL"]?>" />
			    	</div>
                </div>
			</div>
			<?
			if ($arResult['CAN_EDIT_PASSWORD'])
			{
				?>
                <div class="form__widget form__widget_password">
                    <div class="">
                        <div class="account-form__widget form__widget-box">
                            <label class="form__widget-label" for="main-profile-password"><?=Loc::getMessage('NEW_PASSWORD_REQ')?></label>
                            <input class="text-field" type="password" name="NEW_PASSWORD" maxlength="50" id="main-profile-password" value="" autocomplete="off"/>
                            <p class="main-profile-form-password-annotation small">
                                <?echo $arResult["GROUP_POLICY"]["PASSWORD_REQUIREMENTS"];?>
                            </p>
                        </div>
                    </div>
				</div>
                <div class="form__widget form__widget_password">
                    <div class="">
                        <div class="account-form__widget form__widget-box">
                            <label class="form__widget-label" for="main-profile-password-confirm"><?=Loc::getMessage('NEW_PASSWORD_CONFIRM')?></label>
                            <input class="text-field" type="password" name="NEW_PASSWORD_CONFIRM" maxlength="50" value="" id="main-profile-password-confirm" autocomplete="off" />
                        </div>
					</div>
				</div>
				<?
			}
			?>
		</div>
        <div class="form__controls password-form__controls">
            <input type="submit" name="save" class="btn-form__control btn-primary main-profile-submit" value="<?=(($arResult["ID"]>0) ? Loc::getMessage("MAIN_SAVE") : Loc::getMessage("MAIN_ADD"))?>">
            <div class="btn-green-border btn-form__control">
                <input type="submit" class="cancel"  name="reset" value="<?echo GetMessage("MAIN_RESET")?>">
            </div>
        </div>
	</form>
	<div class="col-sm-12 main-profile-social-block">
		<?
		if ($arResult["SOCSERV_ENABLED"])
		{
			$APPLICATION->IncludeComponent("bitrix:socserv.auth.split", ".default", array(
				"SHOW_PROFILES" => "Y",
				"ALLOW_DELETE" => "Y"
			),
				false
			);
		}
		?>
	</div>
	<div class="clearfix"></div>
</div>