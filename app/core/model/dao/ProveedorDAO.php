<?php
    //Aca interactuo con las tablas de la base de datos haciendo consultas o creandolas.
    namespace app\core\model\dao;

    use app\core\model\base\DAO;
    use app\core\model\base\InterfaceDAO;
    use app\core\model\base\InterfaceDTO;

    use app\core\model\dto\ProveedorDTO;

    final class ProveedorDAO extends DAO implements InterfaceDAO {

        public function __construct ($conn) {
            parent::__construct ($conn, "proveedores");
        }

        public function save (InterfaceDTO $object): void {
            $sql = "INSERT INTO {$this->table} VALUES (DEFAULT, :nombre, :telefono, :email, :direccion)";
            $stmt = $this->conn->prepare($sql);
            $data = $object->toArray();

            unset($data["id"]);
            $stmt->execute($data);

            $object->setId((int)$this->conn->lastInsertId());
        }

        //Devuelvo el objeto en formato DTO para se utilizado por la logica de negocio. Se devuelve mas especificamente al service o al controller del back y se transforma a JSON.
        public function load ($id): InterfaceDTO {
            $sql = "SELECT id, nombre, telefono, email, direccion FROM {$this->table} WHERE id = :id";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute([
                "id" => $id
            ]);

            return new ProveedorDTO($stmt->fetch(\PDO::FETCH_ASSOC));
        }

        public function update (InterfaceDTO $object): void {
            $sql = "UPDATE {$this->table} SET nombre = :nombre, telefono = :telefono, email = :email, direccion = :direccion WHERE id = $id";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute($object->toArray());
        }

        public function delete ($id): void {
            $sql = "DELETE FROM {$this->table} WHERE id = :id";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute([
                "id" => $id
            ]);
        }

        public function list (): array {
            $sql = "SELECT id, nombre, telefono, email, direccion FROM {$this->table}";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute();
            return $stmt->fetchAll(\PDO::FETCH_ASSOC);
        }

    }

?>