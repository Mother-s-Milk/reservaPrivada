let categoriaController = {
  categorias: [],
  data: {
    id: 0,
    nombre: "",
    descripcion: "",
  },

  pagActual: 1,
  tamPag: 3,

  save: () => {
    let categoriaForm = document.forms["categoria-form"];

    categoriaController.data.nombre = categoriaForm.categoriaNombre.value;
    categoriaController.data.descripcion =
      categoriaForm.categoriaDescripcion.value;

    //Validar datos
    const validacionErrores = categoriaController.validacion(
      categoriaController.data
    );

    if (Object.keys(validacionErrores).length > 0) {
      categoriaController.mostrarErrores(validacionErrores);

      return;
    }

    categoriaService.save(categoriaController.data);
  },
  //Función para validar datos
  validacion: (data) => {
    const errores = {};

    if (!data.nombre.trim()) {
      errores.nombre = "El nombre es obligatorio.";
    }

    return errores;
  },
  //Mostrar errores en el formulario
  mostrarErrores: (errores) => {
    document.getElementById("error-nombre").textContent = errores.nombre || "";
  },
  //Limpiar mensajes de error
  limpiarCamposErrores: () => {
    const camposError = document.querySelectorAll(".error");
    camposError.forEach((campo) => {
      campo.textContent = "";
    });
  },
  resetForm: () => {
    document.forms["categoria-form"].reset();
  },
  update: (id) => {
    let categoriaForm = document.forms["categoria-form"];

    categoriaController.data.id = parseInt(id);
    categoriaController.data.nombre = categoriaForm.categoriaNombre.value;
    categoriaController.data.descripcion =
      categoriaForm.categoriaDescripcion.value;

    //Validar datos
    const validacionErrores = categoriaController.validacion(
      categoriaController.data
    );

    if (Object.keys(validacionErrores).length > 0) {
      categoriaController.mostrarErrores(validacionErrores);

      return;
    }

    categoriaService
      .update(categoriaController.data)
      .then((response) => {
        alert("Categoria actualizada exitosamente.");
        window.location.href = "categoria";
      })
      .catch((error) => {
        console.error("Error al actualizar la categoria:", error);
        alert("Ocurrió un error al actualizar la categoria.");
      });
  },
  delete: (event) => {
    if (confirm(`¿Estás seguro de eliminar la categoria con ID`)) {
      return categoriaService
        .delete(parseInt(event.target.getAttribute("data-id")))
        .then((data) => {
          alert(data.message);
        })
        .catch((error) => {
          alert("Ocurrió un error al eliminar la categoria.");
        });
    }
  },
  list: (page) => {
    let data = {
      page: page,
      pageSize: categoriaController.tamPag,
    };

    categoriaService
      .listPage(data)
      .then((data) => {
        categoriaController.categorias = data.result.data;
        categoriaController.render(data.result.total);
      })
      .catch((error) => {
        console.error("Error al cargar los categorias", error);
      });
  },

  render: (page) => {
    let categoriasBody = document.getElementById("categorias-body");

    let paginas = Math.ceil(page / categoriaController.tamPag);

    if (categoriaController.categorias.length === 0) {
      let fila = `
                <tr>
                    <td colspan="4">
                        No hay categorias registradas
                    </td>
                </tr>
            `;

      categoriasBody.innerHTML = fila;
    } else {
      categoriasBody.innerHTML = "";
      let fila;
      let contador = 1;
      categoriaController.categorias.forEach((categoria) => {
        fila = `
                    <tr>
                        <td>${contador}</td>
                        <td>${categoria.nombre}</td>
                        <td>${categoria.descripcion}</td>
                        <td>
                            <button type="button" class="btn-editar" data-id="${categoria.id}" onclick="window.location.href='categoria/editar/${categoria.id}'"><i class="fa-solid fa-pen-to-square"></i></button>
                            <button type="button" class="btn-eliminar" data-id="${categoria.id}"><i class="fa-solid fa-trash"></i></button>
                        </td>
                    </tr>
                `;
        contador++;
        categoriasBody.insertAdjacentHTML("beforeend", fila);
      });

      document.querySelectorAll(".btn-eliminar").forEach((button) => {
        button.addEventListener("click", (event) => {
          categoriaController.delete(event).then(() => {
            categoriaController.list(categoriaController.pagActual);
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
        categoriaController.list(i);
        categoriaController.pagActual = i;
      });
      pagination.appendChild(button);
    }
  },

  pdf: () => {
    // Obtener los datos de la tabla en el frontend
    let table = document.getElementById("categorias-body");
    let rows = Array.from(table.rows);
    let categorias = rows.map(row => {
        let cells = row.cells;
        return {
            id: cells[0].innerText,
            nombre: cells[1].innerText,
            descripcion: cells[2].innerText
        };
    });

    categoriaService
        .pdf(categorias) // Envía las categorías al servicio
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
  let table = document.getElementById("categorias-body");
  let rows = Array.from(table.rows);
  let categorias = rows.map(row => {
      let cells = row.cells;
      return {
          id: cells[0].innerText,
          nombre: cells[1].innerText,
          descripcion: cells[2].innerText
      };
  });

  categoriaService
      .excel(categorias) // Envía las categorías al servicio
      .then((response) => {
          window.open(response.url, "_blank"); // Abre el PDF en una nueva pestaña
      })
      .catch((error) => {
          console.error("Error al generar el PDF", error);
      });
}

};

document.addEventListener("DOMContentLoaded", () => {
  const path = window.location.pathname;
  if (path === "/reservaPrivada/public/categoria") {
    categoriaController.list(1);
  }

  let btnCategoriaAlta = document.getElementById("btn-categoria-alta");
  if (btnCategoriaAlta != null) {
    btnCategoriaAlta.onclick = () => {
      categoriaController.save();
    };
  }

  let btnCategoriaActualizar = document.getElementById(
    "btn-categoria-actualizar"
  );

  if (btnCategoriaActualizar != null) {
    btnCategoriaActualizar.onclick = () => {
      let id = document.getElementById("btn-categoria-actualizar").dataset.id;
      categoriaController.update(id);
    };
  }

  let btnPDF = document.getElementById("btn-pdf");

  if (btnPDF != null) {
    btnPDF.onclick = () => {
      categoriaController.pdf(); // Abre la URL del controlador en una nueva pestaña para descargar el PDF
    };
  }

  let btnExcel = document.getElementById("btn-excel");
  if(btnExcel != null) {
      btnExcel.onclick = () => {
          categoriaController.excel(); // Abre la URL del controlador en una nueva pestaña para descargar el PDF
      };
  }

});
