<?php
$arUrlRewrite=array (
  0 => 
  array (
    'CONDITION' => '#^\\/?\\/mobileapp/jn\\/(.*)\\/.*#',
    'RULE' => 'componentName=$1',
    'ID' => NULL,
    'PATH' => '/bitrix/services/mobileapp/jn.php',
    'SORT' => 100,
  ),
  2 => 
  array (
    'CONDITION' => '#^/bitrix/services/ymarket/#',
    'RULE' => '',
    'ID' => '',
    'PATH' => '/bitrix/services/ymarket/index.php',
    'SORT' => 100,
  ),
  5 => 
  array (
    'CONDITION' => '#^={SITE_DIR."receipts/"}#',
    'RULE' => '',
    'ID' => 'bitrix:news',
    'PATH' => '/receipts/!!index.php',
    'SORT' => 100,
  ),
  19 => 
  array (
    'CONDITION' => '#^#SITE_DIR#stores/#',
    'RULE' => '',
    'ID' => 'bitrix:catalog.store',
    'PATH' => '/stores/index.php',
    'SORT' => 100,
  ),
  6 => 
  array (
    'CONDITION' => '#^#SITE_DIR#forum/#',
    'RULE' => '',
    'ID' => 'bitrix:forum',
    'PATH' => '/forum/index.php',
    'SORT' => 100,
  ),
  18 => 
  array (
    'CONDITION' => '#^/pastry_shops/#',
    'RULE' => '',
    'ID' => 'bitrix:news',
    'PATH' => '/pastry_shops/index.php',
    'SORT' => 100,
  ),
  20 => 
  array (
    'CONDITION' => '#^/personal/#',
    'RULE' => '',
    'ID' => 'bitrix:sale.personal.section',
    'PATH' => '/personal/index.php',
    'SORT' => 100,
  ),
  17 => 
  array (
    'CONDITION' => '#^/catalog/#',
    'RULE' => '',
    'ID' => 'bitrix:catalog',
    'PATH' => '/catalog/index.php',
    'SORT' => 100,
  ),
  15 => 
  array (
    'CONDITION' => '#^/stock/#',
    'RULE' => '',
    'ID' => 'bitrix:news',
    'PATH' => '/stock/index.php',
    'SORT' => 100,
  ),
  1 => 
  array (
    'CONDITION' => '#^/rest/#',
    'RULE' => '',
    'ID' => NULL,
    'PATH' => '/bitrix/services/rest/index.php',
    'SORT' => 100,
  ),
  16 => 
  array (
    'CONDITION' => '#^/blog/#',
    'RULE' => '',
    'ID' => 'bitrix:news',
    'PATH' => '/blog/index.php',
    'SORT' => 100,
  ),
);
