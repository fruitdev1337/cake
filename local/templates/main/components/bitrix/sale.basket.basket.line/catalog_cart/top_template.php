<?if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED!==true) die();
use \Bitrix\Main\Localization\Loc;
/**
 * @global array $arParams
 * @global CUser $USER
 * @global CMain $APPLICATION
 * @global string $cartId
 */
$compositeStub = (isset($arResult['COMPOSITE_STUB']) && $arResult['COMPOSITE_STUB'] == 'Y');
?>
<div class="catalog-basket">

	<div class="catalog-basket-block icon-box_item">
		<?
		if (!$arResult["DISABLE_USE_BASKET"])
		{
			?>
            <a href="<?=($arResult['NUM_PRODUCTS'] > 0 ? $arParams['PATH_TO_BASKET'] : 'javascript:void(0)')?>" class="icon-box-link <?=($arResult['NUM_PRODUCTS'] > 0 ? 'basket-link' : 'empty-link')?>">
                <span class="icon-item basket-icon">
                <?if (!$compositeStub) {
                    if ($arParams['SHOW_NUM_PRODUCTS'] == 'Y' && ($arResult['NUM_PRODUCTS'] > 0 || $arParams['SHOW_EMPTY_VALUES'] == 'Y')) {
                        ?>
                        <span class="goods_icon-counter"><?= $arResult['NUM_PRODUCTS'] ?></span>
                        <?
                    }
                }?>
                </span>
                <?if (!$compositeStub)
                {
                    if ($arParams['SHOW_NUM_PRODUCTS'] == 'Y' && $arParams['SHOW_EMPTY_VALUES'] == 'Y')
                    {
                        if ($arResult['NUM_PRODUCTS'] > 0) {
                            if ($arParams['SHOW_TOTAL_PRICE'] == 'Y')
                            {
                                ?>
                                <span class="total-price"><?= $arResult["TOTAL_PRICE"] ?></span>
                                <?
                            }
                        } else {
                            ?>
                            <span class="basket-item-list empty-basket"><?=Loc::getMessage("TSB1_CART_EMPTY")?></span>
                            <?
                        }
                    }
                }?>
            </a>
			<?
		}
		?>
	</div>
</div>