<?php

    namespace app\core\controller;

    use app\core\controller\base\Controller;
    use app\core\controller\base\InterfaceController;

    use app\core\service\MesaService;

    use app\libs\request\Request;
    use app\libs\response\Response;

    final class MesaController extends Controller implements InterfaceController {

        public function __construct () {
            parent::__construct ([
                "app/js/mesa/mesaController.js",
                "app/js/mesa/mesaService.js"
            ]);
        }

        public function index (): void {
            $this->view = "mesa/index.php";
            $BC_actual="Mesa";
            $BC_link_anterior=APP_FRONT."inicio/index";
            $BC_anterior="Inicio";
            require_once APP_TEMPLATE . "template.php";
        }

        public function create (): void {
            $this->view = "mesa/alta.php";
            $BC_actual="Crear Mesa";
            $BC_link_anterior=APP_FRONT."mesa/index";
            $BC_anterior="Mesas";
            require_once APP_TEMPLATE . "template.php";
        }

        public function save (Request $request, Response $response): void {
            $service = new MesaService();
            $service->save($request->getData());
            $response->setMessage("La mesa se registro correctamente.");
            $response->send();
        }

        public function editar (): void {
            $this->view = "mesa/editar.php";
            $BC_actual="Editar Mesa";
            $BC_link_anterior=APP_FRONT."mesa/index";
            $BC_anterior="Mesas";
            require_once APP_TEMPLATE . "template.php";
        }

        public function load (Request $request, Response $response): void {
            try {
                $service = new MesaService();
                $mesa = $service->load($request->getId());

                if (!$mesa) {
                    throw new \Exception("La mesa con ID $id no existe.");
                }

                $response->setResult($mesa->toArray());
                $response->setMessage("La mesa se cargó correctamente");
                $response->send();
            }
            catch (\Exception $ex) {
                $response->setMessage($ex->getMessage());
                $response->send();
            }
        }

        public function update (Request $request, Response $response): void {
            try {
                $data = $request->getData();

                $service = new MesaService();
                $service->update($data);

                $response->setMessage("La mesa se actualizo correctamente.");
                $response->send();
            }
            catch (\Exception $ex) {
                $response->setMessage($ex->getMessage());
                $response->send();
            }
        }

        public function delete (Request $request, Response $response): void {
            $service = new MesaService();
            $service->delete($request->getId());
            $response->setMessage('mesa eliminada correctamente.');
            $response->send();
        }

        public function list(Request $request, Response $response): void {
            $service = new MesaService();
            $data = $service->list();
        
            $response->setResult($data);
            $response->send();
        }


    }

?>