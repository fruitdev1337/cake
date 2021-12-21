<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();                        
if(\Bitrix\Main\Loader::includeSharewareModule("krayt.retail") == \Bitrix\Main\Loader::MODULE_DEMO_EXPIRED || 
   \Bitrix\Main\Loader::includeSharewareModule("krayt.retail") ==  \Bitrix\Main\Loader::MODULE_NOT_FOUND
    )
{ return false;}?>

<?if (!empty($arResult)):?>
<ul class="navigation">

<?
foreach($arResult as $arItem):
	if($arParams["MAX_LEVEL"] == 1 && $arItem["DEPTH_LEVEL"] > 1)
		continue;
?>
	<?if($arItem["SELECTED"]):?>
		<li class="navigation_item"><a href="<?=$arItem["LINK"]?>" class="navigation-link selected"><?=$arItem["TEXT"]?></a></li>
	<?else:?>
		<li class="navigation_item"><a href="<?=$arItem["LINK"]?>" class="navigation-link 
		<?if($arItem["PARAMS"]["CLASS"]){echo $arItem["PARAMS"]["CLASS"];}?>"
		<?if($arItem["PARAMS"]["DATA_TARGET"]):?> data-target="#<?=$arItem["PARAMS"]["DATA_TARGET"];?>"<?endif;?>
		><?=$arItem["TEXT"]?></a></li>
	<?endif?>
	
<?endforeach?>

</ul>
<?endif?>