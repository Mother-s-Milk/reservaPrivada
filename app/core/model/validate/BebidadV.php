<?php

namespace app\core\model\validate;

use app\core\model\base\DAO;
use app\core\model\base\InterfaceDAO;
use app\core\model\base\InterfaceDTO;
use app\core\model\base\InterfaceValidation;
use app\core\model\dto\BebidaDTO;
use app\core\model\base\VALIDATION;

final class BebidadV extends VALIDATION implements InterfaceValidation {

    public function __construct($conn)
    {
        parent::__construct($conn, "bebidas");
    }

    //Este método se encarga de validar el Update y el Save
    public function validationUS (InterfaceDTO $object): void{
        $this->validate($object);
        $this->validateCategoria($object);
        $this->validateProveedor($object);
    }

    //Este método se encarga de validar el Delete
    public function validationD ($id): void{

    }

    // Validación del objeto para campos vacíos o inválidos
    private function validate(BebidaDTO $object): void
    {
        if (trim($object->getNombre()) === "") {
            throw new \Exception("El campo 'nombre' no puede estar vacío o contener caracteres no válidos.");
        }

        if (trim($object->getDescripcion()) === "") {
            throw new \Exception("El campo 'descripción' no puede estar vacío o contener caracteres no válidos.");
        }

        if (trim($object->getPrecioUnitario()) === "") {
            throw new \Exception("El campo 'Precio Unitario' no puede estar vacío o contener caracteres no válidos.");
        }

        if (trim($object->getStock()) === "") {
            throw new \Exception("El campo 'Stock' no puede estar vacío o contener caracteres no válidos.");
        }

        if (trim($object->getMarca()) === "") {
            throw new \Exception("El campo 'marca' no puede estar vacío o contener caracteres no válidos.");
        }
    }

    private function validateCategoria(BebidaDTO $id): void
    {
        $sql = "SELECT count(f.id) AS cantidad 
            FROM categorias f
            WHERE f.id = :id";

        $stmt = $this->conn->prepare($sql);

        // Parámetro id
        $params = [
            ':id' => $id->getCategoriaId()
        ];

        $stmt->execute($params);
        $result = $stmt->fetch(\PDO::FETCH_OBJ);

        // Retorna true si la función existe y está vigente
        if ($result->cantidad == 0) throw  new \Exception("No existe esta categoría");
    }

    private function validateProveedor(BebidaDTO $id): void
    {
        $sql = "SELECT count(f.id) AS cantidad 
            FROM proveedores f
            WHERE f.id = :id";

        $stmt = $this->conn->prepare($sql);

        // Parámetro id
        $params = [
            ':id' => $id->getProveedorId()
        ];

        $stmt->execute($params);
        $result = $stmt->fetch(\PDO::FETCH_OBJ);

        // Retorna true si la función existe y está vigente
        if ($result->cantidad == 0) throw  new \Exception("No existe este proveedor");
    }

}
