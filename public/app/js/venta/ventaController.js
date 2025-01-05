//Agregar un modal de confirmacion si el usuario presiona el boton de resertar formulario
//Si al agregar un detalle de venta, el data-stock es menor a la cantidad solicitada, avisar.
//Agregar el atributo "tipo de venta" para identificar si fue una venta al paso o de una mesa
const ventaController = {
  pagActual: 1,
  tamPag: 3,
  ventas: [], //Para guardar las ventas enviadas desde el back en las solicitudes
  venta: {
    id: 0,
    fecha: "",
    hora: "",
    formaPago: "",
    detalles: [],
    total: 0,
  },
  agregarProducto: () => {
    const bebida = document.getElementById("bebidaNombre");
    const cantidad = document.getElementById("bebidaCantidad");

    if (!bebida.value || cantidad.value <= 0) {
      alert("Debe seleccionar una bebida y una cantidad mayor a 0.");
      return;
    }

    const formulario = document.forms["venta-form"];
    const nuevoDetalle = {
      bebidaId: parseInt(formulario["bebidaNombre"].value),
      nombre:
        formulario["bebidaNombre"].options[
          formulario["bebidaNombre"].selectedIndex
        ].getAttribute("data-nombre"),
      precio: parseFloat(
        formulario["bebidaNombre"].options[
          formulario["bebidaNombre"].selectedIndex
        ].getAttribute("data-precio")
      ),
      cantidad: parseInt(formulario["bebidaCantidad"].value),
    };

    if (ventaController.estaEnLista(nuevoDetalle.bebidaId)) {
      ventaController.actualizarCantidad(
        nuevoDetalle.bebidaId,
        nuevoDetalle.cantidad
      );
      ventaController.mostrarDetallesVenta();
    } else {
      ventaService
        .consultarStock(bebida.value)
        .then((response) => {
          const stockActual = response.result;

          if (stockActual < nuevoDetalle.cantidad) {
            alert("No hay suficiente stock de la bebida seleccionada.");
            return;
          }

          // Agregar el producto a los detalles si hay suficiente stock
          ventaController.venta.detalles.push(nuevoDetalle);
          ventaController.resetearCamposBebida();
          ventaController.mostrarDetallesVenta();
        })
        .catch((error) => {
          console.error("Error al consultar el stock:", error);
          alert("Hubo un error al consultar el stock. Intente nuevamente.");
        });
    }
  },
  resetearCamposBebida: () => {
    let controls = document.querySelectorAll(
      "#form-bebida input[type=text], #form-bebida input[type=number], #form-bebida select"
    );
    controls.forEach((control) => {
      control.value = "";
    });
  },

  mostrarDetallesVenta: () => {
    let bodyBebidas = document.getElementById("bebidas-venta-body");

    if (ventaController.venta.detalles.length === 0) {
      bodyBebidas.innerHTML =
        '<tr><td class="text-center text-muted" colspan="5">No hay detalles cargados</td></tr>';
      bodyBebidas.nextElementSibling.hidden = true;
    } else {
      bodyBebidas.innerHTML = "";
      let total = 0;

      ventaController.venta.detalles.forEach((bebida, index) => {
        let fila = `
          <tr>
            <td>${bebida.nombre}</td>
            <td>$${bebida.precio}</td>
            <td>${bebida.cantidad}</td>
            <td>$${(bebida.precio * bebida.cantidad).toFixed(2)}</td>
            <td>
              <button type="button" class="btn-editar" data-index="${index}" data-value="${
          bebida.bebidaId
        }">
                <i class="fa-solid fa-pen-to-square"></i>
              </button>
              <button type="button" class="btn-eliminar" data-index="${index}">
                <i class="fa-solid fa-trash"></i>
              </button>
            </td>
          </tr>
        `;
        total += bebida.precio * bebida.cantidad;
        ventaController.venta.total = total;
        bodyBebidas.insertAdjacentHTML("beforeend", fila);
      });

      document.getElementById("total-venta").textContent = `$${total.toFixed(
        2
      )}`;
      bodyBebidas.nextElementSibling.hidden = false;

      // Añadir evento a los botones de eliminar
      bodyBebidas.querySelectorAll(".btn-eliminar").forEach((button) => {
        button.addEventListener("click", (event) => {
          const index = event.currentTarget.dataset.index; // Obtener índice
          ventaController.venta.detalles.splice(index, 1); // Eliminar del array
          ventaController.mostrarDetallesVenta(); // Actualizar la tabla
        });
      });

      // Añadir evento a los botones de modificar
      bodyBebidas.querySelectorAll(".btn-modificar").forEach((button) => {
        button.addEventListener("click", (event) => {
          const index = event.currentTarget.dataset.index; // Obtener índice
          const value = event.currentTarget.dataset.value; // Obtener value único
          const bebida = ventaController.venta.detalles[index]; // Obtener el detalle

          // Actualizar el select con el value correspondiente
          const selectBebida = document.getElementById("bebidaNombre");
          selectBebida.value = value; // Seleccionar el value correspondiente en el select

          // Actualizar otros campos
          document.getElementById("bebidaCantidad").value = bebida.cantidad;
          // Eliminar el detalle del array
          ventaController.venta.detalles.splice(index, 1);

          // Actualizar la tabla
          ventaController.mostrarDetallesVenta();
        });
      });
    }
  },

  save: () => {
    const formaPagoInput = document.getElementById("formaPago").value;
    ventaController.venta.formaPago = formaPagoInput;

    if (
      !ventaController.venta.formaPago ||
      ventaController.venta.detalles.length === 0
    ) {
      alert(
        "Debe especificar un medio de pago y al menos un producto a la venta."
      );
      return;
    }

    ventaService
      .save(ventaController.venta)
      .then((response) => {
        if (response.message === "La venta fue registrada correctamente.") {
          alert(response.message);
          ventaController.venta.detalles = [];
          ventaController.venta.total = 0;
          ventaController.resetearFormulario();
          ventaController.mostrarDetallesVenta();
        } else {
          alert(response.message);
        }
      })
      .catch((error) => {
        console.error("Error al guardar la venta:", error);
      });
  },

  estaEnLista: (idBebida) => {
    let estaEnLista = false;

    for (let i = 0; i < ventaController.venta.detalles.length; i++) {
      if (ventaController.venta.detalles[i].bebidaId == idBebida) {
        estaEnLista = true;
        return estaEnLista;
      }
    }

    return estaEnLista;
  },
  actualizarCantidad: (idBebida, cantidad) => {
    let bebida = document.getElementById("bebidaNombre");
    let cantidadNueva = parseInt(cantidad);
    let cantidadActual = 0;

    for (let i = 0; i < ventaController.venta.detalles.length; i++) {
      if (ventaController.venta.detalles[i].bebidaId == idBebida) {
        cantidadActual = ventaController.venta.detalles[i].cantidad;
        break;
      }
    }
    ventaService.consultarStock(idBebida).then((response) => {
      let stockActual = response.result;
      if (stockActual >= cantidadActual + cantidadNueva) {
        for (let i = 0; i < ventaController.venta.detalles.length; i++) {
          if (ventaController.venta.detalles[i].bebidaId == idBebida) {
            ventaController.venta.detalles[i].cantidad += cantidadNueva;
            break;
          }
        }
        ventaController.mostrarDetallesVenta();
      } else {
        alert("No hay suficiente stock de la bebida seleccionada.");
      }
    });
  },
  list: (page) => {
    let data = {
      page: page,
      pageSize: ventaController.tamPag,
    };

    ventaService
      .listPage(data)
      .then((data) => {
        ventaController.ventas = data.result.data;
        ventaController.render(data.result.total);
      })
      .catch((error) => {
        console.error("Error al cargar las ventas (controller)", error);
      });
  },
  render: (page) => {
    let ventasBody = document.getElementById("ventas-body");

    let paginas = Math.ceil(page / ventaController.tamPag);

    if (ventaController.ventas.length === 0) {
      let nuevaFila = `
                <tr>
                    <td colspan="7">No hay ventas registradas</td>
                </tr>
            `;
      ventasBody.innerHTML = nuevaFila;
    } else {
      ventasBody.innerHTML = "";
      let nuevaFila;
      let contador = 1;
      ventaController.ventas.forEach((venta) => {
        nuevaFila = `
                    <tr>
                        <td>${contador}</td>
                        <td>${venta.fecha}</td>
                        <td>${venta.hora}</td>
                        <td>${venta.formaPago}</td>
                        <td>$${venta.total}</td>
                        <td>
                            <button type="button" class="btn-check" data-id="${venta.id}" onclick="window.location.href='venta/consultar/${venta.id}'" style="width: auto">Ver detalles</button>
                        </td>
                    </tr>
                `;
        contador++;
        ventasBody.insertAdjacentHTML("beforeend", nuevaFila);
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
        ventaController.list(i);
        ventaController.pagActual = i;
      });
      pagination.appendChild(button);
    }
  },

  Filter: (page) => {
    let data = {
      page: page,
      pageSize: ventaController.tamPag,
      pMin: document.getElementById("filtro-precio-minimo").value,
      pMax: document.getElementById("filtro-precio-maximo").value,
      fMin: document.getElementById("filtro-fecha-inicio").value,
      fMax: document.getElementById("filtro-fecha-fin").value,
      medioPago: document.getElementById("filtro-medio-pago").value,
    };
  
    // Validar rangos de precios
    if ((data.pMin && !data.pMax) || (!data.pMin && data.pMax)) {
      alert("Debe ingresar ambos valores para el filtro de precios o dejar ambos campos vacíos");
      return;
    }
  
    if (data.pMin && data.pMax && parseFloat(data.pMin) > parseFloat(data.pMax)) {
      alert("El precio mínimo no puede ser mayor al máximo");
      return;
    }
  
    // Validar rangos de fechas
    if ((data.fMin && !data.fMax) || (!data.fMin && data.fMax)) {
      alert("Debe ingresar ambas fechas para el filtro de fechas o dejar ambos campos vacíos");
      return;
    }
  
    if (data.fMin && data.fMax && data.fMin > data.fMax) {
      alert("La fecha de inicio no puede ser mayor a la fecha de fin");
      return;
    }
  
    // Enviar datos al servicio
    ventaService
      .filter(data)
      .then((data) => {
        ventaController.ventas = data.result.data;
        ventaController.renderFilter(data.result.total);
      })
      .catch((error) => {
        console.error("Error al cargar las ventas (controller)", error);
      });
  },
  


  renderFilter: (page) => {
    let ventasBody = document.getElementById("ventas-body");

    let paginas = Math.ceil(page / ventaController.tamPag);

    if (ventaController.ventas.length === 0) {
      let nuevaFila = `
                <tr>
                    <td colspan="7">No hay ventas registradas</td>
                </tr>
            `;
      ventasBody.innerHTML = nuevaFila;
    } else {
      ventasBody.innerHTML = "";
      let nuevaFila;
      let contador = 1;
      ventaController.ventas.forEach((venta) => {
        nuevaFila = `
                    <tr>
                        <td>${contador}</td>
                        <td>${venta.fecha}</td>
                        <td>${venta.hora}</td>
                        <td>${venta.formaPago}</td>
                        <td>$${venta.total}</td>
                        <td>
                            <button type="button" class="btn-check" data-id="${venta.id}" onclick="window.location.href='venta/consultar/${venta.id}'" style="width: auto">Ver detalles</button>
                        </td>
                    </tr>
                `;
        contador++;
        ventasBody.insertAdjacentHTML("beforeend", nuevaFila);
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
        ventaController.Filter(i);
        ventaController.pagActual = i;
      });
      pagination.appendChild(button);
    }
  },

  resetearFormulario: () => {
    document.getElementById("venta-form").reset();
  },
  resetearVenta: () => {
    if (confirm(`¿Estás seguro de resetear el formulario?`)) {
      ventaController.venta.detalles = [];
      ventaController.venta.total = 0;
      ventaController.resetearFormulario();
      ventaController.mostrarDetallesVenta();
    }
  },
};

document.addEventListener("DOMContentLoaded", () => {
  const path = window.location.pathname;
  if (path === "/reservaPrivada/public/venta") {
    ventaController.list(1); //Se listan las ventas solamente si la ruta es igual al index de ventas

    let btnResetearFiltros = document.getElementById("btn-borrar-filtrar");
    btnResetearFiltros.onclick = () => {
      ventaController.list(1);
    };
  
    let btnFiltros = document.getElementById("btn-filtrar");
    btnFiltros.onclick = () => {
      ventaController.Filter(1);
    };

  }

  let btnAgregarBebida = document.getElementById("btn-agregar-bebida-venta");
  btnAgregarBebida.onclick = () => {
    ventaController.agregarProducto();
  };

  let btnResetearVenta = document.getElementById("btn-venta-resetear");
  btnResetearVenta.onclick = () => {
    ventaController.resetearVenta();
  };

  let btnAltaVenta = document.getElementById("btn-venta-alta");
  btnAltaVenta.onclick = () => {
    ventaController.save();
  };

});