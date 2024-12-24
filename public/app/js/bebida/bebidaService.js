const API_BASE_URL = "bebida/";

let bebidaService = {
    save: (data) => {
        return fetch (`${API_BASE_URL}save`, {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                "Accept": "application/json"
            },
            //Aca se genera el array asociativo con los atributos y valores que conforman el parametro data
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
    },
    list: () => {
        return fetch(`${API_BASE_URL}list`, {
            method: "GET",
            headers: {
                "Content-Type": "application/json",
                "Accept": "application/json"
            }
        })  // Esta es la URL de tu controlador
        .then(response => {
            if (!response.ok) {
                throw new Error("Error al obtener las bebidas");
            }
            return response.json();  // Parseas la respuesta JSON
        })
        .then(data => {
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
    filter: (data) => {
        return fetch(`${API_BASE_URL}filter`, {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                "Accept": "application/json"
            },
            body: JSON.stringify(data)
        })
        .then(response => {
            if (!response.ok) {
                throw new Error("Error al obtener las reservas");
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
}