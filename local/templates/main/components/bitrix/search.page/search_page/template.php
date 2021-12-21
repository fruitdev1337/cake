<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();?>

<div class="search_wrapper">
    <div class="search__input">
        <div class="input-wrapper">
            <form action="" method="get">
                <?if($arParams["USE_SUGGEST"] === "Y"):
                    if(strlen($arResult["REQUEST"]["~QUERY"]) && is_object($arResult["NAV_RESULT"]))
                    {
                        $arResult["FILTER_MD5"] = $arResult["NAV_RESULT"]->GetFilterMD5();
                        $obSearchSuggest = new CSearchSuggest($arResult["FILTER_MD5"], $arResult["REQUEST"]["~QUERY"]);
                        $obSearchSuggest->SetResultCount($arResult["NAV_RESULT"]->NavRecordCount);
                    }
                    ?>
                    <?$APPLICATION->IncludeComponent(
                    "bitrix:search.suggest.input",
                    "",
                    array(
                        "NAME" => "q",
                        "VALUE" => $arResult["REQUEST"]["~QUERY"],
                        "INPUT_SIZE" => 40,
                        "DROPDOWN_SIZE" => 10,
                        "FILTER_MD5" => $arResult["FILTER_MD5"],
                    ),
                    $component, array("HIDE_ICONS" => "Y")
                );?>
                <?else:?>
                    <input type="text" name="q" value="<?=$arResult["REQUEST"]["QUERY"]?>" size="40" />
                <?endif;?>
                <button class="search-title-button" type="submit" name="s"><?=GetMessage("SEARCH_GO")?></button>
                <!--            <input type="submit" value="--><?//=GetMessage("SEARCH_GO")?><!--" />-->
                <input type="hidden" name="how" value="<?echo $arResult["REQUEST"]["HOW"]=="d"? "d": "r"?>" />
                <?if($arParams["SHOW_WHEN"]):?>
                    <script>
                        var switch_search_params = function()
                        {
                            var sp = document.getElementById('search_params');
                            var flag;

                            if(sp.style.display == 'none')
                            {
                                flag = false;
                                sp.style.display = 'block'
                            }
                            else
                            {
                                flag = true;
                                sp.style.display = 'none';
                            }

                            var from = document.getElementsByName('from');
                            for(var i = 0; i < from.length; i++)
                                if(from[i].type.toLowerCase() == 'text')
                                    from[i].disabled = flag

                            var to = document.getElementsByName('to');
                            for(var i = 0; i < to.length; i++)
                                if(to[i].type.toLowerCase() == 'text')
                                    to[i].disabled = flag

                            return false;
                        }
                    </script>
                    <br /><a class="search-page-params" href="#" onclick="return switch_search_params()"><?echo GetMessage('CT_BSP_ADDITIONAL_PARAMS')?></a>
                    <div id="search_params" class="search-page-params" style="display:<?echo $arResult["REQUEST"]["FROM"] || $arResult["REQUEST"]["TO"]? 'block': 'none'?>">
                        <?$APPLICATION->IncludeComponent(
                            'bitrix:main.calendar',
                            '',
                            array(
                                'SHOW_INPUT' => 'Y',
                                'INPUT_NAME' => 'from',
                                'INPUT_VALUE' => $arResult["REQUEST"]["~FROM"],
                                'INPUT_NAME_FINISH' => 'to',
                                'INPUT_VALUE_FINISH' =>$arResult["REQUEST"]["~TO"],
                                'INPUT_ADDITIONAL_ATTR' => 'size="10"',
                            ),
                            null,
                            array('HIDE_ICONS' => 'Y')
                        );?>
                    </div>
                <?endif?>
            </form>
        </div>

        <?if(isset($arResult["REQUEST"]["ORIGINAL_QUERY"])):
            ?>
            <div class="search-language-guess">
                <?echo GetMessage("CT_BSP_KEYBOARD_WARNING", array("#query#"=>'<a href="'.$arResult["ORIGINAL_QUERY_URL"].'">'.$arResult["REQUEST"]["ORIGINAL_QUERY"].'</a>'))?>
            </div><br /><?
        endif;?>
        <?if($arResult["REQUEST"]["QUERY"] === false && $arResult["REQUEST"]["TAGS"] === false):?>
        <?elseif($arResult["ERROR_CODE"]!=0):?>
            <p><?=GetMessage("SEARCH_ERROR")?></p>
            <?ShowError($arResult["ERROR_TEXT"]);?>
            <p><?=GetMessage("SEARCH_CORRECT_AND_CONTINUE")?></p>
            <br /><br />
            <p><?=GetMessage("SEARCH_SINTAX")?><br /><b><?=GetMessage("SEARCH_LOGIC")?></b></p>
            <table border="0" cellpadding="5">
                <tr>
                    <td align="center" valign="top"><?=GetMessage("SEARCH_OPERATOR")?></td><td valign="top"><?=GetMessage("SEARCH_SYNONIM")?></td>
                    <td><?=GetMessage("SEARCH_DESCRIPTION")?></td>
                </tr>
                <tr>
                    <td align="center" valign="top"><?=GetMessage("SEARCH_AND")?></td><td valign="top">and, &amp;, +</td>
                    <td><?=GetMessage("SEARCH_AND_ALT")?></td>
                </tr>
                <tr>
                    <td align="center" valign="top"><?=GetMessage("SEARCH_OR")?></td><td valign="top">or, |</td>
                    <td><?=GetMessage("SEARCH_OR_ALT")?></td>
                </tr>
                <tr>
                    <td align="center" valign="top"><?=GetMessage("SEARCH_NOT")?></td><td valign="top">not, ~</td>
                    <td><?=GetMessage("SEARCH_NOT_ALT")?></td>
                </tr>
                <tr>
                    <td align="center" valign="top">( )</td>
                    <td valign="top">&nbsp;</td>
                    <td><?=GetMessage("SEARCH_BRACKETS_ALT")?></td>
                </tr>
            </table>
        <?elseif(count($arResult["SEARCH"])>0):?>

        <?else:?>
            <?ShowNote(GetMessage("SEARCH_NOTHING_TO_FOUND"));?>
        <?endif;?>
    </div>
</div>