<?php

    require_once "../app/config/DBConfig.php";
    require_once "../app/vendor/autoload.php";

    use app\libs\connection\Connection;

    use app\core\model\dao\ProveedorDAO;
    use app\core\model\dto\ProveedorDTO;

    try {
        $conn = Connection::get();
        echo ('Conexion establecida');

        $proveedor1 = [
            "nombre" => "Bodegas López",
            "telefono" => "261-1234567",
            "email" => "bodegasLopez@gmail.com",
            "localidad" => "Maipú",
            "direccion" => "Ruta 60"
        ];

        $proveedor2 = [
            "nombre" => "Bodegas del Sol",
            "telefono" => "Bodegas del Sol",
            "email" => "contacto@bodegasdelsol.com",
            "localidad" => "Mendoza",
            "direccion" => "Calle Uva 123, Luján de Cuyo"
        ];

        $proveedor3 = [
            "nombre" => "Cervezas Artesanales Patagonia",
            "telefono" => "+54 9 383 321-6547",
            "email" => "ventas@cervezapatagonia.com",
            "localidad" => "Bariloche",
            "direccion" => "Av. Los Lagos 456, Bariloche"
        ];

        $proveedor4 = [
            "nombre" => "Destilados Andinos",
            "telefono" => "+54 9 383 987-1234",
            "email" => "info@destiladosandinos.com",
            "localidad" => "Córdoba",
            "direccion" => "Ruta Nacional 20, Km 30"
        ];

        $proveedor5 = [
            "nombre" => "Viñedos de la Costa",
            "telefono" => "+54 9 383 234-5678",
            "email" => "contacto@vinedosdelacosta.com",
            "localidad" => "Mar del Plata",
            "direccion" => "Calle Viña 567, Sierra de los Padres"
        ];

        $proveedor6 = [
            "nombre" => "Licores del Valle",
            "telefono" => "+54 9 383 456-1234",
            "email" => "pedidos@licoresdelvalle.com",
            "localidad" => "Salta",
            "direccion" => "Av. Principal 789, Cafayate"
        ];

        $proveedor7 = [
            "nombre" => "Bebidas Premium SRL",
            "telefono" => "+54 9 383 678-4321",
            "email" => "ventas@bebidaspremium.com",
            "localidad" => "Rosario",
            "direccion" => "Bv. Oroño 1234"
        ];

        $proveedorDAO = new ProveedorDAO($conn);

        try {
            $proveedorDAO->save(new ProveedorDTO($proveedor1));
            $proveedorDAO->save(new ProveedorDTO($proveedor2));
            $proveedorDAO->save(new ProveedorDTO($proveedor3));
            $proveedorDAO->save(new ProveedorDTO($proveedor4));
            $proveedorDAO->save(new ProveedorDTO($proveedor5));
            $proveedorDAO->save(new ProveedorDTO($proveedor6));
            $proveedorDAO->save(new ProveedorDTO($proveedor7));
        }
        catch (Exception $ex) {
            print_r($ex->getMessage());
        }
    }
    catch (PDOException $ex) {
        echo '<p>Error de conexión' . $ex->getMessage() . '</p>';
    }

?>