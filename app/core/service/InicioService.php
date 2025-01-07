<?php

    namespace app\core\service;

    use app\core\model\dao\ProveedorDAO;
    use app\core\model\dao\BebidaDAO;
    use app\core\model\dao\VentaDAO;
    use app\core\model\dao\ReservaDAO;

    use app\core\service\base\Service;
    use app\libs\Connection\Connection;

    final class InicioService extends Service {

        public function __construct () {
            parent::__construct();
        }

        public function consultarVentas (): array {
            $conn = Connection::get();
            $dao = new VentaDAO($conn);
            return $dao->consultarVentas();
        }

        public function consultarBajoStock (): array {
            $conn = Connection::get();
            $dao = new BebidaDAO($conn);
            return $dao->consultarBajoStock();
        }

        public function consultarReservas (): array {
            $conn = Connection::get();
            $dao = new ReservaDAO($conn);
            return $dao->consultarReservas();
        }

        public function consultarProveedores (): int {
            $conn = Connection::get();
            $dao = new ProveedorDAO($conn);
            return $dao->consultarProveedores();
        }

        public function consultarBebidas (): int {
            $conn = Connection::get();
            $dao = new BebidaDAO($conn);
            return $dao->consultarBebidas();
        }

        public function consultarVentasSemanales (): array {
            $conn = Connection::get();
            $dao = new VentaDAO($conn);
            return $dao->consultarVentasSemanales();
        }

        public function mostrarInicioVentas():array{
            $conn = Connection::get();
            $dao = new VentaDAO($conn);
            return $dao->mostrarInicioVentas();
        }

    }

?>