<?php

    use app\core\model\dao\BebidaDAO;
    use app\libs\connection\Connection;

    $conn = Connection::get();

    $bebidaDAO = new BebidaDAO($conn);
    $bebidas = $bebidaDAO->list();

?>

<h1 class="breadcrumbs">Ventas/Alta</h1>

<section class="container section">
    <div class="gadget">
        <header class="titulo-formulario">
            <h1>Formulario de Ventas</h1>
        </header>
        <form id="venta-form" class="form one">
            <section>
                <header>
                    <h2 class="gadget-titulo">
                        Datos del pago
                    </h2>
                </header>
                <main class="triple">
                    <div>
                        <input id="pagoFecha" type="date">
                    </div>
                    <div>
                        <input id="pagoHora" type="time">
                    </div>
                    <div>
                        <select id="formaPago" name="formaPago" required>
                            <option value="" disabled selected>Seleccionar medio de pago</option>
                            <option value="Efectivo">Efectivo</option>
                            <option value="Debito">Débito</option>
                            <option value="Credito">Crédito</option>
                            <option value="Transferencia">Transferencia</option>
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
                <main class="triple">
                    <div>
                        <select id="bebidaNombre" name="bebidaNombre" required>
                            <option value="" selected disabled>Seleccionar bebida</option>
                                <?php
                                    foreach ($bebidas as $bebida) {
                                        echo "<option value='{$bebida['id']}' data-nombre='{$bebida['nombre']}' data-precio='{$bebida['precioUnitario']}'  data-stock='{$bebida['stock']}'>{$bebida['nombre']}
                                        </option>";
                                    }
                                ?>
                        </select>
                    </div>
                    <div>
                        <input id="bebidaCantidad" type="number" placeholder="Cantidad" required>
                    </div>
                    <div>
                        <button id="btn-agregar-bebida-venta" type="button" class="btn-add">
                            Agregar bebida
                        </button>
                    </div>
                </main>
            </section>
            <section>
                <table class="tabla-lista">
                    <thead>
                        <tr>
                            <th>Nombre</th>
                            <th>Precio unitario</th>
                            <th>Cantidad</th>
                            <th>SubTotal</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody id="bebidas-venta-body">
                        <tr>
                            <td colspan="5">
                                No hay productos cargados
                            </td>
                        </tr>
                    </tbody>
                    <tfoot hidden>
                        <tr>
                            <th colspan="3" style="text-align: right;">TOTAL:</th>
                            <th colspan="1" id="total-venta">$0.00</th>
                        </tr>
                    </tfoot>
                </table>
            </section>
            <div class="double">
                <button type="button" id="btn-venta-resetear" class="btn-reset">Resetear formulario</button>
                <button type="button" id="btn-venta-alta" class="btn-form">Registrar venta</button>
            </div>
        </form>
    </div>
</section>