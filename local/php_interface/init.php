<?php

CModule::AddAutoloadClasses(
    '',
    array(
        'Ttcr\Cake' => '/local/php_interface/classes/Cake.php',
        'Ttcr\CakeOrder' => '/local/php_interface/classes/CakeOrder.php',
        'Ttcr\CakeTinkoff' => '/local/php_interface/classes/CakeTinkoff.php',
        'Ttcr\CakeFuncs' => '/local/php_interface/classes/CakeFuncs.php',
		'lib\usertype\CUserTypeWorkTine' => '/local/php_interface/lib//usertype/CUserTypeWorkTine.php', // новый тип свойства
    )
);
function dump($arg){
    global $USER;
    if($USER->isAdmin()){
        ?>
        <font style="font-size: 13px; text-align: left;"><pre>
		<?print_r($arg);?>
		</pre></font>
        <?
    }
}
//Обработка событий
require dirname(__FILE__) . '/event_handler.php';

/*склоняем */
if(!function_exists('format_by_count')) {
	function format_by_count($count, $form1, $form2, $form3)
	{
		$count = abs($count) % 100;
		$lcount = $count % 10;
		if ($count >= 11 && $count <= 19) return($form3);
		if ($lcount >= 2 && $lcount <= 4) return($form2);
		if ($lcount == 1) return($form1);
		return $form3;
	}
}

// что бы поиск по заголовкам включал в себя свойства
AddEventHandler("search", "BeforeIndex", "BeforeIndexHandler");

function BeforeIndexHandler($arFields)
{
	if(!CModule::IncludeModule("iblock"))
		return $arFields;
	if($arFields["MODULE_ID"] == "iblock" && $arFields["PARAM2"] == 4)
	{

		$db_props = CIBlockElement::GetProperty(
			$arFields["PARAM2"],
			$arFields["ITEM_ID"],
			array("sort" => "asc"),
			array("CODE"=>"FORM")
		);
		if($ar_props = $db_props->Fetch()){
			$arFields["TITLE"] .= " #".$ar_props["VALUE_ENUM"]."#";
		}

		$db_props = CIBlockElement::GetProperty(
			$arFields["PARAM2"],
			$arFields["ITEM_ID"],
			array("sort" => "asc"),
			array("CODE"=>"TYPE_CAKE")
		);
		if($ar_props = $db_props->Fetch()){
			$arFields["TITLE"] .= " #".$ar_props["VALUE_ENUM"]."#";
		}
		
		$db_props = CIBlockElement::GetProperty(
			$arFields["PARAM2"],
			$arFields["ITEM_ID"],
			array("sort" => "asc"),
			array("CODE"=>"COVERAGE")
		);
		if($ar_props = $db_props->Fetch()){
			$arFields["TITLE"] .= " #".$ar_props["VALUE_ENUM"]."#";
		}
		
		$db_props = CIBlockElement::GetProperty(
			$arFields["PARAM2"],
			$arFields["ITEM_ID"],
			array("sort" => "asc"),
			array("CODE"=>"FOR_WHOM")
		);
		if($ar_props = $db_props->Fetch()){
			$arFields["TITLE"] .= " #".$ar_props["VALUE_ENUM"]."#";
		}
		
		$db_props = CIBlockElement::GetProperty(
			$arFields["PARAM2"],
			$arFields["ITEM_ID"],
			array("sort" => "asc"),
			array("CODE"=>"HOLIDAY")
		);
		if($ar_props = $db_props->Fetch()){
			$arFields["TITLE"] .= " #".$ar_props["VALUE_ENUM"]."#";
		}
		
		$db_props = CIBlockElement::GetProperty(
			$arFields["PARAM2"],
			$arFields["ITEM_ID"],
			array("sort" => "asc"),
			array("CODE"=>"HOBBIES")
		);
		if($ar_props = $db_props->Fetch()){
			$arFields["TITLE"] .= " #".$ar_props["VALUE_ENUM"]."#";
		}
		
		$db_props = CIBlockElement::GetProperty(
			$arFields["PARAM2"],
			$arFields["ITEM_ID"],
			array("sort" => "asc"),
			array("CODE"=>"CORPORATE")
		);
		if($ar_props = $db_props->Fetch()){
			$arFields["TITLE"] .= " #".$ar_props["VALUE_ENUM"]."#";
		}
		
		$db_props = CIBlockElement::GetProperty(
			$arFields["PARAM2"],
			$arFields["ITEM_ID"],
			array("sort" => "asc"),
			array("CODE"=>"VIP")
		);
		if($ar_props = $db_props->Fetch()){
			$arFields["TITLE"] .= " #".$ar_props["VALUE_ENUM"]."#";
		}

		$db_props = CIBlockElement::GetProperty(
			$arFields["PARAM2"],
			$arFields["ITEM_ID"],
			array("sort" => "asc"),
			array("CODE"=>"DECORATING")
		);
		if($ar_props = $db_props->Fetch()){
			$arFields["TITLE"] .= " #".$ar_props["VALUE_ENUM"]."#";
		}

	}
	
	return $arFields; // вернём изменения
}