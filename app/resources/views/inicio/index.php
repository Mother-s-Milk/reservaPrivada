<?php

    use app\core\model\dao\BebidaDAO;
    use app\core\model\dao\ReservaDAO;
    use app\libs\Connection\Connection;

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

    $fechaActual = date('y-m-d'); //Fecha actual en formato 'YYYY-MM-DD'
    $reservasHoy = [];

    foreach($reservas as $reserva) {
        if ($reserva['fecha'] == $fechaActual) {
            $reservasHoy[] = $reserva;
        }
    }

?>

<h1 class="breadcrum">Inicio</h1>
<h1 class="breadcrum">¡Hola, Franco!</h1>
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
                    <?php
                        if (count($bajoStock) == 0) {
                            echo '<tr><td colspan="3" style="text-align: center;">No hay stock bajo</td></tr>';
                        }
                        else {
                            $contador = 1;
                            foreach($bajoStock as $bebida) {
                                echo '<tr>';
                                echo '<td>' . $contador . '</td>';
                                echo '<td>' . $bebida['nombre'] . '</td>';
                                echo '<td>' . $bebida['stock'] . '</td>';
                                echo '</tr>';
                                $contador++;
                            }
                        }
                    ?>
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
                        <th>Detalles</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        if (count($reservasHoy) == 0) {
                            echo '<tr><td colspan="3" style="text-align: center;">No hay reservas para hoy</td></tr>';
                        }
                        else {
                            $contador = 1;
                            foreach($reservasHoy as $reserva) {
                                echo '<tr>';
                                echo '<td>' . $contador . '</td>';
                                echo '<td>' . $reserva['hora'] . '</td>';
                                echo '<td>' . $reserva['detalles'] . '</td>';
                                echo '</tr>';
                                $contador++;
                            }
                        }
                    ?>
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
                        <th>Fecha</th>
                        <th>Hora</th>
                        <th>Total</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td colspan="4" style="text-align: center;">No hay ventas registradas</td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="double">
            <div></div>
            <div class="gadget grafico-dashboard">
                <h2 class="gadget-titulo">Ventas Diarias</h2>
                <canvas id="ventasDiariasChart"></canvas>
            </div>
        </div>
    </main>
</section>