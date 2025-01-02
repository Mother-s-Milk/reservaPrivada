const API_BASE_URL = "venta/";

let ventaService = {
    consultarStock: (id) => {
        return fetch(`${API_BASE_URL}consultarStock/${id}`, {
            method: "GET",
            headers: {
                "Content-Type": "application/json",
                "Accept": "application/json"
            }
        })
        .then(response => {
            if (!response.ok) {
                throw new Error(`Error en la petición: ${response.statusText}`);
            }
            return response.json();
        })
        .then(data => {
            return data;
        })
        .catch(error => {
            console.error("Error al consultar el stock:", error);
        });
    },
    save: (data) => {
        return fetch(`${API_BASE_URL}save`, {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                "Accept": "application/json"
            },
            body: JSON.stringify(data)
        })
        .then(response => {
            if (!response.ok) {
                throw new Error(`Error en la petición: ${response.statusText}`);
            }
            return response.json();
        })
        .then(data => {
            return data;
        })
        .catch(error => {
            console.error("Error al registrar la venta:", error);
        });
    },
    buscarBebida: (id) => {
        return fetch (`${API_BASE_URL}buscarBebida/${id}`, {
            method: "GET",
            headers: {
                "Content-Type": "application/json",
                "Accept": "application/json"
            }
        })
        .then(response => {
            if (!response.ok) {
                throw new Error(`Error en la peticion: ${response.statusText}`);
            }
            return response.json();
        })
        .then(data => {
            return data;
        })
        .catch(error => {
            console.error("Error:", error);
        })
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
                throw new Error("Error al obtener las ventas");
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