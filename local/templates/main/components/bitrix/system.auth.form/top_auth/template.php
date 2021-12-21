<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();                        
if(\Bitrix\Main\Loader::includeSharewareModule("krayt.retail") == \Bitrix\Main\Loader::MODULE_DEMO_EXPIRED || 
   \Bitrix\Main\Loader::includeSharewareModule("krayt.retail") ==  \Bitrix\Main\Loader::MODULE_NOT_FOUND
    )
{ return false;}

CJSCore::Init();

$cur = $APPLICATION->GetCurDir();
?>

<?if($arResult["FORM_TYPE"] == "login"):?>
    <a href="<?=SITE_DIR?>auth/" class="icon-box-link">
        <span class="fa fa-user-o"></span>
        <span class="icon-txt"><?=GetMessage("AUTH_LOGIN_BUTTON")?></span>
    </a>
        <?if($arResult["NEW_USER_REGISTRATION"] == "Y"):?>
            <a class="icon-box-link visible-xs<?if(($cur == SITE_DIR.'auth/') && ($_GET['register'] == 'yes')):?> selected<?endif;?>" href="<?=SITE_DIR?>auth/?register=yes">
                <span class="icon-txt"><?=GetMessage("AUTH_REGISTER_TITLE")?></span>
            </a>
        <?endif;?>
    <?
else:
    ?>
    <a href="<?=$arResult["PROFILE_URL"]?>" class="icon-box-link user-link" title="<?=GetMessage("AUTH_PROFILE")?>">
        <span class="fa fa-user-o"></span>
        <span class="icon-txt"><?=GetMessage('AUTH_PROFILE')?></span>
    </a>
    <a class="icon-box-link logout visible-xs" href="<?=$APPLICATION->GetCurPageParam("logout=yes", Array("logout"))?>">
        <span class="icon-txt"><?=GetMessage("AUTH_LOGOUT_BUTTON")?></span>
    </a>
<?endif?>