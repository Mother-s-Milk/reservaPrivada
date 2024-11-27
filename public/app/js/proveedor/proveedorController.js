let proveedorController = {
    proveedores: [],
    data: {
        id: 0,
        nombre: "",
        telefono: "",
        email: "",
        direccion: ""
    },
    save: () => {
        let proveedorForm = document.forms["proveedor-form"];

        proveedorController.data.nombre = proveedorForm.proveedorNombre.value;
        proveedorController.data.telefono = proveedorForm.proveedorTelefono.value;
        proveedorController.data.email = proveedorForm.proveedorEmail.value;
        proveedorController.data.direccion = proveedorForm.proveedorDireccion.value;

        proveedorService.save(proveedorController.data);
    },
    /*edit: (id) => {
        proveedorService.edit();
    },*/
    delete: (id) => {
        if (confirm(`¿Estás seguro de eliminar el proveedor con ID ${id}?`)) {
            proveedorService.delete(id) // Llamar al método delete del servicio
            .then(data => {
                alert(data.message); // Mostrar mensaje del servidor
                proveedorController.list(); // Actualizar lista después de eliminar
            })
            .catch(error => {
                alert("Ocurrió un error al eliminar el proveedor.");
            });
        }
    },
    update: (id) => {
        let proveedorForm = document.forms["proveedor-form"];

        proveedorController.data.id = parseInt(id);
        proveedorController.data.nombre = proveedorForm.proveedorNombre.value;
        proveedorController.data.telefono = proveedorForm.proveedorTelefono.value;
        proveedorController.data.email = proveedorForm.proveedorEmail.value;
        proveedorController.data.direccion = proveedorForm.proveedorDireccion.value;

        proveedorService.update(proveedorController.data)
        .then(response => {
            alert("Proveedor actualizado exitosamente.");
            window.location.href = "proveedor";
        })
        .catch(error => {
            console.error("Error al actualizar el proveedor:", error);
            alert("Ocurrió un error al actualizar el proveedor.");
        });
    },
    list: () => {
        proveedorService.list()
            .then(data => {
                proveedorController.proveedores = data.result;
                proveedorController.render();
            })
            .catch(error => {
                console.error("Error al cargar los proveedores", error);
            });
    },
    render: () => {
        let proveedoresBody = document.getElementById('proveedores-body');

        if (proveedorController.proveedores.length === 0) {
            let fila = `
                <tr>
                    <td colspan="5">
                        No hay proveedores registrados
                    </td>
                </tr>
            `;

            proveedoresBody.innerHTML = fila;
        } else {
            proveedoresBody.innerHTML = '';
            let fila;
            let contador = 1;
            proveedorController.proveedores.forEach(proveedor => {
                fila = `
                    <tr>
                        <td>${contador}</td>
                        <td>${proveedor.nombre}</td>
                        <td>${proveedor.telefono}</td>
                        <td>${proveedor.email}</td>
                        <td>${proveedor.direccion}</td>
                        <td>
                            <button type="button" class="btn-editar" data-id="${proveedor.id}" onclick="window.location.href='proveedor/editar/${proveedor.id}'">Editar</button>
                            <button type="button" class="btn-eliminar" data-id="${proveedor.id}" onclick=proveedorController.delete(${proveedor.id})>Eliminar</button>
                        </td>
                    </tr>
                `;
                contador++;
                proveedoresBody.insertAdjacentHTML('beforeend', fila);
            });
        }
    }
}

document.addEventListener("DOMContentLoaded", () => {
    const path = window.location.pathname;
    if (path === "/reservaPrivada/public/proveedor") {
        proveedorController.list();
    }

    let btnProveedorAlta = document.getElementById("btn-proveedor-alta");
    if (btnProveedorAlta != null) {
        btnProveedorAlta.onclick = () => {
            proveedorController.save();
        }
    }

    let btnBotonActualizar = document.getElementById('btn-proveedor-actualizar');
    if (btnBotonActualizar != null) {
        btnBotonActualizar.onclick = () => {
            let id = document.getElementById("btn-proveedor-actualizar").dataset.id;
            proveedorController.update(id);
        }
    }
});