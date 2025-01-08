<?php

namespace app\core\controller;

use app\core\controller\base\Controller;
use app\core\controller\base\InterfaceController;
use app\libs\report\ReportGenerator;
use app\core\service\CategoriaService;

use app\libs\request\Request;
use app\libs\response\Response;

final class CategoriaController extends Controller implements InterfaceController
{

    public function __construct()
    {
        parent::__construct([
            "app/js/categoria/categoriaController.js",
            "app/js/categoria/categoriaService.js"
        ]);
    }

    public function index(): void
    {
        $this->view = "categoria/index.php";
        $BC_actual = "Categoria";
        $BC_link_anterior = APP_FRONT . "inicio/index";
        $BC_anterior = "Inicio";
        require_once APP_TEMPLATE . "template.php";
    }

    public function create(): void
    {
        $this->view = "categoria/alta.php";
        $BC_actual = "Crear Categoria";
        $BC_link_anterior = APP_FRONT . "categoria/index";
        $BC_anterior = "Categorias";
        require_once APP_TEMPLATE . "template.php";
    }

    public function save(Request $request, Response $response): void
    {
        $service = new CategoriaService();
        $service->save($request->getData());
        $response->setMessage("La categoria se registro correctamente.");
        $response->send();
    }

    public function editar(): void
    {
        $this->view = "categoria/editar.php";
        $BC_actual = "Editar Categoria";
        $BC_link_anterior = APP_FRONT . "categoria/index";
        $BC_anterior = "Categorias";
        require_once APP_TEMPLATE . "template.php";
    }

    public function load(Request $request, Response $response): void
    {
        try {
            $service = new CategoriaService();
            $categoria = $service->load($request->getId());

            if (!$categoria) {
                throw new \Exception("La categoria con ID $id no existe.");
            }

            $response->setResult($categoria->toArray());
            $response->setMessage("La categoria se cargó correctamente");
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

            $service = new CategoriaService();
            $service->update($data);

            $response->setMessage("La categoria se actualizo correctamente.");
            $response->send();
        } catch (\Exception $ex) {
            $response->setMessage($ex->getMessage());
            $response->send();
        }
    }

    public function delete(Request $request, Response $response): void
    {
        $service = new CategoriaService();
        $service->delete($request->getId());
        $response->setMessage('Categoria eliminada correctamente.');
        $response->send();
    }

    public function list(Request $request, Response $response): void
    {
        $service = new CategoriaService();
        $data = $service->list();

        $response->setResult($data);
        $response->send();
    }

    public function listPage(Request $request, Response $response): void
    {
        $data = $request->getData();
        $service = new CategoriaService();
        $result = $service->listPage($data);

        $response->setResult($result);
        $response->send();
    }

    public function pdf(Request $request, Response $response): void
    {
        $requestData = $request->getData();
        $categorias = $requestData['categorias'] ?? [];
    
        $headers = ['ID', 'Nombre', 'Descripción'];
        $rows = array_map(fn($categoria) => [$categoria['id'], $categoria['nombre'], $categoria['descripcion']], $categorias);
    
        $reportGenerator = new ReportGenerator();
        $reportGenerator->generatePDF('Lista de Categorías', $headers, $rows, 'categorias.pdf');
    }

    public function excel(Request $request, Response $response): void
    {
        {
            $requestData = $request->getData();
            $categorias = $requestData['categorias'] ?? [];
    
            $headers = ['ID', 'Nombre', 'Descripción'];
            $rows = array_map(fn($categoria) => [$categoria['id'], $categoria['nombre'], $categoria['descripcion']], $categorias);
    
            $excelReportGenerator = new ReportGenerator();
            $excelReportGenerator->generateExcel('Lista de Categorías', $headers, $rows, 'categorias.xlsx');
        }
    }
}
