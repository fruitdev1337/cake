<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>


<?
use Bitrix\Main\Localization\Loc;
$required = 'required="required"';
?>

<?if($arResult["isFormErrors"] == "Y")
{
	$textError = str_replace(array("\r","\n"), "", $arResult["FORM_ERRORS_TEXT"]);
	print_r($textError);
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
			$('#modal-submit .modal__content h2').text('Ваша кондитесркая успешно зарегистрирована');
			$('#modal-submit .modal__content .registration-form__subtitle').html('<p>В ближайшее время мы свяжемся с вами для уточнения информации.</p>');
			modalSubmit();
		});
	</script>
	<?
}
?>
<?=$arResult["FORM_HEADER"]?>

	<?foreach ($arResult["QUESTIONS"] as $FIELD_SID => $arQuestion):?>
		<?if ($arQuestion['STRUCTURE'][0]['FIELD_TYPE'] == 'hidden'):
			echo $arQuestion["HTML_CODE"];
		endif;?>
	<?endforeach;?>
									
	<div id="modal-step-1" class="modal" data-scroll-lock-scrollable>
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
								<h2><?=GetMessage("FORM_REG_BLOCK_TITLE")?></h2>
							</div>

							<ul class="registration-form__steps">
								<li>Шаг 1</li>
								<li class="registration-form__divider"></li>
								<li>Шаг 2</li>
								<li class="registration-form__divider"></li>
								<li>Шаг 3</li>
								<li class="registration-form__divider"></li>
								<li>Шаг 4</li>
							</ul> 						
							
							<div class="form">
								<div class="form__item">
									<div class="form__title">
										<h3>Общая информация</h3>
									</div>

									<div class="form__row">
										<div class="form__label">
											<label>Название кондитерской</label>
										</div>
										
										<?$arQuestion = $arResult["QUESTIONS"]["name_pastry_shops"]?>
										<div class="form__control">
											<input class="form__input" type="text" name="form_text_<?= $arQuestion['STRUCTURE'][0]['ID']?>" value="<?= $arResult['arrVALUES']['form_text_'.$arQuestion["STRUCTURE"][0]["ID"]]?>" placeholder="Введите название" <?=($arQuestion["REQUIRED"] == "Y" ? $required : '')?>>

											<div class="form__hint">
												Введите название кондитерской
											</div>
										</div>
									</div>

									<div class="form__row">
										<div class="form__label">
											<label>Веб-сайт</label>
										</div>

										<?$arQuestion = $arResult["QUESTIONS"]["web_site"]?>
										<div class="form__control">
											<input class="form__input" type="text" name="form_text_<?= $arQuestion['STRUCTURE'][0]['ID']?>" value="<?= $arResult['arrVALUES']['form_text_'.$arQuestion["STRUCTURE"][0]["ID"]]?>" placeholder="www..." <?=($arQuestion["REQUIRED"] == "Y" ? $required : '')?>>

											<div class="form__hint">
												Введите адрес сайта
											</div>
										</div>
									</div>
								</div>
								
								<div class="form__item">
									<div class="form__title">
										<h3>Данные контактного лица</h3>
									</div>

									<div class="form__row">
										<div class="form__label">
											<label>ФИО</label>
										</div>

										<?$arQuestion = $arResult["QUESTIONS"]["name"]?>
										<div class="form__control">
											<input class="form__input" type="text" name="form_text_<?= $arQuestion['STRUCTURE'][0]['ID']?>" value="<?= $arResult['arrVALUES']['form_text_'.$arQuestion["STRUCTURE"][0]["ID"]]?>" placeholder="Введите ФИО" <?=($arQuestion["REQUIRED"] == "Y" ? $required : '')?>>

											<div class="form__hint">
												Введите Ваши ФИО
											</div>
										</div>
									</div>

									<div class="form__row">
										<div class="form__label">
											<label>Телефон</label>
										</div>

										<?$arQuestion = $arResult["QUESTIONS"]["phone"]?>
										<div class="form__control">
											<input class="form__input  input-phone" type="tel" name="form_text_<?= $arQuestion['STRUCTURE'][0]['ID']?>" value="<?= $arResult['arrVALUES']['form_text_'.$arQuestion["STRUCTURE"][0]["ID"]]?>" placeholder="+7 (XXX) XXX-XX-XX" <?=($arQuestion["REQUIRED"] == "Y" ? $required : '')?>>

											<div class="form__hint">
												Введите Ваш номер
											</div>
										</div>
									</div>

									<div class="form__row">
										<div class="form__label">
											<label>E-mail</label>
										</div>

										<?$arQuestion = $arResult["QUESTIONS"]["email"]?>
										<div class="form__control">
											<input class="form__input" type="email" name="form_email_<?= $arQuestion['STRUCTURE'][0]['ID']?>" value="<?= $arResult['arrVALUES']['form_text_'.$arQuestion["STRUCTURE"][0]["ID"]]?>" placeholder="Введите e-mail" <?=($arQuestion["REQUIRED"] == "Y" ? $required : '')?>>

											<div class="form__hint">
												Введите Ваш e-mail
											</div>
										</div>
									</div>
								</div>
							</div>
							
							<div class="registration-form__action">
								<button class="btn  btn--transparent  js-modal-close" type="button">Отмена</button>

								<button class="btn  btn--primary  js-modal-open  js-submit-step-1" data-target="#modal-step-2" disabled>Далее</button>
							</div>
							
						</div>
					</div>
				</section>
			</div>

		</div>
	</div>
	
	<div id="modal-step-2" class="modal" data-scroll-lock-scrollable>
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
								<h2>Зарегистрируйте свою кондитерскую</h2>
							</div>

							<ul class="registration-form__steps">
								<li>Шаг 1</li>
								<li class="registration-form__divider"></li>
								<li>Шаг 2</li>
								<li class="registration-form__divider"></li>
								<li>Шаг 3</li>
								<li class="registration-form__divider"></li>
								<li>Шаг 4</li>
							</ul>

							<div class="form">
							
								<div class="form__item">
									<div class="form__title">
										<h3>О компании</h3>
									</div>

									<div class="form__row">
										<div class="form__label">
											<label for="name">Краткое описание*</label>
										</div>

										<?$arQuestion = $arResult["QUESTIONS"]["about"]?>
										<div class="form__control">
											<textarea class="form__textarea  form__element" rows="5" name="form_textarea_<?= $arQuestion['STRUCTURE'][0]['ID']?>" placeholder="Напишите презентационный текст для размещения на площадке" <?=($arQuestion["REQUIRED"] == "Y" ? $required : '')?>><?= $arResult['arrVALUES']['form_textarea_'.$arQuestion["STRUCTURE"][0]["ID"]]?></textarea>

											<div class="form__hint">
												Введите краткое описание
											</div>

											<p>* до 1000 символов</p>
										</div>
									</div>
								</div>
								
								<div class="form__item">
									<div class="form__row">
										<div class="form__label">
											<label for="name">Логотип компании</label>
										</div>

										<?$arQuestion = $arResult["QUESTIONS"]["logo"]?>
										<div class="form__control">
											<div class="file-form">
												<button type="button" class="btn  btn--green">Загрузить</button>
												<input class="form__element  file-form__input" type="file" name="form_file_<?= $arQuestion['STRUCTURE'][0]['ID']?>" accept=".jpg, .jpeg, .png, .svg, .pdf" onchange="getNameUpload(this.value);" />
												<div class="file-form__label"></div>
											</div>

											<div class="form__hint">
												Загрузите логотип компании
											</div>
										</div>
									</div>
								</div>
								
								<div class="form__item">
									<div class="form__title">
										<h3>Данные для размещения на площадке</h3>
									</div>

									<div class="form__row">
										<div class="form__label">
											<label>Телефон</label>
										</div>

										<?$arQuestion = $arResult["QUESTIONS"]["phone_2"]?>
										<div class="form__control">
											<input class="form__input  input-phone  form__element" type="tel" name="form_text_<?= $arQuestion['STRUCTURE'][0]['ID']?>" value="<?= $arResult['arrVALUES']['form_text_'.$arQuestion["STRUCTURE"][0]["ID"]]?>" placeholder="+7 (XXX) XXX-XX-XX" <?=($arQuestion["REQUIRED"] == "Y" ? $required : '')?>>
											
											<div class="form__hint">
												Введите Ваш телефон
											</div>
										</div>
									</div>

									<div class="form__row">
										<div class="form__label">
											<label for="email">E-mail</label>
										</div>

										<?$arQuestion = $arResult["QUESTIONS"]["email_2"]?>
										<div class="form__control">
											<input class="form__input  form__element" type="email" name="form_email_<?= $arQuestion['STRUCTURE'][0]['ID']?>" value="<?= $arResult['arrVALUES']['form_text_'.$arQuestion["STRUCTURE"][0]["ID"]]?>" placeholder="Введите e-mail" <?=($arQuestion["REQUIRED"] == "Y" ? $required : '')?>>

											<div class="form__hint">
												Введите Ваш e-mail
											</div>
										</div>
									</div>

									<div class="form__row">
										<div class="form__label">
											<label>Адрес отгрузки</label>
										</div>

										<?$arQuestion = $arResult["QUESTIONS"]["address"]?>
										<div class="form__control">
											<input class="form__input  form__element" type="text" name="form_text_<?= $arQuestion['STRUCTURE'][0]['ID']?>" value="<?= $arResult['arrVALUES']['form_text_'.$arQuestion["STRUCTURE"][0]["ID"]]?>" placeholder="Введите адрес, с которого будет осуществляться доставка" <?=($arQuestion["REQUIRED"] == "Y" ? $required : '')?>>

											<div class="form__hint">
												Введите адрес отгрузки
											</div>
										</div>
									</div>
								</div>
								
								<div class="form__item">
									<div class="form__title">
										<h3>Часы работы</h3>
									</div>
									
									<div class="form__row">
										<div class="form__label">
											<label><strong>Время работы</strong></label>
										</div>
									</div>
									
									<?$arQuestion = $arResult["QUESTIONS"]["work_time"]?>
									<?foreach($arQuestion["STRUCTURE"] as $arItem):?>
										<div class="form__row">
											<div class="form__control">
												<div class="opening-hours">
													<div class="opening-hours__select">
														<p><?echo $arItem["MESSAGE"]?></p>
													</div>

													<div class="opening-hours__input">
														<input class="form__input  input-hours" type="text"  name="form_text_<?= $arItem['ID']?>" value="<?= $arResult['arrVALUES']['form_text_'.$arItem["ID"]]?>" placeholder="XX:XX-XX:XX">
													</div>
												</div>
											</div>
										</div>
									<?endforeach;?>
								</div>
							</div>
							
							<div class="registration-form__action">
								<button class="btn  btn--transparent  js-modal-open" data-target="#modal-step-1" type="button">Назад</button>

								<button class="btn  btn--primary  js-modal-open  js-submit-step-2" data-target="#modal-step-3" type="button" disabled>Далее</button>
							</div>
						</div>
					</div>
				</section>
			</div>
		</div>
	</div>
	
	<div id="modal-step-3" class="modal" data-scroll-lock-scrollable>
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
								<h2>Зарегистрируйте свою кондитерскую</h2>
							</div>

							<ul class="registration-form__steps">
								<li>Шаг 1</li>
								<li class="registration-form__divider"></li>
								<li>Шаг 2</li>
								<li class="registration-form__divider"></li>
								<li>Шаг 3</li>
								<li class="registration-form__divider"></li>
								<li>Шаг 4</li>
							</ul>

							<div class="form">

								<div class="form__item">
									<div class="form__title">
										<h3>Дополнительная информация</h3>
									</div>

									<div class="form__row">
										<div class="form__label">
											<label>Срок исполнения заказа с момента поступления (в часах)</label>
										</div>

										<?$arQuestion = $arResult["QUESTIONS"]["time_manufacturing"]?>
										<div class="form__control">
											<input class="form__input  form__element" type="text" name="form_text_<?= $arQuestion['STRUCTURE'][0]['ID']?>" value="<?= $arResult['arrVALUES']['form_text_'.$arQuestion["STRUCTURE"][0]["ID"]]?>" placeholder="XX:XX — XX:XX" <?=($arQuestion["REQUIRED"] == "Y" ? $required : '')?>>

											<div class="form__hint">
												Введите cрок исполнения заказа
											</div>
										</div>
									</div>
									
									<div class="form__row">
										<div class="form__label">
											<label for="phone">Район и стоиомсть доставки</label>
										</div>

										<div class="form__control">
											<div class="delivery">
												<div class="delivery__toggle  js-collapse-delivery-toggle">
													<div class="delivery__desc">
														Выберите район
													</div>

													<div class="delivery__icon"></div>
												</div>

												<div class="delivery__collapse">
													<ul class="delivery__table">
														<li>
															<div class="delivery__content">
																<label class="form__checkbox">
																	<input class="js-all-places" type="checkbox">
																	<span>Выбрать все районы</span>
																</label>
															</div>

															<div class="delivery__action">
																<p>Стоимость <br> доставки</p>
															</div>
														</li>
														
														<?$arQuestion = $arResult["QUESTIONS"]["district_price"]?>
														<?foreach($arQuestion["STRUCTURE"] as $arItem):?>
															<li>
																<div class="delivery__content">
																	<label class="form__checkbox">
																		<input class="input-place" type="checkbox" disabled>
																		<span><?echo $arItem["MESSAGE"]?></span>
																	</label>
																</div>

																<div class="delivery__action">
																	<div class="delivery__price">
																		<input type="number" class="form__input" name="form_text_<?= $arItem['ID']?>" value="<?= $arResult['arrVALUES']['form_text_'.$arItem["ID"]]?>">
																	</div>

																	<div class="delivery__currency">₽</div>
																</div>
															</li>
														<?endforeach;?>
														
														<li>
															<div class="delivery__content">
																<span>Стоимость доставки <br> по всем районам</span>
															</div>

															<div class="delivery__action">
																<div class="delivery__price">
																	<input type="number" class="form__input  js-all-prices">
																</div>

																<div class="delivery__currency">₽</div>
															</div>
														</li>
													</ul>

													<div class="delivery__save">
														<button class="btn  btn--transparent  js-remove-places" type="button">Отмена</button>

														<button button class="btn  btn--primary  js-add-places" type="button">Сохранить</button>
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>

							</div>
							
							<div class="registration-form__tag">
								<ul></ul>
							</div>

							<div class="registration-form__action">
								<button class="btn  btn--transparent  js-modal-open" data-target="#modal-step-2" type="button">Назад</button>

								<button class="btn  btn--primary  js-modal-open  js-submit-step-3" data-target="#modal-step-4" type="button" disabled>Далее</button>
							</div>
						</div>
					</div>
				</section>
			</div>
		</div>
	</div>
	
	<div id="modal-step-4" class="modal" data-scroll-lock-scrollable>
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
								<h2>Зарегистрируйте свою кондитерскую</h2>
							</div>

							<ul class="registration-form__steps">
								<li>Шаг 1</li>
								<li class="registration-form__divider"></li>
								<li>Шаг 2</li>
								<li class="registration-form__divider"></li>
								<li>Шаг 3</li>
								<li class="registration-form__divider"></li>
								<li>Шаг 4</li>
							</ul>            

							<div class="form">
								<div class="form__item">
									<div class="form__title">
										<h3>Юридическая информация</h3>
									</div>

									<div class="form__row">
										<div class="form__label">
											<label>Полное название юридического лица</label>
										</div>

										<?$arQuestion = $arResult["QUESTIONS"]["name_company_full"]?>
										<div class="form__control">
											<input class="form__input  form__element" type="text" name="form_text_<?= $arQuestion['STRUCTURE'][0]['ID']?>" value="<?= $arResult['arrVALUES']['form_text_'.$arQuestion["STRUCTURE"][0]["ID"]]?>" placeholder="Введите название" <?=($arQuestion["REQUIRED"] == "Y" ? $required : '')?>>

											<div class="form__hint">
												Введите название юридического лица
											</div>
										</div>
									</div>

									<div class="form__row">
										<div class="form__label">
											<label>Название на английском языке</label>
										</div>

										<?$arQuestion = $arResult["QUESTIONS"]["name_company_en"]?>
										<div class="form__control">
											<input class="form__input  form__element" type="text" name="form_text_<?= $arQuestion['STRUCTURE'][0]['ID']?>" value="<?= $arResult['arrVALUES']['form_text_'.$arQuestion["STRUCTURE"][0]["ID"]]?>" placeholder="Введите название на английском языке" <?=($arQuestion["REQUIRED"] == "Y" ? $required : '')?>>

											<div class="form__hint">
												Введите название на английском языке
											</div>
										</div>
									</div>

									<div class="form__row">
										<div class="form__label">
											<label>Сокращенное наименование</label>
										</div>

										<?$arQuestion = $arResult["QUESTIONS"]["name_company_short"]?>
										<div class="form__control">
											<input class="form__input  form__element" type="text" name="form_text_<?= $arQuestion['STRUCTURE'][0]['ID']?>" value="<?= $arResult['arrVALUES']['form_text_'.$arQuestion["STRUCTURE"][0]["ID"]]?>" placeholder="Введите сокращенное наименование" <?=($arQuestion["REQUIRED"] == "Y" ? $required : '')?>>

											<div class="form__hint">
												Введите сокращенное наименование
											</div>
										</div>
									</div>

									<div class="form__title">
										<h3>Юридический адрес</h3>
									</div>

									<div class="form__row">
										<div class="form__label">
											<label>Город</label>
										</div>

										<?$arQuestion = $arResult["QUESTIONS"]["city_legal"]?>
										<div class="form__control">
											<input class="form__input  form__element" type="text" name="form_text_<?= $arQuestion['STRUCTURE'][0]['ID']?>" value="<?= $arResult['arrVALUES']['form_text_'.$arQuestion["STRUCTURE"][0]["ID"]]?>" placeholder="Введите город" <?=($arQuestion["REQUIRED"] == "Y" ? $required : '')?>>

											<div class="form__hint">
												Введите город
											</div>
										</div>
									</div>

									<div class="form__row">
										<div class="form__label">
											<label>Почтовый индекс</label>
										</div>

										<?$arQuestion = $arResult["QUESTIONS"]["zip_legal"]?>
										<div class="form__control">
											<input class="form__input  form__element" type="text" name="form_text_<?= $arQuestion['STRUCTURE'][0]['ID']?>" value="<?= $arResult['arrVALUES']['form_text_'.$arQuestion["STRUCTURE"][0]["ID"]]?>" placeholder="Введите почтовый индекс" <?=($arQuestion["REQUIRED"] == "Y" ? $required : '')?>>

											<div class="form__hint">
												Введите почтовый индекс
											</div>
										</div>
									</div>

									<div class="form__row">
										<div class="form__label">
											<label>Улица</label>
										</div>

										<?$arQuestion = $arResult["QUESTIONS"]["street_legal"]?>
										<div class="form__control">
											<input class="form__input  form__element" type="text" name="form_text_<?= $arQuestion['STRUCTURE'][0]['ID']?>" value="<?= $arResult['arrVALUES']['form_text_'.$arQuestion["STRUCTURE"][0]["ID"]]?>" placeholder="Введите улицу" <?=($arQuestion["REQUIRED"] == "Y" ? $required : '')?>>

											<div class="form__hint">
												Введите улицу
											</div>
										</div>
									</div>

									<div class="form__row">
										<div class="form__label">
											<label>Дом, корпус, офис</label>
										</div>

										<?$arQuestion = $arResult["QUESTIONS"]["house_legal"]?>
										<div class="form__control">
											<input class="form__input  form__element" type="text" name="form_text_<?= $arQuestion['STRUCTURE'][0]['ID']?>" value="<?= $arResult['arrVALUES']['form_text_'.$arQuestion["STRUCTURE"][0]["ID"]]?>" placeholder="Введите дом, корпус, офис" <?=($arQuestion["REQUIRED"] == "Y" ? $required : '')?>>

											<div class="form__hint">
												Введите дом, корпус, офис
											</div>
										</div>
									</div>

									<div class="form__row">
										<div class="form__label">
											<label> Почтовый адрес</label>
										</div>

										<?$arQuestion = $arResult["QUESTIONS"]["postal_address"]?>
										<div class="form__control">
											<input class="form__input  form__element" type="text" name="form_text_<?= $arQuestion['STRUCTURE'][0]['ID']?>" value="<?= $arResult['arrVALUES']['form_text_'.$arQuestion["STRUCTURE"][0]["ID"]]?>" placeholder="Введите  почтовый адрес" <?=($arQuestion["REQUIRED"] == "Y" ? $required : '')?>>

											<div class="form__hint">
												Введите  почтовый адрес
											</div>
										</div>
									</div>

									<div class="form__row">
										<div class="form__label">
											<label>ИНН</label>
										</div>

										<?$arQuestion = $arResult["QUESTIONS"]["inn"]?>
										<div class="form__control">
											<input class="form__input  form__element" type="text" name="form_text_<?= $arQuestion['STRUCTURE'][0]['ID']?>" value="<?= $arResult['arrVALUES']['form_text_'.$arQuestion["STRUCTURE"][0]["ID"]]?>" placeholder="Введите номер ИНН" <?=($arQuestion["REQUIRED"] == "Y" ? $required : '')?>>

											<div class="form__hint">
												Введите ИНН
											</div>
										</div>
									</div>

									<div class="form__row">
										<div class="form__label">
											<label>КПП</label>
										</div>

										<?$arQuestion = $arResult["QUESTIONS"]["kpp"]?>
										<div class="form__control">
											<input class="form__input  form__element" type="text" name="form_text_<?= $arQuestion['STRUCTURE'][0]['ID']?>" value="<?= $arResult['arrVALUES']['form_text_'.$arQuestion["STRUCTURE"][0]["ID"]]?>" placeholder="Введите номер КПП" <?=($arQuestion["REQUIRED"] == "Y" ? $required : '')?>>

											<div class="form__hint">
												Введите КПП
											</div>
										</div>
									</div>

									<div class="form__row">
										<div class="form__label">
											<label>ОГРН</label>
										</div>

										<?$arQuestion = $arResult["QUESTIONS"]["ogrn"]?>
										<div class="form__control">
											<input class="form__input  form__element" type="text" name="form_text_<?= $arQuestion['STRUCTURE'][0]['ID']?>" value="<?= $arResult['arrVALUES']['form_text_'.$arQuestion["STRUCTURE"][0]["ID"]]?>" placeholder="ОГРН" <?=($arQuestion["REQUIRED"] == "Y" ? $required : '')?>>

											<div class="form__hint">
												Введите ОГРН
											</div>
										</div>
									</div>

									<div class="form__row">
										<div class="form__label">
											<label>ОКПО</label>
										</div>

										<?$arQuestion = $arResult["QUESTIONS"]["okpo"]?>
										<div class="form__control">
											<input class="form__input  form__element" type="text" name="form_text_<?= $arQuestion['STRUCTURE'][0]['ID']?>" value="<?= $arResult['arrVALUES']['form_text_'.$arQuestion["STRUCTURE"][0]["ID"]]?>" placeholder="Введите ОКПО" <?=($arQuestion["REQUIRED"] == "Y" ? $required : '')?>>

											<div class="form__hint">
												Введите ОКПО
											</div>
										</div>
									</div>

									<div class="form__row">
										<div class="form__label">
											<label>Расчетный счет</label>
										</div>

										<?$arQuestion = $arResult["QUESTIONS"]["payment_account"]?>
										<div class="form__control">
											<input class="form__input  form__element" type="text" name="form_text_<?= $arQuestion['STRUCTURE'][0]['ID']?>" value="<?= $arResult['arrVALUES']['form_text_'.$arQuestion["STRUCTURE"][0]["ID"]]?>" placeholder="Введите номер р/с" <?=($arQuestion["REQUIRED"] == "Y" ? $required : '')?>>

											<div class="form__hint">
												Введите расчетный счет
											</div>
										</div>
									</div>

									<div class="form__row">
										<div class="form__label">
											<label>Банк</label>
										</div>

										<?$arQuestion = $arResult["QUESTIONS"]["bank"]?>
										<div class="form__control">
											<input class="form__input  form__element" type="text" name="form_text_<?= $arQuestion['STRUCTURE'][0]['ID']?>" value="<?= $arResult['arrVALUES']['form_text_'.$arQuestion["STRUCTURE"][0]["ID"]]?>" placeholder="Введите название банка" <?=($arQuestion["REQUIRED"] == "Y" ? $required : '')?>>

											<div class="form__hint">
												Введите банк
											</div>
										</div>
									</div>

									<div class="form__row">
										<div class="form__label">
											<label>БИК</label>
										</div>

										<?$arQuestion = $arResult["QUESTIONS"]["bik"]?>
										<div class="form__control">
											<input class="form__input  form__element" type="text" name="form_text_<?= $arQuestion['STRUCTURE'][0]['ID']?>" value="<?= $arResult['arrVALUES']['form_text_'.$arQuestion["STRUCTURE"][0]["ID"]]?>" placeholder="Введите БИК" <?=($arQuestion["REQUIRED"] == "Y" ? $required : '')?>>

											<div class="form__hint">
												Введите БИК
											</div>
										</div>
									</div>

									<div class="form__row">
										<div class="form__label">
											<label>Корреспондентский счет</label>
										</div>

										<?$arQuestion = $arResult["QUESTIONS"]["correspondent_account"]?>
										<div class="form__control">
											<input class="form__input  form__element" type="text" name="form_text_<?= $arQuestion['STRUCTURE'][0]['ID']?>" value="<?= $arResult['arrVALUES']['form_text_'.$arQuestion["STRUCTURE"][0]["ID"]]?>" placeholder="Введите корреспондентский счет" <?=($arQuestion["REQUIRED"] == "Y" ? $required : '')?>>

											<div class="form__hint">
												Введите корреспондентский счет
											</div>
										</div>
									</div>

									<div class="form__row">
										<div class="form__label">
											<label>Прикрепить сканы необходимых документов</label>
										</div>

										<?$arQuestion = $arResult["QUESTIONS"]["scan"]?>
										<div class="form__control">
											<div class="file-form">
												<button type="button" class="btn  btn--green">Загрузить</button>
												<input class="form__element  file-form__input" type="file" name="form_file_<?= $arQuestion['STRUCTURE'][0]['ID']?>" accept=".jpg, .jpeg, .png, .svg, .pbf" onchange="getNameUploadNext(this.value);" multiple />
												<div class="file-form__label"></div>
											</div>

											<div class="form__hint">
												Прикрепите файлы
											</div>
										</div>
									</div>
								</div>
								
								<div class="form__item">
									<div class="form__row">
										<p>НДС</p>
									</div>

									<?$arQuestion = $arResult["QUESTIONS"]["ndc"]?>
									<?foreach($arQuestion["STRUCTURE"] as $arItem):?>
										<div class="form__row">
											<label class="form__checkbox">
												<input class="js-all-places" type="checkbox" name="form_checkbox_ndc[]" value="<?=$arItem["ID"]?>">
												<span><?=$arItem["MESSAGE"]?></span>
											</label>
										</div>
									<?endforeach;?>
								</div>
								
								<div class="form__item">
									<div class="form__title">
										<h3>Данные руководителя</h3>
									</div>

									<div class="form__row">
										<div class="form__label">
											<label>Фамилия</label>
										</div>

										<?$arQuestion = $arResult["QUESTIONS"]["first_name_boss"]?>
										<div class="form__control">
											<input class="form__input  form__element" type="text" name="form_text_<?= $arQuestion['STRUCTURE'][0]['ID']?>" value="<?= $arResult['arrVALUES']['form_text_'.$arQuestion["STRUCTURE"][0]["ID"]]?>" placeholder="Введите фамилию" <?=($arQuestion["REQUIRED"] == "Y" ? $required : '')?>>

											<div class="form__hint">
												Введите фамилию
											</div>
										</div>
									</div>

									<div class="form__row">
										<div class="form__label">
											<label>Имя</label>
										</div>

										<?$arQuestion = $arResult["QUESTIONS"]["name_boss"]?>
										<div class="form__control">
											<input class="form__input  form__element" type="text" name="form_text_<?= $arQuestion['STRUCTURE'][0]['ID']?>" value="<?= $arResult['arrVALUES']['form_text_'.$arQuestion["STRUCTURE"][0]["ID"]]?>" placeholder="Введите имя" <?=($arQuestion["REQUIRED"] == "Y" ? $required : '')?>>

											<div class="form__hint">
												Введите имя
											</div>
										</div>
									</div>

									<div class="form__row">
										<div class="form__label">
											<label>Отчество</label>
										</div>

										<?$arQuestion = $arResult["QUESTIONS"]["second_name_boss"]?>
										<div class="form__control">
											<input class="form__input  form__element" type="text" name="form_text_<?= $arQuestion['STRUCTURE'][0]['ID']?>" value="<?= $arResult['arrVALUES']['form_text_'.$arQuestion["STRUCTURE"][0]["ID"]]?>" placeholder="Введите отчество" <?=($arQuestion["REQUIRED"] == "Y" ? $required : '')?>>
											
											<div class="form__hint">
												Введите отчество
											</div>
										</div>
									</div>

									<div class="form__row">
										<div class="form__label">
											<label>Адрес</label>
										</div>

										<?$arQuestion = $arResult["QUESTIONS"]["address_boss"]?>
										<div class="form__control">
											<input class="form__input  form__element" type="text" name="form_text_<?= $arQuestion['STRUCTURE'][0]['ID']?>" value="<?= $arResult['arrVALUES']['form_text_'.$arQuestion["STRUCTURE"][0]["ID"]]?>" placeholder="Введите адрес" <?=($arQuestion["REQUIRED"] == "Y" ? $required : '')?>>

											<div class="form__hint">
												Введите адрес
											</div>
										</div>
									</div>

									<div class="form__row">
										<div class="form__label">
											<label>Дата рождения</label>
										</div>

										<?$arQuestion = $arResult["QUESTIONS"]["date_birth_boss"]?>
										<div class="form__control">
											<input class="form__input  form__element" type="text" name="form_text_<?= $arQuestion['STRUCTURE'][0]['ID']?>" value="<?= $arResult['arrVALUES']['form_text_'.$arQuestion["STRUCTURE"][0]["ID"]]?>" placeholder="Введите дату рождения" <?=($arQuestion["REQUIRED"] == "Y" ? $required : '')?>>

											<div class="form__hint">
												Введите дату рождения
											</div>
										</div>
									</div>

									<div class="form__row">
										<div class="form__label">
											<label>Телефон</label>
										</div>

										<?$arQuestion = $arResult["QUESTIONS"]["phone_boss"]?>
										<div class="form__control">
											<input class="form__input  input-phone  form__element" type="text" name="form_text_<?= $arQuestion['STRUCTURE'][0]['ID']?>" value="<?= $arResult['arrVALUES']['form_text_'.$arQuestion["STRUCTURE"][0]["ID"]]?>" placeholder="+7 (XXX) XXX-XX-XX" <?=($arQuestion["REQUIRED"] == "Y" ? $required : '')?>>

											<div class="form__hint">
												Введите телефон
											</div>
										</div>
									</div>

									<div class="form__row">
										<div class="form__label">
											<label>Должность</label>
										</div>

										<?$arQuestion = $arResult["QUESTIONS"]["post_boss"]?>
										<div class="form__control">
										<input class="form__input  form__element" type="text" name="form_text_<?= $arQuestion['STRUCTURE'][0]['ID']?>" value="<?= $arResult['arrVALUES']['form_text_'.$arQuestion["STRUCTURE"][0]["ID"]]?>" placeholder="Введите должность" <?=($arQuestion["REQUIRED"] == "Y" ? $required : '')?>>

											<div class="form__hint">
												Введите должность
											</div>
										</div>
									</div>

									<div class="form__row">
										<div class="form__label">
											<label>E-mail</label>
										</div>

										<?$arQuestion = $arResult["QUESTIONS"]["email_boss"]?>
										<div class="form__control">
											<input class="form__input  form__element" type="email" name="form_email_<?= $arQuestion['STRUCTURE'][0]['ID']?>" value="<?= $arResult['arrVALUES']['form_text_'.$arQuestion["STRUCTURE"][0]["ID"]]?>" placeholder="Введите e-mail" <?=($arQuestion["REQUIRED"] == "Y" ? $required : '')?>>

											<div class="form__hint">
												Введите e-mail
											</div>
										</div>
									</div>
								</div>
								
								<div class="form__item  js-founders">
									<div class="form__title">
										<h3>Учредители</h3>
									</div>

									<div class="form__row">
										<div class="form__label">
											<label>Фамилия</label>
										</div>

										<?$arQuestion = $arResult["QUESTIONS"]["first_name_founder"]?>
										<div class="form__control">
											<input class="form__input  form__element" type="text" name="form_text_<?= $arQuestion['STRUCTURE'][0]['ID']?>" value="<?= $arResult['arrVALUES']['form_text_'.$arQuestion["STRUCTURE"][0]["ID"]]?>" placeholder="Введите фамилию" <?=($arQuestion["REQUIRED"] == "Y" ? $required : '')?>>

											<div class="form__hint">
												Введите фамилию
											</div>
										</div>
									</div>

									<div class="form__row">
										<div class="form__label">
											<label>Имя</label>
										</div>

										<?$arQuestion = $arResult["QUESTIONS"]["name_founder"]?>
										<div class="form__control">
											<input class="form__input  form__element" type="text" name="form_text_<?= $arQuestion['STRUCTURE'][0]['ID']?>" value="<?= $arResult['arrVALUES']['form_text_'.$arQuestion["STRUCTURE"][0]["ID"]]?>" placeholder="Введите имя" <?=($arQuestion["REQUIRED"] == "Y" ? $required : '')?>>

											<div class="form__hint">
												Введите имя
											</div>
										</div>
									</div>

									<div class="form__row">
										<div class="form__label">
											<label>Отчество</label>
										</div>

										<?$arQuestion = $arResult["QUESTIONS"]["second_name_founder"]?>
										<div class="form__control">
											<input class="form__input  form__element" type="text" name="form_text_<?= $arQuestion['STRUCTURE'][0]['ID']?>" value="<?= $arResult['arrVALUES']['form_text_'.$arQuestion["STRUCTURE"][0]["ID"]]?>" placeholder="Введите отчество" <?=($arQuestion["REQUIRED"] == "Y" ? $required : '')?>>

											<div class="form__hint">
												Введите отчество
											</div>
										</div>
									</div>

									<div class="form__row">
										<div class="form__label">
											<label>Гражданство</label>
										</div>

										<?$arQuestion = $arResult["QUESTIONS"]["nationality_founder"]?>
										<div class="form__control">
											<input class="form__input  form__element" type="text" name="form_text_<?= $arQuestion['STRUCTURE'][0]['ID']?>" value="<?= $arResult['arrVALUES']['form_text_'.$arQuestion["STRUCTURE"][0]["ID"]]?>" placeholder="Введите гражданство" <?=($arQuestion["REQUIRED"] == "Y" ? $required : '')?>>

											<div class="form__hint">
												Введите гражданство
											</div>
										</div>
									</div>

									<div class="form__row">
										<div class="form__label">
											<label>Адрес</label>
										</div>

										<?$arQuestion = $arResult["QUESTIONS"]["address_founder"]?>
										<div class="form__control">
											<input class="form__input  form__element" type="text" name="form_text_<?= $arQuestion['STRUCTURE'][0]['ID']?>" value="<?= $arResult['arrVALUES']['form_text_'.$arQuestion["STRUCTURE"][0]["ID"]]?>" placeholder="Введите адрес" <?=($arQuestion["REQUIRED"] == "Y" ? $required : '')?>>

											<div class="form__hint">
												Введите адрес
											</div>
										</div>
									</div>
								</div>
								
								<div class="form__item">
									<div class="form__row">
										<button class="btn  btn--green  js-founders-add" type="button">Добавить</button>
									</div>
								</div>
							</div>

							<div class="registration-form__action">
								<button class="btn  btn--transparent  js-modal-open" data-target="#modal-step-3" type="button">Назад</button>

								<button class="btn  btn--primary  js-submit-step-4" type="submit" disabled>Зарегистрировать кондитерскую</button>
							</div>

							<div class="registration-form__desc">
								<p><?=GetMessage("FORM_AGREE")?></p>
							</div>
						</div>
					</div>
				</section>
			</div>
		</div>
	</div>
	
	<?if($arResult["isUseCaptcha"] == "Y"):?>
		<div class="recaptcha">
			<input id="captchaSid" type="hidden" name="captcha_sid" value="<?=htmlspecialcharsbx($arResult["CAPTCHACode"]);?>" />
			<img id="reloadCaptcha" src="/bitrix/tools/captcha.php?captcha_sid=<?=htmlspecialcharsbx($arResult["CAPTCHACode"]);?>" width="180" height="40" />
			<input type="text" name="captcha_word" size="30" maxlength="50" value="" class="inputtext" placeholder="<?=GetMessage('FORM_CAPTCHA_PLACEHOLDER')?>" <?=$required?> />
		</div>
	<?endif;?>
	
	<input type="hidden" name="web_form_submit" value="<?=htmlspecialcharsbx(strlen(trim($arResult["arForm"]["BUTTON"])) <= 0 ? GetMessage("FORM_ADD") : $arResult["arForm"]["BUTTON"]);?>" />
	<input type="hidden" name="web_form_apply" value="Y" />
	
<?=$arResult["FORM_FOOTER"];?>