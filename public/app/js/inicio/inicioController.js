const inicioController = {
  ventas: [],
  reservas: [],
  bajoStock: [],
  ventasSemanales: [],
  consultarVentas: () => {
    inicioService.consultarVentas()
    .then((response) => {
      inicioController.ventas = response.result;
      let gananciaTotal = 0;
      inicioController.ventas.forEach(venta => {
        gananciaTotal += parseFloat(venta.total);
      });
      let notificaciones = document.getElementById('notificaciones');
      data = `
        <div class="gadget notificacion">
          <h2>Ganancias totales (hoy):</h2>
          <p>$${gananciaTotal.toFixed(2)}</p>
        </div>
      `;
      notificaciones.insertAdjacentHTML('beforeend', data);
      inicioController.mostrarVentas(inicioController.ventas);
    });
  },
  mostrarVentas: (ventas) => {
    let ventasBody = document.getElementById('ventas-body');

    if (ventas.length === 0) {
      let nuevaFila = `
        <tr>
          <td colspan="5">No hay ventas de hoy</td>
        </tr>
      `;
      ventasBody.innerHTML = nuevaFila;
    }
    else {
      ventasBody.innerHTML = '';
      let nuevaFila;
      let contador = 1;
      ventas.forEach(venta => {
        nuevaFila = `
          <tr>
            <td>${contador}</td>
            <td>${venta.fecha}</td>
            <td>${venta.hora}</td>
            <td>$${venta.total}</td>
            <td>
              <button type="button" class="btn-check" data-id="${venta.id}" onclick="window.location.href='venta/consultar/${venta.id}'" style="width: auto">Ver detalles</button>
            </td>
          </tr>
        `;
        ventasBody.insertAdjacentHTML('beforeend', nuevaFila);
        contador++;
      });
    }
  },
  consultarBajoStock: () => {
    inicioService.consultarBajoStock()
    .then(response => {
      inicioController.bajoStock = response.result;
      let notificaciones = document.getElementById('notificaciones');
      data = `
        <div class="gadget notificacion">
          <h2>Productos con bajo stock:</h2>
          <p>${inicioController.bajoStock.length}</p>
        </div>
      `;
      notificaciones.insertAdjacentHTML('beforeend', data);
      inicioController.mostrarBajoStock(inicioController.bajoStock);
    });
  },
  mostrarBajoStock: (bajoStock) => {
    let bajoStockBody = document.getElementById('bajo-stock-body');

    if (bajoStock.length === 0) {
      let nuevaFila = `
        <tr>
          <td colspan="4">No hay bajo stock</td>
        </tr>
      `;
      bajoStockBody.innerHTML = nuevaFila;
    }
    else {
      bajoStockBody.innerHTML = '';
      let nuevaFila;
      let contador = 1;
      bajoStock.forEach(bajoStock => {
        nuevaFila = `
          <tr>
            <td>${contador}</td>
            <td>${bajoStock.nombre}</td>
            <td>${bajoStock.stock}</td>
            <td>
              <button type="button" class="btn-actualizar btn-form" data-id="${bajoStock.id}" onclick="window.location.href='bebida/editar/${bajoStock.id}'">Actualizar</button>
            </td>
          </tr>
        `;
        bajoStockBody.insertAdjacentHTML('beforeend', nuevaFila);
        contador++;
      });
    }
  },
  consultarReservas: () => {
    inicioService.consultarReservas()
    .then((response) => {
      inicioController.reservas = response.result;
      let notificaciones = document.getElementById('notificaciones');
      data = `
        <div class="gadget notificacion">
          <h2>Reservas de hoy:</h2>
          <p>${inicioController.reservas.length}</p>
        </div>
      `;
      notificaciones.insertAdjacentHTML('beforeend', data);
      inicioController.mostrarReservas();
    });
  },
  mostrarReservas: () => {
    let reservasBody = document.getElementById('reservas-body');

    if (inicioController.reservas.length === 0) {
      let nuevaFila = `
        <tr>
          <td colspan="6">No hay reservas para hoy</td>
        </tr>
      `;
      reservasBody.innerHTML = nuevaFila;
    }
    else {
      reservasBody.innerHTML = '';
      let nuevaFila;
      let contador = 1;
      inicioController.reservas.forEach(reserva => {
        nuevaFila = `
          <tr>
            <td>${contador}</td>
            <td>${reserva.hora}</td>
            <td>${reserva.apellido}</td>
            <td>${reserva.nombres}</td>
            <td>${reserva.personas}</td>
            <td>
              <button type="button" class="btn-confirmar btn-actualizar btn-form" data-id="${reserva.id}"><i class="fa-solid fa-check"></i></button>
              <button type="button" class="btn-cancelar btn-eliminar" data-id="${reserva.id}"><i class="fa-solid fa-x"></i></button>
            </td>
          </tr>
        `;
        reservasBody.insertAdjacentHTML('beforeend', nuevaFila);
        contador++;
      });
    }
  },
  consultarProveedores: () => {
    inicioService.consultarProveedores()
    .then((response) => {
      let notificaciones = document.getElementById('notificaciones');
      data = `
        <div class="gadget notificacion">
          <h2>Total Proveedores:</h2>
          <p>${response.result}</p>
        </div>
      `;
      notificaciones.insertAdjacentHTML('beforeend', data);
    });
  },
  consultarBebidas: () => {
    inicioService.consultarBebidas()
    .then((response) => {
      let notificaciones = document.getElementById('notificaciones');
      data = `
        <div class="gadget notificacion">
          <h2>Total Bebidas:</h2>
          <p>${response.result}</p>
        </div>
      `;
      notificaciones.insertAdjacentHTML('beforeend', data);
    });
  },
  consultarVentasSemanales: () => {
    inicioService.consultarVentasSemanales()
    .then((response) => {
      inicioController.ventasSemanales = response.result;
      inicioController.mostrarGrafica(inicioController.ventasSemanales);
    });
  },
  mostrarGrafica: (ventasSemanales) => {
    const grafica = document.getElementById('grafica');

    if (grafica.chart) {
      grafica.chart.destroy(); //Elimina la gráfica previa
    }

    //Mapear los datos
    const diasSemana = ['Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado', 'Domingo'];
    
    //Extraer las fechas y totales
    const labels = ventasSemanales.map((venta) => {
        const fecha = new Date(venta.dia);
        return diasSemana[fecha.getDay()]; //Convertir fecha a nombre de día
    });

    const data = ventasSemanales.map((venta) => venta.total);

    //Crear la gráfica
    new Chart(grafica, {
        type: 'bar',
        data: {
            labels: labels, //Etiquetas (nombres de días)
            datasets: [{
                label: 'Ganancias por día',
                data: data, //Datos (totales)
                borderWidth: 1,
                borderColor: '#A9CDD4',
                backgroundColor: '#477A91',
            }],
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true,
                }
            }
        }
    });
  }
}

document.addEventListener("DOMContentLoaded", () => {

  inicioController.consultarVentas();
  inicioController.consultarBajoStock();
  inicioController.consultarReservas();
  inicioController.consultarProveedores();
  inicioController.consultarBebidas();
  inicioController.consultarVentasSemanales();

});