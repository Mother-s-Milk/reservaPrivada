//En este archivo se encuentran los scripts que se utilizan en todas las páginas del sitio. En este caso los eventos relacionados a la barra de navegación y el botón de cerrar sesión.

document.addEventListener("DOMContentLoaded", () => {
    const dropdownButtons = document.querySelectorAll(".dropdown-btn");

    dropdownButtons.forEach((btn) => {
        btn.addEventListener("click", (e) => {
            e.preventDefault();
            const dropdownContent = btn.nextElementSibling;

            if (dropdownContent.style.display === "block") {
                dropdownContent.style.display = "none";
            } else {
                document.querySelectorAll(".dropdown-content").forEach((content) => {
                    content.style.display = "none"; // Cierra otras sublistas
                });
                dropdownContent.style.display = "block";
            }
        });
    });

    // Botón de cerrar sesión
    /*const logoutButton = document.getElementById("logout");
    logoutButton.addEventListener("click", () => {
        const confirmLogout = confirm("¿Estás seguro de que deseas cerrar sesión?");
        if (confirmLogout) {
            alert("Sesión cerrada exitosamente.");
            window.location.href = "inicio";
        }
    });*/

    const darkModeToggle = document.getElementById("dark-mode");
    const body = document.body;
    
    // Verificar el modo oscuro en localStorage
    if (localStorage.getItem("darkMode") === "enabled") {
        body.classList.add("dark-mode");
        darkModeToggle.classList.add("active");
    }
    
    // Alternar modo oscuro
    darkModeToggle.addEventListener("click", () => {
        const isDarkMode = body.classList.toggle("dark-mode");
        darkModeToggle.classList.toggle("active");
            
        // Guardar preferencia en localStorage
        if (isDarkMode) {
            localStorage.setItem("darkMode", "enabled");
        } else {
            localStorage.setItem("darkMode", "disabled");
        }
    });

});