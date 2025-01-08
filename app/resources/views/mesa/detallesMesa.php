<?php

    /*use app\libs\Connection\Connection;
    use app\core\model\dao\MesaDAO;

    $mesaID = $_GET['id'];
    $conn = Connection::get();

    $mesaDAO = new MesaDAO($conn);
    $mesa = $mesaDAO->load($mesaID);*/

?>

<h1 class="breadcrumbs">Mesas/Detalles mesa</h1>

<div class="container section seccion-detalles-mesa">

    <main class="pedido-container gadget">

      <h2 class="gadget-titulo">Detalles del Pedido</h2>

      <div class="mesa-info">
        <p><span>Mesa:</span> 3</p>
        <p><span>Apertura:</span> 19:50</p>
        <p><span>Duración:</span> 45:36</p>
        <!-- <p><span>Mozo:</span> Cristian</p> -->
      </div>

      <div id="pedido-detalles">
        <p>Acá se mostrará el pedido de la mesa.</p>
      </div>

      <div class="pedido-resumen">
        <p>Total: $<span id="total-pedido">0.00</span></p>
        <button id="cerrar-pedido">Cerrar Pedido</button>
      </div>

    </main>

    <aside class="productos-container gadget">
      <h2 class="gadget-titulo">Productos Disponibles</h2>
        
      <input type="text" id="busqueda-productos" placeholder="Buscar productos...">

      <div class="productos-grid">
        <!-- Productos cargados dinámicamente -->
      </div>
    </aside>

</div>