<!-- Start Form -->
<div id="modal-action" class="modal  modal--transparent" data-scroll-lock-scrollable>
	<div class="modal__overlay"></div>

	<div class="modal__window">
		<div class="modal__close">
			<button class="js-modal-close" aria-label="Закрыть" type="button">
				<img src="<?=SITE_TEMPLATE_PATH?>/img/close.svg" width="21" height="21" alt="">
			</button>
		</div>

		<div class="modal__content">
			<section class="scene">
				<div class="grid  grid--double">
					<div class="grid__item">
						<div class="feedback-card">
							<div class="feedback-card__title">
								<h2>Зарегистрироваться</h2>
							</div>

							<div class="feedback-card__text">
								<p>Вы хотите стать партнёром площадки и готовы предоставить развёрнутую информацию о Вашей компании, включая юридические данные? Тогда предлагаем Вам перейти к регистрации</p>
							</div>

							<div class="feedback-card__action">
								<button class="btn  btn--primary  js-modal-open" data-target="#modal-step-1">Перейти к регистрации</button>
							</div>
						</div>
					</div>

					<div class="grid__item">
						<div class="feedback-card">
							<div class="feedback-card__title">
								<h2>Связаться с администрацией площадки</h2>
							</div>

							<div class="feedback-card__text">
								<p>Хотите стать партнёром площадки, но у Вас есть вопросы? Отправьте нам запрос, используя форму. Мы обязательно свяжемся с Вами в ближайшее время.</p>
							</div>

							<div class="feedback-card__action">
								<button class="btn  btn--green  js-modal-open" data-target="#modal-feedback">Перейти к форме</button>
							</div>
						</div>
					</div>
				</div>
			</section>
		</div>
	</div>
</div>

<?$APPLICATION->IncludeComponent(
	"bitrix:form.result.new", 
	"feedback", 
	array(
		"AJAX_MODE" => "Y",
		"AJAX_OPTION_HISTORY" => "N",
		"AJAX_OPTION_JUMP" => "N",
		"AJAX_OPTION_SHADOW" => "N",
		"AJAX_OPTION_STYLE" => "Y",
		"CACHE_TIME" => "3600",
		"CACHE_TYPE" => "A",
		"CHAIN_ITEM_LINK" => "",
		"CHAIN_ITEM_TEXT" => "",
		"EDIT_URL" => "",
		"IGNORE_CUSTOM_TEMPLATE" => "N",
		"LIST_URL" => "",
		"SEF_MODE" => "N",
		"SUCCESS_URL" => "",
		"USE_EXTENDED_ERRORS" => "Y",
		"WEB_FORM_ID" => "1",
		"COMPONENT_TEMPLATE" => "feedback",
		"VARIABLE_ALIASES" => array(
			"WEB_FORM_ID" => "WEB_FORM_ID",
			"RESULT_ID" => "RESULT_ID",
		)
	),
	false
);?>

<?$APPLICATION->IncludeComponent(
	"bitrix:form.result.new", 
	"registration", 
	array(
		"AJAX_MODE" => "Y",
		"AJAX_OPTION_HISTORY" => "N",
		"AJAX_OPTION_JUMP" => "N",
		"AJAX_OPTION_SHADOW" => "N",
		"AJAX_OPTION_STYLE" => "Y",
		"CACHE_TIME" => "3600",
		"CACHE_TYPE" => "A",
		"CHAIN_ITEM_LINK" => "",
		"CHAIN_ITEM_TEXT" => "",
		"EDIT_URL" => "",
		"IGNORE_CUSTOM_TEMPLATE" => "N",
		"LIST_URL" => "",
		"SEF_MODE" => "N",
		"SUCCESS_URL" => "",
		"USE_EXTENDED_ERRORS" => "Y",
		"WEB_FORM_ID" => "2",
		"COMPONENT_TEMPLATE" => "registration",
		"VARIABLE_ALIASES" => array(
			"WEB_FORM_ID" => "WEB_FORM_ID",
			"RESULT_ID" => "RESULT_ID",
		)
	),
	false
);?>

<div id="modal-submit" class="modal" data-scroll-lock-scrollable>
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
							<h2>Ваша кондитесркая успешно зарегистрирована.</h2>
						</div>

						<div class="registration-form__subtitle">
							<p>В ближайшее время мы свяжемся с вами для уточнения информации.</p>
						</div>

						<div class="registration-form__action  registration-form__action--center">
							<a class="btn  btn--primary" href="/">На главную</a>
						</div>
					</div>
				</div>
			</section>
		</div>
	</div>
</div>

<!-- End Form -->