<?php

    namespace app\core\service;

    use app\core\model\dao\ReservaDAO;
    use app\core\model\dto\ReservaDTO;

    use app\core\service\base\InterfaceService;
    use app\core\service\base\Service;

    use app\libs\connection\Connection;

    final class ReservaService extends Service implements InterfaceService {

        public function __construct () {
            parent::__construct();
        }

        public function save (array $object): void {
            $conn = Connection::get();
            $dao = new ReservaDAO($conn);
            $dao->save(new ReservaDTO($object));
        }

        public function load ($id): ReservaDTO {
            $conn = Connection::get();
            $dao = new ReservaDAO($conn);
            return $dao->load($id);
        }

        public function update (array $object): void {
            $conn = Connection::get();
            $dao = new ReservaDAO($conn);
            $dao->update(new ReservaDTO($object));
        }   

        public function changeState (array $object): void {
            $conn = Connection::get();
            $dao = new ReservaDAO($conn);
            $dao->changeState(new ReservaDTO($object));
        }

        public function delete ($id): void {
            $conn = Connection::get();
            $dao = new ReservaDAO($conn);
            $dao->delete($id);
        }

       public function list (): array {
            $conn = Connection::get();
            $dao = new ReservaDAO($conn);
            return $dao->list();
        }

        public function pages (): int {
            $conn = Connection::get();
            $dao = new ReservaDAO($conn);
            return $dao->pages();
        }


        public function listPage($data ): array {
            $conn = Connection::get();
            $dao = new ReservaDAO($conn);
            return $dao->listPage($data);
        }



    }

?>