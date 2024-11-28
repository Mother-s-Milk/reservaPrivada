<?php

    namespace app\core\controller;

    use app\core\controller\base\Controller;
    use app\core\controller\base\InterfaceController;

    use app\libs\request\Request;
    use app\libs\response\Response;

    final class InicioController extends Controller {

        public function __construct () {
            parent::__construct ([
                "app/js/inicio/inicioController.js"
            ]);
        }

        public function index (): void {
            /*$service = new BebidaService();
            $data = $service->list();*/
            $this->view = "inicio/index.php";
            require_once APP_TEMPLATE . "template.php";
        }

    }

?>