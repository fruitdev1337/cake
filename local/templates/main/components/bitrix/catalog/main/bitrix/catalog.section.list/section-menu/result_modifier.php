<? if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();


if (IsModuleInstalled("iblock") && $arParams['IBLOCK_ID'] && $arParams['SECTION_ID']) {
    $arFilter = array(
        "ID" => $arParams['SECTION_ID'],
        "IBLOCK_ID" => intval($arParams['IBLOCK_ID']),
        "SITE_ID" => SITE_ID,
    );
    $obCache = new CPHPCache();
    if ($obCache->InitCache(36000, serialize($arFilter), "/iblock/menu"))
    {
        $arResult['PARENT_SECTION'] = $obCache->GetVars();
    }
    elseif ($obCache->StartDataCache())
    {
        if (CModule::IncludeModule("iblock"))
        {
                $arSelect  = array("ID", "SECTION_PAGE_URL", "NAME");
                if($arParams['ICON_MENU'] && (!empty($arParams['ICON_MENU'])))
                {
                    $arSelect[] = $arParams['ICON_MENU'];
                }
                $dbSections = CIBlockSection::GetList(array(),$arFilter, false, $arSelect)->GetNext();
                if($arParams['ICON_MENU'] && (!empty($arParams['ICON_MENU'])))
                {
                    if($dbSections[$arParams['ICON_MENU']])
                    {
                        $iconSrc = CFile::GetFileArray($dbSections[$arParams['ICON_MENU']]);
                        if ($iconSrc)
                            $arResizeIcon = CFile::ResizeImageGet(
                                $dbSections[$arParams['ICON_MENU']],
                                array("width" => 50, 'height'=>50),
                                BX_RESIZE_IMAGE_PROPORTIONAL,
                                true
                            );
                        $dbSections["ICON"] = $iconSrc ? $arResizeIcon["src"] : false;
                    }
                }
                if(defined("BX_COMP_MANAGED_CACHE"))
                {
                    global $CACHE_MANAGER;
                    $CACHE_MANAGER->StartTagCache("/iblock/menu");
                    $CACHE_MANAGER->RegisterTag("iblock_id_".$arIBlock["ID"]);
                    $CACHE_MANAGER->EndTagCache();
                }
            $arResult['PARENT_SECTION'] = $dbSections;
        }
        $obCache->EndDataCache($dbSections);
    }
}