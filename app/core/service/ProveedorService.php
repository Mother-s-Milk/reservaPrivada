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
            return new ProveedorDTO();
        }

        public function update (array $object): void {
        }

        public function delete ($id): void {
        }

        public function list (): array {
            $conn = Connection::get();
            $dao = new ProveedorDAO($conn);
            return $dao->list();
        }

    }

?>