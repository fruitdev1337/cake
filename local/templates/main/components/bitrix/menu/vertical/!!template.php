<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();                        
if(\Bitrix\Main\Loader::includeSharewareModule("krayt.retail") == \Bitrix\Main\Loader::MODULE_DEMO_EXPIRED || 
   \Bitrix\Main\Loader::includeSharewareModule("krayt.retail") ==  \Bitrix\Main\Loader::MODULE_NOT_FOUND
    )
{ return false;}?>


<?if (!empty($arResult)):?>
<div class="nav-catalogue-wrap nav-catalogue-wrap_1">
    <a href="" class="el-del" id="js-close-nav"></a>
    <div class="nav-catalogue nav-catalogue_1">
        <div class="scrollbar-inner">
            <? $previousLevel_1 = 0;
            $i = 1;
            foreach ($arResult as $arItem): ?>
                <? if ($previousLevel_1 && $arItem["DEPTH_LEVEL"] < $previousLevel_1): ?>
                    <?= str_repeat("</ul></li>", ($previousLevel_1 - $arItem["DEPTH_LEVEL"])); ?>
                <? endif ?>
                <? if ($arItem["DEPTH_LEVEL"] == 1): // первый уровень  ?>
                    <span data-id="<?=$arItem['PARAMS']['ID']?>" data-num="<?=$i;?>" class="nav-catalogue__item-wrap nav-catalogue__item-wrap_js_hover nav-catalogue__item-wrap_<?= $arItem["DEPTH_LEVEL"] ?> nav-catalogue__item-wrap_haschild <?=($i==1 ? 'js-lastopen' : '');?>">
                                        <a href="<?= $arItem["LINK"] ?>"
                                           class="nav-catalogue__item nav-catalogue__item_<?= $arItem["DEPTH_LEVEL"] ?>">
                                                <span class="nav-catalogue__item_ico">
                                                    <?if($arItem['SVG']):?>
                                                        <img src="<?=$arItem['SVG']?>" alt="">
                                                    <?endif;?>
                                                </span>
                                            <span class="name"><?= $arItem["TEXT"] ?></span>
                                        </a>
                                    </span>
                <? endif ?>
                <?
                $i++;
            endforeach;?>
        </div>
    </div>
</div>
<?endif;?>

<div class="nav-catalogue_two">
    <? $previousLevel = 0;
    $i = 1;
    foreach ($arResult as $arItem): ?>
<? if ($previousLevel && $arItem["DEPTH_LEVEL"] < $previousLevel): ?>
    <?= str_repeat("</div></div>", ($previousLevel - $arItem["DEPTH_LEVEL"])); ?>
<? endif ?>

<? if ($arItem["IS_PARENT"]){  // если есть вложенность  ?>
    <? if ($arItem["DEPTH_LEVEL"] == 1) {// первый уровень  ?>
        <div id="li_<?=$arItem['PARAMS']['ID']?>" data-num="<?=$i;?>" class="nav-catalogue__item-wrap nav-catalogue__item-wrap_<?= $arItem["DEPTH_LEVEL"] ?> nav-catalogue__item-wrap_haschild" <?=($i==1 ? 'style="display:block;"' : '');?>>
            <div class="nav-catalogue-wrap nav-catalogue-wrap_<?= $arItem["DEPTH_LEVEL"] + 1 ?>">
                <div class="wrap">
                    <div class="inner">

                        <div class="nav-catalogue nav-catalogue_<?= $arItem["DEPTH_LEVEL"] + 1 ?>">
    <? } elseif ($arItem["DEPTH_LEVEL"] == 2) {
                            // второй уровень  ?>
                            <div class="nav-catalogue__item-wrap nav-catalogue__item-wrap_<?= $arItem["DEPTH_LEVEL"] ?>">
                                <a href="<?= $arItem["LINK"] ?>"
                                   class="nav-catalogue__item nav-catalogue__item_<?= $arItem["DEPTH_LEVEL"] ?>"><span
                                            class="name"><?= $arItem["TEXT"] ?></span></a>
                            </div>
                        </div>
                    </div>
                </div>
                </div>
        </div>
                                <div class="nav-catalogue nav-catalogue_<?= $arItem["DEPTH_LEVEL"] + 1 ?>">
    <? } else { // остальные уровни  ?>
                                    <!-- level <?= $arItem["DEPTH_LEVEL"] ?> -->
                                    <div class="nav-catalogue__item-wrap nav-catalogue__item-wrap_3 <?if($arItem['PARAMS']['IS_MORE']):?> link<?endif;?>">
                                        <a href="<?= $arItem["LINK"] ?>"
                                           class="nav-catalogue__item nav-catalogue__item_3"><span
                                                    class="name"><?=$arItem["TEXT"]?></span></a>
                                    </div>
                                </div>
                                        <div class="nav-catalogue nav-catalogue_3">
    <? } ?>
                                        </div>
                    </div>

<? } else { ?>

    <? if ($arItem["PERMISSION"] > "D") { ?>
        <? if ($arItem["DEPTH_LEVEL"] == 1) { // первый уровень ?>
                                                    <div class="nav-catalogue__item-wrap nav-catalogue__item-wrap_<?= $arItem["DEPTH_LEVEL"] ?> <? if ($arItem['PARAMS']['TYPE'] != 'SHOP'): ?>nav-catalogue__item-wrap_haschild<? endif; ?>">
                                                        <a href="<?= $arItem["LINK"] ?>"
                                                           class="nav-catalogue__item nav-catalogue__item_<?= $arItem["DEPTH_LEVEL"] ?>"><span
                                                                    class="name"><?= $arItem["TEXT"] ?></span></a>
                                                    </div>
        <? } else { // остальные уровни ?>
                                                    <div class="nav-catalogue__item-wrap <?if($arItem['PARAMS']['IS_MORE']):?> link<?endif;?> nav-catalogue__item-wrap_<?= $arItem["DEPTH_LEVEL"] ?>">
                                                        <a href="<?= $arItem["LINK"] ?>"
                                                           class="nav-catalogue__item nav-catalogue__item_<?= $arItem["DEPTH_LEVEL"] ?>"><span
                                                                    class="name"> <?= $arItem["TEXT"] ?> </span></a>
                                                    </div>
        <? } ?>
    <? } else { ?>
                                                <? if ($arItem["DEPTH_LEVEL"] == 1) {
                                                    // первый уровень?>
                                                    <div class="nav-catalogue__item-wrap nav-catalogue__item-wrap_<?= $arItem["DEPTH_LEVEL"] ?> nav-catalogue__item-wrap_haschild">
                                                        <a href="<?= $arItem["LINK"] ?>"
                                                           class="nav-catalogue__item nav-catalogue__item_<?= $arItem["DEPTH_LEVEL"] ?>"
                                                           title="<?= GetMessage("MENU_ITEM_ACCESS_DENIED") ?>"><span
                                                                    class="name"><?= $arItem["TEXT"] ?></span></a>
                                                    </div>
                                                <? } else { // остальные уровни ?>
                                                    <div class="nav-catalogue__item-wrap <?if($arItem['PARAMS']['IS_MORE']):?> link<?endif;?> nav-catalogue__item-wrap_<?= $arItem["DEPTH_LEVEL"] ?>">
                                                        <a href="<?= $arItem["LINK"] ?>"
                                                           class="nav-catalogue__item  nav-catalogue__item_<?= $arItem["DEPTH_LEVEL"] ?>"
                                                           title="<?= $arItem["TEXT"] ?>"><span
                                                                    class="name"><?= $arItem["TEXT"] ?></span></a>
                                                    </div>
                                                <? } ?>
    <? } ?>
<? } ?>
<? $previousLevel = $arItem["DEPTH_LEVEL"]; ?>
<? $i++;
endforeach ?>


<? for ($i = $previousLevel - 1; $i > 0; $i--) { ?>
    <? if ($i === 1) { // первый уровень  ?>
                                    </div>
                                </div>
    <? } else { ?>
<!--            </div>-->
<!--            </div>-->
    <? } ?>
        </div>
<? } ?>
            <!-- NAVEND -->
        </div>




<span style="display: none;">
<?if (!empty($arResult)):?>
    <div class="bx-top-nav-container">
        <ul class="bx-nav-list">

            <?
            $previousLevel = 0;
            foreach($arResult as $arItem):?>

<!--                --><?//if ($previousLevel && $arItem["DEPTH_LEVEL"] < $previousLevel):?>
<!--                    --><?//=str_repeat("</ul></li>", ($previousLevel - $arItem["DEPTH_LEVEL"]));?>
<!--                --><?//endif?>

                <?if ($arItem["IS_PARENT"]):?>

                    <?if ($arItem["DEPTH_LEVEL"] == 1):?>
                    <li class="bx-nav-item bx-nav-1-lvl">
                        <a href="<?=$arItem["LINK"]?>" class="bx-nav-link bx-nav-1-lvl-link">
                            <span class="bx-nav-icon"></span>
                            <span class="bx-nav-link-text"><?=$arItem["TEXT"]?></span>
                            <?if (is_array($arColumns) && count($arColumns) > 0):?><span class="fa fa-angle-right"></span><?endif?>
                        </a>
                        <ul class="root-item">
                            <?else:?>
                            <li><a href="<?=$arItem["LINK"]?>" class="parent<?if ($arItem["SELECTED"]):?> item-selected<?endif?>"><?=$arItem["TEXT"]?></a>
                                <ul>
                    <?endif?>

                <?else:?>

                <?if ($arItem["PERMISSION"] > "D"):?>

                    <?if ($arItem["DEPTH_LEVEL"] == 1):?>
                        <li><a href="<?=$arItem["LINK"]?>" class="<?if ($arItem["SELECTED"]):?>root-item-selected<?else:?>root-item<?endif?>"><?=$arItem["TEXT"]?></a></li>
                    <?else:?>
                        <li><a href="<?=$arItem["LINK"]?>" <?if ($arItem["SELECTED"]):?> class="item-selected"<?endif?>><?=$arItem["TEXT"]?></a></li>
                    <?endif?>

                <?else:?>

                    <?if ($arItem["DEPTH_LEVEL"] == 1):?>
                        <li><a href="" class="<?if ($arItem["SELECTED"]):?>root-item-selected<?else:?>root-item<?endif?>" title="<?=GetMessage("MENU_ITEM_ACCESS_DENIED")?>"><?=$arItem["TEXT"]?></a></li>
                    <?else:?>
                        <li><a href="" class="denied" title="<?=GetMessage("MENU_ITEM_ACCESS_DENIED")?>"><?=$arItem["TEXT"]?></a></li>
                    <?endif?>

                <?endif?>

            <?endif?>

            <?$previousLevel = $arItem["DEPTH_LEVEL"];?>

        <?endforeach?>

<!--        --><?//if ($previousLevel > 1)://close last item tags?>
<!--            --><?//=str_repeat("</ul></li>", ($previousLevel-1) );?>
<!--        --><?//endif?>

        </ul>
    </div>
<?endif?>
</span>
