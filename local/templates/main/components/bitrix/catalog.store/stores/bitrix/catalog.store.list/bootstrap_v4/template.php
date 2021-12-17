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
if(strlen($arResult["ERROR_MESSAGE"])>0)
	ShowError($arResult["ERROR_MESSAGE"]);
//$arPlacemarks = array();
$gpsN = '';
$gpsS = '';
?>
<? if(is_array($arResult["STORES"]) && !empty($arResult["STORES"])){?>
    <div class="row">
        <div class="col-lg-4 d-lg-block d-none">
            <div id="storesTabList">
                <ul class="nav nav-tabs" id="storesTab" role="tablist">
                    <?
                    $i=1;
                    foreach($arResult["STORES"] as $pid=>$arProperty):?>
                        <li class="nav-item box_shadow">
                            <button class="nav-link"
                                    id="store_<?=$arProperty["ID"]?>-tab"
                                    data-target="#store_<?=$arProperty["ID"]?>"
                                    data-toggle="tab"
                                    role="tab"
                                    aria-controls="store_<?=$arProperty["ID"]?>"
                                    aria-selected="<?=($i == 1 ? 'true' : 'false')?>">
                                <div class="store-item">
                                    <div class="catalog-stores-item-title mb-3">
                                        <div class="catalog-stores-item-name"><?=$arProperty["TITLE"]?></div>
                                        <?if ($arProperty["DESCRIPTION"]=='' && $arProperty["ADDRESS"]!=''):?>
                                            <div class="catalog-stores-address"><?=$arProperty["DESCRIPTION"]?></div>
                                        <?elseif ($arProperty["ADDRESS"]=='' && $arProperty["DESCRIPTION"]!=''):?>
                                            <div class="catalog-stores-address"><?=$arProperty["ADDRESS"]?></div>
                                        <?else:?>
                                            <div class="catalog-stores-item-address"><?=$arProperty["ADDRESS"]?></div>
                                        <?endif;?>
                                    </div>

                                    <? if(isset($arProperty["PHONE"]) || isset($arProperty["SCHEDULE"])) { ?>
                                        <div class="catalog-stores-item-info">
                                            <? if(isset($arProperty["SCHEDULE"]) && $arProperty["PHONE"] != ''):?>
                                                <div class="catalog-stores-item-schhedule mb-3">
                                                    <div class="subtitle text-muted"><?=\Bitrix\Main\Localization\Loc::getMessage('S_SCHEDULE')?></div>
                                                    <div style="font-weight: bold;"><?=$arProperty["SCHEDULE"]?></div>
                                                </div>
                                            <?endif;?>
                                            <? if(isset($arProperty["PHONE"]) && $arProperty["PHONE"] != ''):?>
                                                <div class="catalog-stores-item-phone" itemprop="telephone">
                                                    <div class="subtitle text-muted"><?=\Bitrix\Main\Localization\Loc::getMessage('S_PHONE')?></div>
                                                    <a href="tel:<?=$arProperty['PHONE_URL'];?>" style="font-weight: bold;"><?=$arProperty["PHONE"]?></a>
                                                </div>
                                            <?endif;?>
                                        </div>
                                    <? } ?>
                                </div>
                            </button>
                        </li>
                        <?$i++;
                    endforeach;?>
                </ul>
            </div>
        </div>
        <div class="col-lg-8 col-12">
            <div class="tab-content box_shadow" id="storesTabContent">
                <?
                $i=1;
                foreach($arResult["STORES"] as $pid=>$arProperty):?>
                    <div class="tab-pane"
                         id="store_<?=$arProperty["ID"]?>"
                         role="tabpanel"
                         aria-labelledby="store_<?=$arProperty["ID"]?>-tab">
                        <button class="title d-lg-none d-block<?=($i == 1 ? '' : ' collapsed')?>"
                                data-toggle="collapse"
                                data-target="#store_<?=$arProperty["ID"]?>-tab" role="button"
                                aria-expanded="false" aria-controls="store_<?=$arProperty["ID"]?>">
                            <span class="catalog-stores-item-title">
                                <span class="catalog-stores-item-name"><?=$arProperty["TITLE"]?></span>
                                <?if ($arProperty["DESCRIPTION"]=='' && $arProperty["ADDRESS"]!=''):?>
                                    <div class="catalog-stores-address"><?=$arProperty["DESCRIPTION"]?></div>
                                <?elseif ($arProperty["ADDRESS"]=='' && $arProperty["DESCRIPTION"]!=''):?>
                                    <div class="catalog-stores-address"><?=$arProperty["ADDRESS"]?></div>
                                <?else:?>
                                    <div class="catalog-stores-item-address"><?=$arProperty["ADDRESS"]?></div>
                                <?endif;?>
                            </span>
                            <span class="fa fa-angle-up"></span>
                        </button>
                        <div class="tab_box <?=($i == 1 ? ' show' : '')?>" id="store_<?=$arProperty["ID"]?>-tab">
                            <div class="store-item d-sm-none d-block">

                                <? if(isset($arProperty["PHONE"]) || isset($arProperty["SCHEDULE"])) { ?>
                                    <div class="catalog-stores-item-info">
                                        <? if(isset($arProperty["SCHEDULE"]) && $arProperty["PHONE"] != ''):?>
                                            <div class="catalog-stores-item-schhedule mb-2">
                                                <div class="subtitle text-muted"><?=\Bitrix\Main\Localization\Loc::getMessage('S_SCHEDULE')?></div>
                                                <div style="font-weight: bold;"><?=$arProperty["SCHEDULE"]?></div>
                                            </div>
                                        <?endif;?>
                                        <? if(isset($arProperty["PHONE"]) && $arProperty["PHONE"] != ''):?>
                                            <div class="catalog-stores-item-phone mb-3" itemprop="telephone">
                                                <div class="subtitle text-muted"><?=\Bitrix\Main\Localization\Loc::getMessage('S_PHONE')?></div>
                                                <a href="tel:<?=$arProperty['PHONE_URL'];?>" style="font-weight: bold;"><?=$arProperty["PHONE"]?></a>
                                            </div>
                                        <?endif;?>
                                    </div>
                                <? } ?>
                            </div>
                        <? if($arProperty["GPS_S"]!=0 && $arProperty["GPS_N"]!=0)
                        {
                            $gpsN=substr(doubleval($arProperty["GPS_N"]),0,15);
                            $gpsS=substr(doubleval($arProperty["GPS_S"]),0,15);
                        }?>
                        <?
                        if ($arResult['VIEW_MAP'])
                        {
                            if($arResult["MAP"]==0)
                            {
                                $APPLICATION->IncludeComponent("bitrix:map.yandex.view", "map", array(
                                    "INIT_MAP_TYPE" => "MAP",
                                    "MAP_DATA" => serialize(array(
                                        "yandex_lat"=>$gpsN,
                                        "yandex_lon"=>$gpsS,
                                        "yandex_scale"=>12,
                                        "PLACEMARKS" => array( 0=>array("LON"=>$gpsS,"LAT"=>$gpsN,"TEXT"=>$arResult["ADDRESS"]))
                                    )),
                                    "MAP_WIDTH" => "100%",
                                    "MAP_HEIGHT" => "558",
                                    "CONTROLS" => array(
                                        0 => "ZOOM",
                                    ),
                                    "OPTIONS" => array(
                                        0 => "ENABLE_SCROLL_ZOOM",
                                        1 => "ENABLE_DBLCLICK_ZOOM",
                                        2 => "ENABLE_DRAGGING",
                                    ),
                                    "MAP_ID" => ""
                                ),
                                    $component,
                                    array("HIDE_ICONS" => "Y")
                                );
                            }
                            else
                            {
                                $APPLICATION->IncludeComponent("bitrix:map.google.view", ".default", array(
                                    "INIT_MAP_TYPE" => "MAP",
                                    "MAP_DATA" => serialize(array("google_lat"=>$gpsN,"google_lon"=>$gpsS,"google_scale"=>10,"PLACEMARKS" => array( 0=>array("LON"=>$gpsS,"LAT"=>$gpsN,"TEXT"=>$arResult["ADDRESS"])))),
                                    "MAP_WIDTH" => "100%",
                                    "MAP_HEIGHT" => "558",
                                    "CONTROLS" => array(
                                        0 => "ZOOM",
                                    ),
                                    "OPTIONS" => array(
                                        0 => "ENABLE_SCROLL_ZOOM",
                                        1 => "ENABLE_DBLCLICK_ZOOM",
                                        2 => "ENABLE_DRAGGING",
                                    ),
                                    "MAP_ID" => ""
                                ),
                                    $component,
                                    array("HIDE_ICONS" => "Y")
                                );
                            }
                        }
                        ?>
                        </div>
                    </div>

                    <?$i++;
                endforeach;?>
            </div>
        </div>
    </div>
<?}?>
