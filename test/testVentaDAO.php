<?php

    require_once "../app/config/AppConfig.php";
    require_once "../app/config/DBConfig.php";
    require_once "../app/vendor/autoload.php";

    use app\libs\connection\Connection;

    use app\core\model\dao\VentaDAO;
    use app\core\model\dto\VentaDTO;

    use app\core\model\dto\DetalleVentaDTO;
    use app\core\model\dao\DetalleVentaDAO;

    try {
        $conn = Connection::get();
        echo '<p>Conexion establecida</p>';

        $dao = new VentaDAO($conn);

        $detallesData = [
            ["id" => 0,
            "ventaId" => 0,
            "bebidaId" => 16,
            "cantidad" => 2],
            ["id" => 0,
            "ventaId" => 0,
            "bebidaId" => 18,
            "cantidad" => 1]
        ];

        $ventaData = [
            "id" => 0,
            "fecha" => "",
            "hora" => "",
            "detalles" => $detallesData
        ];
    
        $ventaDTO = new VentaDTO($ventaData);
    
        $ventaDAO = new VentaDAO($conn);

        //$ventaDAO->save($ventaDTO);

        $ventas = $ventaDAO->list();
        var_dump($ventas);
        
    }
    catch (PDOException $ex) {
        print_r($ex->getMessage());
    }

?>