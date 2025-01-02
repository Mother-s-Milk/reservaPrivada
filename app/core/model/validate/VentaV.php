<?php

namespace app\core\model\validate;

use app\core\model\base\InterfaceDTO;
use app\core\model\base\InterfaceValidation;
use app\core\model\dto\VentaDTO;
use app\core\model\dto\DetalleVentaDTO;
use app\core\model\base\VALIDATION;

final class VentaV extends VALIDATION implements InterfaceValidation
{
    public function __construct($conn)
    {
        parent::__construct($conn, "proveedores");
    }
    //Este método se encarga de validar el Update y el Save
    public function validationUS(InterfaceDTO $object): void
    {
        $this->validate($object);
        $this->validateStock($object);
    }

    //Este método se encarga de validar el Delete
    public function validationD($id): void
    {
        $sql = "SELECT COUNT(id) AS cantidad FROM bebidas WHERE proveedorId = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':id', $id, \PDO::PARAM_INT);
        $stmt->execute();
        $result = $stmt->fetch(\PDO::FETCH_OBJ);

        if ($result->cantidad > 0) {
            throw new \Exception("No se puede eliminar ya que hay alguna bebida que tiene este proveedor");
        }
    }

    private function validate(VentaDTO $object): void
    {

        if ($object->getTotal() == 0) {
            throw new \Exception("El campo 'total' no puede ser 0.");
        }

        if ($object->getFormaPago() == "") {
            throw new \Exception("El campo 'formato de Pago' no puede estar vacío.");
        }

        if ($object->getDetalles() === []) {
            throw new \Exception("El campo 'detalles' debe contener elementos.");
        }

        foreach ($object->getDetalles() as $detalle) {

            $detalleVentaDTO = new DetalleVentaDTO($detalle);

            if ($detalleVentaDTO->getCantidad() == 0) {
                throw new \Exception("El campo 'cantidad' no puede ser 0.");
            }

            if ($detalleVentaDTO->getBebidaId() == 0) {
                throw new \Exception("El campo 'bebidaId' no puede ser 0.");
            }
        }
    }

    private function validateStock(VentaDTO $object): void
    {
        foreach ($object->getDetalles() as $detalle) {
            
            $query = "
                SELECT stock 
                FROM bebidas 
                WHERE id = :id AND stock >= :cantidad
            ";
            $stmt = $this->conn->prepare($query);
            $stmt->execute([
                ":id" => $detalle["bebidaId"],
                ":cantidad" => $detalle["cantidad"]
            ]);
    
            $result = $stmt->fetch(\PDO::FETCH_ASSOC);
    
            if (!$result) {
                throw new \Exception("No hay suficiente stock de la bebida {$detalle["nombre"]} o no se encontró la bebida.");
            }
        }
    }
    
}
