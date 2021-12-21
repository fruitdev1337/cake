/**
 * Created by aleksander on 05.03.2019.
 */

$(function () {

    $('.scroll_bar_main').mCustomScrollbar({
        scrollInertia:0,
        advanced:{autoScrollOnFocus:false}
    });

    $(document).trigger("OnAddProDuctFavorites");

    if ($(window).width() > 1024) {

        var gallery_slider;

        $('.product-item-detail-slider-controls-block .swiper-container').on("mouseenter", function (e) {
            if ($(this).hasClass('has-slider')) {
                return;
            }
            var x = document.getElementsByClassName("product-item-detail-slider-controls-block");
            for(var i = 0; i < x.length; i++) {
                var el = x[i];
                var nx = el.querySelector(".swiper-next");
                var pr = el.querySelector(".swiper-prev");
                var sliderId = $(this).attr("data-id");
                // console.log(nx);
                $(this).addClass('has-slider');
                gallery_slider = new Swiper('.' + sliderId, {
                    direction: 'vertical',
                    slidesPerView: 3,
                    spaceBetween: 13,
                    navigation: {
                        nextEl: nx,
                        prevEl: pr,
                    },
                    watchOverflow: true
                });
            }
        });

        $('.product-item-detail-slider-images-container').fancybox({
            selector: 'a.fancybox-prev',
            hash: false,
            buttons: [
                'close'
            ]
        });

    }
});

$(document).on('click','.fast_wrapper',function(e){
if (e.target.className === 'fast_wrapper'){
$('body').removeClass('noscroll');
  $('.fast_elem_wrapper .close-btn').hide();
  $('.product_card_fast').removeClass('fast-in');
  $('.popup_mask').fadeOut(100);
  $('.add_el').html("");
}
});

