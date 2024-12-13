<?php

namespace app\core\model\validate;

use app\core\model\base\InterfaceDTO;
use app\core\model\base\InterfaceValidation;
use app\core\model\base\VALIDATION;
use app\core\model\dto\CategoriaDTO;

final class CategoriaV extends VALIDATION implements InterfaceValidation
{
    public function __construct($conn)
    {
        parent::__construct($conn, "categorias");
    }
    // Este método se encarga de validar el Update y el Save
    public function validationUS(InterfaceDTO $object): void
    {
        $this->validate($object);
        $this->validateName($object);
    }

    // Este método se encarga de validar el Delete
    public function validationD($id): void
    {
        $sql = "SELECT COUNT(id) AS cantidad FROM bebidas WHERE categoriaId = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':id', $id, \PDO::PARAM_INT);
        $stmt->execute();
        $result = $stmt->fetch(\PDO::FETCH_OBJ);
    
        if ($result->cantidad > 0) {
            throw new \Exception("No se puede eliminar ya que hay alguna bebida que tiene esta categoria");
        }
    }

    // Validación del objeto para campos vacíos o inválidos
    private function validate(CategoriaDTO $object): void
    {
        if (trim($object->getNombre()) === "") {
            throw new \Exception("El campo 'nombre' no puede estar vacío o contener caracteres no válidos.");
        }
    }

    // Validación para comprobar nombres duplicados
    private function validateName(CategoriaDTO $object): void
    {
        $sql = "SELECT COUNT(id) AS cantidad FROM {$this->table} WHERE nombre = :nombre AND id != :id";
        $stmt = $this->conn->prepare($sql);

        $stmt->execute([
            'nombre' => $object->getNombre(),
            'id' => $object->getId()
        ]);

        $result = $stmt->fetch(\PDO::FETCH_OBJ);

        if ($result->cantidad > 0) {
            throw new \Exception("El dato 'nombre' ({$object->getNombre()}) ya existe en la base de datos.");
        }
    }
}
