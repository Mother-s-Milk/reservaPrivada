<h1>Reserva->Index</h1>

<div>
    <button type="button" onclick="window.location.href='reserva/create'">Agregar Reserva</button>
</div>

<section class="container section animation-section">
    <header class="header-section">
        <h2>Reservas</h2>
    </header>
    <div class="section-filter">
        <section class="bebidas-tabla" id="reservas-index">
            <table>
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
        </section>
    </div>
</section>