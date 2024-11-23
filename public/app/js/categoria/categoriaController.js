let categoriaController = {
    categorias: [],
    data: {
        id: 0,
        nombre: "",
    },
    save: () => {
        let categoriaForm = document.forms["categoria-form"];

        categoriaController.data.nombre = categoriaForm.categoriaNombre.value;

        console.log(categoriaController.data);

        categoriaService.save(categoriaController.data)
    },
    list: () => {
        categoriaService.list()
            .then(data => {
                categoriaController.categorias = data.result;
                categoriaController.render();
            })
            .catch(error => {
                console.error("Error al cargar las categorias", error);
            });
    },
    render: () => {
        let categoriasBody = document.getElementById('categorias-body');

        if (categoriaController.categorias.length === 0) {
            let fila = `
                <tr>
                    <td colspan 2>
                        No hay categorias registradas
                    </td>
                </tr>
            `;

            categoriasBody.innerHTML = fila;
        } else {
            categoriasBody.innerHTML = '';
            let fila;
            let contador = 1;
            categoriaController.categorias.forEach(categoria => {
                fila = `
                    <tr>
                        <td>${contador}</td>
                        <td>${categoria.nombre}</td>
                        <td>
                            <button type="button" class="btn-editar" data-id="${categoria.id}">Editar</button>
                            <button type="button" class="btn-eliminar" data-id="${categoria.id}">Eliminar</button>
                        </td>
                    </tr>
                `;
                contador++;
                categoriasBody.insertAdjacentHTML('beforeend', fila);
            });
        }
    }
}

document.addEventListener("DOMContentLoaded", () => {
    categoriaController.list();

    let btnCategoriaAlta = document.getElementById("btn-categoria-alta");
    if (btnCategoriaAlta != null) {
        btnCategoriaAlta.onclick = () => {
            categoriaController.save();
        }
    }
});