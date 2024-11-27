<?php

    namespace app\core\controller;

    use app\core\controller\base\Controller;
    use app\core\controller\base\InterfaceController;

    use app\core\service\CategoriaService;

    use app\libs\request\Request;
    use app\libs\response\Response;

    final class CategoriaController extends Controller implements InterfaceController {

        public function __construct () {
            parent::__construct ([
                "app/js/categoria/categoriaController.js",
                "app/js/categoria/categoriaService.js"
            ]);
        }

        public function index (): void {
            $this->view = "categoria/index.php";
            require_once APP_TEMPLATE . "template.php";
        }

        public function create (): void {
            $this->view = "categoria/alta.php";
            require_once APP_TEMPLATE . "template.php";
        }

        public function save (Request $request, Response $response): void {
            $service = new CategoriaService();
            $service->save($request->getData());
            $response->setMessage("La categoria se registro correctamente.");
            $response->send();
        }

        public function editar (): void {
            $this->view = "categoria/editar.php";
            require_once APP_TEMPLATE . "template.php";
        }

        public function load (Request $request, Response $response): void {
            try {
                $service = new CategoriaService();
                $categoria = $service->load($request->getId());

                if (!$categoria) {
                    throw new \Exception("La categoria con ID $id no existe.");
                }

                //Enviar los datos al front
                $response->setResult($categoria->toArray());
                $response->setMessage("La categoria se cargó correctamente");
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

                $service = new CategoriaService();
                $service->update($data);

                $response->setMessage("La categoria se actualizo correctamente.");
                $response->send();
            }
            catch (\Exception $ex) {
                //$response->setError(true);
                $response->setMessage($ex->getMessage());
                $response->send();
            }
        }

        public function delete (Request $request, Response $response): void {
            $service = new CategoriaService();
            $service->delete($request->getId());
            $response->setMessage('Categoria eliminada correctamente.');
            $response->send();
        }

        public function list(Request $request, Response $response): void {
            // Usamos el servicio para obtener los datos
            $service = new CategoriaService();
            $data = $service->list();  // Obtienes las bebidas desde el servicio
        
            // Estableces la respuesta en formato JSON
            $response->setResult($data);
            $response->send();  // Envías la respuesta con los datos
        }


    }

?>