$(function () {

    if ($(window).width() > 1024) {
        var h1 = $('.bx-nav-list-1-lvl').outerHeight(),
            h2 = $('.bx-nav-list-2-lvl').outerHeight(),
            h3 = $('.bx-nav-list-3-lvl').outerHeight();

        if (h1 > h2 && h1 > h3) {
            $('.bx-top-nav-menu').css({'height': h1});
        } else if (h2 > h3 && h2 > h1) {
            $('.bx-top-nav-menu').css({'height': h2});
        } else {
            $('.bx-top-nav-menu').css({'height': h3});
        }


        $('.bx-nav-item').hover(
            function () {
                $('.bx-top-nav-wrapper').addClass("hover-menu");
            },
            function () {
                $('.bx-top-nav-wrapper').removeClass("hover-menu");
            }
        );
    }

});

var jsvhover = function () {

    $('.top-catalog-menu-title').hover(
        function () {
            $('.bx-nav-parent[data-num="1"]').addClass('bx-active');
        },
        function () {
            $('.bx-nav-parent[data-num="1"]').addClass('bx-active');
            $('.bx-nav-1-lvl').removeClass('bx-active');
        }
    );

    $('.bx-nav-1-lvl').hover(function () {
        $('.bx-nav-1-lvl').removeClass('bx-active');
        $(this).addClass('bx-active');
    });



}


