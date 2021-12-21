<? if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

use Bitrix\Main\Localization\Loc;

/**
 * @var array $arParams
 */
?>
<script id="basket-total-template" type="text/html">
	<div class="basket-checkout-container" data-entity="basket-checkout-aligner">
        <?
        if ($arParams['HIDE_COUPON'] !== 'Y')
        {
            ?>
            <div class="basket-coupon-section">
                <div class="basket-coupon-block-field">
                    <div class="basket-coupon-block-field-description"><?
                        echo Loc::getMessage('SBB_COUPON_ENTER')?>:</div>
                    <div class="form">
                        <div class="form-group" style="position: relative;">
                            <input type="text" class="form-control" id="" placeholder="" data-entity="basket-coupon-input">
                            <span class="basket-coupon-block-coupon-btn btn-primary"><?
                                echo Loc::getMessage('SBB_COUPON_ENTER_BTN')?></span>
                        </div>
                    </div>
                </div>

                <?
                if ($arParams['HIDE_COUPON'] !== 'Y')
                {
                    ?>
                    <div class="basket-coupon-alert-section">
                        <div class="basket-coupon-alert-inner">
                            {{#COUPON_LIST}}
                            <div class="basket-coupon-alert text-{{CLASS}}">
                <span class="basket-coupon-text">
                    <strong>{{COUPON}}</strong> - {{JS_CHECK_CODE}}
                    {{#DISCOUNT_NAME}}({{{DISCOUNT_NAME}}}){{/DISCOUNT_NAME}}
                </span>
                                <span class="close-link fa fa-times" data-entity="basket-coupon-delete" data-coupon="{{COUPON}}"></span>
                            </div>
                            {{/COUPON_LIST}}
                        </div>
                    </div>
                    <?
                }
                ?>
            </div>
            <?
        }
        ?>
        <div class="basket-checkout-section">
            <div class="basket-checkout-section-inner">
                <div class="basket-checkout-block basket-checkout-block-total">
                    <div class="basket-checkout-block-total-inner">
                        <div class="basket-checkout-block-total-title"><?=Loc::getMessage('SBB_TOTAL')?>:</div>
                        <div class="basket-checkout-block-total-description">
                            {{#WEIGHT_FORMATED}}
                            <?=Loc::getMessage('SBB_WEIGHT')?>: {{{WEIGHT_FORMATED}}}
                            {{#SHOW_VAT}}<br>{{/SHOW_VAT}}
                            {{/WEIGHT_FORMATED}}
                            {{#SHOW_VAT}}
                            <?=Loc::getMessage('SBB_VAT')?>: {{{VAT_SUM_FORMATED}}}
                            {{/SHOW_VAT}}
                        </div>
                    </div>
                </div>

                <div class="basket-checkout-block basket-checkout-block-total-price">
                    <div class="basket-checkout-block-total-price-inner">
                        {{#DISCOUNT_PRICE_FORMATED}}
                        <div class="basket-coupon-block-total-price-old">
                            {{{PRICE_WITHOUT_DISCOUNT_FORMATED}}}
                        </div>
                        {{/DISCOUNT_PRICE_FORMATED}}

                        <div class="basket-coupon-block-total-price-current" data-entity="basket-total-price">
                            {{{PRICE_FORMATED}}}
                        </div>

                        {{#DISCOUNT_PRICE_FORMATED}}
                        <div class="basket-coupon-block-total-price-difference">
                            <?=Loc::getMessage('SBB_BASKET_ITEM_ECONOMY')?>
                            <span style="white-space: nowrap;">{{{DISCOUNT_PRICE_FORMATED}}}</span>
                        </div>
                        {{/DISCOUNT_PRICE_FORMATED}}
                    </div>
                </div>
            </div>
        </div>
        <div class="basket-checkout-block basket-checkout-block-btn">
            <button class="btn-primary basket-btn-checkout{{#DISABLE_CHECKOUT}} disabled{{/DISABLE_CHECKOUT}}"
                    data-entity="basket-checkout-button" {{#BUY_BTN}} disabled{{/BUY_BTN}}>
            {{#BUY_BTN_TEXT}}
                {{{BUY_BTN_TEXT}}}
            {{/BUY_BTN_TEXT}}
            {{^BUY_BTN_TEXT}}
                <?=Loc::getMessage('SBB_ORDER')?>
            {{/BUY_BTN_TEXT}}
            </button>
        </div>
	</div>
</script>