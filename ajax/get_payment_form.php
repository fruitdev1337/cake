<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");
use Ttcr\Cake;
if($_POST['order_id']){
    echo Cake::getPaymentButt($_POST['order_id']);exit();
}

require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/epilog_after.php");
?>