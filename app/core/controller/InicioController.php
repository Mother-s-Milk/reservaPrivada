<?php

    namespace app\core\controller;

    use app\core\controller\base\Controller;

    use app\core\service\InicioService;

    use app\libs\request\Request;
    use app\libs\response\Response;

    final class InicioController extends Controller {

        public function __construct () {
            parent::__construct ([
                "app/js/inicio/inicioController.js",
                "app/js/inicio/inicioService.js"
            ]);
        }

        public function index (): void {
            $this->view = "inicio/index.php";
            $BC_actual = "";
            $BC_link_anterior = APP_FRONT."inicio/index";
            $BC_anterior = "Inicio";
            require_once APP_TEMPLATE . "template.php";
        }

        public function consultarVentas (Request $request, Response $response): void {
            $service = new InicioService();
            $ventas = $service->consultarVentas();
            $response->setResult($ventas);
            $response->send();
        }

        public function consultarBajoStock (Request $request, Response $response): void {
            $service = new InicioService();
            $bajoStock = $service->consultarBajoStock();
            $response->setResult($bajoStock);
            $response->send();
        }

        public function consultarReservas (Request $request, Response $response): void {
            $service = new InicioService();
            $reservas = $service->consultarReservas();
            $response->setResult($reservas);
            $response->send();
        }

        public function consultarProveedores (Request $request, Response $response): void {
            $service = new InicioService();
            $proveedores = $service->consultarProveedores();
            $response->setResult($proveedores);
            $response->send();
        }

        public function consultarBebidas (Request $request, Response $response): void {
            $service = new InicioService();
            $bebidas = $service->consultarBebidas();
            $response->setResult($bebidas);
            $response->send();
        }

        public function consultarVentasSemanales (Request $request, Response $response): void {
            $service = new InicioService();
            $ventasSemanales = $service->consultarVentasSemanales();
            $response->setResult($ventasSemanales);
            $response->send();
        }

        public function mostrarInicioVentas (Request $request, Response $response): void {
            $service = new InicioService();
            $ventasSemanales = $service->mostrarInicioVentas();
            $response->setResult($ventasSemanales);
            $response->send();
        }

    }

?>