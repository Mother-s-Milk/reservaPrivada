<?php

    require_once "../app/vendor/autoload.php";
    require_once "../app/config/DBConfig.php";

    use app\libs\connection\Connection;
    
    use app\core\model\dao\BebidaDAO;
    use app\core\model\dto\BebidaDTO;

    try {

        $conn = Connection::get();
        echo ('Conexion establecida');

        $dao = new BebidaDAO($conn);

        try {
            $dao->delete(1);
            echo '<p>Se borro la bebida exitosamente</p>';
        }
        catch (Exception $ex) {
            print_r($ex->getMessage());
        }

    }
    catch (PDOException $ex) {
        print_r('Error de conexion');
        //print_r($ex->getMessage());
    }

?>