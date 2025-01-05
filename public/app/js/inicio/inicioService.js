const API_BASE_URL = "inicio/";

let inicioService = {
  consultarVentas: () => {
    return fetch(`${API_BASE_URL}consultarVentas`, {
      method: "GET",
      headers: {
        "Content-Type": "application/json",
        "Accept": "application/json",
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
  consultarBajoStock: () => {
    return fetch(`${API_BASE_URL}consultarBajoStock`, {
      method: "GET",
      headers: {
        "Content-Type": "application/json",
        "Accept": "application/json",
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
  consultarReservas: () => {
    return fetch(`${API_BASE_URL}consultarReservas`, {
      method: "GET",
      headers: {
        "Content-Type": "application/json",
        "Accept": "application/json",
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
  consultarProveedores: () => {
    return fetch(`${API_BASE_URL}consultarProveedores`, {
      method: "GET",
      headers: {
        "Content-Type": "application/json",
        "Accept": "application/json",
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
  consultarBebidas: () => {
    return fetch(`${API_BASE_URL}consultarBebidas`, {
      method: "GET",
      headers: {
        "Content-Type": "application/json",
        "Accept": "application/json",
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
  consultarVentasSemanales: () => {
    return fetch(`${API_BASE_URL}consultarVentasSemanales`, {
      method: "GET",
      headers: {
        "Content-Type": "application/json",
        "Accept": "application/json",
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
  }
};