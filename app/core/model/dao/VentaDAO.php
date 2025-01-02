<?php

namespace app\core\model\dao;

use app\core\model\base\DAO;
use app\core\model\base\InterfaceDAO;
use app\core\model\base\InterfaceDTO;

use app\core\model\dto\VentaDTO;
use app\core\model\dto\DetalleVentaDTO;
use app\core\model\validate\VentaV;

final class VentaDAO extends DAO implements InterfaceDAO
{

    public function __construct($conn)
    {
        parent::__construct($conn, 'ventas');
    }

    public function save(InterfaceDTO $object): void
    {
        
        $validation = new VentaV($this->conn);
        $validation->validationUS($object);
        
        $sql = "INSERT INTO {$this->table} VALUES (DEFAULT, NOW(), CURTIME(), :formaPago, :total)";
        $stmt = $this->conn->prepare($sql);

        $formaPago = $object->getFormaPago();
        $total = $object->getTotal();
        $stmt->execute(["formaPago" => $formaPago, "total" => $total]);

        $data = $object->toArray();

        $object->setId((int)$this->conn->lastInsertId());
        $this->saveDetalles($object->getId(), $data["detalles"]);
    }

    public function saveDetalles(int $ventaId, array $detalles): void
    {
        try {
            // Iniciar transacción
            $this->conn->beginTransaction();

            foreach ($detalles as $detalle) {
                $this->actualizarStock($detalle);

                $sql = "INSERT INTO detallesVenta VALUES (DEFAULT, :ventaId, :bebidaId, :precio, :cantidad)";
                $stmt = $this->conn->prepare($sql);
                $stmt->execute([
                    ":ventaId" => $ventaId,
                    ":bebidaId" => $detalle["bebidaId"],
                    ":precio" => $detalle["precio"],
                    ":cantidad" => $detalle["cantidad"]
                ]);
            }

            // Confirmar la transacción si todo salió bien
            $this->conn->commit();
        } catch (\Exception $e) {
            // Revertir la transacción si ocurre un error
            $this->conn->rollBack();
            throw $e; // Re-lanzar la excepción para manejarla externamente
        }
    }


    private function actualizarStock(array $detalles): void
    {
        $updateQuery = "
        UPDATE bebidas 
        SET stock = stock - :cantidad 
        WHERE id = :id AND stock >= :cantidad
    ";
        $stmtUpdate = $this->conn->prepare($updateQuery);
        $stmtUpdate->execute([
            ":cantidad" => $detalles["cantidad"],
            ":id" => $detalles["bebidaId"]
        ]);

        if ($stmtUpdate->rowCount() === 0) {
            throw new \Exception("No hay suficiente stock de la bebida {$detalles["nombre"]} o no se encontró la bebida.");
        }
    }



    //Falta probar
    public function load($id): InterfaceDTO
    {
        $sql = "SELECT * FROM {$this->table} WHERE id = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute(["id" => $id]);

        $data = $stmt->fetch(\PDO::FETCH_ASSOC);
        if (!$data) {
            throw new \Exception("Venta con ID {$id} no encontrada.");
        }

        $ventaDTO = new VentaDTO($data);
        $ventaDTO->setDetalles($this->getDetallesByVentaId($id));
        return $ventaDTO;
    }

    private function getDetallesByVentaId($ventaId): array
    {
        $sql = "SELECT vd.*, b.nombre AS bebida 
                    FROM detallesVenta vd
                    INNER JOIN bebidas b ON vd.bebidaId = b.id
                    WHERE vd.ventaId = :ventaId";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute(["ventaId" => $ventaId]);
        $rows = $stmt->fetchAll(\PDO::FETCH_ASSOC);
        $detalles = [];
        foreach ($rows as $row) {
            unset($row['id']);
            unset($row['ventaId']);
            unset($row['bebidaId']);
            $detalles[] = $row;
        }

        return $detalles;
    }

    public function update(InterfaceDTO $object): void
    {
        $sql = "UPDATE {$this->table} SET fecha = NOW(), hora = :CURTIME() WHERE id = :id";
        $stmt = $this->conn->prepare($sql);
        //$stmt->execute(["id" => $id]);
        $stmt->execute($object->toArray());
    }

    public function delete($id): void
    {
        $sql = "DELETE FROM detallesVenta WHERE ventaId = :ventaId";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute(['ventaId' => $id]);

        $sql = "DELETE FROM {$this->table} WHERE id = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute(["id" => $id]);

        if ($stmt->rowCount() === 0) {
            echo "No se encontró el registro con ID {$id}.";
        }
    }

    public function list(): array
    {
        $sql = "SELECT * FROM {$this->table}
            ORDER BY DATE(fecha) DESC";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();

        $ventas = [];
        $rows = $stmt->fetchAll(\PDO::FETCH_ASSOC);
        //var_dump($rows);
        foreach ($rows as $row) {
            $ventaDTO = new VentaDTO($row);
            $detalles = $this->getDetallesByVentaId($row['id']);
            $ventaDTO->setDetalles($detalles);

            // Convierte el objeto VentaDTO a un array asociativo
            $ventas[] = $ventaDTO->toArray(); // Aquí estamos utilizando el método toArray() para convertir a array
        }

        return $ventas;
    }

    public function consultarVentas(): array
    {
        $sql = "SELECT * FROM {$this->table} 
                    WHERE DATE(fecha) = CURRENT_DATE()
                    ORDER BY TIME(hora) DESC";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetchall(\PDO::FETCH_ASSOC);

        return $result;
    }

    public function consultarVentasSemanales(): array
    {
        $sql = "SELECT 
                DATE(fecha) AS dia,
                    SUM(total) AS total
                FROM 
                    ventas
                WHERE 
                    fecha >= CURDATE() - INTERVAL 7 DAY
                AND fecha <= CURDATE()
                GROUP BY 
                DATE(fecha)
                ORDER BY 
                DATE(fecha) ASC";;
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();

        $result = $stmt->fetchall(\PDO::FETCH_ASSOC);

        return $result;
    }
}
