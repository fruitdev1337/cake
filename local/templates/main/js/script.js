function getName (th, str){
    console.log(th);
    console.log(str);
    if (str.lastIndexOf('\\')){
        var i = str.lastIndexOf('\\')+1;
    }
    else{
        var i = str.lastIndexOf('/')+1;
    }
    var filename = str.slice(i);
    let uploaded = th.closest('.fileform').querySelector("#fileformlabel");
    // var uploaded = document.getElementById("fileformlabel");
    uploaded.innerHTML = filename;
}

$(document).on('click', '.js-desc-save', ()=>{
    const inputDesc = document.getElementById("form-title").value;
    $(".form-result-desc__title").text(inputDesc);
    $(".form--cart").hide();
    $(".form-result-desc")[0].style.display = "flex";
});
$(document).on('click', '.js-button-change', ()=>{
    $(".form--cart").show();
    $(".form-result-desc")[0].style.display = "none";
});
$(document).on('click', '.js-button-delete', ()=>{
    $(".form-result-desc").hide();
});

function topLinePosition() {
    var scrollTop = $(document).scrollTop(),
        headerbottomTop = $(".header-bottom").offset().top;

    if(scrollTop >= headerbottomTop) {
        $(".hb-content").addClass("sticky");
            $(".hb-content").addClass('animated fadeInDown');
    }
    else {
        $(".hb-content").removeClass("sticky");
            $(".hb-content").removeClass('animated fadeInDown');
    }
}
// endregion


// region open fast view window -----------------------------------

var fastView = {

    url: "",
    self:{},
    _init: function () {

        $(document).on('click',".fast_view",this.loadView);
    },
    loadView: function () {

        var self = fastView;
        self.url = $(this).data('href');
        $('.preloader-wrapper').fadeIn('fast');
        $('.product_card_fast').addClass('fast-in');
        $('body').addClass('noscroll');
        $.get(self.url+"?ajax_view=y&"+Date.now(),function (data) {

            $(".add_el").html(data).promise().done(function () {
                $('.preloader-wrapper').fadeOut();
                $('.fast_elem_wrapper .close-btn').show();
                $('.popup_mask').fadeIn(100);
            });

        });
        return false;
    }

};
$(function () {
    fastView._init();
});
// endregion



$(document).ready(function () {

    let custom_button = document.querySelector('.js-m-pay');
    if(custom_button){
        custom_button.addEventListener('click', function (){
            document.querySelector('.js-pay-btn input[type="submit"]').click();
        });
    }

    $('.scroll_bar_main').mCustomScrollbar({
        scrollInertia:100,
        advanced:{autoScrollOnFocus:false},
        updateOnContentResize: true
    });


    if ($(window).width() > 1024) {

        // header fixed -----------------------------------
        topLinePosition();
        $(window).scroll(function() {
            topLinePosition();
        });


        // close fast view window -----------------------------------
        $('.close-btn, .popup_mask').on('click', function () {
            $('body').removeClass('noscroll');
            $('.fast_elem_wrapper .close-btn').hide();
            $('.product_card_fast').removeClass('fast-in');
            $('.popup_mask').fadeOut(100);
            $('.add_el').html("");
        });

    } else {

        // open mobile menu catalog
        $(document).on('click', '.open_list', function () {
            var id = $(this).attr('data-id');
            $(this).toggleClass('active');
            $('#' + id).slideToggle();
        });

        $(window).scroll(function () {
            var scroll = $(window).scrollTop();
            if (scroll > 10) {
                $('.header').addClass('fixed');
            } else {
                $(".header").removeClass('fixed');
            }
        });

// region open search title -----------------------------------

        $(document).on('click', '.search-link', function (e) {
            e.preventDefault();
            $('#search_in').toggleClass('open-in');
            $('#title-search-input').focus();
            $('.hamburger').removeClass('is-active');
            $('body').removeClass('noscroll menu-in');
            Closed = false;
        });
// endregion


// region open mobile menu

        var Closed = false;

        $('.hamburger').click(function () {
            if (Closed == true) {
                $('.hamburger').removeClass('is-active');
                $('body').removeClass('noscroll menu-in');
                Closed = false;
            } else {
                $('.hamburger').addClass('is-active');
                $('body').addClass('noscroll menu-in');
                Closed = true;
            }
        });
// endregion

    }




// region add to favourites  -----------------------------------
    $(document).on('click','.to_favorites',function() { // работа с закладками
        var name = 'FOREVER';
        var cookie_zac = BX.getCookie(name);

        if($(this).hasClass('active')){
            $(this).removeClass('active');
            var znach = $(this).attr('data-cookieid')+"|";
            var new_zac = cookie_zac.replace(znach,"");

            $('.goods_icon-counter').html(
                +($('.goods_icon-counter').html())-1
            );
            if($(this).data('remove')) {
                $(this).closest('.favour-item').remove();
            }
            BX.setCookie(name, new_zac, {expires: 86400,path:'/'});
        }else{
            $(this).addClass('active');

            if(cookie_zac == undefined){
                var znach = "|"+$(this).attr('data-cookieid')+"|";
                BX.setCookie(name, znach, {expires: 86400,path:'/'});
            }else{
                var znach = cookie_zac+$(this).attr('data-cookieid')+"|";
                BX.setCookie(name, znach, {expires: 86400,path:'/'});
            }
        }
        activZacladca();
        return false;
    });

    activZacladca();

});

function activZacladca() { // проверка есть ли товар в закладках
    var name = 'FOREVER';

    var cookie_zac = BX.getCookie(name);
    if (cookie_zac !== undefined) {
        var mas = cookie_zac.split('|');

        mas.forEach(function (item, i, mas) {
            if (item != "" ) {

                $('#favour_in .goods_icon-counter').html(
                    i
                );
                $(".to_favorites[data-cookieid='"+item+"']").addClass('active');
            }
        });
    }

}

$(function(){
    $(document).on('change', '.js-cust-field', function(){

        var form_data = new FormData;

        let text_arr = {};
        let files_arr = {};
        let files_comp = {};

        $('.js-text-f').each(function(){
            let pr_id = $(this).data('id');
            text_arr[pr_id] = $(this).val();
        });

        $('.js-upload-f').each(function(){
            let pr_id = $(this).data('id');
            let file = $(this)[0].files[0];
            if(file){
                files_comp[pr_id] = file.name;
                form_data.append("file[]", file);
            }
        });
        console.log(files_comp);

        // $.each($(".js-upload-f")[0].files, function(i, file) {
        //     console.log(file);
        //     form_data.append('file', file);
        // });

        form_data.append("text", JSON.stringify(text_arr));
        form_data.append("files_comp", JSON.stringify(files_comp));
        $.ajax({
            url: "/ajax/cake_save_file.php",
            type: "POST",
            processData: false,
            contentType:false,
            async:true,
            data: form_data,
            success:function(data){
                console.log(data);
                // console.log(JSON.parse(data));
                // $('input[name="FILES"]').val(data);
            }
        });
    });

    $(document).on('click', '.js-get-payment', function(e){
        e.preventDefault();
        let order_id = $(this).data().orderid;
        let th = $(this);
        $.ajax({
            type: 'post',
            url: "/ajax/get_payment_form.php",
            dataType: 'html',
            data: {order_id: order_id},
            success: function(data){
                if(data){
                    th.parent().find('.js-payment-wrapper').append(data);
                    th.parent().find('form').submit();
                }
            }
        });
    });
});

function changeCalendar() {
    var el = $('[id ^= "calendar_popup_"]'); //найдем div  с календарем
    var links = el.find(".bx-calendar-cell"); //найдем элементы отображающие дни
    $('.bx-calendar-left-arrow').attr({'onclick': 'changeCalendar();',}); //вешаем функцию изменения  календаря на кнопку смещения календаря на месяц назад
    $('.bx-calendar-right-arrow').attr({'onclick': 'changeCalendar();',}); //вешаем функцию изменения  календаря на кнопку смещения календаря на месяц вперед
    $('.bx-calendar-top-month').attr({'onclick': 'changeMonth();',}); //вешаем функцию изменения  календаря на кнопку выбора месяца
    $('.bx-calendar-top-year').attr({'onclick': 'changeYear();',}); //вешаем функцию изменения  календаря на кнопку выбора года
    // var date = new Date();

    let min_date = $('#soa-property-21').parents('.bx-soa-customer-field').data('date');
    let pattern = /(\d{2})\.(\d{2})\.(\d{4})/;
    let date = new Date(min_date.replace(pattern,'$3-$2-$1'));
    // date.setDate(date.getDate() + 1); // +1 день  !!!

    for (var i =0; i < links.length; i++)
    {
        var atrDate = links[i].attributes['data-date'].value;
        var d = date.valueOf();
        var g = links[i].innerHTML;
        if (date - atrDate >= 24*60*60*1000) {
            $('[data-date="' + atrDate +'"]').addClass("bx-calendar-date-hidden disabled"); //меняем класс у элемента отображающего день, который меньше по дате чем текущий день
        }
    }
}

$(function(){
    if($('input[name="ORDER_PROP_21"]').length && $('select[name="ORDER_PROP_23"]').length){
        setHoursRange();

        $(document).on('change', 'input[name="ORDER_PROP_21"]', function(){
            checkMinDate();
            setHoursRange();
        })
        $(document).on('click', 'select[name="ORDER_PROP_23"]', function(){
            setHoursRange();
        })

    }
});
function checkMinDate(){
    let min_date = $('input[name="ORDER_PROP_21"]').parents('.form-group').data('date');
    let cur_val = $('input[name="ORDER_PROP_21"]').val();
    let min_date_arr = min_date.split('.');
    let cur_val_arr = cur_val.split('.');
    let d1 = new Date(min_date_arr[2]+'-'+min_date_arr[1]+'-'+min_date_arr[0]);
    let d2 = new Date(cur_val_arr[2]+'-'+cur_val_arr[1]+'-'+cur_val_arr[0]);
    if(d2 < d1){
        $('input[name="ORDER_PROP_21"]').val(min_date);
    }
}
function setHoursRange(){
    let selected_date = $('input[name="ORDER_PROP_21"]').val();
    let min_date = $('input[name="ORDER_PROP_21"]').parents('.form-group').data('date');

    if(selected_date == min_date){
        let min_hour = $('select[name="ORDER_PROP_23"]').parents('.form-group').data('hour');
        $('select[name="ORDER_PROP_23"]').find('option').each(function(index, item){
            let range = $(this).val().split('-');
            console.log(index)
            if(index == 2 && range.length > 1 && min_hour<=parseInt(range[0])) return false;

            if(range.length > 1){
                $(this).prop( "disabled", true );
            }
            if(range.length > 1 && min_hour >= parseInt(range[0]) && min_hour < parseInt(range[1])){
                $(this).prop( "disabled", false);
                return false;
            }
        });
    }else{
        $('select[name="ORDER_PROP_23"]').find('option').each(function(){
            $(this).prop( "disabled", false);
        });
    }
}


