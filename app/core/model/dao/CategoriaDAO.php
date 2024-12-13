<?php
    namespace app\core\model\dao;

    use app\core\model\base\DAO;
    use app\core\model\base\InterfaceDAO;
    use app\core\model\base\InterfaceDTO;
    use app\core\model\validate\CategoriaV;
    use app\core\model\dto\CategoriaDTO;

    final class CategoriaDAO extends DAO implements InterfaceDAO {

        public function __construct ($conn) {
            parent::__construct ($conn, "categorias");
        }

        public function save (InterfaceDTO $object): void {
<<<<<<< Updated upstream

            $validation = new CategoriaV($this->conn);
            $validation->validationUS($object);

            $sql = "INSERT INTO {$this->table} VALUES (DEFAULT, :nombre)";
=======
            $sql = "INSERT INTO {$this->table} VALUES (DEFAULT, :nombre, :descripcion)";
>>>>>>> Stashed changes
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
                throw new \Exception("Categoria con ID {$id} no encontrada.");
            }
            return new CategoriaDTO($data);
        }

        public function update (InterfaceDTO $object): void {
<<<<<<< Updated upstream

            $validation = new CategoriaV($this->conn);
            $validation->validationUS($object);

            $sql = "UPDATE {$this->table} SET nombre = :nombre WHERE id = :id";
=======
            $sql = "UPDATE {$this->table} SET nombre = :nombre, descripcion = :descripcion WHERE id = :id";
>>>>>>> Stashed changes
            $stmt = $this->conn->prepare($sql);
            $stmt->execute($object->toArray());
        }

        public function delete ($id): void {

            $validation = new CategoriaV($this->conn);
            $validation->validationD($id);

            $sql = "DELETE FROM {$this->table} WHERE id = :id";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute(["id" => $id]);

            if ($stmt->rowCount() === 0) {
                echo "No se encontró el registro con ID {$id}.";
            }
        }

        public function list (): array {
            $sql = "SELECT id, nombre, descripcion FROM {$this->table}";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute();
            return $stmt->fetchAll(\PDO::FETCH_ASSOC);
        }

    }

?>