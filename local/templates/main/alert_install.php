<?php
/**
 * Created by PhpStorm.
 * User: aleksander
 * Date: 22.07.2019
 * Time: 11:46
 */

//\Bitrix\Main\Loader::includeSharewareModule("krayt.cosmetics") == \Bitrix\Main\Loader::MODULE_DEMO_EXPIRED ||
    //\Bitrix\Main\Loader::includeSharewareModule("krayt.cosmetics") ==  \Bitrix\Main\Loader::MODULE_NOT_FOUND
?>
<?if(Bitrix\Main\Loader::includeSharewareModule("krayt.cosmetics") ==  \Bitrix\Main\Loader::MODULE_DEMO_EXPIRED):?>
<div id="alert-module">
    <div class="alert-module-content">
        <h2>Модуль - Интернет-магазин косметики, парфюмерии, техники для красоты <br> 'Крайт: Косметика.Beauty' <span class="alert-module-red">не установлен</span></h2>
        <p>
            Для работы с сайтом установить модуль "krayt.cosmetics".
          <br>  <a class="btn btn-green-gradient" href="/bitrix/admin/partner_modules.php?lang=ru">Установить</a>
        </p>
    </div>
</div>
<?endif;?>
<?if(Bitrix\Main\Loader::includeSharewareModule("krayt.cosmetics") ==  \Bitrix\Main\Loader::MODULE_NOT_FOUND):?>
    <div id="alert-module">
        <div class="alert-module-content">
            <h2>Модуль - Интернет-магазин косметики, парфюмерии, техники для красоты <br> 'Крайт: Косметика.Beauty'
                <br> <span class="alert-module-red">закончился демо режим</span></h2>
            <p>
                Для работы с сайтом оплатите модуль "krayt.cosmetics".
                <br>  <a target="_blank" class="btn btn-green-gradient" href="http://marketplace.1c-bitrix.ru/solutions/krayt.cosmetics/">Купить</a>
            </p>
        </div>
    </div>
<?endif;?>
<style>
    body{
        overflow: hidden;
    }
    #alert-module{
        position: absolute;
        width: 100%;
        height: 100%;
        background-color: #fff;
        z-index: 1000000;
        top:0;
        left: 0;
        right: 0;
        bottom: 0;
        text-align: center;
    }
    .alert-module-content{
        position: absolute;
        width: 60%;
        top:0;
        bottom: 0;
        height: 200px;
        margin: auto;
        left: 0;
        right: 0;
    }
    .alert-module-content p{
        margin-top: 10px;
    }
    .alert-module-red{
        color: red;
    }
</style>