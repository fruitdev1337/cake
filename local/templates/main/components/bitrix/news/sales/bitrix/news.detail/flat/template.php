<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();                        
if(\Bitrix\Main\Loader::includeSharewareModule("krayt.retail") == \Bitrix\Main\Loader::MODULE_DEMO_EXPIRED || 
   \Bitrix\Main\Loader::includeSharewareModule("krayt.retail") ==  \Bitrix\Main\Loader::MODULE_NOT_FOUND
    )
{ return false;}
/** @var array $arParams */
/** @var array $arResult */
/** @global CMain $APPLICATION */
/** @global CUser $USER */
/** @global CDatabase $DB */
/** @var CBitrixComponentTemplate $this */
/** @var string $templateName */
/** @var string $templateFile */
/** @var string $templateFolder */
/** @var string $componentPath */
/** @var CBitrixComponent $component */
use Bitrix\Main\Localization\Loc;
$this->setFrameMode(true);
?>


	<div class="promo-detail-block" id="<?echo $this->GetEditAreaId($arResult['ID'])?>">
        <div class="promo-detail-top-row">
            <div class="promo-detail-top-col">
                <div class="promo-detail-top-image">
                    <?if($arParams["DISPLAY_PICTURE"]!="N" || (is_array($arResult["DETAIL_PICTURE"]))):?>
                        <div class="promo-detail-image-wrapper">
                            <img class="promo-detail-img"
                                 src="<?=$arResult["DETAIL_PICTURE"]["SRC"]?>"
                                 width="<?=$arResult["DETAIL_PICTURE"]["WIDTH"]?>"
                                 height="<?=$arResult["DETAIL_PICTURE"]["HEIGHT"]?>"
                                 alt="<?=$arResult["DETAIL_PICTURE"]["ALT"]?>"
                                 title="<?=$arResult["DETAIL_PICTURE"]["TITLE"]?>"
                            />
                        </div>
                    <?endif?>
                    <div class="promo-list-dates-row row justify-content-between no-gutters">
                        <div class="col-md-auto col-12">
                            <div class="promo-list-dates">
                                <span class="fa fa-calendar"></span>
                                <span>
                                    <?= Loc::getMessage("K_ACTION_TIME", array(
                                        "#START#" => salesTime($arResult['DATE_ACTIVE_FROM']),
                                        "#END#" => salesTime($arResult['DATE_ACTIVE_TO']),
                                    ));?>
                            </div>
                        </div>
                        <div class="col-md-auto col-12">
                            <div class="promo-list-dates">
                            <?if(getDiffTime($arResult["DATE_ACTIVE_TO"])):?>
                                <span><?=Loc::getMessage('K_DAY_ACTION')?></span>
                                <span class="count"><?echo getDiffTime($arResult["DATE_ACTIVE_TO"])?></span>
                            <?else:?>
                                <span><?=Loc::getMessage('K_ACTION_DAY_END')?></span>
                            <?endif;?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="receipt-detail-top-col mt-3">
                <div class="promo-detail-content">
                    <?if(strlen($arResult["DETAIL_TEXT"])>0):?>
                        <?echo $arResult["DETAIL_TEXT"];?>
                    <?else:?>
                        <?echo $arResult["PREVIEW_TEXT"];?>
                    <?endif?>
                </div>
            </div>
        </div>





	<div class="row">
		<div class="col-5">
		</div>
	<?
	if ($arParams["USE_SHARE"] == "Y")
	{
		?>
		<div class="col-7 text-right">
			<noindex>
			<?
			$APPLICATION->IncludeComponent("bitrix:main.share", $arParams["SHARE_TEMPLATE"], array(
					"HANDLERS" => $arParams["SHARE_HANDLERS"],
					"PAGE_URL" => $arResult["~DETAIL_PAGE_URL"],
					"PAGE_TITLE" => $arResult["~NAME"],
					"SHORTEN_URL_LOGIN" => $arParams["SHARE_SHORTEN_URL_LOGIN"],
					"SHORTEN_URL_KEY" => $arParams["SHARE_SHORTEN_URL_KEY"],
					"HIDE" => $arParams["SHARE_HIDE"],
				),
				$component,
				array("HIDE_ICONS" => "Y")
			);
			?>
			</noindex>
		</div>
		<?
	}
	?>
	</div>
	</div>


<script type="text/javascript">
	BX.ready(function() {
		var slider = new JCNewsSlider('<?=CUtil::JSEscape($this->GetEditAreaId($arResult['ID']));?>', {
			imagesContainerClassName: 'promo-detail-slider-container',
			leftArrowClassName: 'promo-detail-slider-arrow-container-left',
			rightArrowClassName: 'promo-detail-slider-arrow-container-right',
			controlContainerClassName: 'promo-detail-slider-control'
		});
	});
</script>
