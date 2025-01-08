<?php

    namespace app\core\controller;

    use app\core\controller\base\Controller;
    use app\core\controller\base\InterfaceController;
    use app\libs\report\ReportGenerator;
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
            $BC_actual="Proveedores";
            $BC_link_anterior=APP_FRONT."inicio/index";
            $BC_anterior="Inicio";
            require_once APP_TEMPLATE . "template.php";
        }

        public function create (): void {
            $this->view = "proveedor/alta.php";
            $BC_actual="Crear Proveedor";
            $BC_link_anterior=APP_FRONT."proveedor/index";
            $BC_anterior="Proveedores";
            require_once APP_TEMPLATE . "template.php";
        }

        public function save (Request $request, Response $response): void {
            $service = new ProveedorService();
            $service->save($request->getData());
            $response->setMessage("El proveedor se registro correctamente.");
            $response->send();
        }

        public function editar (): void {
            $this->view = "proveedor/editar.php";
            $BC_actual="Editar Proveedor";
            $BC_link_anterior=APP_FRONT."Proveedor/index";
            $BC_anterior="Proveedores";
            require_once APP_TEMPLATE . "template.php";
        }

        public function load (Request $request, Response $response): void {
            $service = new ProveedorService();
            $info = $service->load($request->getId());

            $response->setResult($info->toArray());
            $response->setMessage("El proveedor se cargó correctamente");
            $response->send();
        }

        public function update (Request $request, Response $response): void {
            try {
                $data = $request->getData();

                $service = new ProveedorService();
                $service->update($data);

                $response->setMessage("El proveedor se actualizo correctamente.");
                $response->send();
            }
            catch (\Exception $ex) {
                $response->setMessage($ex->getMessage());
                $response->send();
            }
        }

        public function delete (Request $request, Response $response): void {
            $service = new ProveedorService();
            $service->delete($request->getId());
            $response->setMessage('Proveedor eliminado correctamente.');
            $response->send();
        }

        public function list(Request $request, Response $response): void {
            $service = new ProveedorService();
            $data = $service->list();
        
            $response->setResult($data);
            $response->send();
        }

        public function listPage(Request $request, Response $response): void
    {
        $data = $request->getData();
        $service = new ProveedorService();
        $result = $service->listPage($data);

        $response->setResult($result);
        $response->send();
    }

    public function filter(Request $request, Response $response): void
    {
        $data = $request->getData();
        $service = new ProveedorService();
        $result = $service->filter($data);

        $response->setResult($result);
        $response->send();
    }  

    public function pdf(Request $request, Response $response): void
    {
        $requestData = $request->getData();
        $proveedores = $requestData['proveedores'] ?? [];
    
        $headers = ['ID', 'Nombre', 'Teléfono','Email','Localidad','Dirección'];
        $rows = array_map(fn($proveedor) => [$proveedor['id'], $proveedor['nombre'], $proveedor['telefono'],$proveedor['email'],$proveedor['localidad'],$proveedor['direccion']], $proveedores);
    
        $reportGenerator = new ReportGenerator();
        $reportGenerator->generatePDF('Lista de Proveedores', $headers, $rows, 'proveedores.pdf');
    }

    public function excel(Request $request, Response $response): void
    {
        {
            $requestData = $request->getData();
            $proveedores = $requestData['proveedores'] ?? [];
    
            $headers = ['ID', 'Nombre', 'Teléfono','Email','Localidad','Dirección'];
        $rows = array_map(fn($proveedor) => [$proveedor['id'], $proveedor['nombre'], $proveedor['telefono'],$proveedor['email'],$proveedor['localidad'],$proveedor['direccion']], $proveedores);
    
    
            $excelReportGenerator = new ReportGenerator();
            $excelReportGenerator->generateExcel('Lista de Proveedores', $headers, $rows, 'proveedores.xlsx');
        }
    }


    }

?>