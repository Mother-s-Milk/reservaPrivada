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

        $sql = "INSERT INTO {$this->table} VALUES (DEFAULT, :apellido, :nombres, :telefono, :fecha, :hora, :personas ,:detalles, :estado)";
        $stmt = $this->conn->prepare($sql);
        $data = $object->toArray();

        unset($data["id"]);
        $stmt->execute($data);

        $object->setId((int)$this->conn->lastInsertId());
    }

    public function changeState(InterfaceDTO $object): void
    {

        $sql = "UPDATE {$this->table} SET estado = :estado WHERE id = :id";
        $stmt = $this->conn->prepare($sql);

        $stmt->execute([
            ':estado' => $object->getEstado(),
            ':id' => $object->getId()
        ]);
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

        $sql = "UPDATE {$this->table} SET apellido = :apellido, nombres = :nombres, telefono = :telefono, fecha = :fecha, hora = :hora, detalles = :detalles, estado = :estado , personas = :personas WHERE id = :id";
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
        $sql = "SELECT id,apellido, nombres, telefono, fecha, hora, detalles, estado FROM {$this->table}";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function listPage($data): array
    {
        $offset = ($data["page"] - 1) * $data['pageSize'];

        // Consulta para obtener los datos paginados
        $sql = "SELECT id, apellido, nombres, telefono, fecha, hora, personas, detalles, estado 
            FROM {$this->table}
            LIMIT :limit OFFSET :offset";

        // Consulta para contar el total de elementos
        $countSql = "SELECT COUNT(*) as total FROM {$this->table}";

        // Ejecutar la consulta de conteo
        $countStmt = $this->conn->prepare($countSql);
        $countStmt->execute();
        $total = $countStmt->fetch(\PDO::FETCH_ASSOC)['total'];

        // Ejecutar la consulta principal con paginación
        $stmt = $this->conn->prepare($sql);
        $stmt->bindValue(':limit', $data['pageSize'], \PDO::PARAM_INT);
        $stmt->bindValue(':offset', $offset, \PDO::PARAM_INT);
        $stmt->execute();
        $results = $stmt->fetchAll(\PDO::FETCH_ASSOC);

        // Retornar los resultados y el total
        return [
            'data' => $results,
            'total' => $total
        ];
    }

    public function filter($data): array
    {
        $offset = ($data["page"] - 1) * $data['pageSize'];

        // Base de la consulta SQL
        $baseSql = "SELECT id, apellido, nombres, telefono, fecha, hora, personas, detalles, estado 
                FROM {$this->table}";

        // Base de la consulta de conteo
        $countSql = "SELECT COUNT(*) as total FROM {$this->table}";

        // Inicializar el array de condiciones
        $conditions = [];
        $params = [];

        // Filtro por fechas
        if (!empty($data['fechaInicio']) && !empty($data['fechaFin'])) {
            $conditions[] = "fecha BETWEEN :fechaInicio AND :fechaFin";
            $params[':fechaInicio'] = $data['fechaInicio'];
            $params[':fechaFin'] = $data['fechaFin'];
        }

        // Filtro por estado
        if (!empty($data['estado'])) {
            $conditions[] = "estado = :estado";
            $params[':estado'] = $data['estado'];
        }

        // Agregar las condiciones a las consultas si existen
        if (!empty($conditions)) {
            $whereClause = " WHERE " . implode(" AND ", $conditions);
            $baseSql .= $whereClause;
            $countSql .= $whereClause;
        }

        // Consulta principal con paginación
        $baseSql .= " LIMIT :limit OFFSET :offset";

        // Ejecutar la consulta de conteo
        $countStmt = $this->conn->prepare($countSql);
        foreach ($params as $key => $value) {
            $countStmt->bindValue($key, $value);
        }
        $countStmt->execute();
        $total = $countStmt->fetch(\PDO::FETCH_ASSOC)['total'];

        // Ejecutar la consulta principal
        $stmt = $this->conn->prepare($baseSql);
        foreach ($params as $key => $value) {
            $stmt->bindValue($key, $value);
        }
        $stmt->bindValue(':limit', $data['pageSize'], \PDO::PARAM_INT);
        $stmt->bindValue(':offset', $offset, \PDO::PARAM_INT);
        $stmt->execute();
        $results = $stmt->fetchAll(\PDO::FETCH_ASSOC);

        // Retornar los resultados y el total
        return [
            'data' => $results,
            'total' => $total
        ];
    }

    public function pages(): int
    {
        $sql = "SELECT COUNT(*) as total FROM {$this->table}";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetch(\PDO::FETCH_ASSOC);
        return (int)$result['total'];
    }
}
