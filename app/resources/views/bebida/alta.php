<?php

    use app\core\model\dao\CategoriaDAO;
    use app\core\model\dao\ProveedorDAO;
    use app\libs\connection\Connection;

    $conn = Connection::get();

    $categoriaDao = new CategoriaDAO($conn);
    $categorias = $categoriaDao->list();

    $proveedorDao = new ProveedorDAO($conn);
    $proveedores = $proveedorDao->list();

?>

<h1>Bebida->Alta</h1>

<form id="bebida-form">
    <div>
        <label for="bebidaNombre">Nombre del Producto</label>
        <input type="text" id="bebidaNombre" name="bebidaNombre" placeholder="" required>
    </div>
    <div>
        <label for="bebidaDescripcion">Descripción</label>
        <textarea id="bebidaDescripcion" name="bebidaDescripcion" rows="4"></textarea>
    </div>
    <div>
        <label for="bebidaCategoriaId">Categoría</label>
        <select id="bebidaCategoriaId" name="bebidaCategoriaId" required>
            <option value="" disabled selected>Seleccionar Categoría</option>
            <?php

                foreach ($categorias as $categoria) {
                    echo '<option value="' . $categoria['id'] . '">' . $categoria['nombre'] . '</option>' . "\n";
                }

            ?>
        </select>
    </div>
    <div>
        <label for="bebidaPrecioUnitario">Precio Unitario</label>
        <input type="number" id="bebidaPrecioUnitario" name="bebidaPrecioUnitario" step="0.01" placeholder="" required>
    </div>
    <div>
        <label for="bebidaStock">Cantidad en Stock</label>
        <input type="number" id="bebidaStock" name="bebidaStock" min="0" placeholder="" required>
    </div>
    <div>
        <label for="bebidaMarca">Marca del Producto</label>
        <input type="text" id="bebidaMarca" name="bebidaMarca" required>
    </div>
    <div>
        <label for="bebidaProveedorId">Proveedor</label>
        <select id="bebidaProveedorId" name="bebidaProveedorId" required>
            <option value="" disabled selected>Seleccionar Proveedor</option>
            <?php

                foreach ($proveedores as $proveedor) {
                    echo '<option value="' . $proveedor['id'] . '">' . $proveedor['nombre'] . '</option>' . "\n";
                }

            ?>
        </select>
    </div>
    <button type="button" id="btn-bebida-alta">Guardar Bebida</button>
</form>