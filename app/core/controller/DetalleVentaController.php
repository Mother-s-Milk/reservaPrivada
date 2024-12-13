<?php

    namespace app\core\controller;

    use app\core\controller\base\Controller;
    use app\core\controller\base\InterfaceController;

    use app\core\service\DetalleVentaService;

    use app\libs\request\Request;
    use app\libs\response\Response;

    final class DetalleVentaController extends Controller implements InterfaceController {

        public function __construct () {
            parent::__construct ([]);
        }

        public function save (Request $request, Response $response): void {
            try {
                $data = $request->getData();

                $service = new DetalleVentaService();
                $service->save($data);

                $response->setMessage("El detalle se registro correctamente.");
                $response->send();
            }
            catch (\Exception $ex) {
                $response->setMessage($ex->getMessage());
                $response->send();
            }
        }

        public function load (Request $request, Response $response): void {
            try {
                //Cargar bebida por id
                $service = new DetalleVentaService();
                $bebida = $service->load($request->getId());

                if (!$bebida) {
                    throw new \Exception("El detalle con ID $id no existe.");
                }

                //Enviar los datos al front
                $response->setResult($bebida->toArray());
                $response->setMessage("El detalle se cargó correctamente");
                $response->send();
            }
            catch (\Exception $ex) {
                //$response->setError(true);
                $response->setMessage($ex->getMessage());
                $response->send();
            }
        }

        public function update (Request $request, Response $response): void {
            try {
                $data = $request->getData();

                $service = new DetalleVentaService();
                $service->update($data);

                $response->setMessage("El detalle se actualizo correctamente.");
                $response->send();
            }
            catch (\Exception $ex) {
                $response->setMessage($ex->getMessage());
                $response->send();
            }
        }

        public function delete (Request $request, Response $response): void {
            $service = new DetalleVentaService();
            $service->delete($request->getId());
            $response->setMessage('Detalle venta eliminado correctamente.');
            $response->send();
        }
        
    }

?>