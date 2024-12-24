<?php

namespace app\core\model\dao;

use app\core\model\base\DAO;
use app\core\model\base\InterfaceDAO;
use app\core\model\base\InterfaceDTO;
use app\core\model\validate\CategoriaV;
use app\core\model\dto\CategoriaDTO;

final class CategoriaDAO extends DAO implements InterfaceDAO
{

    public function __construct($conn)
    {
        parent::__construct($conn, "categorias");
    }

    public function save(InterfaceDTO $object): void
    {

        $validation = new CategoriaV($this->conn);
        $validation->validationUS($object);

        $sql = "INSERT INTO {$this->table} VALUES (DEFAULT, :nombre, :descripcion)";
        $stmt = $this->conn->prepare($sql);
        $data = $object->toArray();

        unset($data["id"]);
        $stmt->execute($data);

        $object->setId((int)$this->conn->lastInsertId());
    }

    //Devuelvo el objeto en formato DTO para se utilizado por la logica de negocio. Se devuelve mas especificamente al service o al controller del back y se transforma a JSON.
    public function load($id): InterfaceDTO
    {
        $sql = "SELECT * FROM {$this->table} WHERE id = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute(["id" => $id]);

        $data = $stmt->fetch(\PDO::FETCH_ASSOC);
        if (!$data) {
            throw new \Exception("Categoria con ID {$id} no encontrada.");
        }
        return new CategoriaDTO($data);
    }

    public function update(InterfaceDTO $object): void
    {

        $validation = new CategoriaV($this->conn);
        $validation->validationUS($object);

        $sql = "UPDATE {$this->table} SET nombre = :nombre, descripcion = :descripcion WHERE id = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute($object->toArray());
    }

    public function delete($id): void
    {

        $validation = new CategoriaV($this->conn);
        $validation->validationD($id);

        $sql = "DELETE FROM {$this->table} WHERE id = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute(["id" => $id]);

        if ($stmt->rowCount() === 0) {
            echo "No se encontró el registro con ID {$id}.";
        }
    }

    public function list(): array
    {
        $sql = "SELECT id, nombre, descripcion FROM {$this->table}";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function listPage($data): array
    {
        $offset = ($data["page"] - 1) * $data['pageSize'];

        // Consulta para obtener los datos paginados
        $sql = "SELECT id, nombre, descripcion  
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
}
