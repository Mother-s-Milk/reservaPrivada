<h1 class="breadcrumbs">Reservas/Alta</h1>

<section class="container section">
    <div class="gadget">
        <header class="titulo-formulario">
            <h1>Formulario de Reservas</h1>
        </header>
        <form id="reserva-form" class="form">
            <div>
                <input type="text" id="reservaApellido" name="reservaApellido" placeholder="Apellido" required>
            </div>
            <div>
                <input type="text" id="reservaNombres" name="reservaNombres" placeholder="Nombres" required>
            </div>
            <div>
                <input type="text" id="reservaTelefono" name="reservaTelefono" placeholder="Telefono" required>
            </div>
            <div>
                <input type="date" id="reservaFecha" name="reservaFecha" required>
            </div>
            <div>
                <input type="time" id="reservaHora" name="reservaHora" required>
            </div>
            <div>
                <textarea id="reservaDetalles" name="reservaDetalles" placeholder="Detalles de la reserva" required></textarea>
            </div>
            <button type="button" id="btn-reserva-alta" class="btn-form">Guardar Reserva</button>
        </form>
    </div>
</section>