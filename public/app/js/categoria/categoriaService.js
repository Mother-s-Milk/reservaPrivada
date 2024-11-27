const API_BASE_URL = "categoria/";

let categoriaService = {
    save: (data) => {
        return fetch (`${API_BASE_URL}save`, {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                "Accept": "application/json"
            },
            body: JSON.stringify(data)
        })
        .then(response => {
            if (!response.ok) {
                throw new Error(`Error en la peticion: ${response.statusText}`);
            }
            return response.json();
        })
        .then(data => {
            console.log("Respuesta del servidor:", data);
            return data;
        })
        .catch(error => {
            console.error("Error:", error);
        })
    },
    edit: () => {
        return fetch(`${API_BASE_URL}editar`, {
            method: "GET",
            headers: {
              "Content-Type": "application/json",
              "Accept": "application/json",
            },
          })
    },
    update: (data) => {
        return fetch (`${API_BASE_URL}update`, {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                "Accept": "application/json"
            },
            body: JSON.stringify(data)
        })
        .then(response => {
            if (!response.ok) {
                throw new Error(`Error en la peticion: ${response.statusText}`);
            }
            return response.json();
        })
        .then(data => {
            console.log("Respuesta del servidor:", data);
            return data;
        })
        .catch(error => {
            console.error("Error:", error);
        })
    },
    delete: (id) => {
        return fetch(`${API_BASE_URL}delete/${id}`, {
            method: "DELETE",
            headers: {
                "Content-Type": "application/json",
                "Accept": "application/json",
            }
        })
        .then(response => {
            if (!response.ok) {
                throw new Error(`Error al eliminar la categoria: ${response.statusText}`);
            }
            return response.json();
        })
        .then(data => {
            console.log("Respuesta de la eliminación:", data);
            return data;
        })
        .catch(error => {
            console.error("Error:", error);
        });
    },
    list: () => {
        return fetch("categoria/list", {
            method: "GET",
            headers: {
                "Content-Type": "application/json",
                "Accept": "application/json"
            }
        })  // Esta es la URL de tu controlador
            .then(response => {
                if (!response.ok) {
                    throw new Error("Error al obtener las categorias");
                }
                return response.json();  // Parseas la respuesta JSON
            })
            .then(data => {
                //console.log("Lista de categorias:", data);
                return data;  // Los datos están bajo la propiedad 'data'
            })
            .catch(error => {
                console.error("Error en la solicitud:", error);
            });
    }
}