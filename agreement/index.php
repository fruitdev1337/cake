<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Пользовательское соглашение");

?>

    <div class="">
        <div class="title_box">
            <h1><?=$APPLICATION->ShowTitle(false);?></h1>
        </div>
		<div class="privacy_page">

		</div>
		<?/*
        $ID = 1; // идентификатор соглашения
		$agreement = new \Bitrix\Main\UserConsent\Agreement($ID);
		echo $agreement->getData()['AGREEMENT_TEXT'];
		*/?>
    </div>



<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>