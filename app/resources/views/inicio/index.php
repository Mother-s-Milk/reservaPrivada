<?php

    use app\core\model\dao\BebidaDAO;
    use app\libs\Connection\Connection;

    use app\core\model\dao\ReservaDAO;

    $conn = Connection::get();

    $dao= new BebidaDAO($conn);
    $bebidas = $dao->list();

    $dao2 = new ReservaDAO($conn);
    $reservas = $dao2->list();

    $bajoStock = [];

    foreach($bebidas as $bebida) {
        if ($bebida['stock'] <= 10) {
            $bajoStock[] = $bebida;
        }
    }

    $fechaActual = date('Y-m-d'); // Esto te dará la fecha actual en formato 'YYYY-MM-DD'
    $reservasHoy = [];

    foreach($reservas as $reserva) {
        if ($reserva['fecha'] == $fechaActual) {
            $reservasHoy[] = $reserva;
        }
    }

?>

<h1 class="breadcrum">Inicio</h1>
<section class="container section one">
    <aside class="double">
        <div class="gadget">
            <h2 class="gadget-titulo">Stock bajo</h2>
            <table class="dashboard-table">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Nombre</th>
                        <th>Stock</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td colspan="3">No hay stock bajo</td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="gadget">
            <h2 class="gadget-titulo">Reservas</h2>
            <table class="dashboard-table">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Hora</th>
                        <th>Mesa</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td colspan="3">No hay reservas registradas</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </aside>
    <main class="one">
        <div class="gadget">
            <h2 class="gadget-titulo">Historial de ventas</h2>
            <table class="dashboard-table">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Total</th>
                        <th>Fecha</th>
                        <th>Hora</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td colspan="4">No hay ventas registradas</td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="double">
            <div></div>
            <div class="gadget grafico-dashboard">
                <h2>Ventas Diarias</h2>
                <canvas id="ventasDiariasChart"></canvas>
            </div>
        </div>
    </main>
</section>