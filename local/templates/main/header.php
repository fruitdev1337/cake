<?php
  if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)   die();

use Bitrix\Main\Localization\Loc;
use Bitrix\Main\Loader;
Loc::loadLanguageFile(__FILE__);
if(\Bitrix\Main\Loader::includeSharewareModule("krayt.retail") == \Bitrix\Main\Loader::MODULE_DEMO_EXPIRED ||
    \Bitrix\Main\Loader::includeSharewareModule("krayt.retail") ==  \Bitrix\Main\Loader::MODULE_NOT_FOUND
)
{
    $APPLICATION->IncludeFile(SITE_DIR.'include/alert_install.php');
    die();
}

CJSCore::Init(array("fx"));
global  $USER;
?>
<!DOCTYPE html>
<html lang="<?=LANGUAGE_ID?>">
    <head>
	
		<!-- Google Tag Manager -->
		<script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
		new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
		j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
		'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
		})(window,document,'script','dataLayer','GTM-PG66342');</script>
		<!-- End Google Tag Manager -->
	

        <meta name="viewport"
              content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <?php
        // JS libraries
        $APPLICATION->AddHeadScript(SITE_TEMPLATE_PATH."/js/lib/jquery-3.2.1_min.js");
        $APPLICATION->AddHeadScript(SITE_TEMPLATE_PATH."/js/lib/owl.carousel.js");
        $APPLICATION->AddHeadScript(SITE_TEMPLATE_PATH."/js/lib/jquery.cookie.js");
        $APPLICATION->AddHeadScript(SITE_TEMPLATE_PATH."/js/lib/bootstrap.min.js");
        $APPLICATION->AddHeadScript(SITE_TEMPLATE_PATH."/js/lib/jquery.fancybox.js");
        $APPLICATION->AddHeadScript(SITE_TEMPLATE_PATH."/js/lib/swiper.min.js");
        $APPLICATION->AddHeadScript(SITE_TEMPLATE_PATH."/js/lib/mCustomScrollbar.min.js");
        $APPLICATION->AddHeadScript(SITE_TEMPLATE_PATH."/js/script.js?v=0.5");

        // CSS libraries
        $APPLICATION->SetAdditionalCSS(SITE_TEMPLATE_PATH."/css/owl.carousel.css");
        $APPLICATION->SetAdditionalCSS(SITE_TEMPLATE_PATH."/css/swiper.min.css");
        $APPLICATION->SetAdditionalCSS(SITE_TEMPLATE_PATH."/css/bootstrap_v4.css");
        $APPLICATION->SetAdditionalCSS(SITE_TEMPLATE_PATH."/css/font-awesome.css");
        $APPLICATION->SetAdditionalCSS(SITE_TEMPLATE_PATH."/css/mCustomScrollbar.css");
        $APPLICATION->SetAdditionalCSS(SITE_TEMPLATE_PATH."/css/jquery.fancybox.min.css");
        
		$APPLICATION->SetAdditionalCSS(SITE_TEMPLATE_PATH."/css/custom.css?v0.21", true);
		
		// CSS forms
		$APPLICATION->SetAdditionalCSS(SITE_TEMPLATE_PATH."/css/forms/index.min.css");

        $APPLICATION->ShowHead();
        ?>
        <title><?php $APPLICATION->ShowTitle();?></title>
		
		<?require($_SERVER["DOCUMENT_ROOT"] . "/include/pixel.php");?>
    </head>
    <body class="">
	
	<!-- Google Tag Manager (noscript) -->
	<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-PG66342"
	height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
	<!-- End Google Tag Manager (noscript) -->

	
    <?$APPLICATION->ShowPanel();?>
    <?if(CModule::IncludeModule("advertising")):?>
    <?$APPLICATION->IncludeComponent(
        "bitrix:advertising.banner",
        "top-banner",
        Array(
            "BS_ARROW_NAV" => "Y",
            "BS_BULLET_NAV" => "Y",
            "BS_CYCLING" => "N",
            "BS_EFFECT" => "fade",
            "BS_HIDE_FOR_PHONES" => "N",
            "BS_HIDE_FOR_TABLETS" => "N",
            "BS_KEYBOARD" => "Y",
            "BS_WRAP" => "Y",
            "CACHE_TIME" => "0",
            "CACHE_TYPE" => "A",
            "DEFAULT_TEMPLATE" => "-",
            "NOINDEX" => "N",
            "QUANTITY" => "1",
            "TYPE" => "TOP_BANNER"
        )
    );?>
    <?endif;?>
        <header class="header">
            <div class="wrapper-inner">
                <div class="header-top">
                    <div class="ht-content">
                        <div class="header-top-line" id="header-top-line">
                            <div class="col-left">
                                <div class="row align-items-center">
                                    <div class="col-auto logo-header" style="width: 210px;">
                                        <div class="hamburger visible-xs">
                                            <span class="line"></span>
                                        </div>
                                        <a href="<?=SITE_DIR;?>" class="logo top-logo">
                                            <?php $APPLICATION->IncludeFile(SITE_DIR.'include/logo-inner.php') ?>
                                        </a>
                                    </div>
                                    <div class="col-auto">
                                        <div class="navigation-box top-menu">
                                            <? $APPLICATION->IncludeComponent(
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
													"ROOT_MENU_TYPE" => "top",
													"USE_EXT" => "N",
													"COMPONENT_TEMPLATE" => "bottom"
												),
												false
											); ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-right">
                                <div class="header-phone">
                                    <?php $APPLICATION->IncludeFile(SITE_DIR.'include/top-phone.php') ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="header-bottom">
                    <div class="hb-content">
                        <div class="header-bottom-line wrapper-inner">
                            <div class="header-bottom-row row align-items-center menu-fixed">
								<div class="navigation-box top-menu">
									<? $APPLICATION->IncludeComponent(
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
											"ROOT_MENU_TYPE" => "top",
											"USE_EXT" => "N",
											"COMPONENT_TEMPLATE" => "bottom"
										),
										false
									); ?>									
								</div>
							</div>
							<div class="header-bottom-row row align-items-center">
                                <div class="hamburger visible-xs">
                                    <span class="line"></span>
                                </div>
                                <div class="top-nav-wrapper col-auto pr-0">
                                    <div class="top-nav-wrapper-overflow">

                                        <div class="icon-box_item">
                                            <? $APPLICATION->IncludeComponent("bitrix:system.auth.form", "top_auth", Array(
                                                "FORGOT_PASSWORD_URL" => "",	// Страница забытого пароля
                                                "PROFILE_URL" => SITE_DIR."personal",	// Страница профиля
                                                "REGISTER_URL" => SITE_DIR."personal/",	// Страница регистрации
                                                "SHOW_ERRORS" => "N",	// Показывать ошибки
                                                "COMPONENT_TEMPLATE" => ""
                                            ),
                                                false
                                            ); ?>
                                        </div>

                                        <div class="top-catalog-menu">
                                            <a href="<?=SITE_DIR?>catalog/" class="top-catalog-menu-title btn-primary" title="<?=Loc::getMessage('K_LINK_CATALOG')?>">
                                                <span><?=Loc::getMessage('K_LINK_CATALOG')?></span>
                                                <span class="fa fa-angle-down"></span>
                                            </a>
                                            <div class="bx-top-nav-wrapper">
                                                <div class="bx-top-nav-box">
                                                    <div class="bx-top-nav-menu">
                                                        <?php $APPLICATION->IncludeFile(SITE_DIR.'include/header_catalog_menu.php') ?>
                                                    </div>
                                                    <div class="bx-top-nav-banner-wrapper">
                                                        <?php $APPLICATION->IncludeFile(SITE_DIR.'include/header_banner_menu.php') ?>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="navigation-container visible-xs">
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
                                <div class="logo col-auto pr-0">
                                    <a href="<?=SITE_DIR;?>" class="top-logo">
                                        <?php $APPLICATION->IncludeFile(SITE_DIR.'include/logo-inner.php') ?>
                                    </a>
                                </div>
                                <div class="top-search col" id="search_in">
                                    <a href="" class="icon-box-link search-link visible-xs">
                                        <span class="icon-item fa fa-search"></span>
                                    </a>
                                    <div class="search_wrapper">
                                        <div class="search__input">
                                            <?$APPLICATION->IncludeComponent(
												"bitrix:search.title", 
												"main", 
												array(
													"CATEGORY_0" => array(
														0 => "iblock_offers",
														1 => "iblock_catalog",
													),
													"CATEGORY_0_TITLE" => "main",
													"CATEGORY_0_iblock_catalog" => array(
														0 => "all",
													),
													"CATEGORY_0_iblock_offers" => array(
														0 => "all",
													),
													"CHECK_DATES" => "N",
													"CONTAINER_ID" => "title-search",
													"INPUT_ID" => "title-search-input",
													"NUM_CATEGORIES" => "1",
													"ORDER" => "rank",
													"PAGE" => "#SITE_DIR#catalog/search.php",
													"SHOW_INPUT" => "Y",
													"SHOW_OTHERS" => "N",
													"TOP_COUNT" => "5",
													"USE_LANGUAGE_GUESS" => "N",
													"COMPONENT_TEMPLATE" => "main",
													"TEMPLATE_THEME" => "",
													"PRICE_CODE" => array(
														0 => "ru",
													),
													"PRICE_VAT_INCLUDE" => "Y",
													"PREVIEW_TRUNCATE_LEN" => "",
													"SHOW_PREVIEW" => "Y",
													"CONVERT_CURRENCY" => "N",
													"PREVIEW_WIDTH" => "75",
													"PREVIEW_HEIGHT" => "75",
													"CATEGORY_1_TITLE" => "",
													"CATEGORY_1" => "",
													"CATEGORY_0_iblock_info" => array(
														0 => "8",
													)
												),
												false
											);?>

                                        </div>
                                    </div>
                                </div>
                                <div class="top-icon-box col-auto">
                                    <div class="icon-box_item" id="user">
                                        <? $APPLICATION->IncludeComponent("bitrix:system.auth.form", "top_auth", Array(
                                            "FORGOT_PASSWORD_URL" => "",	// Страница забытого пароля
                                            "PROFILE_URL" => SITE_DIR."personal",	// Страница профиля
                                            "REGISTER_URL" => SITE_DIR."personal/",	// Страница регистрации
                                            "SHOW_ERRORS" => "N",	// Показывать ошибки
                                            "COMPONENT_TEMPLATE" => ""
                                        ),
                                            false
                                        );
                                        ?>
                                    </div>
                                    <div class="icon-box_item" id="favour_in">
                                        <a href="<?=SITE_DIR;?>favorite/" class=" icon-box-link">
                                            <span class="icon-item favour-icon">
                                                <span class="goods_icon-counter">0</span>
                                            </span>
                                            <span style="display: none;" class="icon-txt"><?=Loc::getMessage('K_TITLE_PERRFORMER')?></span>
                                        </a>
                                    </div>
                                    <div class="icon-box_item_line"></div>
                                    <div class="icon-box_item" id="basket_in">
                                        <?$APPLICATION->IncludeComponent(
											"bitrix:sale.basket.basket.line", 
											"top_cart", 
											array(
												"HIDE_ON_BASKET_PAGES" => "Y",
												"PATH_TO_BASKET" => SITE_DIR."basket/",
												"PATH_TO_ORDER" => SITE_DIR."personal/order/",
												"PATH_TO_PERSONAL" => SITE_DIR."personal/",
												"PATH_TO_PROFILE" => SITE_DIR."personal/",
												"PATH_TO_REGISTER" => SITE_DIR."login/",
												"POSITION_FIXED" => "N",
												"POSITION_HORIZONTAL" => "right",
												"POSITION_VERTICAL" => "top",
												"SHOW_AUTHOR" => "Y",
												"SHOW_DELAY" => "N",
												"SHOW_EMPTY_VALUES" => "Y",
												"SHOW_IMAGE" => "Y",
												"SHOW_NOTAVAIL" => "N",
												"SHOW_NUM_PRODUCTS" => "Y",
												"SHOW_PERSONAL_LINK" => "N",
												"SHOW_PRICE" => "Y",
												"SHOW_PRODUCTS" => "Y",
												"SHOW_SUMMARY" => "Y",
												"SHOW_TOTAL_PRICE" => "Y",
												"COMPONENT_TEMPLATE" => "top_cart",
												"PATH_TO_AUTHORIZE" => SITE_DIR."login/",
												"SHOW_REGISTRATION" => "Y",
												"MAX_IMAGE_SIZE" => "70"
											),
											false
										);?>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </header>
        <div class="main_content" <?=($APPLICATION->GetCurDir() == SITE_DIR.'contacts/' ? 'style="margin-bottom:0;"' : '');?>>
            <div class="wrapper-inner">

            <?php if($APPLICATION->GetCurDir() != SITE_DIR){?>
                <div id="breadcrumbs" class="breadcrumbs breadcrumb" aria-label="breadcrumb">
                        <?$APPLICATION->IncludeComponent("bitrix:breadcrumb", "main", Array(
                            "PATH" => "",
                                "SITE_ID" => SITE_ID,
                                "START_FROM" => "0",
                            ),
                            false
                        );?>
                </div>
            <?php }?>