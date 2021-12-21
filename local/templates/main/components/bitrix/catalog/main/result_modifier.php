<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 12.07.2019
 * Time: 10:48
 */
if($arParams['DETAIL_PROPS_ANALOG']) {
    // сделаем вывод похожих товаров
    $arSelect = Array(
        "ID",
        "LANG_DIR",
        "IBLOCK_CODE",
        "IBLOCK_ID",
        "IBLOCK_SECTION_ID",
        "CODE",
        "NAME",
        "PREVIEW_PICTURE",
        "DETAIL_PICTURE",
        "DETAIL_PAGE_URL"
    );
// это для того что бы определить какую цену выбирать из базы
    foreach($arParams['PRICE_CODE'] as $price) {
        $dbPriceType = CCatalogGroup::GetList(
            array("SORT" => "ASC"),
            array("NAME" => $price)
        );
        while ($arPriceType = $dbPriceType->Fetch()){
            $arSelect[] = 'CATALOG_GROUP_'.$arPriceType['ID'];
            $arResult['PRICE_ID'][] = $arPriceType['ID'];
        }
    }

    // для выборки свойств по которым будем сравнивать
    foreach($arParams['DETAIL_PROPS_ANALOG'] as $det_props) {
        if($det_props != ''){
            $arSelect[] = 'PROPERTY_'.$det_props;
        }

    }
    $arSelect[] = 'PROPERTY_PRODUCT_NAME';
    // фильтрование, в данном случае из того же инфоблока , раздела, активные и только с картинками
    $arFilter = Array(
        "IBLOCK_ID"=>$arResult["IBLOCK_ID"] ,
        "SECTION_ID" => $arResult["SECTION"]["ID"], "ACTIVE"=>"Y" ,
        "!ID" => $arResult["ID"],
        "!DETAIL_PICTURE" => false
    );
    $arr_analogs = CIBlockElement::GetList(Array("RAND" => "ASC"), $arFilter, false, false, $arSelect);

    $analog_count_id = array();
    while($arr_analog = $arr_analogs->GetNextElement())
    {
        $element = $arr_analog->GetFields();

        // теперь сравним товарары
        $i = 0;
        foreach($arParams['DETAIL_PROPS_ANALOG'] as $analog_propers) {
            if($arResult['PROPERTIES'][$analog_propers]['VALUE'] == $element['PROPERTY_'.$analog_propers.'_VALUE']) {
                $i++;
            }
        }
        $analog_count_id[$element['ID']] = $i;

        //  этот код нужен для создания не превью товара
        if($element["PREVIEW_PICTURE"]) {
            $more_element_img = CFile::ResizeImageGet(
                $element["PREVIEW_PICTURE"],
                array("width" => 65, "height" => 70),
                BX_RESIZE_IMAGE_PROPORTIONAL_ALT,
                true
            );
        }
        elseif($element["DETAIL_PICTURE"]) {
            $more_element_img = CFile::ResizeImageGet(
                $element["DETAIL_PICTURE"],
                array("width" => 65, "height" => 70),
                BX_RESIZE_IMAGE_PROPORTIONAL_ALT,
                true
            );
        }

        $element['PICTURE']['WIDTH'] = $more_element_img["width"];
        $element['PICTURE']['HEIGHT'] = $more_element_img["height"];
        $element['PICTURE']['SRC'] = $more_element_img["src"];
        unset($more_element_img);

        $analog[$element['ID']] = $element;

    }
    arsort($analog_count_id);
    foreach($analog_count_id as $k => $v) {
        $arResult["ANALOG"][$k] = $analog[$k];
    }
}

