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

        bebidaController.data.nombre = bebidaForm.bebidaNombre.value;

        bebidaController.data.descripcion = bebidaForm.bebidaDescripcion.value;

        bebidaController.data.categoriaId = parseInt(bebidaForm.bebidaCategoriaId.value);

        bebidaController.data.precioUnitario = parseFloat(bebidaForm.bebidaPrecioUnitario.value);

        bebidaController.data.stock = parseInt(bebidaForm.bebidaStock.value);

        bebidaController.data.marca = bebidaForm.bebidaMarca.value;

        bebidaController.data.proveedorId = parseInt(bebidaForm.bebidaProveedorId.value);

        console.log(bebidaController.data);

        bebidaService.save(bebidaController.data)
        /*.then(response => {
            console.log("RESPUESTA DEL SERVIDOR ", response);
        })
        .catch (error => {
            console.error("ERROR AL GUARDAR LA BEBIDA", error);
        })*/
    },
    // Función que obtiene los productos y los despliega en el DOM
    list: () => {
        bebidaService.list()
            .then(data => {
                bebidaController.bebidas = data.result;  // Almacenas los datos
                bebidaController.render();  // Llamas a la función de renderizado
            })
            .catch(error => {
                console.error("Error al cargar los productos", error);
            });
    },

    // Función que recorre los productos y los agrega al DOM
    render: () => {
        let bebidasBody = document.getElementById('bebidas-body');

        if (bebidaController.bebidas.length === 0) {
            let fila = `
                <tr>
                    <td colspan 9>
                        No hay bebidas registradas
                    </td>
                </tr>
            `;

            bebidasBody.innerHTML = fila;
        } else {
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
                            <button type="button" class="btn-editar" data-id="${bebida.id}">Editar</button>
                            <button type="button" class="btn-eliminar" data-id="${bebida.id}">Eliminar</button>
                        </td>
                    </tr>
                `;
                contador++;
                bebidasBody.insertAdjacentHTML('beforeend', fila);
            });
        }
    }
}

document.addEventListener("DOMContentLoaded", () => {
    bebidaController.list();

    let btnBebidaAlta = document.getElementById("btn-bebida-alta");
    if (btnBebidaAlta != null) {
        btnBebidaAlta.onclick = () => {
            bebidaController.save();
        }
    }
});