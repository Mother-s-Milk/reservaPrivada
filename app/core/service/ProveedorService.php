<?php

    namespace app\core\service;

    use app\core\model\dao\ProveedorDAO;
    use app\core\model\dto\ProveedorDTO;

    use app\core\service\base\InterfaceService;
    use app\core\service\base\Service;

    use app\libs\connection\Connection;

    final class ProveedorService extends Service implements InterfaceService {

        public function __construct () {
            parent::__construct();
        }

        public function save (array $object): void {
            $conn = Connection::get();
            $dao = new ProveedorDAO($conn);
            $dao->save(new ProveedorDTO($object));
        }

        public function load ($id): ProveedorDTO {
            $conn = Connection::get();
            $dao = new ProveedorDAO($conn);
            return $dao->load($id);
        }

        public function update (array $object): void {
            $conn = Connection::get();
            $dao = new ProveedorDAO($conn);
            $dao->update(new ProveedorDTO($object));
        }

        public function delete ($id): void {
            $conn = Connection::get();
            $dao = new ProveedorDAO($conn);
            $dao->delete($id);
        }

        public function list (): array {
            $conn = Connection::get();
            $dao = new ProveedorDAO($conn);
            return $dao->list();
        }

        public function listPage($data): array {
            $conn = Connection::get();
            $dao = new ProveedorDAO($conn);
            return $dao->listPage($data);
        }

        public function filter($data ): array {
            $conn = Connection::get();
            $dao = new ProveedorDAO($conn);
            return $dao->filter($data);
        }
    }

?>