<?php

    namespace app\core\controller;

    use app\core\controller\base\Controller;
    use app\core\controller\base\InterfaceController;

    use app\core\service\ProveedorService;

    use app\libs\request\Request;
    use app\libs\response\Response;

    final class ProveedorController extends Controller {

        public function __construct () {
            parent::__construct ([
                "app/js/proveedor/proveedorController.js",
                "app/js/proveedor/proveedorService.js"
            ]);
        }

        public function index (): void {
            $this->view = "proveedor/index.php";
            require_once APP_TEMPLATE . "template.php";
        }

        public function create (): void {
            $this->view = "proveedor/alta.php";
            require_once APP_TEMPLATE . "template.php";
        }

        public function save (Request $request, Response $response): void {
            $service = new ProveedorService();
            $service->save($request->getData());
            $response->setMessage("El proveedor se registro correctamente.");
            $response->send();
        }

        public function load ($id): void {
            echo 'CONTROLADOR => LOAD <br>';
        }

        public function update (): void {
            echo 'CONTROLADOR => UPDATE <br>';
        }

        public function delete ($id): void {
            echo 'CONTROLADOR => DELETE <br>';
        }

        public function list(Request $request, Response $response): void {
            $service = new ProveedorService();
            $data = $service->list();
        
            $response->setResult($data);
            $response->send();
        }


    }

?>