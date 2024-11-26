<h1>Reserva->Alta</h1>

<form id="reserva-form">
    <div>
        <label for="reservaApellido">Apellido</label>
        <input type="text" id="reservaApellido" name="reservaApellido" required>
    </div>
    <div>
        <label for="reservaNombres">Nombres</label>
        <input type="text" id="reservaNombres" name="reservaNombres" required>
    </div>
    <div>
        <label for="reservaTelefono">Telefono</label>
        <input type="text" id="reservaTelefono" name="reservaTelefono" required>
    </div>
    <div>
        <label for="reservaFecha">Fecha</label>
        <input type="date" id="reservaFecha" name="reservaFecha" required>
    </div>
    <div>
        <label for="reservaHora">Hora</label>
        <input type="time" id="reservaHora" name="reservaHora" required>
    </div>
    <div>
        <label for="reservaDetalles">Detalles de la reserva</label>
        <textarea id="reservaDetalles" name="reservaDetalles" required></textarea>
    </div>
    <button type="button" id="btn-reserva-alta">Guardar Reserva</button>
</form>