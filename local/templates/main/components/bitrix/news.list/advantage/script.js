/**
 * Created by aleksander on 04.07.2019.
 */
$(function () {
    $.each($(".LOAD_IMG_JS"),function () {
       $(this).css("background-image","url('"+$(this).data('src')+"')");
    });
});