<?php

    use app\App;

    require_once '../app/config/AppConfig.php';
    require_once '../app/config/DBConfig.php';
    require_once '../app/vendor/autoload.php';

    App::run();

    //Recupero los valores de los parametros dela URL de la forma especificada en el .htaccess
    /*$controller = $_GET['controller'] ?? 'home'; //Por defecto
    $action = $_GET['action'] ?? 'index';
    $id = $_GET['id'] ?? null;
    $extra = $_GET['extra'] ?? null;*/

    /*switch ($controller) {
        case 'bebida':
            switch ($action) {
                case 'index':
                    include "../app/resources/views/bebida/index.php";
                    break;
                case 'alta':
                    include "../app/resources/views/bebida/alta.php";
                    break;
                default:
                    echo ('Error');
            }
            break;
        default:
        echo ("Error");
    }*/

?>