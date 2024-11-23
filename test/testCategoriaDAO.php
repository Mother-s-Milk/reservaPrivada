<?php
    //En este archivo interactuo con el DAO, es decir, la base de datos, manipulando objetos de tipo Categoria
    require_once "../app/config/DBConfig.php";
    require_once "../app/vendor/autoload.php";

    use app\libs\connection\Connection;

    use app\core\model\dao\CategoriaDAO;
    use app\core\model\dto\CategoriaDTO;

    try {
        $conn = Connection::get();
        echo ('Conexion establecida');

        $c1 = [
            "id" => 0,
            "nombre" => "Vinos Tintos"
        ];

        $c2 = [
            "id" => 0,
            "nombre" => "Vinos Blancos"
        ];

        $c3 = [
            "id" => 0,
            "nombre" => "Vinos Espumosos"
        ];

        $c4 = [
            "id" => 0,
            "nombre" => "Vinos Rosados"
        ];

        $c5 = [
            "id" => 0,
            "nombre" => "Vinos de Postre"
        ];

        $c6 = [
            "id" => 0,
            "nombre" => "Cervezas Artesanales"
        ];

        $c7 = [
            "id" => 0,
            "nombre" => "Destilados y Licores"
        ];

        $c8 = [
            "id" => 0,
            "nombre" => "Bebidas sin Alcohol"
        ];

        $dao = new CategoriaDAO($conn);

        try {
            $dao->save(new CategoriaDTO($c1));
            $dao->save(new CategoriaDTO($c2));
            $dao->save(new CategoriaDTO($c3));
            $dao->save(new CategoriaDTO($c4));
            $dao->save(new CategoriaDTO($c5));
            $dao->save(new CategoriaDTO($c6));
            $dao->save(new CategoriaDTO($c7));
            $dao->save(new CategoriaDTO($c8));
        }
        catch (Exception $ex) {
            print_r($ex->getMessage());
        }
    }
    catch (PDOException $ex) {
        echo '<p>Error de conexión' . $ex->getMessage() . '</p>';
    }

?>