<?php

    require_once "../app/config/DBConfig.php";
    require_once "../app/vendor/autoload.php";

    use app\libs\connection\Connection;

    use app\core\model\dao\ProveedorDAO;
    use app\core\model\dto\ProveedorDTO;

    try {
        $conn = Connection::get();
        echo ('Conexion establecida');

        $p1 = [
            "id" => 0,
            "nombre" => "Bodegas del Sol S.A",
            "telefono" => "+54 9 261 555 1234",
            "email" => "contacto@bodegasdelsol.com",
            "direccion" => "Ruta Nacional 7, Km 1100, Mendoza, Argentina"
        ];

        $p2 = [
            "id" => 0,
            "nombre" => "Viñedos Tierra Noble",
            "telefono" => "+56 9 9876 5432",
            "email" => "ventas@tierranoble.cl",
            "direccion" => "Avenida del Valle 234, Santiago, Chile"
        ];

        $p3 = [
            "id" => 0,
            "nombre" => "Importadora VinArt",
            "telefono" => "+34 91 234 5678",
            "email" => "info@vinart.es",
            "direccion" => "Calle Mayor 45, Madrid, España"
        ];

        $p4 = [
            "id" => 0,
            "nombre" => "Bebidas Premium Global",
            "telefono" => "+1 212 555 6789",
            "email" => "support@bebidaspremium.com",
            "direccion" => "123 Broadway, Nueva York, EE.UU."
        ];

        $p5 = [
            "id" => 0,
            "nombre" => "Cervezas y Vinos Artesanales SRL",
            "telefono" => "+54 9 11 6789 4321",
            "email" => "contacto@artesanalessrl.com",
            "direccion" => "Calle San Martín 678, Córdoba, Argentina"
        ];

        $dao = new ProveedorDAO($conn);

        try {
            $dao->save(new ProveedorDTO($p1));
            $dao->save(new ProveedorDTO($p2));
            $dao->save(new ProveedorDTO($p3));
            $dao->save(new ProveedorDTO($p4));
            $dao->save(new ProveedorDTO($p5));
        }
        catch (Exception $ex) {
            print_r($ex->getMessage());
        }
    }
    catch (PDOException $ex) {
        echo '<p>Error de conexión' . $ex->getMessage() . '</p>';
    }

?>