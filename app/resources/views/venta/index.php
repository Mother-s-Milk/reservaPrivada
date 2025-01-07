<h1 class="breadcrumbs">Ventas</h1>

<section class="container section">
    <div class="one">
        <aside class="gadget">
            <h2>Filtros</h2>
            <form id="filtros-form">
                <div>
                    <label for="filtro-fecha-inicio">Fecha Inicio:</label>
                    <input type="date" id="filtro-fecha-inicio" name="fechaInicio">
                </div>
                <div>
                    <label for="filtro-fecha-fin">Fecha Fin:</label>
                    <input type="date" id="filtro-fecha-fin" name="fechaFin">
                </div>
                <div>
                    <label for="filtro-medio-pago">Medio de pago:</label>
                    <select id="filtro-medio-pago" name="medioPago">
                        <option value="">Todos</option>
                        <option value="Efectivo">Efectivo</option>
                        <option value="Debito">Debito</option>
                        <option value="Credito">Credito</option>
                        <option value="Transferencia">Transferencia</option>
                    </select>
                </div>
                <div>
                    <label for="filtro-precio-minimo">Precio Mínimo:</label>
                    <input type="number" id="filtro-precio-minimo" name="precioMinimo" placeholder="0" min="0" step="0.01">
                </div>
                <div>
                    <label for="filtro-precio-maximo">Precio Máximo:</label>
                    <input type="number" id="filtro-precio-maximo" name="precioMaximo" placeholder="0" min="0" step="0.01">
                </div>

                <button type="button" id="btn-filtrar" class="btn-form">Aplicar Filtros</button>
                <button type="button" id="btn-borrar-filtrar" class="btn-reset">Borrar Filtros</button>
                <button type="button" class="btn-add" onclick="window.location.href='venta/create'">Nueva venta</button>
                <button type="button" class="btn-pdf" id="btn-pdf">PDF</button>
                <button type="button" class="btn-excel" id="btn-excel">Excel</button>
            </form>
        </aside>
        <main class="gadget">
            <table class="tabla-lista">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Fecha</th>
                        <th>Hora</th>
                        <th>Forma de pago</th>
                        <th>Total</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody id="ventas-body">
                </tbody>
            </table>
            <div id="pagination" class="pagination">
                <!-- Botones de paginación se agregarán aquí -->
            </div>
        </main>
    </div>
</section>