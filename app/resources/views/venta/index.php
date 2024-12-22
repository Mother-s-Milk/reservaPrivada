<h1 class="breadcrumbs">Ventas</h1>

<section class="container section">
    <div class="header-actions gadget">
        <h2>Historial de Ventas</h2>
        <button type="button" class="btn-add" onclick="window.location.href='venta/create'">Nueva venta</button>
    </div>
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
                    <label for="filtro-estado">Estado:</label>
                    <select id="filtro-estado" name="estado">
                        <option value="">Todas</option>
                        <option value="Confirmada">Confirmada</option>
                        <option value="Cancelada">Cancelada</option>
                        <option value="Pendiente">Pendiente</option>
                    </select>
                </div>
                <div>
                    <label for="filtro-estado">Medio de pago:</label>
                    <select id="filtro-estado" name="estado">
                        <option value="">Todos</option>
                        <option value="Confirmada">Efectivo</option>
                        <option value="Cancelada">Debito</option>
                        <option value="Pendiente">Credito</option>
                        <option value="Pendiente">Transferencia</option>
                    </select>
                </div>
                <button type="button" id="btn-filtrar" class="btn-form">Aplicar Filtros</button>
                <button type="button" id="btn-borrar-filtrar" class="btn-reset">Borrar Filtros</button>
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
        </main>
    </div>
</section>