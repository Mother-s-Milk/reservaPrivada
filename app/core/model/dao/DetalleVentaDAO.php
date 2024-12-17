<?php

    namespace app\core\model\dao;

    use app\core\model\base\DAO;
    use app\core\model\base\InterfaceDAO;
    use app\core\model\base\InterfaceDTO;

    use app\core\model\dto\DetalleVentaDTO;

    final class DetalleVentaDAO extends DAO implements InterfaceDAO {

        public function __construct ($conn) {
            parent::__construct ($conn, 'detallesVenta');
        }

        public function save (InterfaceDTO $object): void {
            $sql = "INSERT INTO {$this->table} VALUES (DEFAULT, :ventaId, :bebidaId, :precio, :cantidad)";
            $stmt = $this->conn->prepare($sql);
            $data = $object->toArray();
            unset($data["id"]);
            $stmt->execute($data);

            $object->setId((int)$this->conn->lastInsertId());
        }

        public function load ($id): InterfaceDTO {
            $sql = "SELECT ventaId, bebidaId, cantidad FROM {$this->table} WHERE id = :id";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute(["id" => $id]);

            $data = $stmt->fetch(\PDO::FETCH_ASSOC);
            if (!$data) {
                throw new \Exception("Detalle con ID {$id} no encontrado.");
            }
            return new DetalleVentaDTO($data);
        }

        public function update (InterfaceDTO $object): void {
            $sql = "UPDATE {$this->table} SET ventaId = :ventaId, bebidaId = :bebidaId, cantidad = :cantidad WHERE id = :id";
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

    }

?>