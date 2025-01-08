<?php

    use app\libs\Connection\Connection;
    use app\core\model\dao\VentaDAO;

    $ventaID = $_GET['id'];
    $conn = Connection::get();

    $ventaDAO = new VentaDAO($conn);
    $venta = $ventaDAO->load($ventaID);

?>

<h1 class="breadcrumbs">Ventas/Ver Detalles</h1>

<section class="container section">
    <div class="gadget">
        <header class="titulo-formulario">
            <h1>Detalles de Ventas</h1>
        </header>
        <form id="venta-form" class="form one">
            <section>
                <header>

                    <h2 class="gadget-titulo">
                        Formato del pago
                    </h2>
                    <button type="button" id="btn-pay" data-id="<?=$venta->getId();?>" class="btn-excel"> Pagar(modo prueba)</button>

                </header>
                <main class="one">
                    <div>
                        <select id="formaPago" name="formaPago"> 
                            <option value="" disabled selected><?php echo $venta->getFormaPago();?></option>
                        </select>
                    </div>
                </main>
            </section>
            <section>
                <header>
                    <h2 class="gadget-titulo">
                        Detalles de la venta
                    </h2>
                </header>
            </section>
            <section>
                <table class="tabla-lista">
                    <thead>
                        <tr>
                            <th>Nombre</th>
                            <th>Precio unitario</th>
                            <th>Cantidad</th>
                            <th>SubTotal</th>
                        </tr>
                    </thead>
                    <tbody id="bebidas-venta-body">
                        <?php
                            foreach ($venta->getDetalles() as $detalle) {
                                echo '<tr>';
                                echo '<td>' . $detalle['bebida'] . '</td>';
                                echo '<td>$' . $detalle['precio'] . '</td>';
                                echo '<td>' . $detalle['cantidad'] . '</td>';
                                echo '<td>$' . $detalle['precio'] * $detalle['cantidad'] . '</td>';
                                echo '</tr>';
                            }
                        ?>
                    </tbody>
                    <tfoot>
                        <tr class="total-venta">
                            <th colspan="3" style="text-align: right;">TOTAL:</th>
                            <th colspan="1" id="total-venta">$<?php echo $venta->getTotal();?></th>
                        </tr>
                    </tfoot>
                </table>
            </section>
        </form>
    </div>
</section>