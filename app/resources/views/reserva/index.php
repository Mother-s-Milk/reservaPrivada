<h1 class="breadcrum">Reservas</h1>

<section class="container section">
    <div class="header-actions gadget">
        <h2>Lista de Reservas</h2>
        <button type="button" class="btn-add" onclick="window.location.href='reserva/create'">Agregar Reserva</button>
    </div>
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
                    <th>Detalles</th>
                    <th>Estado</th>
                    <th>Opciones</th>
                </tr>
            </thead>
            <tbody id="reservas-body">
            </tbody>
        </table>
    </main>
</section>