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
            //$validation = new BebidadV($this->conn);
            //$validation->validationUS($object);
            
            $sql= "INSERT INTO {$this->table} VALUES (DEFAULT, :nombre, :descripcion, :categoriaId, :precioUnitario, :stock, :marca, :proveedorId)";
            $stmt = $this->conn->prepare($sql);
            $data = $object->toArray();

            unset($data["id"]);
            $stmt->execute($data);

            $object->setId((int)$this->conn->lastInsertId());
        }

        public function load ($id): InterfaceDTO {
            $sql = "SELECT id, nombre, descripcion, categoriaId, precioUnitario, stock, marca, proveedorId FROM {$this->table} WHERE id = :id";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute(["id" => $id]);

            //prueba de id inexistente
            $data = $stmt->fetch(\PDO::FETCH_ASSOC);#:: significa que se invoca algun metodo del PDO en este caso
            if (!$data) {
                throw new \Exception("Bebida con ID {$id} no encontrada.");
            }
            return new BebidaDTO($data);
        }

        public function update (InterfaceDTO $object): void {
            //$validation = new BebidadV($this->conn);
            //$validation->validationUS($object);
            
            $sql = "UPDATE {$this->table} SET nombre = :nombre, descripcion = :descripcion, categoriaId = :categoriaId, precioUnitario = :precioUnitario, stock = :stock, marca = :marca, proveedorId = :proveedorId WHERE id = :id";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute($object->toArray());
        }

        public function delete ($id): void {
            $sql = "DELETE FROM {$this->table} WHERE id = :id";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute(["id" => $id]);

            if ($stmt->rowCount() === 0) {
                throw new \Exception("No se encontró la bebida con ID {$id}.");
            }
        }

        public function list (): array {
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

        public function consultarStock ($id): int {
            $sql = "SELECT stock FROM {$this->table} WHERE id = :id";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute(["id" => $id]);

            $data = $stmt->fetch(\PDO::FETCH_ASSOC);
            return (int)$data['stock'];
        }

        public function consultarBebidas(): int {
            $sql = "SELECT COUNT(*) as total FROM {$this->table}";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute();
            return $stmt->fetch(\PDO::FETCH_ASSOC)['total'];
        }

        public function consultarBajoStock(): array {
            $sql = "SELECT * FROM {$this->table} WHERE stock <= 10
            ORDER BY stock ASC";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute();
            return $stmt->fetchAll(\PDO::FETCH_ASSOC);
        }

        public function listPage($data): array
    {
        $offset = ($data["page"] - 1) * $data['pageSize'];

        // Consulta para obtener los datos paginados
        $sql = "SELECT id, nombre, descripcion, categoriaId, precioUnitario, stock, marca, proveedorId  
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

    // Base de la consulta principal
    $sql = "SELECT id, nombre, descripcion, categoriaId, precioUnitario, stock, marca, proveedorId  
            FROM {$this->table}";

    // Base de la consulta para contar el total
    $countSql = "SELECT COUNT(*) as total FROM {$this->table}";

    // Array para las condiciones de los filtros
    $conditions = [];
    $params = [];

    // Filtro por nombre (búsqueda parcial)
    if (!empty($data['nombre'])) {
        $conditions[] = "nombre LIKE :nombre";
        $params[':nombre'] = '%' . $data['nombre'] . '%';
    }

    // Filtro por stock (igual o mayor al valor proporcionado)
    if (!empty($data['stock'])) {
        $conditions[] = "stock >= :stock";
        $params[':stock'] = $data['stock'];
    }

    // Filtro por proveedorId
    if (!empty($data['proveedor'])) {
        $conditions[] = "proveedorId = :proveedor";
        $params[':proveedor'] = $data['proveedor'];
    }

    // Filtro por categoriaId
    if (!empty($data['categoria'])) {
        $conditions[] = "categoriaId = :categoria";
        $params[':categoria'] = $data['categoria'];
    }

    // Si hay condiciones, agregarlas a ambas consultas
    if (!empty($conditions)) {
        $whereClause = " WHERE " . implode(" AND ", $conditions);
        $sql .= $whereClause;
        $countSql .= $whereClause;
    }

    // Agregar paginación a la consulta principal
    $sql .= " LIMIT :limit OFFSET :offset";

    // Ejecutar la consulta para contar el total
    $countStmt = $this->conn->prepare($countSql);
    foreach ($params as $key => $value) {
        $countStmt->bindValue($key, $value);
    }
    $countStmt->execute();
    $total = $countStmt->fetch(\PDO::FETCH_ASSOC)['total'];

    // Ejecutar la consulta principal con paginación
    $stmt = $this->conn->prepare($sql);
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

?>