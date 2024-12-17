let bebidaController = {
    //En el array "bebidas" se van a almacenar las bebidas cuando se haga la solicitud al back para desplegarlas en el index relacionado a las mismas.
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

        //Validar datos
        const validacionErrores = bebidaController.validacion(bebidaController.data);

        if (Object.keys(validacionErrores).length > 0) {
            bebidaController.mostrarErrores(validacionErrores);

            return;
        }

        bebidaService.save(bebidaController.data)
        .then(response => {
            alert('Bebida almacenada exitosamente');
            bebidaController.limpiarCamposErrores();
            bebidaController.resetForm();
        })
        .catch(error => {
            alert('Error al almacenar bebida');
        })
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
        document.getElementById("error-categoriaId").textContent = errores.categoriaId || "";
        document.getElementById("error-precioUnitario").textContent = errores.precioUnitario || "";
        document.getElementById("error-stock").textContent = errores.stock || "";
        document.getElementById("error-marca").textContent = errores.marca || "";
        document.getElementById("error-proveedorId").textContent = errores.proveedorId || "";
    },
    //Limpiar mensajes de error
    limpiarCamposErrores: () => {
        const camposError = document.querySelectorAll(".error");
        camposError.forEach(campo => {
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

        bebidaService.update(bebidaController.data)
        .then(response => {
            alert("Bebida actualizado exitosamente.");
            window.location.href = "bebida";
        })
        .catch(error => {
            console.error("Error al actualizar el proveedor");
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
                console.log(error.getMessage());
                alert("Ocurrió un error al eliminar la bebida.");
            });
        }
    },
    //Función que obtiene las bebidas y las despliega en el DOM
    list: () => {
        bebidaService.list()
        .then(data => {
            bebidaController.bebidas = data.result;
            bebidaController.mostrarBebidas();
        })
        .catch(error => {
            console.error("Error al cargar las bebidas (controller front)");
        });
    },
    //Función que recorre el array "bebidas" y las agrega al DOM
    mostrarBebidas: () => {
        let bebidasBody = document.getElementById('bebidas-body');

        if (bebidaController.bebidas.length === 0) {
            let nuevaFila = `
                <tr>
                    <td colspan="9">No hay bebidas registradas</td>
                </tr>
            `;
            bebidasBody.innerHTML = nuevaFila;
        }
        else {
            bebidasBody.innerHTML = '';
            let nuevaFila;
            let contador = 1;
            bebidaController.bebidas.forEach(bebida => {
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
                            <button type="button" class="btn-eliminar" data-id="${bebida.id}" onclick=bebidaController.delete(${bebida.id})><i class="fa-solid fa-trash"></i></button>
                        </td>
                    </tr>
                `;
                contador++;
                bebidasBody.insertAdjacentHTML('beforeend', nuevaFila);
            });
        }
    }
}

document.addEventListener("DOMContentLoaded", () => {
    //Despliega la lista de bebidas solamente si se encuentra en el index relacionado a las mismas.
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