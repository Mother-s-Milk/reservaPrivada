<?php

namespace app\core\model\validate;

use app\core\model\base\InterfaceDTO;
use app\core\model\base\InterfaceValidation;
use app\core\model\dto\ReservaDTO;


final class ReservaV implements InterfaceValidation {

    //Este método se encarga de validar el Update y el Save
    public function validationUS (InterfaceDTO $object): void{
        

    }

    //Este método se encarga de validar el Delete
    public function validationD ($id): void{



        
    }


}