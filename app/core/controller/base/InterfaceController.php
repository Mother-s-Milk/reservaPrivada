<?php

    namespace app\core\controller\base;

    use app\libs\request\Request;
    use app\libs\response\Response;

    interface InterfaceController {

        /*Invoca la vista principal del modulo.*/
        public function index (): void;

        /*Invoca la vista correspondiente, para el alta de una nueva entidad.*/
        public function create (): void;

        /*Invoca la vista correspondiente para poder modificar los datos de una entidad existente en el sistema.*/
        //public function edit ($id): void;

        /*Gestiona los servicios correspondientes para el alta de una nueva entidad en el sistema.*/
        public function save (Request $request, Response $response): void;

        /*Gestiona los servicios correspondientes para la busqueda de una entidad existente en el sistema. Se debe enviar el ID del cliente en la peticion.*/
        public function load (Request $request, Response $response): void;

        /*Gestiona los servicios correspondientes para la actualizacion de datos de una entidad existente.*/
        public function update (Request $request, Response $response): void;

        /*Gestiona los servicios correspondientes para la eliminacion (fisica) de la entidad.*/
        public function delete (Request $request, Response $response): void;

        //public function delete ($id, Response $response): void;

    }

?>