document.addEventListener("DOMContentLoaded", () => {
    // Datos simulados de ventas por día
    const ventasDiariasData = {
      labels: ['Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado', 'Domingo'],
      datasets: [{
        label: 'Ventas Diarias ($)',
        data: [1500, 2300, 1800, 2000, 3000, 2500, 2200], // Ventas por día
        backgroundColor: 'rgba(75, 192, 192, 0.2)',
        borderColor: 'rgba(75, 192, 192, 1)',
        borderWidth: 1
      }]
    };
  
    // Configuración del gráfico de barras
    const config = {
      type: 'bar',
      data: ventasDiariasData,
      options: {
        responsive: true,
        scales: {
          y: {
            beginAtZero: true,
            ticks: {
              stepSize: 500
            }
          }
        }
      }
    };
  
    // Crear gráfico en el canvas
    const ventasDiariasChart = new Chart(
      document.getElementById('ventasDiariasChart'),
      config
    );
  
    // Función para recargar el gráfico con nuevos datos (simulados)
    document.getElementById('reload-chart').addEventListener('click', () => {
      // Datos simulados de ventas actualizadas
      ventasDiariasData.datasets[0].data = [2000, 2200, 1600, 2500, 3000, 2800, 2400]; // Nuevas ventas por día
      ventasDiariasChart.update(); // Actualizar el gráfico
    });
  });
  