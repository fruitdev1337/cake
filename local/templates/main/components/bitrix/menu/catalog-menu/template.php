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
/*
 * массив баннеров
$arResult["ALL_ITEMS"][$itemID]["PARAMS"]['banner']
 ['NAME'] - название банера
 ['PREVIEW_PICTURE_SRC'] - ссылка на изображение баннера
 ['LINK'] - ссылка в баннере
 */

$this->setFrameMode(true);

if (empty($arResult["ALL_ITEMS"]))
    return;

CUtil::InitJSCore();
$menuBlockId = "catalog_menu_".$this->randString();
?>
<div id="<?=$menuBlockId?>" class="bx-top-nav">
    <nav class="bx-top-nav-container" id="cont_<?=$menuBlockId?>">
        <ul class="bx-nav-list bx-nav-list-1-lvl" id="ul_<?=$menuBlockId?>">
            <?
            $i = 1;
            foreach($arResult["MENU_STRUCTURE"] as $itemID => $arColumns):?>

                <!-- first level-->
                <?$existPictureDescColomn = ($arResult["ALL_ITEMS"][$itemID]["PARAMS"]["picture_src"] || $arResult["ALL_ITEMS"][$itemID]["PARAMS"]["description"]) ? true : false;?>
                <li class="bx-nav-item bx-nav-1-lvl bx-nav-list-<?=($existPictureDescColomn) ? count($arColumns)+1 : count($arColumns)?>-col <?if (is_array($arColumns) && count($arColumns) > 0):?> bx-nav-parent<?endif?>" <?
                if (is_array($arColumns) && count($arColumns) > 0):?>data-role="bx-menu-item"<?endif?>>
                        <a class="bx-nav-link bx-nav-1-lvl-link <?= ((is_array($arColumns) && count($arColumns) > 0) ? 'hidden-xs' : '');?>"
                           href="<?=$arResult["ALL_ITEMS"][$itemID]["LINK"]?>">
                            <span class="bx-nav-icon">
                                <!-- тут хранится путь до иконки -->
                                <img src="<?=$arResult["ALL_ITEMS"][$itemID]["PARAMS"]['icon']?>" alt="">
                            </span>
                            <span class="bx-nav-link-text"><?=htmlspecialcharsbx($arResult["ALL_ITEMS"][$itemID]["TEXT"])?></span>
                            <?if (is_array($arColumns) && count($arColumns) > 0):?><span class="fa fa-angle-right"></span><?endif?>
                        </a>
                    <?if (is_array($arColumns) && count($arColumns) > 0):?>
                        <div class="bx-nav-2-lvl-container<?=(!empty($arResult["ALL_ITEMS"][$itemID]["PARAMS"]['banner']) ? ' banner-in' : '')?>">
                            <?foreach($arColumns as $key=>$arRow):
                                $menuMobIdLevel_1 = "cat_mobile_".randString(3);?>
                                <div class="mobile-menu-title">
                                    <a class=" bx-nav-1-lvl-link"
                                       href="<?=$arResult["ALL_ITEMS"][$itemID]["LINK"]?>">
                                        <span class="bx-nav-icon">
                                            <!-- тут хранится путь до иконки -->
                                            <img src="<?=$arResult["ALL_ITEMS"][$itemID]["PARAMS"]['icon']?>" alt="">
                                        </span>
                                        <span class="bx-nav-1-lvl-link-text"><?=htmlspecialcharsbx($arResult["ALL_ITEMS"][$itemID]["TEXT"])?></span>
                                    </a>
                                    <button class="open_list mini-plus visible-xs" data-id="<?=$menuMobIdLevel_1;?>">
                                        <span class="fa fa-angle-down"></span>
                                    </button> <!-- for mobile -->
                                </div>
                                <ul class="bx-nav-list bx-nav-list-2-lvl hidden_list<?=(!empty($arResult["ALL_ITEMS"][$itemID]["PARAMS"]['banner']) ? ' banner-in' : '')?>"
                                    id="<?=$menuMobIdLevel_1;?>">
                                    <li class="bx-nav-item bx-nav-2-lvl section-menu-title">
                                        <a class="bx-nav-link bx-nav-2-lvl-link"
                                           href="<?=$arResult["ALL_ITEMS"][$itemID]["LINK"]?>">
                                            <span class="bx-nav-link-text">Смотреть весь раздел</span>
                                        </a>
                                    </li>
                                    <?foreach($arRow as $itemIdLevel_2=>$arLevel_3):
                                        $menuMobIdLevel_2 = "cat_mobile_".randString(3);?>  <!-- second level-->
                                        <li class="bx-nav-item bx-nav-2-lvl <?if (is_array($arLevel_3) && count($arLevel_3) > 0){?>parent-column<?}?>">
                                                <a class="bx-nav-link bx-nav-2-lvl-link"
                                                   href="<?=$arResult["ALL_ITEMS"][$itemIdLevel_2]["LINK"]?>">
                                                    <span class="bx-nav-link-text"><?=htmlspecialcharsbx($arResult["ALL_ITEMS"][$itemIdLevel_2]["TEXT"])?></span>
                                                    <?if (is_array($arLevel_3) && count($arLevel_3) > 0):?><span class="fa fa-angle-right"></span><?endif?>
                                                </a>
                                            <?if (is_array($arLevel_3) && count($arLevel_3) > 0):?>
                                                <div class="bx-nav-3-lvl-container<?=(!empty($arResult["ALL_ITEMS"][$itemID]["PARAMS"]['banner']) ? ' banner-in' : '')?>">
                                                    <div class="mobile-menu-title">
                                                        <a class=" bx-nav-2-lvl-link"
                                                           href="<?=$arResult["ALL_ITEMS"][$itemIdLevel_2]["LINK"]?>">
                                                            <span class="bx-nav-link-text"><?=$arResult["ALL_ITEMS"][$itemIdLevel_2]["TEXT"]?></span>
                                                        </a>
                                                        <button class="open_list fa fa-angle-down visible-xs" data-id="<?=$menuMobIdLevel_2;?>"></button> <!-- for mobile -->
                                                    </div>
                                                    <ul class="bx-nav-list bx-nav-list-3-lvl hidden_list" id="<?=$menuMobIdLevel_2;?>">
                                                        <li class="bx-nav-item bx-nav-3-lvl section-menu-title">
                                                            <a class="bx-nav-link bx-nav-3-lvl-link"
                                                               href="<?=$arResult["ALL_ITEMS"][$itemID]["LINK"]?>">
                                                                <span class="bx-nav-link-text">Смотреть весь раздел</span>
                                                            </a>
                                                        </li>
                                                        <?foreach($arLevel_3 as $itemIdLevel_3):?>	<!-- third level-->
                                                            <li class="bx-nav-item bx-nav-3-lvl">
                                                                <a class="bx-nav-link bx-nav-3-lvl-link"
                                                                   href="<?=$arResult["ALL_ITEMS"][$itemIdLevel_3]["LINK"]?>">
                                                                    <span class="bx-nav-link-text"><?=$arResult["ALL_ITEMS"][$itemIdLevel_3]["TEXT"]?></span>
                                                                </a>
                                                            </li>
                                                        <?endforeach;?>
                                                    </ul>
                                                </div>
                                            <?endif?>
                                        </li>
                                        <?$i++;
                                    endforeach;?>
                                </ul>
                                <?if(!empty($arResult["ALL_ITEMS"][$itemID]["PARAMS"]['banner'])) {
                                    ?>
                                    <div class="top-nav-banner-item">
                                        <div class="card">
                                            <h4 class="card-title">
                                                <a href="<?=$arResult["ALL_ITEMS"][$itemID]["PARAMS"]['banner']['LINK']?>"
                                                   title="<?=$arResult["ALL_ITEMS"][$itemID]["PARAMS"]['banner']['NAME']?>"><?=$arResult["ALL_ITEMS"][$itemID]["PARAMS"]['banner']['NAME']?></a>
                                            </h4>

                                            <a href="<?=$arResult["ALL_ITEMS"][$itemID]["PARAMS"]['banner']['LINK']?>">
                                                <div class="card-img-top-wrapper embed-responsive">
                                                    <div style="background-image: url(<?=$arResult["ALL_ITEMS"][$itemID]["PARAMS"]['banner']['PREVIEW_PICTURE_SRC']?>);" class="card-img-top embed-responsive-item">
                                                    </div>
                                                </div>
                                            </a>

                                        </div>
                                    </div>
                                    <?
                                }?>
                            <?endforeach;?>
                        </div>
                    <?endif?>
                </li>
                <?
                $i++;
            endforeach;?>
        </ul>
    </nav>
</div>
