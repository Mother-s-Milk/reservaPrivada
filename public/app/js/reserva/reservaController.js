let reservaController = {
  reservas: [],
  pagActual: 1,
  tamPag: 5,//IMPORTANTE!!! SIRVE PARA DETERMINAR EL TAMAÑO DE LA PÁGINA, PODRÍAMOS HACER Q EL USUARIO SELECCIONA LA CANTIDAD DE ELEMENTOS Q QUIERE CARGAR

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

    if (
      document.getElementById("reservaPersonas").value === "" ||
      document.getElementById("reservaPersonas").value <= 0
    ) {
      alert("La cantidad de personas es requerida");
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
      personas: parseInt(document.getElementById("reservaPersonas").value),
    };

    return reservaService.save(newReserva).then((data) => {
      alert(data.message);
    });
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

    return reservaService.changeState(reserva).then((data) => {
      alert(data.message);
      // reservaController.list(reservaController.pagActual);
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

    return reservaService.changeState(reserva).then((data) => {
      alert(data.message);
      // reservaController.list(reservaController.pagActual);
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
      pageSize: reservaController.tamPag,
    };
    reservaService
      .listPage(data)
      .then((data) => {
        reservaController.reservas = data.result.data;
        reservaController.render(data.result.total);
      })
      .catch((error) => {
        console.error(
          "Error al cargar las reservas (controller del front)",
          error
        );
      });
  },

  filter: (page) => {
    if (
      document.getElementById("filtro-fecha-inicio").value !== "" &&
      document.getElementById("filtro-fecha-fin").value === ""
    ) {
      alert("La fecha de fin es requerida");
      return;
    }

    if (
      document.getElementById("filtro-fecha-inicio").value === "" &&
      document.getElementById("filtro-fecha-fin").value !== ""
    ) {
      alert("La fecha de inicio es requerida");
      return;
    }

    if (
      document.getElementById("filtro-fecha-inicio").value >
      document.getElementById("filtro-fecha-fin").value
    ) {
      alert("La fecha de inicio no puede ser mayor a la fecha de fin");
      return;
    }

    let data = {
      page: page,
      pageSize: reservaController.tamPag,
      fechaInicio: document.getElementById("filtro-fecha-inicio").value,
      fechaFin: document.getElementById("filtro-fecha-fin").value,
      estado: document.getElementById("filtro-estado").value,
    };

    reservaService
      .filter(data)
      .then((data) => {
        reservaController.reservas = data.result.data;
        reservaController.renderFilter(data.result.total);
      })
      .catch((error) => {
        console.error(
          "Error al cargar las reservas (controller del front)",
          error
        );
      });
  },

  render: (page) => {
    let reservasBody = document.getElementById("reservas-body");

    let paginas = Math.ceil(
      page / reservaController.tamPag
    );

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
                        <button type="button" class="btn-confirmar btn-actualizar btn-form" data-id="${reserva.id}"><i class="fa-solid fa-check"></i></button>
                        <button type="button" class="btn-cancelar btn-eliminar" data-id="${reserva.id}"><i class="fa-solid fa-x"></i></button>
                        <button type="button" class="btn-editar" data-id="${reserva.id}"><i class="fa-solid fa-pen-to-square"></i></button>
                    </td>
                </tr>
            `;
        contador++;
        reservasBody.insertAdjacentHTML("beforeend", fila);
      });

      document.querySelectorAll(".btn-confirmar").forEach((button) => {
        button.addEventListener("click", (event) => {
          reservaController.confirmar(event).then(() => {
            reservaController.list(reservaController.pagActual);
          });
        });
      });

      document.querySelectorAll(".btn-cancelar").forEach((button) => {
        button.addEventListener("click", (event) => {
          reservaController.cancelar(event).then(() => {
            reservaController.list(reservaController.pagActual);
          });
        });
      });
    }

    // Renderizar botones de paginación
    let pagination = document.getElementById("pagination");
    pagination.innerHTML = "";
    for (let i = 1; i <= paginas; i++) {
      let button = document.createElement("button");
      button.textContent = i;
      button.id = `${i}`; // Agregar id único para cada botón
      button.classList.add("pagination-button");

      button.addEventListener("click", () => {
        reservaController.list(i);
        reservaController.pagActual = i;
      });
      pagination.appendChild(button);
    }
  },

  renderFilter: (page) => {
    let reservasBody = document.getElementById("reservas-body");

    let paginas = Math.ceil(
      page / reservaController.tamPag
    );

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
          reservaController.confirmar(event).then(() => {
            reservaController.filter(reservaController.pagActual);
          });
        });
      });

      document.querySelectorAll(".btn-cancelar").forEach((button) => {
        button.addEventListener("click", (event) => {
          reservaController.cancelar(event).then(() => {
            reservaController.filter(reservaController.pagActual);
          });
        });
      });
    }

    // Renderizar botones de paginación
    let pagination = document.getElementById("pagination");
    pagination.innerHTML = "";
    for (let i = 1; i <= paginas; i++) {
      let button = document.createElement("button");
      button.textContent = i;
      button.id = `${i}`; // Agregar id único para cada botón
      button.classList.add("pagination-button");

      button.addEventListener("click", () => {
        reservaController.filter(i);
        reservaController.pagActual = i;
      });
      pagination.appendChild(button);
    }
  },

};

document.addEventListener("DOMContentLoaded", () => {
  const path = window.location.pathname;
  if (path === "/reservaPrivada/public/reserva") {
    
      reservaController.list(1);
  }

  let btnReservaAlta = document.getElementById("btn-reserva-alta");
  if (btnReservaAlta != null) {
    btnReservaAlta.onclick = () => {
      reservaController.save();
    };
  }

  let btnFiltrar = document.getElementById("btn-filtrar");
  if (btnFiltrar != null) {
    btnFiltrar.onclick = () => {
      reservaController.filter(1);
    };
  }

  let btnBorrarFiltrar = document.getElementById("btn-borrar-filtrar");
  if (btnBorrarFiltrar != null) {
    btnBorrarFiltrar.onclick = () => {
      reservaController.list(1);
    };
  }
});
