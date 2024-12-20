<h1 class="breadcrum">Reservas</h1>

<section class="container section">
    <div class="header-actions gadget">
        <h2>Lista de Reservas</h2>
        <button type="button" class="btn-add" onclick="window.location.href='reserva/create'">Agregar Reserva</button>
    </div>
    <div class="section-filter">
        <aside class="gadget">
            <h2>Filtros</h2>
            <ul>
                <li><button type="button" class="filter-button active" data-filter="todas">Todas</button></li>
            </ul>
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