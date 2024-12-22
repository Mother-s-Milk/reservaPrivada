<?php

    use app\libs\Connection\Connection;
    use app\core\model\dao\BebidaDAO;
    use app\core\model\dao\ReservaDAO;
    use app\core\model\dao\VentaDAO;

    $conn = Connection::get();

    $bebidaDAO= new BebidaDAO($conn);
    $bebidas = $bebidaDAO->list();

    $reservaDAO = new ReservaDAO($conn);
    $reservas = $reservaDAO->list();

    $ventasDAO = new VentaDAO($conn);
    $ventas = $ventasDAO->list();

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

<h1 class="breadcrumbs">Inicio</h1>
<!-- <h1 class="breadcrumbs">¡Hola, Franco!</h1> -->
<section class="container section one">
    <aside class="double">
        <div class="gadget">
            <h2 class="gadget-titulo">Historial de ventas</h2>
            <table class="dashboard-table">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Fecha</th>
                        <th>Hora</th>
                        <th>Total</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                <?php
                        if (count($ventas) == 0) {
                            echo '<tr><td colspan="5" style="text-align: center;">No hay ventas de hoy</td></tr>';
                        }
                        else {
                            $contador = 1;
                            foreach($ventas as $venta) {
                                echo '<tr>';
                                echo '<td>' . $contador . '</td>';
                                echo '<td>' . $venta['fecha'] . '</td>';
                                echo '<td>' . $venta['hora'] . '</td>';
                                echo '<td>$' . $venta['total'] . '</td>';
                                echo '<td><button type="button" class="btn-check" data-id="' . $venta['id'] . '" style="width: auto">Ver detalles</button></td>';
                                echo '</tr>';
                                $contador++;
                            }
                        }
                    ?>
                </tbody>
            </table>
        </div>
        <div class="gadget">
            <h2 class="gadget-titulo">Stock bajo</h2>
            <table class="dashboard-table">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Nombre</th>
                        <th>Stock</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        if (count($bajoStock) == 0) {
                            echo '<tr><td colspan="4" style="text-align: center;">No hay stock bajo</td></tr>';
                        }
                        else {
                            $contador = 1;
                            foreach($bajoStock as $bebida) {
                                echo '<tr>';
                                echo '<td>' . $contador . '</td>';
                                echo '<td>' . $bebida['nombre'] . '</td>';
                                echo '<td>' . $bebida['stock'] . '</td>';
                                echo '<td><button type="button" class="btn-form btn-editar" data-id="' . $bebida['id'] . '" onclick="window.location.href=\'bebida/editar/' . $bebida['id'] . '\'" style="width: auto">Actualizar</button></td>';
                                echo '</tr>';
                                $contador++;
                            }
                        }
                    ?>
                </tbody>
            </table>
        </div>
    </aside>
    <main class="double">
        <div class="gadget">
            <h2 class="gadget-titulo">Reservas</h2>
            <table class="dashboard-table">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Hora</th>
                        <th>Detalles</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        if (count($reservasHoy) == 0) {
                            echo '<tr><td colspan="4" style="text-align: center;">No hay reservas para hoy</td></tr>';
                        }
                        else {
                            $contador = 1;
                            foreach($reservasHoy as $reserva) {
                                echo '<tr>';
                                echo '<td>' . $contador . '</td>';
                                echo '<td>' . $reserva['hora'] . '</td>';
                                echo '<td>' . $reserva['detalles'] . '</td>';
                                echo '<td><button type="button" class="btn-form btn-eliminar" data-id="' . $reserva['id'] . '">Cancelar</button></td>';
                                echo '<td><button type="button" class="btn-form btn-actualizar" data-id="' . $reserva['id'] . '">Confirmar</button></td>';
                                echo '</tr>';
                                $contador++;
                            }
                        }
                    ?>
                </tbody>
            </table>
        </div>
        <div class="gadget grafico-dashboard">
            <h2 class="gadget-titulo">Ventas Diarias</h2>
            <canvas id="ventasDiariasChart"></canvas>
        </div>
    </main>
</section>