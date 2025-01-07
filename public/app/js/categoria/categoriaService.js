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
            method: "DELETE",  // O puedes usar DELETE si prefieres
            headers: {
                "Content-Type": "application/json",
                "Accept": "application/json",
            }
        })
        .then(response => {
            if (!response.ok) {
                throw new Error(`Error al eliminar la bebida: ${response.statusText}`);
            }
            return response.json();  // Retorna lo que se necesita
        })
        .then(data => {
            console.log("Respuesta de la eliminación:", data);
            return data;
        })
        .catch(error => {
            console.error("Error:", error);
        });
    }
,    
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
    },
    listPage: (data) => {
        return fetch(`${API_BASE_URL}listPage`, {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                "Accept": "application/json"
            },
            body: JSON.stringify(data)
        })
        .then(response => {
            if (!response.ok) {
                throw new Error("Error al obtener los proveedores");
            }
            return response.json();
        })
        .then(data => {
            return data;
        })
        .catch(error => {
            console.error("Error en la solicitud:", error);
        });
    },

    pdf: (categorias) => {
        return fetch("categoria/pdf", {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                "Accept": "application/json"
            },
            body: JSON.stringify({ categorias: categorias }) // Enviar los datos de la tabla
        })
            .then(response => {
                if (!response.ok) {
                    throw new Error("Error al obtener las categorías");
                }
                return response.blob(); // Captura el PDF como Blob
            })
            .then(blob => {
                let url = window.URL.createObjectURL(blob); // Crear URL temporal para el PDF
                return { url }; // Retorna el objeto con la URL
            })
            .catch(error => {
                console.error("Error en la solicitud:", error);
            });
    }
    ,
    excel:(categorias)  => {
        return fetch("categoria/excel", {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                "Accept": "application/json"
            },
            body: JSON.stringify({ categorias: categorias }) // Enviar los datos de la tabla
        })
            .then(response => {
                if (!response.ok) {
                    throw new Error("Error al obtener las categorías");
                }
                return response.blob(); // Captura el PDF como Blob
            })
            .then(blob => {
                let url = window.URL.createObjectURL(blob); // Crear URL temporal para el PDF
                return { url }; // Retorna el objeto con la URL
            })
            .catch(error => {
                console.error("Error en la solicitud:", error);
            });

    }


}