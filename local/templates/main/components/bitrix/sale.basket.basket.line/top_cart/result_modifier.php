<?php

foreach ($arResult["CATEGORIES"] as $category => &$items)
{
    foreach ($items as &$v)
    {
         $file = CFile::ResizeImageGet($v['PREVIEW_PICTURE'], array('width'=>50, 'height'=>50), BX_RESIZE_IMAGE_PROPORTIONAL, true);
         $v['SRC_PREVIEW_PICTURE'] = $file['src'];
    }
}