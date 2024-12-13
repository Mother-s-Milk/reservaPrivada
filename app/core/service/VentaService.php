<?php

    namespace app\core\service;

    use app\core\model\dao\VentaDAO;
    use app\core\model\dto\VentaDTO;

    use app\core\service\base\InterfaceService;
    use app\core\service\base\Service;

    use app\libs\connection\Connection;

    final class VentaService extends Service implements InterfaceService {

        public function __construct () {
            parent::__construct();
        }

        public function save (array $object): void {
            $conn = Connection::get();
            $dao = new VentaDAO($conn);
            $dao->save(new VentaDTO($object));
        }

        public function load ($id): VentaDTO {
            $conn = Connection::get();
            $dao = new VentaDAO($conn);
            return $dao->load($id);
        }

        public function update(array $object): void {
            throw new \Exception("No es posible actualizar una venta, ya que sus datos son automáticos e inmutables.");
        }

        public function delete ($id): void {
            $conn = Connection::get();
            $dao = new VentaDAO($conn);
            $dao->delete($id);
        }

        public function list (): array {
            $conn = Connection::get();
            $dao = new VentaDAO($conn);
            return $dao->list();
        }

    }

?>