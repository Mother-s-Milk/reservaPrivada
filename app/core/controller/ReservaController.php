<?php

    namespace app\core\controller;

    use app\core\controller\base\Controller;
    use app\core\controller\base\InterfaceController;

    use app\core\service\ReservaService;

    use app\libs\request\Request;
    use app\libs\response\Response;

    final class ReservaController extends Controller implements InterfaceController {

        public function __construct () {
            parent::__construct ([
                "app/js/reserva/reservaController.js",
                "app/js/reserva/reservaService.js"
            ]);
        }

        public function index (): void {
            $this->view = "reserva/index.php";
            require_once APP_TEMPLATE . "template.php";
        }

        public function create (): void {
            $this->view = "reserva/alta.php";
            require_once APP_TEMPLATE . "template.php";
        }

        public function save (Request $request, Response $response): void {
            try {
                $data = $request->getData();

                print_r($data);

                $service = new ReservaService();
                $service->save($data);

                $response->setMessage("La reserva se registro correctamente.");
                $response->send();
            }
            catch (\Exception $ex) {
                $response->setMessage($ex->getMessage());
                $response->send();
            }
        }

        public function load ($id, Response $response): void {
            try {
                $service = new ReservaService();
                $reserva = $service->load($id);

                if (!$reserva) {
                    throw new \Exception("La reserva con ID $id no existe.");
                }

                $response->setResult($reserva->toArray());
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

                $service = new ReservaService();
                $service->update($data);

                $response->setMessage("La reserva se actualizo correctamente.");
                $response->send();
            }
            catch (\Exception $ex) {
                $response->setMessage($ex->getMessage());
                $response->send();
            }
        }

        public function delete (Request $request, Response $response): void {
            $service = new ReservaService();
            $service->delete($request->getId());
            $response->setMessage('Reserva eliminada correctamente.');
            $response->send();
        }

        public function list(Request $request, Response $response): void {
            $service = new ReservaService();
            $data = $service->list();
        
            $response->setResult($data);
            $response->send();
        }
        
    }

?>