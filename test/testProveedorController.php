<?php

    require_once "../app/vendor/autoload.php";
    require_once "../app/config/AppConfig.php";
    require_once "../app/config/DBConfig.php";

    use app\core\controller\base\Controller;
    use app\core\controller\base\InterfaceController;

    use app\core\controller\ProveedorController;

    use app\libs\request\Request;
    use app\libs\response\Response;

    $response = new Response();

    $request = new Request();
    $request->setController('proveedor');
    $request->setAction('save');
    
    $prueba = [
        "id" => 0,
        "nombre" => "Lo de Pipo",
        "telefono" => "297584789",
        "email" => "loDePipo@gmail.com",
        "direccion" => "En ningun lado"
    ];

    $controller = new ProveedorController();
    
    $controller->create();

    $respuesta = $controller->load(12, $response);
    print_r($respuesta);

?>