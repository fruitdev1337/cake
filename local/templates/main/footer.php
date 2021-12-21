<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();?>

    </div>
</div>

        <div class="product_card_fast" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
            <div class="fast_wrapper">
                <div class="preloader-wrapper">
                    <div class="loader">
                        <span></span>
                        <span></span>
                        <span></span>
                    </div>
                </div>
                <div class="fast_elem_wrapper">
                    <button class="close-btn" data-dismiss="modal"></button>
                    <div class="add_el"></div>
                </div>
            </div>
        </div>

        <div class="popup_mask"></div>

        <div class="mail-subscribe-container">
            <div class="mail-subscribe">
                <div class="subscribe-row row align-items-center justify-content-center">
                    <div class="subscribe-col col-lg-5 col-12">
                        <div class="subscribe-title">
                            <?php $APPLICATION->IncludeFile(SITE_DIR.'include/subscribe-title.php') ?>
                        </div>
                    </div>
                    <div class="subscribe-col col-lg-7 col-12">
                        <?$APPLICATION->IncludeComponent(
							"bitrix:sender.subscribe", 
							"subscribe", 
							array(
								"AJAX_MODE" => "Y",
								"AJAX_OPTION_ADDITIONAL" => "",
								"AJAX_OPTION_HISTORY" => "N",
								"AJAX_OPTION_JUMP" => "N",
								"AJAX_OPTION_STYLE" => "Y",
								"CACHE_TIME" => "3600",
								"CACHE_TYPE" => "A",
								"CONFIRMATION" => "N",
								"HIDE_MAILINGS" => "Y",
								"SET_TITLE" => "N",
								"SHOW_HIDDEN" => "N",
								"USER_CONSENT" => "Y",
								"USER_CONSENT_ID" => "1",
								"USER_CONSENT_IS_CHECKED" => "Y",
								"USER_CONSENT_IS_LOADED" => "Y",
								"USE_PERSONALIZATION" => "Y",
								"COMPONENT_TEMPLATE" => "subscribe"
							),
							false
						);?>
                    </div>
                </div>
            </div>
        </div>

		<?php $APPLICATION->IncludeFile(SITE_DIR.'include/form_registration.php') ?>

        <footer class="footer">
            <div class="wrapper-inner">
                <div class="footer-content">
                    <div class="footer-top">
                        <div class="row">
                            <div class="footer-item col-lg-2 col-12 footer-item-logo text-lg-left text-center">
                                <a href="<?=SITE_DIR;?>" class="logo bottom-logo">
                                    <?php $APPLICATION->IncludeFile(SITE_DIR.'include/f_logo-inner.php') ?>
                                </a>
                                <div class="footer-phone row">
                                    <div class="col-lg-12 col-sm-6">
                                        <?php $APPLICATION->IncludeFile(SITE_DIR.'include/bottom-phone.php') ?>
                                    </div>
                                    <div class="col-lg-12 col-sm-6">
                                        <?/*
										<button type="button" class="feedback-btn mt-2" data-toggle="modal" data-target="#feedbackModal"><?=\Bitrix\Main\Localization\Loc::getMessage('K_FEEDBACK_BTN')?></button>
										*/?>
                                    </div>
                                </div>
                            </div>
                            <div class="footer-item col-lg-7 col-12 footer-item-menu-list text-lg-left text-center my-lg-0 my-4 py-lg-0 py-3">
                                <div class="row">
                                    <div class="col-sm-4">
                                        <div class="footer-item-menu mb-sm-0 mb-3">
                                            <div class="footer-item-title">
                                                <?php $APPLICATION->IncludeFile(SITE_DIR.'include/footer-title_2.php') ?>
                                            </div>
                                            <div class="navigation-box">
                                                <?$APPLICATION->IncludeComponent(
                                                    "bitrix:menu",
                                                    "bottom",
                                                    array(
                                                        "ALLOW_MULTI_SELECT" => "N",
                                                        "CHILD_MENU_TYPE" => "bottom2",
                                                        "DELAY" => "N",
                                                        "MAX_LEVEL" => "1",
                                                        "MENU_CACHE_GET_VARS" => array(
                                                        ),
                                                        "MENU_CACHE_TIME" => "3600",
                                                        "MENU_CACHE_TYPE" => "A",
                                                        "MENU_CACHE_USE_GROUPS" => "Y",
                                                        "ROOT_MENU_TYPE" => "bottom2",
                                                        "USE_EXT" => "N",
                                                        "COMPONENT_TEMPLATE" => "bottom"
                                                    ),
                                                    false
                                                );?>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="footer-item-menu">
                                            <div class="footer-item-title">
                                                <?php $APPLICATION->IncludeFile(SITE_DIR.'include/footer-title_1.php') ?>
                                            </div>
                                            <div class="navigation-box">
                                                <?$APPLICATION->IncludeComponent(
                                                    "bitrix:menu",
                                                    "bottom",
                                                    array(
                                                        "ALLOW_MULTI_SELECT" => "N",
                                                        "CHILD_MENU_TYPE" => "bottom_cat",
                                                        "DELAY" => "N",
                                                        "MAX_LEVEL" => "1",
                                                        "MENU_CACHE_GET_VARS" => array(
                                                        ),
                                                        "MENU_CACHE_TIME" => "3600",
                                                        "MENU_CACHE_TYPE" => "A",
                                                        "MENU_CACHE_USE_GROUPS" => "Y",
                                                        "ROOT_MENU_TYPE" => "bottom",
                                                        "USE_EXT" => "Y",
                                                        "COMPONENT_TEMPLATE" => "bottom"
                                                    ),
                                                    false
                                                );?>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="footer-item-menu">
                                            <div class="footer-item-title">
                                                <?php $APPLICATION->IncludeFile(SITE_DIR.'include/footer-title_3.php') ?>
                                            </div>
                                            <div class="navigation-box">
                                                <?$APPLICATION->IncludeComponent(
                                                    "bitrix:menu",
                                                    "bottom",
                                                    array(
                                                        "ALLOW_MULTI_SELECT" => "N",
                                                        "CHILD_MENU_TYPE" => "bottom_3",
                                                        "DELAY" => "N",
                                                        "MAX_LEVEL" => "1",
                                                        "MENU_CACHE_GET_VARS" => array(
                                                        ),
                                                        "MENU_CACHE_TIME" => "3600",
                                                        "MENU_CACHE_TYPE" => "A",
                                                        "MENU_CACHE_USE_GROUPS" => "Y",
                                                        "ROOT_MENU_TYPE" => "bottom3",
                                                        "USE_EXT" => "Y",
                                                        "COMPONENT_TEMPLATE" => "bottom"
                                                    ),
                                                    false
                                                );?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="footer-item col-lg-3 col-12 pl-lg-0 footer-item-text-wrapper text-lg-left text-center">
                                <?php $APPLICATION->IncludeFile(SITE_DIR.'include/footer-social.php') ?>
                                <div class="footer-item-pays">
                                    <?php $APPLICATION->IncludeFile(SITE_DIR.'include/footer_pay_icon.php') ?>
                                </div>
                                <div id="bx-composite-banner" style=" margin-top: 10px;"></div>
                            </div>
                        </div>
                    </div>
                    <div class="footer-bottom">
                        <div class="footer-item-copy">
                            <div class="row align-items-center text-lg-left text-center">
                                <div class="col-lg col-12">
                                  
                                    <span><?php echo date("Y");?> ©</span> <span><?php $APPLICATION->IncludeFile(SITE_DIR.'include/copy.php') ?></span>
                                    
                                </div>
                                <div class="col-lg-auto col-12 mt-lg-0 mt-2">
                                  
                                        <span>&copy;</span> <a href="https://ttcsoft.ru/" target="_blank"><?=\Bitrix\Main\Localization\Loc::getMessage('K_COPY_DEV_WEB')?></a>
                                   
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </footer>

        <div class="feedback-window modal fade" id="feedbackModal" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <button type="button" class="close-btn" data-dismiss="modal"></button>
            <?$APPLICATION->IncludeComponent(
                "krayt:main.feedback",
                ".default",
                array(
                    "COMPONENT_TEMPLATE" => ".default",
                    "EMAIL_TO" => "food@retail.ru",
                    "EVENT_MESSAGE_ID" => array(
                    ),
                    "OK_TEXT" => \Bitrix\Main\Localization\Loc::getMessage('K_FEEDBACK_OK'),
                    "REQUIRED_FIELDS" => array(
                        0 => "NAME",
                        1 => "EMAIL",
                        2 => "PHONE",
                        3 => "MESSAGE",
                    ),
                    "USE_CAPTCHA" => "Y",
                    "AJAX_MODE" => "Y",
                    "AJAX_OPTION_SHADOW" => "N",
                    "AJAX_OPTION_JUMP" => "N",
                    "AJAX_OPTION_STYLE" => "Y",
                    "AJAX_OPTION_HISTORY" => "N",
                    "USER_CONSENT" => "Y",
                    "USER_CONSENT_ID" => "1",
                    "USER_CONSENT_IS_CHECKED" => "Y",
                    "USER_CONSENT_IS_LOADED" => "Y"
                ),
                false
            );?>
                </div>
            </div>
        </div>

    <?php $APPLICATION->IncludeFile(SITE_DIR.'include/metrica.php') ?>
	
		<!-- JS Forms -->
		<script src="<?=SITE_TEMPLATE_PATH?>/js/forms/libs.min.js"></script>
		<script src="<?=SITE_TEMPLATE_PATH?>/js/forms/form.min.js"></script>	
    </body>
</html>
