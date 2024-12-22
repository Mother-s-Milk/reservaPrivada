<h1 class="breadcrumbs">Reservas</h1>

<section class="container section">
    <div class="header-actions gadget">
        <h2>Lista de Reservas</h2>
        <button type="button" class="btn-add" onclick="window.location.href='reserva/create'">Agregar Reserva</button>
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
                        <option value="">Todos</option>
                        <option value="Confirmada">Confirmado</option>
                        <option value="Cancelada">Cancelado</option>
                        <option value="Pendiente">Pendiente</option>
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
                        <th>Apellido</th>
                        <th>Nombres</th>
                        <th>Telefono</th>
                        <th>Fecha</th>
                        <th>Hora</th>
                        <th>Personas</th>
                        <th>Detalles</th>
                        <th>Estado</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody id="reservas-body">
                </tbody>
            </table>
            <div id="pagination" class="pagination">
                <!-- Botones de paginación se agregarán aquí -->
            </div>
        </main>
    </div>
</section>