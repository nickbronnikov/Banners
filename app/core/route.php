<?php
require_once DOCUMENT_ROOT.'/app/models/Banner.php';
class Route
{
    static function redirect($url, $permanent = false){
        header('Location: ' . $url, true, $permanent ? 301 : 302);

        exit();
    }
    static function getUrlSegment($index){
        $routes = explode('/', $_SERVER['REQUEST_URI']);
        return $routes[$index];
    }

    static function setLocalisation()
    {
        //По умолчанию выбираем русскоязычную версию сайта
        $lang = 'RU';

        $local_file = DOCUMENT_ROOT.'/localisations/main/'.$lang.'.php';
        if(file_exists($local_file)){
            require $local_file;
            define('LOCAL', $LOCAL);
        }
    }

    static function start()
    {
        // контроллер и действие по умолчанию
        $controller_name = 'main';
        $action_name = 'index';

        self::setLocalisation();




        // получаем имя контроллера
        if ( !empty(self::getUrlSegment(1)) )
        {
            $controller_name = self::getUrlSegment(1);
        }

        // получаем имя экшена
        if ( !empty(self::getUrlSegment(2)) )
        {
            $action_name = self::getUrlSegment(2);
        }

        $banner = new Banner();

        if($banner->getBannerByURL(self::getUrlSegment(1))){
            $controller_name = 'bannerc';
            $action_name = 'index';
        }

        // добавляем префиксы
        $model_name = $controller_name;

        // подцепляем файл с классом модели (файла модели может и не быть)

        $model_file = strtolower($model_name).'.php';
        $model_path = "app/models/".$model_file;
        if(file_exists($model_path))
        {
            include $model_path;
        }

        // подцепляем файл с классом контроллера
        $controller_file = strtolower($controller_name).'.php';
        $controller_path = "app/controllers/".$controller_file;
        if(file_exists($controller_path))
        {
            include $controller_path;
            // создаем контроллер
            $controller = new $controller_name;
            $action = $action_name;

            if(method_exists($controller, $action))
            {
                // вызываем действие контроллера
                $controller->$action();
            }
            else
            {
                // здесь также разумнее было бы кинуть исключение
                Route::ErrorPage404();
            }
        }
        else
        {
            /*
            правильно было бы кинуть здесь исключение,
            но для упрощения сразу сделаем редирект на страницу 404
            */
            Route::ErrorPage404();
        }



    }

    static function ErrorPage404()
    {
        include "app/controllers/Page404.php";
        $controller = new Page404();
        $action = 'main';
        $controller->$action();
    }
}