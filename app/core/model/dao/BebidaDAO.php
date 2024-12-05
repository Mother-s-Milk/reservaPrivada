<?php

    namespace app\core\model\dao;

    use app\core\model\base\DAO;
    use app\core\model\base\InterfaceDAO;
    use app\core\model\base\InterfaceDTO;

    use app\core\model\dto\BebidaDTO;
use app\core\model\validate\BebidadV;

    final class BebidaDAO extends DAO implements InterfaceDAO {

        public function __construct ($conn) {
            parent::__construct ($conn, 'bebidas');
        }

        public function save (InterfaceDTO $object): void {
            $validation = new BebidadV($this->conn);
            $validation->validationUS($object);
            
            $sql= "INSERT INTO {$this->table} VALUES (DEFAULT, :nombre, :descripcion, :categoriaId, :precioUnitario, :stock, :marca, :proveedorId)";
            $stmt = $this->conn->prepare($sql);
            $data = $object->toArray();

            unset($data["id"]);
            $stmt->execute($data);

            $object->setId((int)$this->conn->lastInsertId());
        }

        //Ver como puedo usar los id para obtener los nombres en lugar del valor del id de la categoria y el proveedor.
        public function load ($id): InterfaceDTO {
            $sql = "SELECT id, nombre, descripcion, categoriaId, precioUnitario, stock, marca, proveedorId FROM {$this->table} WHERE id = :id";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute([
                "id" => $id
            ]);

            //prueba de id inexistente
            $data = $stmt->fetch(\PDO::FETCH_ASSOC);
            if (!$data) {
                throw new \Exception("Bebida con ID {$id} no encontrada.");
            }
            return new BebidaDTO($data);

            //return new BebidaDTO($stmt->fetch(\PDO::FETCH_ASSOC));
        }

        public function update (InterfaceDTO $object): void {
            $validation = new BebidadV($this->conn);
            $validation->validationUS($object);
            
            $sql = "UPDATE {$this->table} SET nombre = :nombre, descripcion = :descripcion, categoriaId = :categoriaId, precioUnitario = :precioUnitario, stock = :stock, marca = :marca, proveedorId = :proveedorId WHERE id = :id";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute($object->toArray());
        }

        public function delete ($id): void {
            $sql = "DELETE FROM {$this->table} WHERE id = :id";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute(["id" => $id]);

            if ($stmt->rowCount() === 0) {
                echo "No se encontró el registro con ID {$id}.";
            }
        }

        public function list (): array {
            /*$sql = "SELECT nombre, descripcion, categoriaId, precioUnitario, stock, marca, proveedorId FROM {$this->table}";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute();
            return $stmt->fetchAll(\PDO::FETCH_ASSOC);*/
            $sql = "
                SELECT
                    b.id,
                    b.nombre,
                    b.descripcion,
                    c.nombre AS categoriaId,
                    b.precioUnitario,
                    b.stock,
                    b.marca,
                    p.nombre AS proveedorId
                FROM {$this->table} AS b
                JOIN categorias AS c ON b.categoriaId = c.id
                JOIN proveedores AS p ON b.proveedorId = p.id
            ";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute();
            return $stmt->fetchAll(\PDO::FETCH_ASSOC);
        }

    }

?>