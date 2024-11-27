let categoriaController = {
    categorias: [],
    data: {
        id: 0,
        nombre: "",
    },
    save: () => {
        let categoriaForm = document.forms["categoria-form"];

        categoriaController.data.nombre = categoriaForm.categoriaNombre.value;

        categoriaService.save(categoriaController.data)
    },
    update: (id) => {
        let categoriaForm = document.forms["categoria-form"];

        categoriaController.data.id = parseInt(id);
        categoriaController.data.nombre = categoriaForm.categoriaNombre.value;

        categoriaService.update(categoriaController.data)
        .then(response => {
            alert("Categoria actualizada exitosamente.");
            window.location.href = "categoria";
        })
        .catch(error => {
            console.error("Error al actualizar la categoria:", error);
            alert("Ocurrió un error al actualizar la categoria.");
        });
    },
    delete: (id) => {
        if (confirm(`¿Estás seguro de eliminar la categoria con ID`, id)) {
            categoriaService.delete(id)
            .then(data => {
                alert(data.message);
                categoriaController.list();
            })
            .catch(error => {
                alert("Ocurrió un error al eliminar la categoria.");
            });
        }
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
                    <td colspan="2">
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
                            <button type="button" class="btn-editar" data-id="${categoria.id}" onclick="window.location.href='categoria/editar/${categoria.id}'">Editar</button>
                            <button type="button" class="btn-eliminar" data-id="${categoria.id}" onclick=categoriaController.delete(${categoria.id})>Eliminar</button>
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
    const path = window.location.pathname;
    if (path === "/reservaPrivada/public/categoria") {
        categoriaController.list();
    }

    let btnCategoriaAlta = document.getElementById("btn-categoria-alta");
    if (btnCategoriaAlta != null) {
        btnCategoriaAlta.onclick = () => {
            categoriaController.save();
        }
    }

    let btnCategoriaActualizar = document.getElementById('btn-categoria-actualizar');
    if (btnCategoriaActualizar != null) {
        btnCategoriaActualizar.onclick = () => {
            let id = document.getElementById("btn-categoria-actualizar").dataset.id;
            categoriaController.update(id);
        }
    }
});