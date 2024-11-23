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

        console.log(proveedorController.data);

        proveedorService.save(proveedorController.data)
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
                    <td colspan 9>
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
                            <button type="button" class="btn-editar" data-id="${proveedor.id}">Editar</button>
                            <button type="button" class="btn-eliminar" data-id="${proveedor.id}">Eliminar</button>
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
    proveedorController.list();

    let btnProveedorAlta = document.getElementById("btn-proveedor-alta");
    if (btnProveedorAlta != null) {
        btnProveedorAlta.onclick = () => {
            proveedorController.save();
        }
    }
});