$(function() {

    if($(window).width() > 991) {
        $('#storesTab li:first-child button').tab('show');

        $("#storesTabList").niceScroll({
            cursorcolor: "#f0a400",
            cursorborder: 0,
            cursorborderradius: 2,
            zindex: 999,
            cursoropacitymax: 1
        });
    } else {

        $('#storesTabContent .tab_box').addClass('collapse');

    }

});