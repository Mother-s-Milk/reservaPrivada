<?php

namespace app\core\model\dao;

use app\core\model\base\DAO;
use app\core\model\base\InterfaceDAO;
use app\core\model\base\InterfaceDTO;

use app\core\model\dto\ReservaDTO;
use app\core\model\validate\ReservaV;

final class ReservaDAO extends DAO implements InterfaceDAO
{

    public function __construct($conn)
    {
        parent::__construct($conn, 'reservas');
    }

    public function save(InterfaceDTO $object): void
    {
        $validation = new ReservaV($this->conn);
        $validation->validationUS($object);

        $sql = "INSERT INTO {$this->table} VALUES (DEFAULT, :apellido, :nombres, :telefono, :fecha, :hora, :detalles, :estado)";
        $stmt = $this->conn->prepare($sql);
        $data = $object->toArray();

        unset($data["id"]);
        $stmt->execute($data);

        $object->setId((int)$this->conn->lastInsertId());
    }

    public function load($id): InterfaceDTO
    {
        $sql = "SELECT id, apellido, nombres, telefono, fecha, hora, detalles, estado FROM {$this->table} WHERE id = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute(["id" => $id]);

        $data = $stmt->fetch(\PDO::FETCH_ASSOC);
        if (!$data) {
            throw new \Exception("Reserva con ID {$id} no encontrada.");
        }
        return new ReservaDTO($data);
    }

    public function update(InterfaceDTO $object): void
    {
        $validation = new ReservaV($this->conn);
        $validation->validationUS($object);


        $sql = "UPDATE {$this->table} SET apellido = :apellido, nombres = :nombres, telefono = :telefono, fecha = :fecha, hora = :hora, detalles = :detalles, estado = :estado WHERE id = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute($object->toArray());
    }

    public function delete($id): void
    {
        $sql = "DELETE FROM {$this->table} WHERE id = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute(["id" => $id]);

        if ($stmt->rowCount() === 0) {
            echo "No se encontró el registro con ID {$id}.";
        }
    }

    public function list(): array
    {
        $sql = "SELECT apellido, nombres, telefono, fecha, hora, detalles, estado FROM {$this->table}";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }
}
