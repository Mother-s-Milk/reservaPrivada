<?php

    namespace app\core\controller;

    use app\core\controller\base\Controller;
    use app\core\controller\base\InterfaceController;
    use app\libs\report\ReportGenerator;
    use app\core\service\BebidaService;

    use app\libs\request\Request;
    use app\libs\response\Response;

    final class BebidaController extends Controller implements InterfaceController {

        public function __construct () {
            parent::__construct ([
                "app/js/bebida/bebidaController.js",
                "app/js/bebida/bebidaService.js"
            ]);
        }

        public function index (): void {
            $this->view = "bebida/index.php";
            $BC_actual="Bebidas";
            $BC_link_anterior=APP_FRONT."inicio/index";
            $BC_anterior="Inicio";
            require_once APP_TEMPLATE . "template.php";
        }

        public function create (): void {
            $this->view = "bebida/alta.php";
            $BC_actual="Crear Bebidas";
            $BC_link_anterior=APP_FRONT."bebida/index";
            $BC_anterior="Inicio";
            require_once APP_TEMPLATE . "template.php";
        }

        public function save (Request $request, Response $response): void {
            try {
                $data = $request->getData();

                $service = new BebidaService();
                $service->save($data);

                $response->setMessage("La bebida se registro correctamente.");
                $response->send();
            }
            catch (\Exception $ex) {
                $response->setMessage($ex->getMessage());
                $response->send();
            }
        }

        public function editar (): void {
            $this->view = "bebida/editar.php";
            $BC_actual="Editar Bebida";
            $BC_link_anterior=APP_FRONT."bebida/index";
            $BC_anterior="Bebidas";
            require_once APP_TEMPLATE . "template.php";
        }

        public function load (Request $request, Response $response): void {
            try {
                //Cargar bebida por id
                $service = new BebidaService();
                $bebida = $service->load($request->getId());

                if (!$bebida) {
                    throw new \Exception("La bebida con ID $id no existe.");
                }

                //Enviar los datos al front
                $response->setResult($bebida->toArray());
                $response->setMessage("La bebida se cargó correctamente");
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

                $service = new BebidaService();
                $service->update($data);

                $response->setMessage("La bebida se actualizo correctamente.");
                $response->send();
            }
            catch (\Exception $ex) {
                $response->setMessage($ex->getMessage());
                $response->send();
            }
        }

        public function delete (Request $request, Response $response): void {
            $service = new BebidaService();
            $service->delete($request->getId());
            $response->setMessage('Bebida eliminada correctamente.');
            $response->send();
        }

        public function list (Request $request, Response $response): void {
            // Usamos el servicio para obtener los datos
            $service = new BebidaService();
            $data = $service->list();  // Obtienes las bebidas desde el servicio
        
            // Estableces la respuesta en formato JSON
            $response->setResult($data);
            $response->send();  // Envías la respuesta con los datos
        }
        
        public function listPage(Request $request, Response $response): void
        {
        $data = $request->getData();
        $service = new BebidaService();
        $result = $service->listPage($data);

        $response->setResult($result);
        $response->send();
        }

        public function filter(Request $request, Response $response): void
    {
        $data = $request->getData();
        $service = new BebidaService();
        $result = $service->filter($data);

        $response->setResult($result);
        $response->send();
    }

    public function pdf(): void
    {
        $requestData = json_decode(file_get_contents("php://input"), true);
        $bebidas = $requestData['bebidas'] ?? [];
    
        $headers = ['ID', 'Nombre', 'Descripción','Categoría','Precio','Stock','Marca','Proveedor'];
        $rows = array_map(fn($bebida) => [$bebida['id'], $bebida['nombre'], $bebida['descripcion'],$bebida['categoria'],$bebida['precio'],$bebida['stock'],$bebida['marca'],$bebida['proveedor']], $bebidas);
    
        $reportGenerator = new ReportGenerator();
        $reportGenerator->generatePDF('Lista de Bebidas', $headers, $rows, 'bebidas.pdf');
    }

    public function excel(): void
    {
        {
            $requestData = json_decode(file_get_contents("php://input"), true);
            $bebidas = $requestData['bebidas'] ?? [];
    
            $headers = ['ID', 'Nombre', 'Descripción','Categoría','Precio','Stock','Marca','Proveedor'];
            $rows = array_map(fn($bebida) => [$bebida['id'], $bebida['nombre'], $bebida['descripcion'],$bebida['categoria'],$bebida['precio'],$bebida['stock'],$bebida['marca'],$bebida['proveedor']], $bebidas);
    
            $excelReportGenerator = new ReportGenerator();
            $excelReportGenerator->generateExcel('Lista de Bebidas', $headers, $rows, 'bebidas.xlsx');
        }
    }


    }

?>