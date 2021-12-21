<? if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

/**
 * @global CMain $APPLICATION
 * @var array $arParams
 * @var array $arResult
 * @var CatalogSectionComponent $component
 * @var CBitrixComponentTemplate $this
 * @var string $templateName
 * @var string $componentPath
 * @var string $templateFolder
 */

// region custom detail properties

if($arParams['DETAIL_PRODUCT_COMPOSITION'])
{
    if(isset($arResult['PROPERTIES'][$arParams['DETAIL_PRODUCT_COMPOSITION']]))
    {
        $propIsprod = $arResult['PROPERTIES'][$arParams['DETAIL_PRODUCT_COMPOSITION']];
        if($propIsprod['VALUE'])
        {
            $arResult['PRODUCT_COMPOSITION']['NAME'] = $propIsprod['NAME'];
            $arResult['PRODUCT_COMPOSITION']['VALUE'] = is_array($propIsprod['VALUE'])?implode(',',$propIsprod['VALUE']):$propIsprod['VALUE'];
        }
    }
}

if($arParams['DETAIL_ENERGY_VALUE'])
{
    if(isset($arResult['PROPERTIES'][$arParams['DETAIL_ENERGY_VALUE']]))
    {
        $propIsprod = $arResult['PROPERTIES'][$arParams['DETAIL_ENERGY_VALUE']];
        if($propIsprod['VALUE'])
        {
            $arResult['ENERGY_VALUE'] = $propIsprod['VALUE'];
        }
    }
}

if($arParams['DETAIL_PROTEIN'])
{
    if(isset($arResult['PROPERTIES'][$arParams['DETAIL_PROTEIN']]))
    {
        $propIsprod = $arResult['PROPERTIES'][$arParams['DETAIL_PROTEIN']];
        if($propIsprod['VALUE'])
        {
            $arResult['PROTEIN'] = $propIsprod['VALUE'];
        }
    }
}

if($arParams['DETAIL_FAT'])
{
    if(isset($arResult['PROPERTIES'][$arParams['DETAIL_FAT']]))
    {
        $propIsprod = $arResult['PROPERTIES'][$arParams['DETAIL_FAT']];
        if($propIsprod['VALUE'])
        {
            $arResult['FAT'] = $propIsprod['VALUE'];
        }
    }
}

if($arParams['DETAIL_CARB'])
{
    if(isset($arResult['PROPERTIES'][$arParams['DETAIL_CARB']]))
    {
        $propIsprod = $arResult['PROPERTIES'][$arParams['DETAIL_CARB']];
        if($propIsprod['VALUE'])
        {
            $arResult['CARB'] = $propIsprod['VALUE'];
        }
    }
}


if($arParams['DETAIL_ENERGY_VALUE_PERCENT'])
{
    if(isset($arResult['PROPERTIES'][$arParams['DETAIL_ENERGY_VALUE_PERCENT']]))
    {
        $propIsprod = $arResult['PROPERTIES'][$arParams['DETAIL_ENERGY_VALUE_PERCENT']];
        if($propIsprod['VALUE'])
        {
            $arResult['ENERGY_VALUE_PERCENT'] = $propIsprod['VALUE'];
        }
    }
}

if($arParams['DETAIL_PROTEIN_PERCENT'])
{
    if(isset($arResult['PROPERTIES'][$arParams['DETAIL_PROTEIN_PERCENT']]))
    {
        $propIsprod = $arResult['PROPERTIES'][$arParams['DETAIL_PROTEIN_PERCENT']];
        if($propIsprod['VALUE'])
        {
            $arResult['PROTEIN_PERCENT'] = $propIsprod['VALUE'];
        }
    }
}

if($arParams['DETAIL_FAT_PERCENT'])
{
    if(isset($arResult['PROPERTIES'][$arParams['DETAIL_FAT_PERCENT']]))
    {
        $propIsprod = $arResult['PROPERTIES'][$arParams['DETAIL_FAT_PERCENT']];
        if($propIsprod['VALUE'])
        {
            $arResult['FAT_PERCENT'] = $propIsprod['VALUE'];
        }
    }
}

if($arParams['DETAIL_CARB_PERCENT'])
{
    if(isset($arResult['PROPERTIES'][$arParams['DETAIL_CARB_PERCENT']]))
    {
        $propIsprod = $arResult['PROPERTIES'][$arParams['DETAIL_CARB_PERCENT']];
        if($propIsprod['VALUE'])
        {
            $arResult['CARB_PERCENT'] = $propIsprod['VALUE'];
        }
    }
}

// endregion

$component = $this->getComponent();
$arParams = $component->applyTemplateModifications();



if (!function_exists('getStars')) {
    /**
     * Form the html for rating
     * @param  [int] $rating: rating, range between 1 & 10
     * @return [html] result html with stars
     */
    function getStars($rating) {
        $rating = intval($rating);
        $responce = '';
        for($i=1; $i<=10; $i++)
        {
            // this is half
            if(($i == $rating) && ($i%2)) {
                $responce .= '<div class="fa fa-star active"></div>';
                $i++;
                continue;
            }

            if(!($i%2)) {
                if($i < $rating) {
                    $responce .= '<div class="fa fa-star active"></div>';
                } elseif($i == $rating) {
                    $responce .= '<div class="fa fa-star active"></div>';
                } elseif($i > $rating) {
                    $responce .= '<div class="fa fa-star"></div>';
                }
            }
        }
        return $responce;
    }
}
use Ttcr\CakeOrder;
/* Посмотреть время работы кондитерской  старый неверный вариант Димы*/
//if($arResult['DISPLAY_PROPERTIES']['TIME_MANUFACTURING']['VALUE']){
//    $arResult["MOD_TIME_READY"] = CakeOrder::getReadyTime($arResult['DISPLAY_PROPERTIES']['TIME_MANUFACTURING']['VALUE'], ['IBLOCK_ID'=>$arResult["PROPERTIES"]["BRAND"]["LINK_IBLOCK_ID"], 'ID'=>$arResult["PROPERTIES"]["BRAND"]["VALUE"]]);
//}
if($arResult['DISPLAY_PROPERTIES']['TIME_MANUFACTURING']['VALUE']){
    $arResult["MOD_TIME_READY_NEW"] = CakeOrder::getReadyTimeNew($arResult['DISPLAY_PROPERTIES']['TIME_MANUFACTURING']['VALUE'], ['IBLOCK_ID'=>$arResult["PROPERTIES"]["BRAND"]["LINK_IBLOCK_ID"], 'ID'=>$arResult["PROPERTIES"]["BRAND"]["VALUE"]]);

//    dump($arResult['MOD_TIME_READY_NEW']);
}
