<?php

    use app\core\model\dao\BebidaDAO;
    use app\libs\connection\Connection;

    $conn = Connection::get();

    $bebidaDao = new BebidaDAO($conn);

?>

<h1 class="breadcrum">Ventas/Alta</h1>

<section class="container section">
    <div class="gadget">
        <header class="titulo-formulario">
            <h1>Formulario de Ventas</h1>
        </header>
        <form id="venta-form" class="form one">
            <section>
                <header>
                    <h2 class="gadget-titulo">
                        Datos del cliente
                    </h2>
                </header>
                <main>
                    <div class="double">
                        <div>
                            <input id="clienteNombre" type="text" placeholder="Apellido y nombre">
                        </div>
                        <div>
                            <input id="clienteCuil" type="text" placeholder="CUIT / CUIL">
                        </div>
                    </div>
                    <div class="double">
                        <div>
                            <input id="clienteDireccion" type="text" placeholder="Dirección">
                        </div>
                        <div>
                            <input id="clienteTelefono" type="text" placeholder="Teléfono">
                        </div>
                    </div>
                </main>
            </section>
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
                        <select id="pagoForma">
                            <option value="" disabled selected>Forma de pago</option>
                            <option value="debito">Débito</option>
                            <option value="credito">Crédito</option>
                            <option value="transferencia">Transferencia</option>
                        </select>
                    </div>
                </main>
            </section>
            <section id="productSection">
                <header>
                    <h2 class="gadget-titulo">
                        Productos
                    </h2>
                </header>
                <main class="four">
                    <div>
                        <input id="productoCodigo" type="number" placeholder="Codigo">
                    </div>
                    <div>
                        <input id="productoDescripcion" type="number" placeholder="Descripcion">
                    </div>
                    <div>
                        <input id="productoCantidad" type="number" placeholder="Cantidad">
                    </div>
                    <div>
                        <button id="btn-agregar-producto" type="button" class="btn-add">
                            Agregar
                        </button>
                    </div>
                </main>
            </section>
            <section>
                <table class="tabla-lista">
                    <thead>
                        <tr>
                            <th>Código</th>
                            <th>Descripción</th>
                            <th>Precio</th>
                            <th>Cantidad</th>
                            <th>SubTotal</th>
                            <th>Opciones</th>
                        </tr>
                    </thead>
                    <tbody id="body-bebidas">
                        <tr>
                            <td colspan="6">
                                No hay productos cargados
                            </td>
                        </tr>
                    </tbody>
                    <tfoot>
                        <tr>
                            <th colspan="4" style="text-align: right;">Total:</th>
                            <th id="total-venta">$0.00</th>
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