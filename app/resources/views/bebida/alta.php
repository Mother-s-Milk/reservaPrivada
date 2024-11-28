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

<h1 class="breadcrum">Bebida/Alta</h1>

<section class="container section">
    <div class="gadget">
        <header class="titulo-formulario">
            <h1>Formulario de bebida</h1>
        </header>
        <form id="bebida-form" class="form">
            <div>
                <input type="text" id="bebidaNombre" name="bebidaNombre" placeholder="Nombre del Producto" required>
            </div>
            <div>
                <textarea id="bebidaDescripcion" name="bebidaDescripcion" rows="4" placeholder="Descripción"></textarea>
            </div>
            <div>
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
                <input type="number" id="bebidaPrecioUnitario" name="bebidaPrecioUnitario" step="0.01" placeholder="Precio Unitario" required>
            </div>
            <div>
                <input type="number" id="bebidaStock" name="bebidaStock" min="0" placeholder="Cantidad en Stock" required>
            </div>
            <div>
                <input type="text" id="bebidaMarca" name="bebidaMarca" placeholder="Marca del Producto" required>
            </div>
            <div>
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
    </div>
</section>