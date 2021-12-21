<?if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED!==true) die();
/**
 * @global array $arParams
 * @global CUser $USER
 * @global CMain $APPLICATION
 * @global string $cartId
 */
$compositeStub = (isset($arResult['COMPOSITE_STUB']) && $arResult['COMPOSITE_STUB'] == 'Y');
?>

<a href="<?=$arParams['PATH_TO_BASKET'];?>" class="icon-box-link basket-link">
    <span class="icon-item basket-icon">
        <span class="goods_icon-counter"><?=$arResult['NUM_PRODUCTS']?></span>
    </span>
    <? if($APPLICATION->GetCurDir() === $arParams['PATH_TO_BASKET']) {?>
    <?} else {?>
        <span class="icon-txt total-price"><?= $arResult["TOTAL_PRICE"] ?></span>
    <?}?>
</a>