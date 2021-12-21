<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();                        
if(\Bitrix\Main\Loader::includeSharewareModule("krayt.retail") == \Bitrix\Main\Loader::MODULE_DEMO_EXPIRED || 
   \Bitrix\Main\Loader::includeSharewareModule("krayt.retail") ==  \Bitrix\Main\Loader::MODULE_NOT_FOUND
    )
{ return false;}?>

<?if (!empty($arResult)):?>
<ul id="vertical-multilevel-menu" class="section__list-root">
<?
$previousLevel = 0;
foreach($arResult as $arItem):?>
	<?if ($previousLevel && $arItem["DEPTH_LEVEL"] < $previousLevel):?>
		<?=str_repeat("</ul></li>", ($previousLevel - $arItem["DEPTH_LEVEL"]));?>
	<?endif?>

	<?if ($arItem["IS_PARENT"]):?>

		<?if ($arItem["DEPTH_LEVEL"] == 2):?>
			<li class="section__list-item root-item-parent<?if ($arItem["SELECTED"]):?> root-item-selected<?endif?>">
                <a href="<?=$arItem["LINK"]?>"
                   class="root-item-parent-link" title="<?=$arItem["TEXT"]?>"><?=$arItem["TEXT"]?> <span class="elem-count">(<?=$arItem['ELEMENT_CNT']?>)</span></a>
				<ul class="section__list-sub">
		<?else:?>
			<li class="section__list-item sub-item-parent<?if ($arItem["SELECTED"]):?> sub-item-selected<?endif?>">
                <a href="<?=$arItem["LINK"]?>"
                   class="sub-item-parent-link" title="<?=$arItem["TEXT"]?>"><?=$arItem["TEXT"]?> <span class="elem-count">(<?=$arItem['ELEMENT_CNT']?>)</span></a>
<!--                <i data-role="prop_angle" class="fa fa-angle-down"></i>-->
                <ul class="section__list-sub">
		<?endif?>

	<?else:?>

		<?if ($arItem["PERMISSION"] > "D"):?>

			<?if ($arItem["DEPTH_LEVEL"] == 2):?>
				<li class="root-item<?if ($arItem["SELECTED"]):?> root-item-selected<?endif?>">
                    <a href="<?=$arItem["LINK"]?>"
                       class="root-item-link" title="<?=$arItem["TEXT"]?>"><?=$arItem["TEXT"]?></a>
                </li>
			<?else:?>
				<li class="sub-item<?if ($arItem["SELECTED"]):?> sub-item-selected<?endif?>">
                    <a href="<?=$arItem["LINK"]?>"
                       class="sub-item-link" title="<?=$arItem["TEXT"]?>"><?=$arItem["TEXT"]?></a>
                </li>
			<?endif?>

		<?else:?>

			<?if ($arItem["DEPTH_LEVEL"] == 2):?>
				<li class="root-item<?if ($arItem["SELECTED"]):?> root-item-selected<?endif?>">
                    <a href="<?=$arItem["LINK"]?>"
                       class="root-item-link" title="<?=$arItem["TEXT"]?>"><?=$arItem["TEXT"]?> <span class="elem-count">(<?=$arItem['ELEMENT_CNT']?>)</span></a>
                </li>
			<?else:?>
                <li class="sub-item<?if ($arItem["SELECTED"]):?> sub-item-selected<?endif?>">
                    <a href="<?=$arItem["LINK"]?>"
                       class="sub-item-link" title="<?=$arItem["TEXT"]?>"><?=$arItem["TEXT"]?> <span class="elem-count">(<?=$arItem['ELEMENT_CNT']?>)</span></a>
                </li>
			<?endif?>

		<?endif?>

	<?endif?>

	<?$previousLevel = $arItem["DEPTH_LEVEL"];?>

<?endforeach?>

<?if ($previousLevel > 1)://close last item tags?>
	<?=str_repeat("</ul></li>", ($previousLevel-1) );?>
<?endif?>

</ul>
<?endif?>