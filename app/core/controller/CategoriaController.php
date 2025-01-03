<?php

    namespace app\core\controller;

    use app\core\controller\base\Controller;
    use app\core\controller\base\InterfaceController;
    use Dompdf\Dompdf;
use Dompdf\Options;
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
            $BC_actual="Categoria";
            $BC_link_anterior=APP_FRONT."inicio/index";
            $BC_anterior="Inicio";
            require_once APP_TEMPLATE . "template.php";
        }

        public function create (): void {
            $this->view = "categoria/alta.php";
            $BC_actual="Crear Categoria";
            $BC_link_anterior=APP_FRONT."categoria/index";
            $BC_anterior="Categorias";
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
            $BC_actual="Editar Categoria";
            $BC_link_anterior=APP_FRONT."categoria/index";
            $BC_anterior="Categorias";
            require_once APP_TEMPLATE . "template.php";
        }

        public function load (Request $request, Response $response): void {
            try {
                $service = new CategoriaService();
                $categoria = $service->load($request->getId());

                if (!$categoria) {
                    throw new \Exception("La categoria con ID $id no existe.");
                }

                $response->setResult($categoria->toArray());
                $response->setMessage("La categoria se cargó correctamente");
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

                $service = new CategoriaService();
                $service->update($data);

                $response->setMessage("La categoria se actualizo correctamente.");
                $response->send();
            }
            catch (\Exception $ex) {
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

        public function pdf(): void {
            $requestData = json_decode(file_get_contents("php://input"), true);
            $categorias = $requestData['categorias'] ?? [];
    
            $html = '<h1>Lista de Categorías</h1>';
            $html .= '<table border="1" cellspacing="0" cellpadding="5">';
            $html .= '<thead><tr><th>#</th><th>Nombre</th><th>Descripción</th></tr></thead>';
            $html .= '<tbody>';
            foreach ($categorias as $categoria) {
                $html .= '<tr>';
                $html .= '<td>' . htmlspecialchars($categoria['id']) . '</td>';
                $html .= '<td>' . htmlspecialchars($categoria['nombre']) . '</td>';
                $html .= '<td>' . htmlspecialchars($categoria['descripcion']) . '</td>';
                $html .= '</tr>';
            }
            $html .= '</tbody></table>';
    
            $options = new Options();
            $options->set('isHtml5ParserEnabled', true);
            $options->set('isRemoteEnabled', true);
    
            $dompdf = new Dompdf($options);
            $dompdf->loadHtml($html);
            $dompdf->setPaper('A4', 'portrait');
            $dompdf->render();
    
            $response = new Response();
            $response->setController('Categoria');
            $response->setAction('pdf');
    
            try {
                $pdfContent = $dompdf->output();
                $response->sendFile($pdfContent, 'categorias.pdf');
            } catch (\Exception $e) {
                $response->setError(true);
                $response->setMessage("Error al generar el PDF: " . $e->getMessage());
                $response->send();
            }
        }

        public function excel(): void {
            $requestData = json_decode(file_get_contents("php://input"), true);
            $categorias = $requestData['categorias'] ?? [];
    
            $html = '<table border="1" cellspacing="0" cellpadding="5">';
            $html .= '<thead><tr><th>#</th><th>Nombre</th><th>Descripción</th></tr></thead>';
            $html .= '<tbody>';
            foreach ($categorias as $categoria) {
                $html .= '<tr>';
                $html .= '<td>' . htmlspecialchars($categoria['id']) . '</td>';
                $html .= '<td>' . htmlspecialchars($categoria['nombre']) . '</td>';
                $html .= '<td>' . htmlspecialchars($categoria['descripcion']) . '</td>';
                $html .= '</tr>';
            }
            $html .= '</tbody></table>';
    
            $response = new Response();
            $response->setController('Categoria');
            $response->setAction('excel');
    
            header('Content-Type: application/vnd.ms-excel');
            header('Content-Disposition: inline;filename=categorias.xls');
    
            echo $html;
        }

}

?>