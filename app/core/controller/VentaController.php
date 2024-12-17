<?php

    namespace app\core\controller;

    use app\core\controller\base\Controller;
    use app\core\controller\base\InterfaceController;

    use app\core\service\VentaService;

    use app\core\service\BebidaService;

    use app\libs\request\Request;
    use app\libs\response\Response;

    final class VentaController extends Controller implements InterfaceController {

        public function __construct () {
            parent::__construct ([
                "app/js/venta/ventaController.js",
                "app/js/venta/ventaService.js"
            ]);
        }

        public function index (): void {
            $this->view = "venta/index.php";
            require_once APP_TEMPLATE . "template.php";
        }

        public function create (): void {
            $this->view = "venta/alta.php";
            require_once APP_TEMPLATE . "template.php";
        }

        public function save (Request $request, Response $response): void {
            try {
                $data = $request->getData();
                
                $service = new VentaService();
                $service->save($data);

    
                $response->setMessage("La venta fue registrada correctamente.");
                $response->send();
            } catch (\Exception $ex) {
                $response->setMessage($ex->getMessage());
                $response->send();
            }
        }

        public function editar (): void {
        }

        public function load (Request $request, Response $response): void {
        }

        public function update (Request $request, Response $response): void {
        }

        public function delete (Request $request, Response $response): void {
        }

        public function list (Request $request, Response $response): void {
            $service = new VentaService();
            $data = $service->list();
            //var_dump($data);
            $response->setResult($data);
            $response->send();
        }

    }

?>