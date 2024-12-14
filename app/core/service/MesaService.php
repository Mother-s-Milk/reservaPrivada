<?php

    namespace app\core\service;

    use app\core\model\dao\MesaDAO;
    use app\core\model\dto\MesaDTO;

    use app\core\service\base\InterfaceService;
    use app\core\service\base\Service;

    use app\libs\connection\Connection;

    final class MesaService extends Service implements InterfaceService {

        public function __construct () {
            parent::__construct();
        }

        public function save (array $object): void {
            $conn = Connection::get();
            $dao = new MesaDAO($conn);
            $dao->save(new MesaDTO($object));
        }

        public function load ($id): MesaDTO {
            $conn = Connection::get();
            $dao = new MesaDAO($conn);
            return $dao->load($id);
        }

        public function update (array $object): void {
            $conn = Connection::get();
            $dao = new MesaDAO($conn);
            $dao->update(new MesaDTO($object));
        }

        public function delete ($id): void {
            $conn = Connection::get();
            $dao = new MesaDAO($conn);
            $dao->delete($id);
        }

        public function list (): array {
            $conn = Connection::get();
            $dao = new MesaDAO($conn);
            return $dao->list();
        }

    }

?>