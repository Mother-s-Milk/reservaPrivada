let proveedorController = {
  proveedores: [],
  data: {
    id: 0,
    nombre: "",
    telefono: "",
    email: "",
    localidad: "",
    direccion: "",
  },

  pagActual: 1,
  tamPag: 5,

  save: () => {
    let proveedorForm = document.forms["proveedor-form"];

    proveedorController.data.nombre = proveedorForm.proveedorNombre.value;
    proveedorController.data.telefono = proveedorForm.proveedorTelefono.value;
    proveedorController.data.email = proveedorForm.proveedorEmail.value;
    proveedorController.data.localidad = proveedorForm.proveedorLocalidad.value;
    proveedorController.data.direccion = proveedorForm.proveedorDireccion.value;

    if (proveedorController.data.nombre == "") {
      alert("El campo nombre es obligatorio");
      return;
    }

    if (proveedorController.data.telefono == "") {
      alert("El campo telefono es obligatorio");
      return;
    }

    if (proveedorController.data.email == "") {
      alert("El campo email es obligatorio");
      return;
    }

    if (proveedorController.data.localidad == "") {
      alert("El campo localidad es obligatorio");
      return;
    }

    if (proveedorController.data.direccion == "") {
      alert("El campo direccion es obligatorio");
      return;
    }

    proveedorService.save(proveedorController.data);
  },
  /*edit: (id) => {
        proveedorService.edit();
    },*/
  delete: (event) => {
    if (!confirm(`¿Estás seguro de eliminar al proveedor?`)) {
      return;
    }

    return proveedorService
      .delete(parseInt(event.target.getAttribute("data-id"))) // Llamar al método delete del servicio
      .then((data) => {
        alert(data.message); // Mostrar mensaje del servidor
      })
      .catch((error) => {
        alert("Ocurrió un error al eliminar el proveedor.");
      });
  },
  update: (id) => {
    let proveedorForm = document.forms["proveedor-form"];

    proveedorController.data.id = parseInt(id);
    proveedorController.data.nombre = proveedorForm.proveedorNombre.value;
    proveedorController.data.telefono = proveedorForm.proveedorTelefono.value;
    proveedorController.data.email = proveedorForm.proveedorEmail.value;
    proveedorController.data.localidad = proveedorForm.proveedorLocalidad.value;
    proveedorController.data.direccion = proveedorForm.proveedorDireccion.value;

    if (proveedorController.data.nombre == "") {
      alert("El campo nombre es obligatorio");
      return;
    }

    if (proveedorController.data.telefono == "") {
      alert("El campo telefono es obligatorio");
      return;
    }

    if (proveedorController.data.email == "") {
      alert("El campo email es obligatorio");
      return;
    }

    if (proveedorController.data.localidad == "") {
      alert("El campo localidad es obligatorio");
      return;
    }

    if (proveedorController.data.direccion == "") {
      alert("El campo direccion es obligatorio");
      return;
    }

    proveedorService
      .update(proveedorController.data)
      .then((response) => {
        alert("Proveedor actualizado exitosamente.");
        window.location.href = "proveedor";
      })
      .catch((error) => {
        console.error("Error al actualizar el proveedor:", error);
        alert("Ocurrió un error al actualizar el proveedor.");
      });
  },
  list: (page) => {
    let data = {
      page: page,
      pageSize: proveedorController.tamPag,
    };

    proveedorService
      .listPage(data)
      .then((data) => {
        proveedorController.proveedores = data.result.data;
        proveedorController.render(data.result.total);
      })
      .catch((error) => {
        console.error("Error al cargar los proveedores", error);
      });
  },
  render: (page) => {
    let proveedoresBody = document.getElementById("proveedores-body");

    let paginas = Math.ceil(page / proveedorController.tamPag);

    if (proveedorController.proveedores.length === 0) {
      let fila = `
                <tr>
                    <td colspan="7">
                        No hay proveedores registrados
                    </td>
                </tr>
            `;

      proveedoresBody.innerHTML = fila;
    } else {
      proveedoresBody.innerHTML = "";
      let fila;
      let contador = 1;
      proveedorController.proveedores.forEach((proveedor) => {
        fila = `
                    <tr>
                        <td>${contador}</td>
                        <td>${proveedor.nombre}</td>
                        <td>${proveedor.telefono}</td>
                        <td>${proveedor.email}</td>
                        <td>${proveedor.localidad}</td>
                        <td>${proveedor.direccion}</td>
                        <td>
                            <button type="button" class="btn-editar" data-id="${proveedor.id}" onclick="window.location.href='proveedor/editar/${proveedor.id}'"><i class="fa-solid fa-pen-to-square"></i></button>
                            <button type="button" class="btn-eliminar" data-id="${proveedor.id}" ><i class="fa-solid fa-trash"></i></button>
                        </td>
                    </tr>
                `;
        contador++;
        proveedoresBody.insertAdjacentHTML("beforeend", fila);
      });

      document.querySelectorAll(".btn-eliminar").forEach((button) => {
        button.addEventListener("click", (event) => {
          proveedorController.delete(event).then(() => {
            proveedorController.list(proveedorController.pagActual);
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
        proveedorController.list(i);
        proveedorController.pagActual = i;
      });
      pagination.appendChild(button);
    }
  },

  filter: (page) => {
    let data = {
      page: page,
      pageSize: proveedorController.tamPag,
      localidad: document.getElementById("filtro-localidad").value,
      nombre: document.getElementById("filtro-nombre").value,
    };

    proveedorService
      .filter(data)
      .then((data) => {
        proveedorController.proveedores = data.result.data;
        proveedorController.renderFilter(data.result.total);
      })
      .catch((error) => {
        console.error(
          "Error al cargar las reservas (controller del front)",
          error
        );
      });
  },

  renderFilter: (page) => {
    let proveedoresBody = document.getElementById("proveedores-body");

    let paginas = Math.ceil(page / proveedorController.tamPag);

    if (proveedorController.proveedores.length === 0) {
      let fila = `
                <tr>
                    <td colspan="7">
                        No hay proveedores registrados
                    </td>
                </tr>
            `;

      proveedoresBody.innerHTML = fila;
    } else {
      proveedoresBody.innerHTML = "";
      let fila;
      let contador = 1;
      proveedorController.proveedores.forEach((proveedor) => {
        fila = `
                    <tr>
                        <td>${contador}</td>
                        <td>${proveedor.nombre}</td>
                        <td>${proveedor.telefono}</td>
                        <td>${proveedor.email}</td>
                        <td>${proveedor.localidad}</td>
                        <td>${proveedor.direccion}</td>
                        <td>
                            <button type="button" class="btn-editar" data-id="${proveedor.id}" onclick="window.location.href='proveedor/editar/${proveedor.id}'"><i class="fa-solid fa-pen-to-square"></i></button>
                            <button type="button" class="btn-eliminar" data-id="${proveedor.id}"><i class="fa-solid fa-trash"></i></button>
                        </td>
                    </tr>
                `;
        contador++;
        proveedoresBody.insertAdjacentHTML("beforeend", fila);
      });
      document.querySelectorAll(".btn-eliminar").forEach((button) => {
        button.addEventListener("click", (event) => {
          proveedorController.delete(event).then(() => {
            proveedorController.filter(proveedorController.pagActual);
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
        proveedorController.filter(i);
        proveedorController.pagActual = i;
      });
      pagination.appendChild(button);
    }
  },
};

document.addEventListener("DOMContentLoaded", () => {
  const path = window.location.pathname;
  if (path === "/reservaPrivada/public/proveedor") {
    proveedorController.list(1);
  }

  let btnProveedorAlta = document.getElementById("btn-proveedor-alta");
  if (btnProveedorAlta != null) {
    btnProveedorAlta.onclick = () => {
      proveedorController.save();
    };
  }

  let btnBotonActualizar = document.getElementById("btn-proveedor-actualizar");
  if (btnBotonActualizar != null) {
    btnBotonActualizar.onclick = () => {
      let id = document.getElementById("btn-proveedor-actualizar").dataset.id;
      proveedorController.update(id);
    };
  }

  let btnBorrarFiltrar = document.getElementById("btn-borrar-filtrar");
  if (btnBorrarFiltrar != null) {
    btnBorrarFiltrar.onclick = () => {
      proveedorController.list(1);
    };
  }

  let btnFiltrar = document.getElementById("btn-filtrar");
  if (btnFiltrar != null) {
    btnFiltrar.onclick = () => {
      proveedorController.filter(1);
    };
  }
});
