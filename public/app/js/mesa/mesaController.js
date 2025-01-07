/*let mesaController = {
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
});*/

/*let mesaController = {
  mesas: [],
  mostrarOpciones: (id) => {
    let mesaInfo = document.getElementById("mesa-info");
    let ocupar = document.createElement("button");
    ocupar.innerHTML = "Ocupar";
    let reservar = document.createElement("button");
    reservar.innerHTML = "Reservar";

    mesaInfo.innerHTML = "";
    mesaInfo.appendChild(ocupar);
    ocupar.onclick = () => {
      mesaController.abrirMesa(id);
    };
    mesaInfo.appendChild(reservar);
    reservar.onclick = () => {
      mesaController.reservarMesa(id);
    }
  },
  mostrarDetalles: (id) => {
    alert("Detalles de mesa");
  },
  abrirMesa: (id) => {
    alert("Mesa abierta");
  },
  reservarMesa: (id) => {
    alert("Mesa reservada");
  }
}

document.addEventListener("DOMContentLoaded", () => {
  let mesas = document.querySelectorAll(".mesa");
  mesas.forEach((mesa) => {
    mesa.addEventListener("click", () => {
      const id = mesa.dataset.id;
      const estado = mesa.dataset.estado;

      if (estado === "ocupada") {
        mesaController.mostrarDetalles(id);
      } else if (estado === "libre") {
        mesaController.mostrarOpciones(id);
      }
    });
  });
});*/

document.addEventListener("DOMContentLoaded", () => {
  const productos = [
    { id: 1, nombre: "Vino Tinto", precio: 6500, imagen: "https://i.pinimg.com/736x/c1/a6/3d/c1a63d9754cbdc5491735a5e983eb01a.jpg" },
    { id: 2, nombre: "Cerveza Artesanal", precio: 5000, imagen: "https://i.pinimg.com/736x/7b/fc/24/7bfc24665536027ac1c4a9369c224ed6.jpg" },
    { id: 3, nombre: "Fernet", precio: 5500, imagen: "https://http2.mlstatic.com/D_NQ_NP_954923-MLA45507877357_042021-O.webp" },
    { id: 4, nombre: "Coca-Cola", precio: 3500, imagen: "https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQyRb4e9Z4iJCHt-OFlg1PJe6tcoyJuwRDxPg&s" },
    { id: 5, nombre: "Whisky", precio: 9000, imagen: "https://www.clarin.com/2023/06/05/X6CQO6yfb_2000x1500__1.jpg" },
    { id: 6, nombre: "Agua", precio: 2000, imagen: "https://statics.dinoonline.com.ar/imagenes/full_600x600_ma/3040004_f.jpg" },
    { id: 7, nombre: "Vino Malbec", precio: 25000, imagen: "https://www.bodegasbianchi.com.ar/cdn/shop/files/Bianchi_Varietales_-_Malbec_2048x2048.jpg?v=1721243965" },
    { id: 8, nombre: "Fanta", precio: 3500, imagen: "https://static.wixstatic.com/media/d2b1c5_02c49ec28b1b4d80ac492fff04b4a137~mv2.jpg/v1/fill/w_480,h_480,al_c,q_80,usm_0.66_1.00_0.01,enc_auto/d2b1c5_02c49ec28b1b4d80ac492fff04b4a137~mv2.jpg" },
    { id: 9, nombre: "Daiquiri", precio: 9000, imagen: "https://www.clarin.com/2021/12/27/P8Im6T26k_2000x1500__1.jpg" },
  ];

  const pedido = [];
  const pedidoDetalles = document.getElementById("pedido-detalles");
  const totalPedido = document.getElementById("total-pedido");
  const productosGrid = document.querySelector(".productos-grid");
  const busquedaInput = document.getElementById("busqueda-productos");

  // Función para cargar los productos dinámicamente
  const cargarProductos = (productosFiltrados) => {
    productosGrid.innerHTML = "";
    productosFiltrados.forEach((producto) => {
      const productoCard = document.createElement("div");
      productoCard.classList.add("producto");

      productoCard.innerHTML = `
        <img src="${producto.imagen}" alt="${producto.nombre}" style="max-height: 120px">
        <h3>${producto.nombre}</h3>
        <p>$${producto.precio}</p>
        <button data-id="${producto.id}">Agregar</button>
      `;

      productosGrid.appendChild(productoCard);
    });
  };

  // Función para actualizar el detalle del pedido
  const actualizarPedido = () => {
    pedidoDetalles.innerHTML = "";
    if (pedido.length === 0) {
      pedidoDetalles.innerHTML = "<p>El pedido está vacío.</p>";
      totalPedido.textContent = "0.00";
      return;
    }

    let total = 0;
    pedido.forEach((item) => {
      const detalleItem = document.createElement("div");
      detalleItem.classList.add("detalle-item");

      detalleItem.innerHTML = `
        <span>${item.nombre} (x${item.cantidad})</span>
        <span>$${item.precio * item.cantidad}</span>
        <button class="eliminar" data-id="${item.id}">Eliminar</button>
      `;

      pedidoDetalles.appendChild(detalleItem);
      total += item.precio * item.cantidad;
    });

    totalPedido.textContent = total.toFixed(2);
  };

  // Función para manejar el evento de agregar producto
  const agregarProducto = (idProducto) => {
    const productoSeleccionado = productos.find((prod) => prod.id === idProducto);

    const productoEnPedido = pedido.find((item) => item.id === idProducto);
    if (productoEnPedido) {
      productoEnPedido.cantidad += 1;
    } else {
      pedido.push({ ...productoSeleccionado, cantidad: 1 });
    }

    actualizarPedido();
  };

  // Función para manejar el evento de eliminar producto
  const eliminarProducto = (idProducto) => {
    const index = pedido.findIndex((item) => item.id === idProducto);
    if (index !== -1) {
      pedido.splice(index, 1);
      actualizarPedido();
    }
  };

  // Evento de búsqueda de productos
  busquedaInput.addEventListener("input", (e) => {
    const texto = e.target.value.toLowerCase();
    const productosFiltrados = productos.filter((producto) =>
      producto.nombre.toLowerCase().includes(texto)
    );
    cargarProductos(productosFiltrados);
  });

  // Evento de clic en el grid de productos
  productosGrid.addEventListener("click", (e) => {
    if (e.target.tagName === "BUTTON") {
      const idProducto = parseInt(e.target.dataset.id, 10);
      agregarProducto(idProducto);
    }
  });

  // Evento de clic para eliminar productos del pedido
  pedidoDetalles.addEventListener("click", (e) => {
    if (e.target.classList.contains("eliminar")) {
      const idProducto = parseInt(e.target.dataset.id, 10);
      eliminarProducto(idProducto);
    }
  });

  // Cargar los productos inicialmente
  cargarProductos(productos);
});