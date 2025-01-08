<?php

namespace app\core\controller;

use app\core\controller\base\Controller;
use app\core\controller\base\InterfaceController;
use app\libs\report\ReportGenerator;

use app\core\service\ReservaService;

use app\libs\request\Request;
use app\libs\response\Response;

final class ReservaController extends Controller implements InterfaceController
{

    public function __construct()
    {
        parent::__construct([
            "app/js/reserva/reservaController.js",
            "app/js/reserva/reservaService.js"
        ]);
    }

    public function index(): void
    {
        $this->view = "reserva/index.php";
        $BC_actual = "Reservas";
        $BC_link_anterior = APP_FRONT . "inicio/index";
        $BC_anterior = "Inicio";
        require_once APP_TEMPLATE . "template.php";
    }

    public function create(): void
    {
        $this->view = "reserva/alta.php";
        $BC_actual = "Crear Reserva";
        $BC_link_anterior = APP_FRONT . "reserva/index";
        $BC_anterior = "Reservas";
        require_once APP_TEMPLATE . "template.php";
    }

    public function save(Request $request, Response $response): void
    {
        try {
            $data = $request->getData();

            print_r($data);

            $service = new ReservaService();
            $service->save($data);

            $response->setMessage("La reserva se registro correctamente.");
            $response->send();
        } catch (\Exception $ex) {
            $response->setMessage($ex->getMessage());
            $response->send();
        }
    }

    public function load($id, Response $response): void
    {
        try {
            $service = new ReservaService();
            $reserva = $service->load($id);

            if (!$reserva) {
                throw new \Exception("La reserva con ID $id no existe.");
            }

            $response->setResult($reserva->toArray());
            $response->send();
        } catch (\Exception $ex) {
            $response->setMessage($ex->getMessage());
            $response->send();
        }
    }

    public function update(Request $request, Response $response): void
    {
        try {
            $data = $request->getData();

            $service = new ReservaService();
            $service->update($data);

            $response->setMessage("La reserva se actualizo correctamente.");
            $response->send();
        } catch (\Exception $ex) {
            $response->setMessage($ex->getMessage());
            $response->send();
        }
    }

    public function changeState(Request $request, Response $response): void
    {
        try {
            $data = $request->getData();

            $service = new ReservaService();
            $service->changeState($data);

            $response->setMessage("La reserva se actualizo correctamente.");
            $response->send();
        } catch (\Exception $ex) {
            $response->setMessage($ex->getMessage());
            $response->send();
        }
    }
    public function delete(Request $request, Response $response): void
    {
        $service = new ReservaService();
        $service->delete($request->getId());
        $response->setMessage('Reserva eliminada correctamente.');
        $response->send();
    }

    public function list(Request $request, Response $response): void
    {
        $service = new ReservaService();
        $data = $service->list();

        $response->setResult($data);
        $response->send();
    }

    public function pages(Request $request, Response $response): void
    {
        $service = new ReservaService();
        $data = $service->pages();

        $response->setResult($data);
        $response->send();
    }

    public function listPage(Request $request, Response $response): void
    {
        $data = $request->getData();
        $service = new ReservaService();
        $result = $service->listPage($data);

        $response->setResult($result);
        $response->send();
    }

    public function filter(Request $request, Response $response): void
    {
        $data = $request->getData();
        $service = new ReservaService();
        $result = $service->filter($data);

        $response->setResult($result);
        $response->send();
    }

    public function pdf(Request $request, Response $response): void
    {
        $requestData = $request->getData();
        $reservas = $requestData['reservas'] ?? [];
    
        $headers = ['ID','Apellido', 'Nombre','Teléfono','Fecha','Hora','Personas','Detalles','Estado'];

        $rows = array_map(fn($reserva) => [$reserva['id'], $reserva['apellido'], $reserva['nombre'],$reserva['telefono'],$reserva['fecha'],$reserva['hora'],$reserva['personas'],$reserva['detalles'],$reserva['estado']], $reservas);
    
        $reportGenerator = new ReportGenerator();
        $reportGenerator->generatePDF('Lista de Reservas', $headers, $rows, 'reservas.pdf');
    }

    public function excel(Request $request, Response $response): void
    {
        {
            $requestData = $request->getData();
            $reservas = $requestData['reservas'] ?? [];
    
        $headers = ['ID','Apellido', 'Nombre','Teléfono','Fecha','Hora','Personas','Detalles','Estado'];

        $rows = array_map(fn($reserva) => [$reserva['id'], $reserva['apellido'], $reserva['nombre'],$reserva['telefono'],$reserva['fecha'],$reserva['hora'],$reserva['personas'],$reserva['detalles'],$reserva['estado']], $reservas);
    
    
            $excelReportGenerator = new ReportGenerator();
            $excelReportGenerator->generateExcel('Lista de Reservas', $headers, $rows, 'reservas.xlsx');
        }
    }
}
