const API_BASE_URL = "proveedor/";

let proveedorService = {
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
        return fetch(`${API_BASE_URL}alta`, {
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
    load: (id) => {
        return fetch(`${API_BASE_URL}load/${id}`, {
          method: "GET",
          headers: {
            "Content-Type": "application/json",
            Accept: "application/json",
          },
        })
          .then((response) => {
            if (!response.ok) {
              throw new Error(response.status);
            }
            return response.json();
          })
          .then((data) => {
            return data;
          })
          .catch((error) => {
            console.error("Error en la petición: ", error);
            throw error;
          });
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
                throw new Error(`Error al eliminar el proveedor: ${response.statusText}`);
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
        return fetch(`${API_BASE_URL}list`, {
            method: "GET",
            headers: {
                "Content-Type": "application/json",
                "Accept": "application/json"
            }
        })  // Esta es la URL de tu controlador
            .then(response => {
                if (!response.ok) {
                    throw new Error("Error al obtener los proveedores");
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

    pdf: (proveedores) => {
        return fetch(`${API_BASE_URL}pdf`, {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                "Accept": "application/json"
            },
            body: JSON.stringify({ proveedores: proveedores }) // Enviar los datos de la tabla
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
    excel:(proveedores)  => {
        return fetch(`${API_BASE_URL}excel`, {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                "Accept": "application/json"
            },
            body: JSON.stringify({ proveedores: proveedores }) // Enviar los datos de la tabla
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