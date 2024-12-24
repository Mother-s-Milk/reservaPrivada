//Agregar un modal de confirmacion si el usuario presiona el boton de resertar formulario
//Si al agregar un detalle de venta, el data-stock es menor a la cantidad solicitada, avisar.

const ventaController = {
    ventas: [],//Para guardar las ventas enviadas desde el back en las solicitudes
    venta: {
        id: 0,
        fecha: "",
        hora: "",
        formaPago: "",
        detalles: [],
        total: 0
    },
    agregarProducto: () => {
        let bebida = document.getElementById('bebidaNombre');
        let cantidad = document.getElementById('bebidaCantidad');

        if (bebida.value && (cantidad.value > 0)) {
            let formulario = document.forms["venta-form"];
            let nuevoDetalle = {
                bebidaId: parseInt(formulario["bebidaNombre"].value),
                nombre: formulario["bebidaNombre"].options[formulario["bebidaNombre"].selectedIndex].getAttribute('data-nombre'),
                precio: parseFloat(formulario["bebidaNombre"].options[formulario["bebidaNombre"].selectedIndex].getAttribute('data-precio')),
                cantidad: parseInt(formulario["bebidaCantidad"].value)
            };
            if (ventaController.estaEnLista(nuevoDetalle.bebidaId)) {
                ventaController.actualizarCantidad(nuevoDetalle.bebidaId,   nuevoDetalle.cantidad);
            }
            else {
                ventaController.venta.detalles.push(nuevoDetalle);
            }
            ventaController.resetearCamposBebida();
            ventaController.mostrarDetallesVenta();
        }
        else {
            alert("Debe seleccionar una bebida y una cantidad mayor a 0.");
        }
    },
    resetearCamposBebida: () => {
        let controls = document.querySelectorAll("#form-bebida input[type=text], #form-bebida input[type=number], #form-bebida select");
        controls.forEach(control => {
            control.value = "";
        })
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
    save: () => {
        ventaController.venta.formaPago = document.getElementById('formaPago').value;

        if (ventaController.venta.formaPago && ventaController.venta.detalles.length > 0) {
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
        }
        else {
            alert('Debe especificar un medio de pago y al menos un producto a la venta.');
        }
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
        let bebida = document.getElementById('bebidaNombre');
        let cantidadNueva = parseInt(cantidad);
        let cantidadActual = 0;

        for (let i = 0; i < ventaController.venta.detalles.length; i++) {
            if (ventaController.venta.detalles[i].bebidaId == idBebida) {
                cantidadActual = ventaController.venta.detalles[i].cantidad;
                break;
            }
        }

        ventaService.consultarStock(idBebida)
        .then(response => {
            let stockActual = response.result;
            if (stockActual >= (cantidadActual + cantidadNueva)) {
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
    list: () => {
        ventaService.list()
        .then(data => {
            ventaController.ventas = data.result;
            ventaController.mostrarVentas();
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
                            <button type="button" class="btn-check" data-id="${venta.id}" onclick="window.location.href='venta/consultar/${venta.id}'" style="width: auto">Ver detalles</button>
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
    },
    resetearVenta: () => {
        if (confirm(`¿Estás seguro de resetear el formulario?`)) {
            ventaController.venta.detalles = [];
            ventaController.venta.total = 0;
            ventaController.resetearFormulario();
            ventaController.mostrarDetallesVenta();
        }
    }
}

document.addEventListener("DOMContentLoaded", () => {
    const path = window.location.pathname;
    if (path === "/reservaPrivada/public/venta") {
        ventaController.list();
    }

    let btnAgregarBebida = document.getElementById('btn-agregar-bebida-venta');
    btnAgregarBebida.onclick = () => {
        ventaController.agregarProducto();
    }

    let btnResetearVenta = document.getElementById('btn-venta-resetear');
    btnResetearVenta.onclick = () => {
        ventaController.resetearVenta();
    }

    let btnAltaVenta = document.getElementById('btn-venta-alta');
    btnAltaVenta.onclick = () => {
        ventaController.save();
    }
});