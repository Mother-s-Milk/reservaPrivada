let ventaController = {
    ventas: [],
    venta: {
        id: 0,
        fecha: "",
        hora: "",
        detalles: []
    },
    save: () => {
        //let detalles = ventaController.venta.detalles;

        //console.log(ventaController.venta);
        ventaService.save(ventaController.venta)
            .then(response => {
                alert("Venta registrada con éxito.", response);
                ventaController.venta.detalles = [];
                ventaController.mostrarBebidas();
            })
            .catch(error => {
                console.error("Error al guardar la venta:", error);
                //alert("Ocurrió un error al registrar la venta.");
            });
    },
    agregarBebida: () => {
        let idBebida = document.getElementById('productoCodigo').value;

        ventaService.buscarBebida(idBebida)
        .then(data => {
            let cantidad = document.getElementById('productoCantidad').value;
            if (data.result.stock >= cantidad) {
                ventaController.venta.detalles.push({
                    bebidaId: parseInt(data.result.id),
                    nombre: data.result.nombre,
                    precio: parseFloat(data.result.precioUnitario),
                    cantidad: parseInt(cantidad)
                });
                ventaController.mostrarBebidas();
            }
            /*else {
                alert('No hay stock suficiente');
            }*/
        });
    },
    mostrarBebidas: () => {
        let bodyBebidas = document.getElementById('body-bebidas');

        if (ventaController.venta.detalles.length === 0) {
            bodyBebidas.innerHTML = '<tr><td class="text-center text-muted" colspan="6">No hay detalles cargados</td></tr>';
            bodyBebidas.nextElementSibling.hidden = true;
        }
        else {
            bodyBebidas.innerHTML = '';
            let total = 0;
            ventaController.venta.detalles.forEach(bebida => {
                let fila = `
                    <tr>
                        <td>${bebida.bebidaId}</td>
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
            ventaController.render();
        })
        .catch(error => {
            console.error("Error al cargar las ventas (controller)", error);
        });
    },
    render: () => {
        let ventasBody = document.getElementById('ventas-body');

        if (ventaController.ventas.length === 0) {
            let fila = `
                <tr>
                    <td colspan="9">No hay ventas registradas</td>
                </tr>
            `;
            ventasBody.innerHTML = fila;
        }
        else {
            ventasBody.innerHTML = '';
            let fila;
            let contador = 1;
            ventaController.ventas.forEach(venta => {
                fila = `
                    <tr>
                        <td>${contador}</td>
                        <td>${venta.nombre}</td>
                        <td>${venta.descripcion}</td>
                        <td>${venta.categoriaId}</td>
                        <td>$${venta.precioUnitario}</td>
                        <td>${venta.stock}</td>
                        <td>${venta.marca}</td>
                        <td>${venta.proveedorId}</td>
                        <td>
                            <button type="button" class="btn-editar" data-id="${venta.id}" onclick="window.location.href='bebida/editar/${bebida.id}'"><i class="fa-solid fa-pen-to-square"></i></button>
                            <button type="button" class="btn-eliminar" data-id="${venta.id}" onclick=bebidaController.delete(${bebida.id})><i class="fa-solid fa-trash"></i></button>
                        </td>
                    </tr>
                `;
                contador++;
                ventasBody.insertAdjacentHTML('beforeend', fila);
            });
        }
    }
}

document.addEventListener("DOMContentLoaded", () => {
    const path = window.location.pathname;
    if (path === "/reservaPrivada/public/venta") {
        ventaController.list();
    }
    else if (path === "/reservaPrivada/public/venta/alta") {
        let btnAgregarProducto = document.getElementById('btn-agregar-producto');
        btnAgregarProducto.onclick = () => {
            ventaController.agregarBebida();
        }

        let btnAltaVenta = document.getElementById('btn-venta-alta');
        btnAltaVenta.onclick = () => {
            ventaController.save();
        }
    }
});