<h1 class="breadcrumbs">Mesas</h1>

<section class="container section">
    <!-- <div class="header-actions gadget">
        <h2>Lista de Mesas</h2>
        <button type="button" class="btn-add" onclick="window.location.href='mesa/create'">Agregar Mesa</button>
    </div> -->
    <div class="seccion-mesas">
        <main class="mesas-container">
            <div class="mesa" data-id="1" data-estado="libre">Mesa 1</div>
            <div class="mesa" data-id="2" data-estado="libre">Mesa 2</div>
            <div class="mesa" data-id="3" data-estado="libre">Mesa 3</div>
            <div class="mesa" data-id="4" data-estado="libre">Mesa 4</div>
            <div class="mesa" data-id="5" data-estado="libre">Mesa 5</div>
            <div class="mesa" data-id="6" data-estado="libre">Mesa 6</div>
        </main>
        <aside id="mesa-info" class="mesa-info">
            <h2>
                Detalles de mesa
            </h2>
            <div>
                <p><span>Mesa:</span> 3</p>
                <p><span>Apertura:</span> 19:50</p>
                <p><span>Duración:</span> 45:36</p>
                <p><span>Mozo:</span> Cristian</p>
            </div>
            <select name="" id="">
                <option value="">Seleccione un producto</option>
            </select>
            <button>Agregar producto</button>
            <table>
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Nombre</th>
                        <th>Precio</th>
                        <th>Cantidad</th>
                        <th>Subtotal</th>
                    </tr>
                </thead>
                <tbody id="mesa-detalles-body">
                    <tr>
                        <td>1</td>
                        <td>Agua mineral</td>
                        <td>$2500</td>
                        <td>1</td>
                        <td>$2500</td>
                    </tr>
                    <tr>
                        <td>2</td>
                        <td>Cerveza tirada</td>
                        <td>$5000</td>
                        <td>3</td>
                        <td>$15000</td>
                    </tr>
                    <tr>
                        <td>3</td>
                        <td>Vino malbec</td>
                        <td>$9000</td>
                        <td>1</td>
                        <td>$27000</td>
                    </tr>
                </tbody>
                <tfoot>
                    <tr>
                        <th colspan="4" style="text-align: right;">Total:</th>
                        <th colspan="1" id="total-venta">$25600.00</th>
                    </tr>
                </tfoot>
            </table>
            <button>Cerrar mesa</button>
        </aside>
    </div>
</section>