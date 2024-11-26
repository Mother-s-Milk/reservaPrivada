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

        proveedorService.save(proveedorController.data)
    },
    edit: (id) => {
        proveedorService.edit()
        .then
        proveedorService.load(id)
            .then(data => {
                if (!data || !data.result) {
                    throw new Error("No se encontraron datos del proveedor.");
                }
                
                let proveedorForm = document.forms["proveedor-form"];
                proveedorForm.proveedorNombre.value = data.result.nombre || "";
                proveedorForm.proveedorTelefono.value = data.result.telefono || "";
                proveedorForm.proveedorEmail.value = data.result.email || "";
                proveedorForm.proveedorDireccion.value = data.result.direccion || "";
    
                // Actualizamos el ID en el controlador
                proveedorController.data.id = id;
            })
            .catch(error => {
                console.error("Error al cargar los datos del proveedor:", error);
                alert("No se pudo cargar la información del proveedor. Intente nuevamente.");
            });
    }
    ,
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
});