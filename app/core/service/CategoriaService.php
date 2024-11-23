<?php

    namespace app\core\service;

    use app\core\model\dao\CategoriaDAO;
    use app\core\model\dto\CategoriaDTO;

    use app\core\service\base\InterfaceService;
    use app\core\service\base\Service;

    use app\libs\connection\Connection;

    final class CategoriaService extends Service implements InterfaceService {

        public function __construct () {
            parent::__construct();
        }

        public function save (array $object): void {
            $conn = Connection::get();
            $dao = new CategoriaDAO($conn);
            $dao->save(new CategoriaDTO($object));
        }

        public function load ($id): CategoriaDTO {
            return new CategoriaDTO();
        }

        public function update (array $object): void {
        }

        public function delete ($id): void {
        }

        public function list (): array {
            $conn = Connection::get();
            $dao = new CategoriaDAO($conn);
            return $dao->list();
        }

    }

?>