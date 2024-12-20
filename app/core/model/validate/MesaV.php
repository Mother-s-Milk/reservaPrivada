<?php

namespace app\core\model\validate;

use app\core\model\base\InterfaceDTO;
use app\core\model\base\InterfaceValidation;
use app\core\model\base\VALIDATION;
use app\core\model\dto\MesaDTO;

final class MesaV extends VALIDATION implements InterfaceValidation
{
    public function __construct($conn)
    {
        parent::__construct($conn, "mesas");
    }
    // Este método se encarga de validar el Update y el Save
    public function validationUS(InterfaceDTO $object): void
    {
        $this->validate($object);

    }

    // Este método se encarga de validar el Delete
    public function validationD($id): void
    {
        $sql = "SELECT COUNT(id) AS cantidad FROM reservasmesa WHERE mesaId = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':id', $id, \PDO::PARAM_INT);
        $stmt->execute();
        $result = $stmt->fetch(\PDO::FETCH_OBJ);
    
        if ($result->cantidad > 0) {
            throw new \Exception("No se puede eliminar ya que hay alguna mesa reservada que tiene esta mesa");
        }
    }

    // Validación del objeto para campos vacíos o inválidos
    private function validate(MesaDTO $object): void
    {
        if (trim($object->getDescripcion()) === "") {
            throw new \Exception("El campo 'descripción' no puede estar vacío o contener caracteres no válidos.");
        }
    }

}
