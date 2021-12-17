<?
include_once($_SERVER['DOCUMENT_ROOT'].'/bitrix/modules/main/include/urlrewrite.php');

CHTTP::SetStatus("404 Not Found");
@define("ERROR_404","Y");

require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");

$APPLICATION->SetTitle("404 Not Found");

?>

<style>
    .page_404 {
        align-items: center;
        margin-top: 50px;
    }

    .page_404 .text_404 {
        position: relative;
    }

    .page_404 .number {
        position: relative;
        text-align: center;
    }

    .page_404 .number .embed-responsive {
        max-width: 500px;
        margin: auto;
    }
    .page_404 .number-img {
        -webkit-background-size: contain;
        background-size: contain;
        background-repeat: no-repeat;
        background-position: 50%;
    }

    .page_404 .title_404 {
        font-size: 28px;
        margin-bottom: 30px;
        text-transform: uppercase;
        background: linear-gradient(to right, #42672f, #81bc3d, #42672f);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        color: #81bc3d;
        font-weight: bold;
        text-align: center;
    }

    .page_404 .content_404 {
        font-size: 20px;
        text-align: center;
        margin-top: 30px;
    }

    .page_404 ul {
        line-height: 24px;
        font-size: 16px;
        margin-top: 20px;
    }

    .page_404 ul li {
        position: relative;
        padding-left: 25px;
        margin: 0;
    }

    .page_404 ul li:before {
        top: 11px;
        width: 15px;
        height: 2px;
    }

    .page_404 .back_link {
        padding-top: 30px;
        text-align: center;
    }

    .page_404 .back_link a {
        position: relative;
    }
    .page_404 .back_link a span {
        margin-left: 5px;
        margin-right: 5px;
    }

    .page_404 .back_link a:hover,
    .page_404 .back_link a:active {
        text-decoration: none;
    }

    .page_404 svg {
        fill: #81bc3d;
        width: 40px;
        height: 40px;
        transition: ease-out .25s;
        position: absolute;
        top: 50%;
        left: 0;
        margin-top: -18px;
    }
</style>

<div class="wrapper-inner">

    <div class="page_404 row">
        <div class="title_404 col-12">Произошла ошибка, нам очень жаль</div>
        <div class="number col-12">
            <div class="embed-responsive embed-responsive-16by9">
                <div class="number-img embed-responsive-item"></div>
            </div>
        </div>
        <div class="text_404 col-12">
            <div class="content_404">
                <p>Страницы, которую Вы искали, нет на нашем сайте.</p>
                <p>Возможно Вы ввели неправильный адрес, или страница была удалена.</p>
            </div>
            <div class="back_link">
                <a href="/" class="btn-primary">
                    <span class="fa fa-angle-left"></span>
                    <span>вернуться на главную</span>
                </a>
            </div>
        </div>
    </div>

</div>

<?

require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>