<?php

    use app\libs\Connection\Connection;
    use app\core\model\dao\BebidaDAO;
    use app\core\model\dao\CategoriaDAO;
    use app\core\model\dao\ProveedorDAO;

    $bebidaID = $_GET['id'];
    $conn = Connection::get();

    $bebidaDAO = new BebidaDAO($conn);
    $bebida = $bebidaDAO->load($bebidaID);

    $categoriaDAO = new CategoriaDAO($conn);
    $categorias = $categoriaDAO->list();

    $proveedorDAO = new ProveedorDAO($conn);
    $proveedores = $proveedorDAO->list();

?>

<h1 class="breadcrumbs">Bebidas/Editar</h1>

<section class="container section">
    <div class="gadget">
        <header class="titulo-formulario">
            <h1>Formulario de Bebidas</h1>
        </header>
        <form id="bebida-form" class="form">
            <span id="error-nombre" class="error"></span>
            <div class="form-edicion">
                <label for="bebidaNombre">Nombre:</label>
                <input type="text" id="bebidaNombre" name="bebidaNombre" value="<?php echo $bebida->getNombre()?>" required>
            </div>
            <div class="form-edicion">
                <label for="bebidaDescripcion">Descripción:</label>
                <textarea id="bebidaDescripcion" name="bebidaDescripcion"><?php echo $bebida->getDescripcion()?></textarea>
            </div>
            <span id="error-categoriaId" class="error"></span>
            <div class="form-edicion">
                <label for="bebidaCategoriaId">Categoría:</label>
                <select id="bebidaCategoriaId" name="bebidaCategoriaId" required>
                    <option value="" disabled>Seleccionar Categoría:</option>
                    <?php

                        foreach ($categorias as $categoria) {
                            $selected = ($categoria['id'] === $bebida->getCategoriaId()) ? 'selected' : '';
                            echo '<option value="' . htmlspecialchars($categoria['id']) . '" ' . $selected . '>' . htmlspecialchars($categoria['nombre']) . '</option>' . "\n";
                        }

                    ?>
                </select>
            </div>
            <span id="error-precioUnitario" class="error"></span>
            <div class="form-edicion">
                <label for="bebidaPrecioUnitario">Precio unitario:</label>
                <input type="number" id="bebidaPrecioUnitario" name="bebidaPrecioUnitario" step="0.01" value="<?php echo $bebida->getPrecioUnitario()?>" required min="0">
            </div>
            <span id="error-stock" class="error"></span>
            <div class="form-edicion">
                <label for="bebidaStock">Stock:</label>
                <input type="number" id="bebidaStock" name="bebidaStock" value="<?php echo $bebida->getStock()?>" required min="0">
            </div>
            <span id="error-marca" class="error"></span>
            <div class="form-edicion">
                <label for="bebidaMarca">Marca:</label>
                <input type="text" id="bebidaMarca" name="bebidaMarca" value="<?php echo $bebida->getMarca()?>" required>
            </div>
            <span id="error-proveedorId" class="error"></span>
            <div class="form-edicion">
                <label for="bebidaProveedorId">Proveedor:</label>
                <select id="bebidaProveedorId" name="bebidaProveedorId" required>
                    <option value="" disabled>Seleccionar Proveedor</option>
                    <?php

                        foreach ($proveedores as $proveedor) {
                            $selected = ($proveedor['id'] === $bebida->getProveedorId()) ? 'selected' : '';
                            echo '<option value="' . htmlspecialchars($proveedor['id']) . '" ' . $selected . '>' . htmlspecialchars($proveedor['nombre']) . '</option>' . "\n";
                        }

                    ?>
                </select>
            </div>
            <button type="button" id="btn-bebida-actualizar" class="btn-form" data-id="<?php echo $bebida->getId(); ?>">Actualizar Bebida</button>
        </form>
    </div>
</section>