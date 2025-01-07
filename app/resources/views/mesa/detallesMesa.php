<main>
    <section class="pedido-container">
      <h2>Detalles del Pedido</h2>
      <div id="pedido-detalles">
        <p>Selecciona una mesa para comenzar un pedido.</p>
      </div>
      <div class="pedido-resumen">
        <h3>Resumen</h3>
        <p>Total: $<span id="total-pedido">0.00</span></p>
        <button id="cerrar-pedido">Cerrar Pedido</button>
      </div>
    </section>
    <section class="productos-container">
      <div class="productos-header">
        <h2>Productos Disponibles</h2>
        <input type="text" id="busqueda-productos" placeholder="Buscar productos...">
      </div>
      <div class="productos-grid">
        <!-- Productos cargados dinámicamente -->
      </div>
    </section>
  </main>