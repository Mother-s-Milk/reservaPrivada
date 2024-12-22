<?php
//Aca interactuo con la base de datos directamente.
namespace app\core\model\dao;

use app\core\model\base\DAO;
use app\core\model\base\InterfaceDAO;
use app\core\model\base\InterfaceDTO;

use app\core\model\dto\ProveedorDTO;
use app\core\model\validate\ProveedorV;

final class ProveedorDAO extends DAO implements InterfaceDAO
{

    public function __construct($conn)
    {
        parent::__construct($conn, "proveedores");
    }

    public function save(InterfaceDTO $object): void
    {
        $validation = new ProveedorV($this->conn);
        $validation->validationUS($object);
        $sql = "INSERT INTO {$this->table} VALUES (DEFAULT, :nombre, :telefono, :email,:localidad ,:direccion)";
        $stmt = $this->conn->prepare($sql);
        $data = $object->toArray();

        unset($data["id"]);
        $stmt->execute($data);

        $object->setId((int)$this->conn->lastInsertId());
    }

    //Devuelvo el objeto en formato DTO para se utilizado por el service. Se devuelve mas especificamente al service o al controller del back y se transforma a JSON.
    public function load($id): InterfaceDTO
    {
        $sql = "SELECT * FROM {$this->table} WHERE id = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute(["id" => $id]);

        $data = $stmt->fetch(\PDO::FETCH_ASSOC);
        if (!$data) {
            throw new \Exception("Proveedor con ID {$id} no encontrado.");
        }
        return new ProveedorDTO($data);

        //return new ProveedorDTO($stmt->fetch(\PDO::FETCH_ASSOC));
    }

    public function update(InterfaceDTO $object): void
    {
        $validation = new ProveedorV($this->conn);
        $validation->validationUS($object);
        $sql = "UPDATE {$this->table} SET nombre = :nombre, telefono = :telefono, email = :email, localidad=:localidad ,direccion = :direccion WHERE id = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute($object->toArray());
    }

    public function delete($id): void
    {
        $validation = new ProveedorV($this->conn);
        $validation->validationD($id);

        $sql = "DELETE FROM {$this->table} WHERE id = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([
            "id" => $id
        ]);

        if ($stmt->rowCount() === 0) {
            echo "No se encontró el registro con ID {$id}.";
        }
    }

    public function list(): array
    {
        $sql = "SELECT id, nombre, telefono, email, localidad, direccion FROM {$this->table}";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function listPage($data): array
    {
        $offset = ($data["page"] - 1) * $data['pageSize'];

        // Consulta para obtener los datos paginados
        $sql = "SELECT id, nombre, telefono, email, localidad, direccion 
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
        $baseSql = "SELECT id, nombre, telefono, email, localidad, direccion 
                FROM {$this->table}";

        // Base de la consulta de conteo
        $countSql = "SELECT COUNT(*) as total FROM {$this->table}";

        // Inicializar el array de condiciones
        $conditions = [];
        $params = [];

        // Filtro por localidad
        if (!empty($data['localidad'])) {
            $conditions[] = "localidad = :localidad";
            $params[':localidad'] = $data['localidad'];
        }

        // Filtro por nombre
        if (!empty($data['nombre'])) {
            $conditions[] = "nombre LIKE :nombre";
            $params[':nombre'] = '%' . $data['nombre'] . '%';
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
}
