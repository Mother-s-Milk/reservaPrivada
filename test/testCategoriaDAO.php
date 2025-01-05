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
            "descripcion" => "Variedades de vinos elaborados a partir de uvas tintas, ideales para acompañar carnes rojas y platos fuertes.",
            "nombre" => "Vinos Tintos"
        ];

        $c2 = [
            "id" => 0,
            "descripcion" => "Vinos frescos y ligeros, producidos a partir de uvas blancas, perfectos para mariscos y comidas ligeras.",
            "nombre" => "Vinos Blancos"
        ];

        $c3 = [
            "id" => 0,
            "descripcion" => "Vinos con burbujas, ideales para celebraciones y brindis especiales.",
            "nombre" => "Vinos Espumosos"
        ];

        $c4 = [
            "id" => 0,
            "descripcion" => "Vinos de tonalidades rosadas, perfectos para acompañar ensaladas y platos ligeros.",
            "nombre" => "Vinos Rosados"
        ];

        $c5 = [
            "id" => 0,
            "descripcion" => "Vinos dulces y de postre, ideales para acompañar postres y quesos.",
            "nombre" => "Vinos de Postre"
        ];

        $c6 = [
            "id" => 0,
            "descripcion" => "Cervezas artesanales de diferentes estilos y sabores.",
            "nombre" => "Cervezas Artesanales"
        ];

        $c7 = [
            "id" => 0,
            "descripcion" => "Destilados y licores de diferentes tipos y sabores.",
            "nombre" => "Destilados y Licores"
        ];

        $c8 = [
            "id" => 0,
            "descripcion" => "Bebidas sin alcohol, refrescantes y deliciosas.",
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