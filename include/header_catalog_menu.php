<?$APPLICATION->IncludeComponent(
    "bitrix:menu",
    "catalog-menu",
    array(
        "ALLOW_MULTI_SELECT" => "N",
        "CHILD_MENU_TYPE" => "bottom",
        "DELAY" => "N",
        "IBLOCK_ID" => "4",
        "MAX_LEVEL" => "3",
        "MENU_CACHE_GET_VARS" => array(
        ),
        "MENU_CACHE_TIME" => "3600",
        "MENU_CACHE_TYPE" => "A",
        "MENU_CACHE_USE_GROUPS" => "Y",
        "MENU_THEME" => "site",
        "ROOT_MENU_TYPE" => "catalog_top",
        "USE_EXT" => "Y",
        "COMPONENT_TEMPLATE" => "catalog-menu",
        "ICON_MENU" => "UF_ICON",
        "ACTION_MENU" => "UF_BANNER_MENU"
    ),
    false
);?>