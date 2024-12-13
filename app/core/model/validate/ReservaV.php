<?php

namespace app\core\model\validate;

use app\core\model\base\InterfaceDTO;
use app\core\model\base\InterfaceValidation;
use app\core\model\dto\ReservaDTO;
use app\core\model\base\VALIDATION;

final class ReservaV extends VALIDATION implements InterfaceValidation {
    public function __construct($conn)
    {
        parent::__construct($conn, "reservas");
    }
    //Este método se encarga de validar el Update y el Save
    public function validationUS (InterfaceDTO $object): void{
        $this->validate($object);

    }

    //Este método se encarga de validar el Delete
    public function validationD ($id): void{
        
    }

    private function validate(ReservaDTO $object): void
    {
        if (trim($object->getApellido()) === "") {
            throw new \Exception("El campo 'apellido' no puede estar vacío o contener caracteres no válidos.");
        }

        if (trim($object->getNombres()) === "") {
            throw new \Exception("El campo 'nombre' no puede estar vacío o contener caracteres no válidos.");
        }

        if (trim($object->getTelefono()) === "") {
            throw new \Exception("El campo 'telefono' no puede estar vacío o contener caracteres no válidos.");
        }

        if (trim($object->getDetalles()) === "") {
            throw new \Exception("El campo 'detalle' no puede estar vacío o contener caracteres no válidos.");
        }

        if (trim($object->getHora()) === "") {
            throw new \Exception("El campo 'hora' no puede estar vacío o contener caracteres no válidos.");
        }
        if (trim($object->getFecha()) === "") {
            throw new \Exception("El campo 'fecha' no puede estar vacío o contener caracteres no válidos.");
        }
    }

}