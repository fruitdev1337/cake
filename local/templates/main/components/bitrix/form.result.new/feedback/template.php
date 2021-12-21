<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>

<?
use Bitrix\Main\Localization\Loc;
$required = 'required="required"';
?>
<?if($arResult["isFormErrors"] == "Y")
{
	$textError = str_replace(array("\r","\n"), "", $arResult["FORM_ERRORS_TEXT"]);
	?>
	<script>
		$(document).ready(function(){
			$('#modal-submit .modal__content h2').text('Что то пошло не так');
			var $er = '<?=$arResult["FORM_ERRORS_TEXT"];?>';
			$('#modal-submit .modal__content .registration-form__subtitle').html($er);
			modalSubmit();
		});
	</script>
	<?
}
if($arResult["isFormNote"] == "Y")
{
	?>
	<script>
		$(document).ready(function(){
			$('#modal-submit .modal__content h2').text('Ваше обращение успешно отправлено');
			$('#modal-submit .modal__content .registration-form__subtitle').html('<p>В ближайшее время мы свяжемся с вами для уточнения информации.</p>');
			modalSubmit();
		});
	</script>
	<?
}
?>

<div id="modal-feedback" class="modal" data-scroll-lock-scrollable>
	<div class="modal__overlay"></div>
	
	<div class="modal__window">
	
		<div class="modal__close">
			<button class="js-modal-close" aria-label="Закрыть" type="button">
				<img src="<?=SITE_TEMPLATE_PATH?>/img/close.svg" width="21" height="21" alt="">
			</button>
		</div>
	
		<div class="modal__content">
			<section class="scene  registration-form">
				<div class="grid">
					<div class="grid__item  registration-form__wrapper">
						
						<div class="registration-form__title">
							<h2><?=GetMessage("FORM_BLOCK_TITLE")?></h2>
						</div>

						<div class="registration-form__subtitle">
							<?=GetMessage("FORM_BLOCK_SUBTITLE")?>
						</div>
						
						<?=$arResult["FORM_HEADER"]?>
							<?foreach ($arResult["QUESTIONS"] as $FIELD_SID => $arQuestion):?>
								<?if ($arQuestion['STRUCTURE'][0]['FIELD_TYPE'] == 'hidden'):
									echo $arQuestion["HTML_CODE"];
							
								else:?>
							
									<?switch ($FIELD_SID):
									
										case "name_pastry_shops":?>
											<div class="form__item">
												<div class="form__title">
													<h3>Общая информация</h3>
												</div>
												
												<div class="form__row">
													<div class="form__label">
														<label>Название кондитерской</label>
													</div>

													<div class="form__control">
														<input class="form__input" type="text" name="form_text_<?= $arQuestion['STRUCTURE'][0]['ID']?>" value="<?= $arResult['arrVALUES']['form_text_'.$arQuestion["STRUCTURE"][0]["ID"]]?>" placeholder="Введите название" <?=($arQuestion["REQUIRED"] == "Y" ? $required : '')?>>

														<div class="form__hint">
															Введите название кондитерской
														</div>
													</div>
												</div>
											<?break;

										case "web_site":?>
												<div class="form__row">
													<div class="form__label">
														<label>Веб-сайт</label>
													</div>

													<div class="form__control">
														<input class="form__input" type="text" name="form_text_<?= $arQuestion['STRUCTURE'][0]['ID']?>" value="<?= $arResult['arrVALUES']['form_text_'.$arQuestion["STRUCTURE"][0]["ID"]]?>" placeholder="www..." <?=($arQuestion["REQUIRED"] == "Y" ? $required : '')?>>

														<div class="form__hint">
															Введите адрес сайта
														</div>
													</div>
												</div>
											</div>
											<?break;
										
										case "name":?>
											<div class="form__item">
												<div class="form__title">
													<h3>Данные контактного лица</h3>
												</div>

												<div class="form__row">
													<div class="form__label">
														<label>ФИО</label>
													</div>

													<div class="form__control">
														<input class="form__input" type="text" name="form_text_<?= $arQuestion['STRUCTURE'][0]['ID']?>" value="<?= $arResult['arrVALUES']['form_text_'.$arQuestion["STRUCTURE"][0]["ID"]]?>" placeholder="Введите ФИО" <?=($arQuestion["REQUIRED"] == "Y" ? $required : '')?>>

														<div class="form__hint">
															Введите Ваши ФИО
														</div>
													</div>
												</div>
											<?break;
										
										case "phone":?>
												<div class="form__row">
													<div class="form__label">
														<label for="phone">Телефон</label>
													</div>

													<div class="form__control">
														<input id="phone" class="form__input  input-phone" type="text" name="form_text_<?= $arQuestion['STRUCTURE'][0]['ID']?>" value="<?= $arResult['arrVALUES']['form_text_'.$arQuestion["STRUCTURE"][0]["ID"]]?>" placeholder="+7 (XXX) XXX-XX-XX" <?=($arQuestion["REQUIRED"] == "Y" ? $required : '')?>>

														<div class="form__hint">
															Введите Ваш номер
														</div>
													</div>
												</div>
											<?break;
										
										case "email":?>
												<div class="form__row">
													<div class="form__label">
														<label for="email">E-mail</label>
													</div>

													<div class="form__control">
														<input id="email" class="form__input" type="email" name="form_email_<?= $arQuestion['STRUCTURE'][0]['ID']?>" value="<?= $arResult['arrVALUES']['form_text_'.$arQuestion["STRUCTURE"][0]["ID"]]?>" placeholder="Введите e-mail" <?=($arQuestion["REQUIRED"] == "Y" ? $required : '')?>>

														<div class="form__hint">
															Введите Ваш e-mail
														</div>
													</div>
												</div>
											</div>
											<?break;
										
									endswitch;?>

								<?endif;?>
							<?endforeach;?>
							
							<?if($arResult["isUseCaptcha"] == "Y"):?>
								<div class="recaptcha">
									<input id="captchaSid" type="hidden" name="captcha_sid" value="<?=htmlspecialcharsbx($arResult["CAPTCHACode"]);?>" />
									<img id="reloadCaptcha" src="/bitrix/tools/captcha.php?captcha_sid=<?=htmlspecialcharsbx($arResult["CAPTCHACode"]);?>" width="180" height="40" />
									<input type="text" name="captcha_word" size="30" maxlength="50" value="" class="inputtext" placeholder="<?=GetMessage('FORM_CAPTCHA_PLACEHOLDER')?>" <?=$required?> />
								</div>
							<?endif;?>

							<div class="form__item">
								<div class="form__row  form__row--center">
									<button type="submit" class="btn  btn--primary  js-submit-feedback" disabled>Отправить</button>
								</div>
							</div>

							<input type="hidden" name="web_form_submit" value="<?=htmlspecialcharsbx(strlen(trim($arResult["arForm"]["BUTTON"])) <= 0 ? GetMessage("FORM_ADD") : $arResult["arForm"]["BUTTON"]);?>" />
							<input type="hidden" name="web_form_apply" value="Y" />
						
						<?=$arResult["FORM_FOOTER"]?>
						
						
						<div class="registration-form__desc">
							<p><?=GetMessage("FORM_AGREE")?></p>
						</div>
						
					</div>
				</div>
			</section>
		</div>
	</div>
</div>