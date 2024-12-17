//Agregar un modal de confirmacion si el usuario presiona el boton de resertar formulario
//Si al agregar un detalle de venta, el data-stock es menor a la cantidad solicitada, avisar.

let ventaController = {
    ventas: [],
    venta: {
        id: 0,
        fecha: "",
        hora: "",
        formaPago: "",
        detalles: [],
        total: 0
    },
    save: () => {
        //let detalles = ventaController.venta.detalles;
        ventaController.venta.formaPago = document.getElementById('formaPago').value;
        //console.log(ventaController.venta);
        ventaService.save(ventaController.venta)
            .then(response => {
                alert("Venta registrada con éxito.", response);
                ventaController.venta.detalles = [];
                ventaController.venta.total = 0;
                ventaController.resetearFormulario();
                ventaController.mostrarDetallesVenta();
            })
            .catch(error => {
                console.error("Error al guardar la venta:", error);
            });
    },
    agregarBebida: () => {
        let bebida = document.getElementById('bebidaNombre');
        let cantidad = document.getElementById('bebidaCantidad');

        if (bebida.value) {
            let bebidaSeleccionada = bebida.options[bebida.selectedIndex];
            //alert(`ID de la bebida seleccionada: ${idBebida}`);
            //Consultar stock antes de almacenar
            ventaController.venta.detalles.push({
                bebidaId: parseInt(bebida.value),
                precio: parseFloat(bebidaSeleccionada.getAttribute('data-precio')),
                cantidad: parseInt(cantidad.value)
            });

            ventaController.mostrarDetallesVenta();
        } else {
            alert("Waskiii");
        }
    },
    mostrarDetallesVenta: () => {
        let bodyBebidas = document.getElementById('bebidas-venta-body');

        if (ventaController.venta.detalles.length === 0) {
            bodyBebidas.innerHTML = '<tr><td class="text-center text-muted" colspan="5">No hay detalles cargados</td></tr>';
            bodyBebidas.nextElementSibling.hidden = true;
        }
        else {
            bodyBebidas.innerHTML = '';
            let total = 0;
            ventaController.venta.detalles.forEach(bebida => {
                let fila = `
                    <tr>
                        <td>${bebida.nombre}</td>
                        <td>$${bebida.precio}</td>
                        <td>${bebida.cantidad}</td>
                        <td>$${(bebida.precio*bebida.cantidad).toFixed(2)}</td>
                        <td>
                            <button type="button" class="btn-editar"><i class="fa-solid fa-pen-to-square"></i></button>
                            <button type="button" class="btn-eliminar"><i class="fa-solid fa-trash"></i></button>
                        </td>
                    </tr>
                `;
                total += bebida.precio*bebida.cantidad;
                ventaController.venta.total = total;
                bodyBebidas.insertAdjacentHTML('beforeend', fila);
            });
            document.getElementById("total-venta").textContent = `$${total.toFixed(2)}`;
            bodyBebidas.nextElementSibling.hidden = false;
        }
    },
    list: () => {
        ventaService.list()
        .then(data => {
            ventaController.ventas = data.result;
            ventaController.mostrarVentas();
            //console.log(data.result);
        })
        .catch(error => {
            console.error("Error al cargar las ventas (controller)", error);
        });
    },
    mostrarVentas: () => {
        let ventasBody = document.getElementById('ventas-body');

        if (ventaController.ventas.length === 0) {
            let nuevaFila = `
                <tr>
                    <td colspan="7">No hay ventas registradas</td>
                </tr>
            `;
            ventasBody.innerHTML = nuevaFila;
        }
        else {
            ventasBody.innerHTML = '';
            let nuevaFila;
            let contador = 1;
            ventaController.ventas.forEach(venta => {
                nuevaFila = `
                    <tr>
                        <td>${contador}</td>
                        <td>${venta.fecha}</td>
                        <td>${venta.hora}</td>
                        <td>${venta.formaPago}</td>
                        <td>$${(venta.total).toFixed(2)}</td>
                        <td>
                            <button type="button" class="btn-check" data-id="${venta.id}" style="width: 100%">Ver detalles</button>
                        </td>
                    </tr>
                `;
                contador++;
                ventasBody.insertAdjacentHTML('beforeend', nuevaFila);
            });
        }
    },
    resetearFormulario: () => {
        document.getElementById('venta-form').reset();
    }
}

document.addEventListener("DOMContentLoaded", () => {
    const path = window.location.pathname;
    if (path === "/reservaPrivada/public/venta") {
        ventaController.list();
    }
    else if (path === "/reservaPrivada/public/venta/create") {
        let btnAgregarBebida = document.getElementById('btn-agregar-bebida-venta');
        btnAgregarBebida.onclick = () => {
            ventaController.agregarBebida();
        }

        let btnAltaVenta = document.getElementById('btn-venta-alta');
        btnAltaVenta.onclick = () => {
            ventaController.save();
        }
    }
});