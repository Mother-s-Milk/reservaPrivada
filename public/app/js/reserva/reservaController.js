let reservaController = {
  reservas: [],
  elementos:0,
  pagActual: 1,
  tamPag:5,
  
  save: () => {
    if (!confirm("¿Estás seguro de guardar la reserva?")) {
      return;
    }

    if (document.getElementById("reservaApellido").value === "") {
      alert("El apellido es requerido");
      return;
    }

    if (document.getElementById("reservaNombres").value === "") {
      alert("El nombre es requerido");
      return;
    }

    if (document.getElementById("reservaTelefono").value === "") {
      alert("El teléfono es requerido");
      return;
    }

    if (document.getElementById("reservaFecha").value === "") {
      alert("La fecha es requerida");
      return;
    }

    if (document.getElementById("reservaHora").value === "") {
      alert("La hora es requerida");
      return;
    }

    if (document.getElementById("reservaDetalles").value === "") {
      alert("Los detalles son requeridos");
      return;
    }

    let newReserva = {
      id: 0,
      apellido: document.getElementById("reservaApellido").value,
      nombres: document.getElementById("reservaNombres").value,
      telefono: document.getElementById("reservaTelefono").value,
      fecha: document.getElementById("reservaFecha").value,
      hora: document.getElementById("reservaHora").value,
      detalles: document.getElementById("reservaDetalles").value,
      estado: "",
      // personas: document.getElementById('reservaPersonas').value,
    };

    reservaService.save(newReserva);
  },

  confirmar: (event) => {
    if (!confirm("¿Estás seguro de confirmar la reserva?")) {
      return;
    }

    let id = parseInt(event.target.getAttribute("data-id"));
    let estado = "Confirmada";

    let reserva = {
      id: id,
      estado: estado,
    };

    reservaService.changeState(reserva).then((data) => {
      alert(data.message);
      reservaController.list(reservaController.pagActual);
    });
  },

  cancelar: (event) => {
    if (!confirm("¿Estás seguro de cancelar la reserva?")) {
      return;
    }
    let id = parseInt(event.target.getAttribute("data-id"));
    let estado = "Cancelada";

    let reserva = {
      id: id,
      estado: estado,
    };

    reservaService.changeState(reserva).then((data) => {
      alert(data.message);
      reservaController.list(reservaController.pagActual);
    });
  },

  delete: (id) => {
    if (confirm(`¿Estás seguro de eliminar la reserva con ID`, id)) {
      reservaService
        .delete(id)
        .then((data) => {
          alert(data.message);
          reservaController.list();
        })
        .catch((error) => {
          alert("Ocurrió un error al eliminar la reserva.", error);
        });
    }
  },
  
  list: (page) => {
    let data = {
        page: page,
        pageSize: 5,
    };
    reservaService
        .listPage(data)
        .then((data) => {
            reservaController.reservas = data.result;
            reservaController.render();
        })
        .catch((error) => {
            console.error(
                "Error al cargar las reservas (controller del front)",
                error
            );
        });
},

render: () => {
    let reservasBody = document.getElementById("reservas-body");
    let paginas=Math.ceil(reservaController.elementos/reservaController.tamPag)
    if (reservaController.reservas.length === 0) {
        let fila = `
            <tr>
                <td colspan="10">
                    No hay reservas registradas
                </td>
            </tr>
        `;
        reservasBody.innerHTML = fila;
    } else {
        reservasBody.innerHTML = "";
        let fila;
        let contador = 1;
        reservaController.reservas.forEach((reserva) => {
            fila = `
                <tr>
                    <td>${contador}</td>
                    <td>${reserva.apellido}</td>
                    <td>${reserva.nombres}</td>
                    <td>${reserva.telefono}</td>
                    <td>${reserva.fecha}</td>
                    <td>${reserva.hora}</td>
                    <td>${reserva.personas}</td>
                    <td>${reserva.detalles}</td>
                    <td>${reserva.estado}</td>
                    <td>
                        <button type="button" class="btn-confirmar" data-id="${reserva.id}">Confirmar</button>
                        <button type="button" class="btn-cancelar" data-id="${reserva.id}">Cancelar</button>
                    </td>
                </tr>
            `;
            contador++;
            reservasBody.insertAdjacentHTML("beforeend", fila);
        });
        document.querySelectorAll(".btn-confirmar").forEach((button) => {
          button.addEventListener("click", (event) => {
              reservaController.confirmar(event);
               // Actualiza la lista después de confirmar
          });
      });
      
      document.querySelectorAll(".btn-cancelar").forEach((button) => {
          button.addEventListener("click", (event) => {
              reservaController.cancelar(event);
               // Actualiza la lista después de cancelar
          });
      });
    }

    // Renderizar botones de paginación
    let pagination = document.getElementById("pagination");
    pagination.innerHTML = "";
    // console.log(Math.ceil(reservaController.elementos))
    for (let i = 1; i <= paginas; i++) {
      let button = document.createElement("button");
      button.textContent = i;
      button.id = `${i}`; // Agregar id único para cada botón
      button.classList.add("pagination-button");
      
      button.addEventListener("click", () => {
        reservaController.list(i);
        reservaController.pagActual=i;
      });
      pagination.appendChild(button);
  }
},

pages: () => {
  return reservaService.pages()
      .then((data) => {
          reservaController.elementos = data.result; // Devuelve los datos recibidos del servicio
      })
      .catch((error) => {
          console.error("Error al obtener las páginas", error);
      });
}



};

document.addEventListener("DOMContentLoaded", () => {
  const path = window.location.pathname;
  if (path === "/reservaPrivada/public/reserva") {
    reservaController.pages().then(() => {
      reservaController.list(1);
  });
  }

  let btnReservaAlta = document.getElementById("btn-reserva-alta");
  if (btnReservaAlta != null) {
    btnReservaAlta.onclick = () => {
      reservaController.save();
    };
  }
});
