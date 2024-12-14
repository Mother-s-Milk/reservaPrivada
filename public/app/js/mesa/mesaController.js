let mesaController = {
  mesas: [],  
  data: {
    id: 0,
    disponibilidad: 0,
    descripcion: "",
  },
  save: () => {
    let mesaForm = document.forms["mesa-form"];

    mesaController.data.disponibilidad = parseInt(
      mesaForm.mesaDisponible.value
    );
    mesaController.data.descripcion = mesaForm.mesaDescripcion.value;

    mesaService.save(mesaController.data);
  },
  update: (id) => {
    let mesaForm = document.forms["mesa-form"];

    mesaController.data.id = parseInt(id);
    mesaController.data.disponibilidad = parseInt(
      mesaForm.mesaDisponible.value
    );
    mesaController.data.descripcion = mesaForm.mesaDescripcion.value;
    mesaService
      .update(mesaController.data)
      .then((response) => {
        alert("Mesa actualizada exitosamente.");
        window.location.href = "mesa";
      })
      .catch((error) => {
        console.error("Error al actualizar la mesa:", error);
        alert("Ocurrió un error al actualizar la mesa.");
      });
  },
  delete: (id) => {
    if (confirm(`¿Estás seguro de eliminar la mesa con ID`, id)) {
      mesaService
        .delete(id)
        .then((data) => {
          alert(data.message);
          mesaController.list();
        })
        .catch((error) => {
          alert("Ocurrió un error al eliminar la mesa.");
        });
    }
  },
  list: () => {
    mesaService
      .list()
      .then((data) => {
        mesaController.mesas = data.result;
        mesaController.render();
      })
      .catch((error) => {
        console.error("Error al cargar las mesas", error);
      });
  },
  render: () => {
    let mesasBody = document.getElementById("mesas-body");

    if (mesaController.mesas.length === 0) {
      let fila = `
                <tr>
                    <td colspan="4">
                        No hay mesas registradas
                    </td>
                </tr>
            `;

      mesasBody.innerHTML = fila;
    } else {
      mesasBody.innerHTML = "";
      let fila;
      let contador = 1;
      mesaController.mesas.forEach((categoria) => {
        fila = `
                    <tr>
                        <td>${contador}</td>
                        <td>${categoria.descripcion}</td>
                        <td>${categoria.disponibilidad}</td>
                        <td>
                            <button type="button" class="btn-editar" data-id="${categoria.id}" onclick="window.location.href='mesa/editar/${categoria.id}'"><i class="fa-solid fa-pen-to-square"></i></button>
                            <button type="button" class="btn-eliminar" data-id="${categoria.id}" onclick=mesaController.delete(${categoria.id})><i class="fa-solid fa-trash"></i></button>
                        </td>
                    </tr>
                `;
        contador++;
        mesasBody.insertAdjacentHTML("beforeend", fila);
      });
    }
  },
};

document.addEventListener("DOMContentLoaded", () => {
  const path = window.location.pathname;
  if (path === "/reservaPrivada/public/mesa") {
    mesaController.list();
  }

  let btnMesaAlta = document.getElementById("btn-mesa-alta");
  if (btnMesaAlta != null) {
    btnMesaAlta.onclick = () => {
      mesaController.save();
    };
  }

  let btnMesaActualizar = document.getElementById("btn-mesa-actualizar");
  if (btnMesaActualizar != null) {
    btnMesaActualizar.onclick = () => {
      let id = document.getElementById("btn-mesa-actualizar").dataset.id;
      mesaController.update(id);
    };
  }
});
