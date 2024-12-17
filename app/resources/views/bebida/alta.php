<?php

    use app\libs\connection\Connection;
    use app\core\model\dao\CategoriaDAO;
    use app\core\model\dao\ProveedorDAO;

    $conn = Connection::get();

    $categoriaDAO = new CategoriaDAO($conn);
    $categorias = $categoriaDAO->list();

    $proveedorDAO = new ProveedorDAO($conn);
    $proveedores = $proveedorDAO->list();

?>

<h1 class="breadcrumbs">Bebidas/Alta</h1>

<section class="container section">
    <div class="gadget">
        <header class="titulo-formulario">
            <h1>Formulario de Bebidas</h1>
        </header>
        <form id="bebida-form" class="form">
            <div>
                <span id="error-nombre" class="error"></span>
                <input type="text" id="bebidaNombre" name="bebidaNombre" placeholder="Nombre de la bebida" required>
            </div>
            <div>
                <textarea id="bebidaDescripcion" name="bebidaDescripcion" placeholder="Descripción"></textarea>
            </div>
            <div>
                <span id="error-categoriaId" class="error"></span>
                <select id="bebidaCategoriaId" name="bebidaCategoriaId" required>
                    <option value="" disabled selected>Seleccionar categoría</option>
                    <?php

                        foreach ($categorias as $categoria) {
                            echo '<option value="' . htmlspecialchars($categoria['id']) . '">' . htmlspecialchars($categoria['nombre']) . '</option>' . "\n";
                        }

                    ?>
                </select>
            </div>
            <div>
                <span id="error-precioUnitario" class="error"></span>
                <input type="number" id="bebidaPrecioUnitario" name="bebidaPrecioUnitario" step="0.01" placeholder="Precio unitario (sin puntos)" required min="0">
            </div>
            <div>
                <span id="error-stock" class="error"></span>
                <input type="number" id="bebidaStock" name="bebidaStock" placeholder="Cantidad en Stock" required min="0">
            </div>
            <div>
                <span id="error-marca" class="error"></span>
                <input type="text" id="bebidaMarca" name="bebidaMarca" placeholder="Marca de la bebida" required>
            </div>
            <div>
                <span id="error-proveedorId" class="error"></span>
                <select id="bebidaProveedorId" name="bebidaProveedorId" required>
                    <option value="" disabled selected>Seleccionar Proveedor</option>
                    <?php

                        foreach ($proveedores as $proveedor) {
                            echo '<option value="' . htmlspecialchars($proveedor['id']) . '">' . htmlspecialchars($proveedor['nombre']) . '</option>' . "\n";
                        }

                    ?>
                </select>
            </div>
            <button type="button" id="btn-bebida-alta" class="btn-form">Guardar Bebida</button>
        </form>
    </div>
</section>