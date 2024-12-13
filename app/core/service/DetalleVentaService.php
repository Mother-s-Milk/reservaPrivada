<?php

    namespace app\core\service;

    use app\core\model\dao\DetalleVentaDAO;
    use app\core\model\dto\DetalleVentaDTO;

    use app\core\service\base\InterfaceService;
    use app\core\service\base\Service;

    use app\libs\connection\Connection;

    final class DetalleVentaService extends Service implements InterfaceService {

        public function __construct () {
            parent::__construct();
        }

        public function save (array $object): void {
            $conn = Connection::get();
            $dao = new DetalleVentaDAO($conn);
            $dao->save(new DetalleVentaDTO($object));
        }

        public function load ($id): DetalleVentaDTO {
            $conn = Connection::get();
            $dao = new DetalleVentaDAO($conn);
            return $dao->load($id);
        }

        public function update (array $object): void {
            $conn = Connection::get();
            $dao = new DetalleVentaDAO($conn);
            $dao->update(new DetalleVentaDTO($object));
        }

        public function delete ($id): void {
            $conn = Connection::get();
            $dao = new DetalleVentaDAO($conn);
            $dao->delete($id);
        }

    }

?>