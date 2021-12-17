/**
 * Created by aleksander on 04.07.2019.
 */
$(function () {
    $.each($(".LOAD_IMG_JS_STOCK"),function () {
       $(this).attr("src",$(this).data('src'));
    });

    if ($(window).width() <= 575.98) {
        $('.sales_block .sales__wrapper')
            .addClass('owl-carousel')
            .owlCarousel({
                items: 1,
                nav: false,
                dots: true,
                dotSpeed: 500,
                margin: 0

            })
    }


});