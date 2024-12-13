<?php

    namespace app\core\model\base;

    interface InterfaceValidation {

        //Este método se encarga de validar el Update y el Save
        public function validationUS (InterfaceDTO $object): void;

        //Este método se encarga de validar el Delete
        public function validationD ($id): void;
    }

?>