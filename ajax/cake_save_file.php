<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");
if($_POST['text']){
    $text_arr = json_decode($_POST['text']);
    $_SESSION['CAKE_TEXT'] = $text_arr;
}
$files_comp = json_decode($_POST['files_comp']);
$custom_add = [];
$added_img = [];
if(isset($_FILES['file']['name'])){
    foreach($_FILES['file']['name'] as $key=>$file_name){
//        $file_name = $file_item['name'][$key];
        move_uploaded_file($_FILES['file']['tmp_name'][$key], $_SERVER["DOCUMENT_ROOT"].'/upload/tmp/add/'.$file_name);
        if(file_exists($_SERVER["DOCUMENT_ROOT"].'/upload/tmp/add/'.$file_name)){
            $arFile = CFile::MakeFileArray($_SERVER["DOCUMENT_ROOT"].'/upload/tmp/add/'.$file_name);
            $file = CFile::SaveFile($arFile, 'vars');
            if($file){
                foreach ($files_comp as $prod_id => $f_name){
                    if($file_name == $f_name){
                        $file_data = \CFile::GetFileArray($file);
                        $added_img[$prod_id] = $file;
                        $custom_add[$prod_id]['imgs'][] = ['file_name'=>$f_name, 'file_id'=>$file, 'src'=>$file_data['SRC']];
                    }
                }
            }
//            echo $file;
        }
    }
    $_SESSION['ADDED_IMG'] = $added_img;
}

foreach ($text_arr as $prod_id=>$text){
    $custom_add[$prod_id]['text'][] = $text;
}

setcookie("custom_add", json_encode($custom_add), time()+3600, '/'); // ставим куку с кастомными картинками, чтобы использовать в дальнейшем при разделении заказов

require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/epilog_after.php");
?>