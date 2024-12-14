<?php

use app\core\model\dao\MesaDAO;
use app\libs\Connection\Connection;

$id = $_GET['id'];
$conn = Connection::get();

$dao = new MesaDAO($conn);
$categoria = $dao->load($id);

?>

<!-- <h1 class="breadcrum">Categorias/Editar</h1> -->
<section class="container section">
    <div class="gadget">
        <header class="titulo-formulario">
            <h1>Formulario de Mesas</h1>
        </header>
        <form id="mesa-form" class="form">
            <div class="form-edicion">
                <label for="mesaDescripcion">Descripcion:</label>
                <input type="text" id="mesaDescripcion" name="mesaDescripcion" value="<?php echo $categoria->getDescripcion() ?>" required>
            </div>
            <div class="form-edicion">
                <label for="">Disponibilidad:</label>
                <select id="mesaDisponible" name="mesaDisponible" required>
                    <option value="1" <?= $categoria->getDisponibilidad() == 1 ? 'selected' : '' ?>>Disponible</option>
                    <option value="0" <?= $categoria->getDisponibilidad() == 0 ? 'selected' : '' ?>>No disponible</option>
                </select>

            </div>
            <button type="button" id="btn-mesa-actualizar" class="btn-form" data-id="<?php echo $categoria->getId(); ?>">Actualizar Mesa</button>
        </form>
    </div>
</section>