<?php

    namespace app\core\service;

    use app\core\model\dao\BebidaDAO;
    use app\core\model\dto\BebidaDTO;

    use app\core\service\base\InterfaceService;
    use app\core\service\base\Service;

    use app\libs\connection\Connection;

    final class BebidaService extends Service implements InterfaceService {

        public function __construct () {
            parent::__construct();
        }

        public function save (array $object): void {
            $conn = Connection::get();
            $dao = new BebidaDAO($conn);
            $dao->save(new BebidaDTO($object));
        }

        public function load ($id): BebidaDTO {
            return new BebidaDTO();
        }

        public function update (array $object): void {
        }

        public function delete ($id): void {
        }

        public function list (): array {
            $conn = Connection::get();
            $dao = new BebidaDAO($conn);
            return $dao->list();
        }

    }

?>