<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

use Bitrix\Main\Localization\Loc;

/**
 * @var array $arParams
 * @var array $arResult
 * @var $APPLICATION CMain
 */

if ($arParams["SET_TITLE"] == "Y")
{
	$APPLICATION->SetTitle(Loc::getMessage("SOA_ORDER_COMPLETE"));
}
?>

<? if (!empty($arResult["ORDER"])): ?>

	<div class="sale_order_full_table order_table">
        <div class="order_suc">
            <div class="message_ok">
                <i class="fa fa-check-circle"></i>
                <span><?= Loc::getMessage("SOA_ORDER_SUC_TITLE");?></span>
            </div>
            <div class="order_num">
                <?= Loc::getMessage("SOA_ORDER_SUC", array(
                    "#ORDER_ID#" => $arResult["ORDER"]["ACCOUNT_NUMBER"]
                ));?>
            </div>
            <div class="order_num SOA_DATE_SUC">
                <?= Loc::getMessage("SOA_DATE_SUC", array(
                    "#ORDER_DATE#" => $arResult["ORDER"]["DATE_INSERT"]->toUserTime()->format('d.m.Y, H:i')
                ));?>
            </div>

            <? if (!empty($arResult['ORDER']["PAYMENT_ID"])): ?>
                <?=Loc::getMessage("SOA_PAYMENT_SUC", array(
                    "#PAYMENT_ID#" => $arResult['PAYMENT'][$arResult['ORDER']["PAYMENT_ID"]]['ACCOUNT_NUMBER']
                ))?>
            <? endif ?>

            <?
            if ($arResult["ORDER"]["IS_ALLOW_PAY"] === 'Y') {
                if (!empty($arResult["PAYMENT"])) {
                    foreach ($arResult["PAYMENT"] as $payment) {
                        if ($payment["PAID"] != 'Y') {
                            if (!empty($arResult['PAY_SYSTEM_LIST'])
                                && array_key_exists($payment["PAY_SYSTEM_ID"], $arResult['PAY_SYSTEM_LIST'])
                            ) {
                                $arPaySystem = $arResult['PAY_SYSTEM_LIST'][$payment["PAY_SYSTEM_ID"]];

                                if (empty($arPaySystem["ERROR"])) {
                                    ?>

                                    <div class="order_pay_table">
                                        <div class="ps_logo">
                                            <div class="pay_name"><?= Loc::getMessage("SOA_PAY") ?></div>
                                            <?= CFile::ShowImage($arPaySystem["LOGOTIP"], 100, 100, "border=0\" style=\"width:100px\"", "", false) ?>
                                            <div class="paysystem_name"><?= $arPaySystem["NAME"] ?></div>
                                            <br/>
                                        </div>
                                        <div>
                                            <? if (strlen($arPaySystem["ACTION_FILE"]) > 0 && $arPaySystem["NEW_WINDOW"] == "Y" && $arPaySystem["IS_CASH"] != "Y"): ?>
                                                <?
                                                $orderAccountNumber = urlencode(urlencode($arResult["ORDER"]["ACCOUNT_NUMBER"]));
                                                $paymentAccountNumber = $payment["ACCOUNT_NUMBER"];
                                                ?>
                                                <script>
                                                    window.open('<?=$arParams["PATH_TO_PAYMENT"]?>?ORDER_ID=<?=$orderAccountNumber?>&PAYMENT_ID=<?=$paymentAccountNumber?>');
                                                </script>
                                            <?= Loc::getMessage("SOA_PAY_LINK", array("#LINK#" => $arParams["PATH_TO_PAYMENT"] . "?ORDER_ID=" . $orderAccountNumber . "&PAYMENT_ID=" . $paymentAccountNumber)) ?>
                                            <? if (CSalePdf::isPdfAvailable() && $arPaySystem['IS_AFFORD_PDF']): ?>
                                            <br/>
                                                <?= Loc::getMessage("SOA_PAY_PDF", array("#LINK#" => $arParams["PATH_TO_PAYMENT"] . "?ORDER_ID=" . $orderAccountNumber . "&pdf=1&DOWNLOAD=Y")) ?>
                                            <? endif ?>
                                            <? else: ?>
                                                <?= $arPaySystem["BUFFERED_OUTPUT"] ?>
                                            <? endif ?>
                                        </div>
                                    </div>

                                    <?
                                } else {
                                    ?>
                                    <span style="color:red;"><?= Loc::getMessage("SOA_ORDER_PS_ERROR") ?></span>
                                    <?
                                }
                            } else {
                                ?>
                                <span style="color:red;"><?= Loc::getMessage("SOA_ORDER_PS_ERROR") ?></span>
                                <?
                            }
                        }
                    }
                }
            } else {
                ?>
                <br/><strong><?= $arParams['MESS_PAY_SYSTEM_PAYABLE_ERROR'] ?></strong>
                <?
            }
            ?>

        </div>
	</div>

    <? if ($arParams['NO_PERSONAL'] !== 'Y'): ?>
        <div class="order_link">
            <?=Loc::getMessage('SOA_ORDER_SUC1', ['#LINK#' => $arParams['PATH_TO_PERSONAL']])?>
        </div>
    <? endif; ?>



<? else: ?>

    <div class="sale_order_full_table alert alert-danger" role="alert">
        <b><?= Loc::getMessage("SOA_ERROR_ORDER") ?></b>
        <br/><br/>
        <?= Loc::getMessage("SOA_ERROR_ORDER_LOST", array("#ORDER_ID#" => $arResult["ACCOUNT_NUMBER"])) ?>
        <?= Loc::getMessage("SOA_ERROR_ORDER_LOST1") ?>
    </div>

<? endif ?>