<?php

    require_once "../app/config/DBConfig.php";
    require_once "../app/vendor/autoload.php";

    use app\libs\connection\Connection;

    use app\core\model\dao\ProveedorDAO;
    use app\core\model\dto\ProveedorDTO;

    try {
        $conn = Connection::get();
        echo ('Conexion establecida');

        $dao = new ProveedorDAO($conn);
        $newData = [
            "id" => 8,
            "nombre" => "El Gordo Beto",
            "telefono" => "297-488662",
            "email" => "loDeBeto@hotmail.com",
            "direccion" => "Caleta Olivia"
        ];

        try {
            print_r($dao->load(8));
            //$dao->update(new ProveedorDTO($newData));

        }
        catch (Exception $ex) {
            print_r($ex->getMessage());
        }
    }
    catch (PDOException $ex) {
        echo '<p>Error de conexión' . $ex->getMessage() . '</p>';
    }

?>