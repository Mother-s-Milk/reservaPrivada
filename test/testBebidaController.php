<?php

    require_once "../app/vendor/autoload.php";
    require_once "../app/config/AppConfig.php";
    require_once "../app/config/DBConfig.php";

    use app\core\controller\BebidaController;

    use app\libs\request\Request;
    use app\libs\response\Response;

    $bebidaController = new BebidaController();

    //$bebidaController->index();
    //$bebidaController->create();
    $request = new Request([]);
    $response = new Response();

?>