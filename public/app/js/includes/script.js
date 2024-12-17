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
    const logoutButton = document.getElementById("logout");
    logoutButton.addEventListener("click", () => {
        const confirmLogout = confirm("¿Estás seguro de que deseas cerrar sesión?");
        if (confirmLogout) {
            alert("Sesión cerrada exitosamente.");
            window.location.href = "login.html";
        }
    });
});