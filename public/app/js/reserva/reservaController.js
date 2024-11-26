let reservaController = {
    reservas: [],
    /*data: {
        id: 0,
        apellido: "",
        nombres: "",
        telefono: "",
        fecha: "",
        hora: "",
        detalles: "",
        estado: 0
    },*/
    save: () => {
        let newReserva = {
            id: 0,
            apellido: document.getElementById('reservaApellido').value,
            nombres: document.getElementById('reservaNombres').value,
            telefono: document.getElementById('reservaTelefono').value,
            fecha: document.getElementById('reservaFecha').value,
            hora: document.getElementById('reservaHora').value,
            detalles: document.getElementById('reservaDetalles').value,
            estado: ''
        }

        reservaService.save(newReserva)
    },
    delete: (id) => {
        if (confirm(`¿Estás seguro de eliminar la reserva con ID`, id)) {
            reservaService.delete(id)
            .then(data => {
                alert(data.message);
                reservaController.list();
            })
            .catch(error => {
                alert("Ocurrió un error al eliminar la reserva.", error);
            });
        }
    },
    list: () => {
        reservaService.list()
            .then(data => {
                reservaController.reservas = data.result;
                reservaController.render();
            })
            .catch(error => {
                console.error("Error al cargar las reservas (controller del front)", error);
            });
    },
    render: () => {
        let reservasBody = document.getElementById('reservas-body');

        if (reservaController.reservas.length === 0) {
            let fila = `
                <tr>
                    <td colspan="9">
                        No hay reservas registradas
                    </td>
                </tr>
            `;

            reservasBody.innerHTML = fila;
        } else {
            reservasBody.innerHTML = '';
            let fila;
            let contador = 1;
            reservaController.reservas.forEach(reserva => {
                fila = `
                    <tr>
                        <td>${contador}</td>
                        <td>${reserva.apellido}</td>
                        <td>${reserva.nombres}</td>
                        <td>${reserva.telefono}</td>
                        <td>${reserva.fecha}</td>
                        <td>${reserva.hora}</td>
                        <td>${reserva.detalles}</td>
                        <td>${reserva.estado}</td>
                        <td>
                            <button type="button" class="btn-confirmar" data-id="${reserva.id}">Confirmar</button>
                            <button type="button" class="btn-cancelar" data-id="${reserva.id}">Cancelar</button>
                        </td>
                    </tr>
                `;
                contador++;
                reservasBody.insertAdjacentHTML('beforeend', fila);
            });
        }
    }
}

document.addEventListener("DOMContentLoaded", () => {
    const path = window.location.pathname;
    if (path === "/reservaPrivada/public/reserva") {
        reservaController.list();
    }

    let btnReservaAlta = document.getElementById("btn-reserva-alta");
    if (btnReservaAlta != null) {
        btnReservaAlta.onclick = () => {
            reservaController.save();
        }
    }
});