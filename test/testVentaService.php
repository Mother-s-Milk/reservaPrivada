<?php

    require_once "../app/vendor/autoload.php";
    require_once "../app/config/DBConfig.php";

    use app\core\service\Service;
    use app\core\service\VentaService;

    use app\core\model\base\InterfaceDTO;
    use app\core\model\dto\VentaDTO;

    try {
        echo '<p>Hola desde el test del service</p>';

        $detalles = [
            [
                "ventaId" => 0,
                "bebidaId" => 16,
                "cantidad" => 10
            ],
            [
                "ventaId" => 0,
                "bebidaId" => 18,
                "cantidad" => 5
            ]
        ];

        $venta = [
            "id" => 0,
            "fecha" => "",
            "hora" => "",
            "detalles" => $detalles
        ];

        $ventaService = new VentaService();

        //$ventaService->save($venta);
        $listaVentas = $ventaService->list();
        foreach ($listaVentas as $venta) {
            // Supongamos que VentaDTO tiene métodos getter
            echo "ID Venta: " . $venta->getId() . "<br>";
            echo "Fecha: " . $venta->getFecha() . "<br>";
            echo "Hora: " . $venta->getHora() . "<br>";

            echo "Detalles: <br>";
            foreach ($venta->getDetalles() as $detalle) {
                echo "-- Bebida ID: " . $detalle->getBebidaId() . "<br>";
                echo "-- Cantidad: " . $detalle->getCantidad() . "<br>";
            }
            echo "<hr>";
        }
        //$ventaService->delete(31);
        //$ventaService->delete(32);
    }
    catch (PDOException $ex) {
        print_r($ex->getMessage());
    }


?>