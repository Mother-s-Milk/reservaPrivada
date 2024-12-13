let bebidaController = {
    bebidas: [],
    data: {
        id: 0,
        nombre: "",
        descripcion: "",
        categoriaId: 0,
        precioUnitario: 0,
        stock: 0,
        marca: "",
        proveedorId: 0
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

        bebidaService.save(bebidaController.data)
        .then(response => {
            alert('Bebida almacenada exitosamente');
            bebidaController.resetForm();
        })
        .catch(error => {
            alert('Error al almacenar bebida');
        })
    },
    update: (id) => {
        let bebidaForm = document.forms["bebida-form"];

        bebidaController.data.id = parseInt(id);
        bebidaController.data.nombre = bebidaForm.bebidaNombre.value;
        bebidaController.data.descripcion = bebidaForm.bebidaDescripcion.value;
        bebidaController.data.categoriaId = parseInt(bebidaForm.bebidaCategoriaId.value);
        bebidaController.data.precioUnitario = parseFloat(bebidaForm.bebidaPrecioUnitario.value);
        bebidaController.data.stock = parseInt(bebidaForm.bebidaStock.value);
        bebidaController.data.marca = bebidaForm.bebidaMarca.value;
        bebidaController.data.proveedorId = parseInt(bebidaForm.bebidaProveedorId.value);

        bebidaService.update(bebidaController.data)
        .then(response => {
            alert("Bebida actualizado exitosamente.");
            window.location.href = "bebida";
        })
        .catch(error => {
            console.error("Error al actualizar el proveedor:", error);
            alert("Ocurrió un error al actualizar el proveedor.");
        });
    },
    delete: (id) => {
        if (confirm(`¿Estás seguro de eliminar la bebida con ID ${id}?`)) {
            bebidaService.delete(id)
            .then(data => {
                alert(data.message); //Mostrar mensaje del servidor
                bebidaController.list();
            })
            .catch(error => {
                alert("Ocurrió un error al eliminar la bebida.");
            });
        }
    },
    //Función que obtiene los productos y los despliega en el DOM
    list: () => {
        bebidaService.list()
        .then(data => {
            bebidaController.bebidas = data.result;
            bebidaController.render();
        })
        .catch(error => {
            console.error("Error al cargar las bebidas (controller)", error);
        });
    },
    //Función que recorre las bebidas y las agrega al DOM
    render: () => {
        let bebidasBody = document.getElementById('bebidas-body');

        if (bebidaController.bebidas.length === 0) {
            let fila = `
                <tr>
                    <td colspan="9">No hay bebidas registradas</td>
                </tr>
            `;
            bebidasBody.innerHTML = fila;
        }
        else {
            bebidasBody.innerHTML = '';
            let fila;
            let contador = 1;
            bebidaController.bebidas.forEach(bebida => {
                fila = `
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
                            <button type="button" class="btn-eliminar" data-id="${bebida.id}" onclick=bebidaController.delete(${bebida.id})><i class="fa-solid fa-trash"></i></button>
                        </td>
                    </tr>
                `;
                contador++;
                bebidasBody.insertAdjacentHTML('beforeend', fila);
            });
        }
    },
    resetForm: () => {
        document.forms["bebida-form"].reset();
    }
}

document.addEventListener("DOMContentLoaded", () => {
    const path = window.location.pathname;
    if (path === "/reservaPrivada/public/bebida") {
        bebidaController.list();
    }

    let btnBebidaAlta = document.getElementById("btn-bebida-alta");
    if (btnBebidaAlta != null) {
        btnBebidaAlta.onclick = () => {
            bebidaController.save();
        }
    }

    let btnBebidaActualizar = document.getElementById('btn-bebida-actualizar');
    if (btnBebidaActualizar != null) {
        btnBebidaActualizar.onclick = () => {
            let id = document.getElementById("btn-bebida-actualizar").dataset.id;
            bebidaController.update(id);
        }
    }
});