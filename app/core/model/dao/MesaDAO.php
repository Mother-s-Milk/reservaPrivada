<?php
    namespace app\core\model\dao;

    use app\core\model\base\DAO;
    use app\core\model\base\InterfaceDAO;
    use app\core\model\base\InterfaceDTO;
    use app\core\model\validate\MesaV;
    use app\core\model\dto\MesaDTO;

    final class MesaDAO extends DAO implements InterfaceDAO {

        public function __construct ($conn) {
            parent::__construct ($conn, "mesas");
        }

        public function save (InterfaceDTO $object): void {

            $validation = new MesaV($this->conn);
            $validation->validationUS($object);

            $sql = "INSERT INTO {$this->table} VALUES (DEFAULT,:descripcion,:disponibilidad)";
            $stmt = $this->conn->prepare($sql);
            $data = $object->toArray();

            unset($data["id"]);
            $stmt->execute($data);

            $object->setId((int)$this->conn->lastInsertId());
        }

        //Devuelvo el objeto en formato DTO para se utilizado por la logica de negocio. Se devuelve mas especificamente al service o al controller del back y se transforma a JSON.
        public function load ($id): InterfaceDTO {
            $sql = "SELECT * FROM {$this->table} WHERE id = :id";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute(["id" => $id]);

            $data = $stmt->fetch(\PDO::FETCH_ASSOC);
            if (!$data) {
                throw new \Exception("Mesa con ID {$id} no encontrada.");
            }
            return new MesaDTO($data);
        }

        public function update (InterfaceDTO $object): void {

            $validation = new MesaV($this->conn);
            $validation->validationUS($object);

            $sql = "UPDATE {$this->table} SET descripcion = :descripcion, disponibilidad = :disponibilidad WHERE id = :id";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute($object->toArray());
        }

        public function delete ($id): void {

            $validation = new MesaV($this->conn);
            $validation->validationD($id);

            $sql = "DELETE FROM {$this->table} WHERE id = :id";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute(["id" => $id]);

            if ($stmt->rowCount() === 0) {
                echo "No se encontró el registro con ID {$id}.";
            }
        }

        public function list (): array {
            $sql = "SELECT id,descripcion,disponibilidad FROM {$this->table}";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute();
            return $stmt->fetchAll(\PDO::FETCH_ASSOC);
        }

    }

?>