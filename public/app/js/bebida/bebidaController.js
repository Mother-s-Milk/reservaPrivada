let bebidaController = {
  //En el array "bebidas" se van a almacenar las bebidas cuando se haga la solicitud al back para desplegarlas
  bebidas: [],
  pagActual: 1,
  tamPag: 3,
  data: {
    id: 0,
    nombre: "",
    descripcion: "",
    categoriaId: 0,
    precioUnitario: 0,
    stock: 0,
    marca: "",
    proveedorId: 0,
  },
  save: () => {
    let bebidaForm = document.forms["bebida-form"];

    //Recupero los valores del formulario
    bebidaController.data.nombre = bebidaForm.bebidaNombre.value;
    bebidaController.data.descripcion = bebidaForm.bebidaDescripcion.value;
    bebidaController.data.categoriaId = parseInt(bebidaForm.bebidaCategoriaId.value);
    bebidaController.data.precioUnitario = parseFloat(bebidaForm.bebidaPrecioUnitario.value);
    bebidaController.data.stock = parseInt(bebidaForm.bebidaStock.value);
    bebidaController.data.marca = bebidaForm.bebidaMarca.value;
    bebidaController.data.proveedorId = parseInt(bebidaForm.bebidaProveedorId.value);

    //Validar datos
    const validacionErrores = bebidaController.validacion(bebidaController.data);

    if (Object.keys(validacionErrores).length > 0) {
      bebidaController.mostrarErrores(validacionErrores);

      return;
    }

    bebidaService
      .save(bebidaController.data)
      .then((response) => {
        alert("Bebida almacenada exitosamente");
        bebidaController.limpiarCamposErrores();
        bebidaController.resetForm();
      })
      .catch((error) => {
        alert("Error al almacenar bebida");
      });
  },
  //Función para validar datos
  validacion: (data) => {
    const errores = {};

    if (!data.nombre.trim()) {
      errores.nombre = "El nombre es obligatorio.";
    }

    if (isNaN(data.categoriaId) || data.categoriaId <= 0) {
      errores.categoriaId = "Debe seleccionar una categoria.";
    }

    if (isNaN(data.precioUnitario) || data.precioUnitario <= 0) {
      errores.precioUnitario = "El precio debe ser mayor que 0.";
    }

    if (isNaN(data.stock) || data.stock < 0) {
      errores.stock = "El stock no puede ser negativo ni estar vacío.";
    }

    if (!data.marca.trim()) {
      errores.marca = "La marca es obligatoria.";
    }

    if (isNaN(data.proveedorId) || data.proveedorId <= 0) {
      errores.proveedorId = "Debe seleccionar un proveedor.";
    }

    return errores;
  },
  //Mostrar errores en el formulario
  mostrarErrores: (errores) => {
    document.getElementById("error-nombre").textContent = errores.nombre || "";
    document.getElementById("error-categoriaId").textContent =
      errores.categoriaId || "";
    document.getElementById("error-precioUnitario").textContent =
      errores.precioUnitario || "";
    document.getElementById("error-stock").textContent = errores.stock || "";
    document.getElementById("error-marca").textContent = errores.marca || "";
    document.getElementById("error-proveedorId").textContent =
      errores.proveedorId || "";
  },
  //Limpiar mensajes de error
  limpiarCamposErrores: () => {
    const camposError = document.querySelectorAll(".error");
    camposError.forEach((campo) => {
      campo.textContent = "";
    });
  },
  resetForm: () => {
    document.forms["bebida-form"].reset();
  },
  update: (id) => {
    let bebidaForm = document.forms["bebida-form"];

    bebidaController.data.id = parseInt(id);
    bebidaController.data.nombre = bebidaForm.bebidaNombre.value;
    bebidaController.data.descripcion = bebidaForm.bebidaDescripcion.value;
    bebidaController.data.categoriaId = parseInt(
      bebidaForm.bebidaCategoriaId.value
    );
    bebidaController.data.precioUnitario = parseFloat(
      bebidaForm.bebidaPrecioUnitario.value
    );
    bebidaController.data.stock = parseInt(bebidaForm.bebidaStock.value);
    bebidaController.data.marca = bebidaForm.bebidaMarca.value;
    bebidaController.data.proveedorId = parseInt(
      bebidaForm.bebidaProveedorId.value
    );

    //Validar datos
    const validacionErrores = bebidaController.validacion(
      bebidaController.data
    );

    if (Object.keys(validacionErrores).length > 0) {
      bebidaController.mostrarErrores(validacionErrores);

      return;
    }

    bebidaService
      .update(bebidaController.data)
      .then((response) => {
        alert("Bebida actualizado exitosamente.");
        window.location.href = "bebida";
      })
      .catch((error) => {
        console.error("Error al actualizar el proveedor");
        alert("Ocurrió un error al actualizar el proveedor.");
      });
  },
  delete: (event) => {
    if (confirm(`¿Estás seguro de eliminar la bebida?`)) {
      return bebidaService
        .delete(parseInt(event.target.getAttribute("data-id")))
        .then((data) => {
          alert(data.message); //Mostrar mensaje del servidor
        })
        .catch((error) => {
          alert("Ocurrió un error al eliminar la bebida.");
        });
    }
  },
  //Función que obtiene las bebidas y las despliega en el DOM
  list: (page) => {
    let data = {
      page: page,
      pageSize: bebidaController.tamPag,
    };

    bebidaService
      .listPage(data)
      .then((data) => {
        bebidaController.bebidas = data.result.data;
        bebidaController.render(data.result.total);
      })
      .catch((error) => {
        console.error("Error al cargar los bebidas", error);
      });
  },
  //Función que recorre el array "bebidas" y las agrega al DOM
  render: (page) => {
    let bebidasBody = document.getElementById("bebidas-body");

    let paginas = Math.ceil(page / bebidaController.tamPag);

    if (bebidaController.bebidas.length === 0) {
      let nuevaFila = `
                <tr>
                    <td colspan="9">No hay bebidas registradas</td>
                </tr>
            `;
      bebidasBody.innerHTML = nuevaFila;
    } else {
      bebidasBody.innerHTML = "";
      let nuevaFila;
      let contador = 1;
      bebidaController.bebidas.forEach((bebida) => {
        nuevaFila = `
                    <tr>
                        <td>${contador}</td>
                        <td>${bebida.nombre}</td>
                        <td>${bebida.descripcion}</td>
                        <td>${bebida.categoriaId}</td>
                        <td>$${bebida.precioUnitario}</td>
                        <td>${bebida.stock}</td>
                        <td>${bebida.marca}</td>
                        <td>${bebida.proveedorId}</td>
                        <td>
                            <button type="button" class="btn-editar" data-id="${bebida.id}" onclick="window.location.href='bebida/editar/${bebida.id}'"><i class="fa-solid fa-pen-to-square"></i></button>
                            <button type="button" class="btn-eliminar" data-id="${bebida.id}"><i class="fa-solid fa-trash"></i></button>
                        </td>
                    </tr>
                `;
        contador++;
        bebidasBody.insertAdjacentHTML("beforeend", nuevaFila);
      });
      document.querySelectorAll(".btn-eliminar").forEach((button) => {
        button.addEventListener("click", (event) => {
          bebidaController.delete(event).then(() => {
            bebidaController.list(bebidaController.pagActual);
          });
        });
      });
    }
    let pagination = document.getElementById("pagination");
    pagination.innerHTML = "";
    for (let i = 1; i <= paginas; i++) {
      let button = document.createElement("button");
      button.textContent = i;
      button.id = `${i}`; // Agregar id único para cada botón
      button.classList.add("pagination-button");

      button.addEventListener("click", () => {
        bebidaController.list(i);
        bebidaController.pagActual = i;
      });
      pagination.appendChild(button);
    }
  },


  pdf: () => {
    // Obtener los datos de la tabla en el frontend
    let table = document.getElementById("bebidas-body");
    let rows = Array.from(table.rows);
    let bebidas = rows.map(row => {
        let cells = row.cells;
        return {
            id: cells[0].innerText,
            nombre: cells[1].innerText,
            descripcion: cells[2].innerText,
            categoria: cells[3].innerText,
            precio: cells[4].innerText,
            stock: cells[5].innerText,
            marca: cells[6].innerText,
            proveedor: cells[7].innerText
        };
    });

    bebidaService
        .pdf(bebidas) // Envía las categorías al servicio
        .then((response) => {
            window.open(response.url, "_blank"); // Abre el PDF en una nueva pestaña
        })
        .catch((error) => {
            console.error("Error al generar el PDF", error);
        });
}
,
excel: () => {
  // Obtener los datos de la tabla en el frontend
  let table = document.getElementById("bebidas-body");
  let rows = Array.from(table.rows);
  let bebidas = rows.map(row => {
      let cells = row.cells;
      return {
        id: cells[0].innerText,
        nombre: cells[1].innerText,
        descripcion: cells[2].innerText,
        categoria: cells[3].innerText,
        precio: cells[4].innerText,
        stock: cells[5].innerText,
        marca: cells[6].innerText,
        proveedor: cells[7].innerText
      };
  });

  bebidaService
      .excel(bebidas) // Envía las categorías al servicio
      .then((response) => {
          window.open(response.url, "_blank"); // Abre el PDF en una nueva pestaña
      })
      .catch((error) => {
          console.error("Error al generar el PDF", error);
      });
}



  ,



  filter: (page) => {

    let data = {
      page: page,
      pageSize: bebidaController.tamPag,
      proveedor: document.getElementById("bebidaProveedorId").value,
      categoria: document.getElementById("bebidaCategoriaId").value,
      stock: document.getElementById("bebidaStock").value,
      nombre: document.getElementById("bebidaNombre").value,
    };

    bebidaService
      .filter(data)
      .then((data) => {
        bebidaController.bebidas = data.result.data;
        bebidaController.renderFilter(data.result.total);
      })
      .catch((error) => {
        console.error(
          "Error al cargar las bebidas (controller del front)",
          error
        );
      });
  },

  renderFilter: (page) => {
    let bebidasBody = document.getElementById("bebidas-body");

    let paginas = Math.ceil(page / bebidaController.tamPag);

    if (bebidaController.bebidas.length === 0) {
      let nuevaFila = `
                <tr>
                    <td colspan="9">No hay bebidas registradas</td>
                </tr>
            `;
      bebidasBody.innerHTML = nuevaFila;
    } else {
      bebidasBody.innerHTML = "";
      let nuevaFila;
      let contador = 1;
      bebidaController.bebidas.forEach((bebida) => {
        nuevaFila = `
                    <tr>
                        <td>${contador}</td>
                        <td>${bebida.nombre}</td>
                        <td>${bebida.descripcion}</td>
                        <td>${bebida.categoriaId}</td>
                        <td>$${bebida.precioUnitario}</td>
                        <td>${bebida.stock}</td>
                        <td>${bebida.marca}</td>
                        <td>${bebida.proveedorId}</td>
                        <td>
                            <button type="button" class="btn-editar" data-id="${bebida.id}" onclick="window.location.href='bebida/editar/${bebida.id}'"><i class="fa-solid fa-pen-to-square"></i></button>
                            <button type="button" class="btn-eliminar" data-id="${bebida.id}"><i class="fa-solid fa-trash"></i></button>
                        </td>
                    </tr>
                `;
        contador++;
        bebidasBody.insertAdjacentHTML("beforeend", nuevaFila);
      });
      document.querySelectorAll(".btn-eliminar").forEach((button) => {
        button.addEventListener("click", (event) => {
          bebidaController.delete(event).then(() => {
            bebidaController.filter(bebidaController.pagActual);
          });
        });
      });
    }
    let pagination = document.getElementById("pagination");
    pagination.innerHTML = "";
    for (let i = 1; i <= paginas; i++) {
      let button = document.createElement("button");
      button.textContent = i;
      button.id = `${i}`; // Agregar id único para cada botón
      button.classList.add("pagination-button");

      button.addEventListener("click", () => {
        bebidaController.filter(i);
        bebidaController.pagActual = i;
      });
      pagination.appendChild(button);
    }
  },

};

document.addEventListener("DOMContentLoaded", () => {
  //Despliega la lista de bebidas solamente si se encuentra en el index relacionado a las mismas.
  const path = window.location.pathname;
  if (path === "/reservaPrivada/public/bebida") {
    bebidaController.list(1);
  }

  let btnBebidaAlta = document.getElementById("btn-bebida-alta");
  if (btnBebidaAlta != null) {
    btnBebidaAlta.onclick = () => {
      bebidaController.save();
    };
  }

  let btnBebidaFiltrar = document.getElementById("btn-filtrar");
  if (btnBebidaFiltrar != null) {
    btnBebidaFiltrar.onclick = () => {
      bebidaController.filter(1);
    };
  }

  let btnReset = document.getElementById("btn-borrar-filtrar");
  if (btnReset != null) {
    btnReset.onclick = () => {
      document.forms["filtros-form"].reset();
      bebidaController.list(1);
    };
  }

  let btnBebidaActualizar = document.getElementById("btn-bebida-actualizar");
  if (btnBebidaActualizar != null) {
    btnBebidaActualizar.onclick = () => {
      let id = document.getElementById("btn-bebida-actualizar").dataset.id;
      bebidaController.update(id);
    };
  }

  let btnPDF = document.getElementById("btn-pdf");

  if (btnPDF != null) {
    btnPDF.onclick = () => {
      bebidaController.pdf(); // Abre la URL del controlador en una nueva pestaña para descargar el PDF
    };
  }

  let btnExcel = document.getElementById("btn-excel");
  if(btnExcel != null) {
      btnExcel.onclick = () => {
          bebidaController.excel(); // Abre la URL del controlador en una nueva pestaña para descargar el PDF
      };
  }


});
