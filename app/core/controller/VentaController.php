<?php

    namespace app\core\controller;

    use app\core\controller\base\Controller;
    use app\core\controller\base\InterfaceController;
    use app\libs\report\ReportGenerator;
    use app\core\service\VentaService;

    use app\core\service\BebidaService;
    use app\libs\pay\mercadopago;
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

        public function exito (): void {
            $this->view = "venta/exito.php";
            require_once APP_TEMPLATE . "template.php";
        }

        public function fallo (): void {
            $this->view = "venta/fallo.php";
            require_once APP_TEMPLATE . "template.php";
        }

        public function pendiente (): void {
            $this->view = "venta/pendiente.php";
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
        
        public function consultar (): void {
            $this->view = "venta/consultar.php";
            require_once APP_TEMPLATE . "template.php";
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

            $response->setResult($data);
            $response->send();
        }

        public function consultarStock (Request $request, Response $response): void {
            $service = new BebidaService();
            $stock = $service->consultarStock($request->getId());
            #var_dump($request->getId());
            $response->setResult($stock);
            $response->send();
        }

        public function listPage (Request $request, Response $response): void {
            $data = $request->getData();
            $service = new VentaService();
            $result = $service->listPage($data);

            $response->setResult($result);
            $response->send();
        }

        public function filter(Request $request, Response $response): void
    {
        $data = $request->getData();
        $service = new VentaService();
        $result = $service->filter($data);

        $response->setResult($result);
        $response->send();
    }


    public function pdf(Request $request, Response $response): void
    {
        $requestData = $request->getData();
        $ventas = $requestData['ventas'] ?? [];
    
        $headers = ['ID', 'Fecha', 'Hora','Forma de Pago','Total'];
        $rows = array_map(fn($venta) => [$venta['id'], $venta['fecha'], $venta['hora'],$venta['formaPago'],$venta['total']], $ventas);
        $reportGenerator = new ReportGenerator();
        $reportGenerator->generatePDF('Lista de Ventas', $headers, $rows, 'ventas.pdf');
    }

    public function excel(Request $request, Response $response): void
    {
        {
            $requestData = $request->getData();
            $ventas = $requestData['ventas'] ?? [];
    
            $headers = ['ID', 'Fecha', 'Hora','Forma de Pago','Total'];
            $rows = array_map(fn($venta) => [$venta['id'], $venta['fecha'], $venta['hora'],$venta['formaPago'],$venta['total']], $ventas);
    
            $excelReportGenerator = new ReportGenerator();
            $excelReportGenerator->generateExcel('Lista de Ventas', $headers, $rows, 'ventas.xlsx');
        }
    }

    public function mercadopago(Request $request, Response $response): void
{
    $requestData = $request->getData();
    $ventaID = $requestData['id'] ?? null;
    $precio = $requestData['precio'] ?? 0;

    $service = new mercadopago();
    $paymentUrl = $service->pagar($ventaID, $precio);  // Agregamos precio como parámetro

    $response->setResult(['init_point' => $paymentUrl]);
    $response->send();
}

public function procesarPago(Request $request, Response $response): void
{
    // Captura todos los datos de la solicitud desde la URL
    $data = $request->getDataGET(); // Cambia esto para usar getDataGET()

    // Captura los parámetros específicos
    $status = $data['status'] ?? null;
    $ventaID = $data['ventaID'] ?? null;
    $collectionStatus = $data['collection_status'] ?? null; // Asegúrate de capturar este parámetro también

    // Verifica si los parámetros requeridos están presentes
    if ($status === null || $ventaID === null) {
        $response->setResult([
            'error' => $request->getDataGET(),
            'message' => "Los parámetros 'status' y 'ventaID' son requeridos."
        ]);
        $response->send();
        return; // Termina la ejecución si faltan parámetros
    }

    // Lógica para manejar el estado del pago
    switch ($collectionStatus) {
        case 'approved':
            $this->exito($ventaID);
            break;
        case 'pending':
            $this->pendiente($ventaID);
            break;
        case 'rejected':
            $this->fallo($ventaID);
            break;
        default:
            $response->setResult(['error' => 'Estado de pago desconocido']);
            $response->send();
            return;
    }

    // Enviar respuesta adecuada
    $response->setResult(['status' => $status, 'ventaID' => $ventaID]);
    $response->send();
}




}