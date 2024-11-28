<?php
        use app\core\model\dao\BebidaDAO;
        use app\libs\Connection\Connection;
        
        use app\core\model\dao\CategoriaDAO;
        use app\core\model\dao\ProveedorDAO;

        $id = $_GET['id'];
        $conn = Connection::get();
        
        $dao= new BebidaDAO($conn);
        $bebida = $dao->load($id);

        $categoriaDao = new CategoriaDAO($conn);
        $categorias = $categoriaDao->list();

        $proveedorDao = new ProveedorDAO($conn);
        $proveedores = $proveedorDao->list();

?>

<h1 class="breadcrum">Bebida/Editar</h1>
<section class="container section">
    <div class="gadget">
        <header class="titulo-formulario">
            <h1>Formulario de bebida</h1>
        </header>
        <form id="bebida-form" class="form">
            <div class="form-edicion">
                <label for="">Nombre:</label>
                <input type="text" id="bebidaNombre" name="bebidaNombre" value="<?php echo $bebida->getNombre()?>" required>
            </div>
            <div class="form-edicion">
                <label for="">Descripcion:</label>
                <textarea id="bebidaDescripcion" name="bebidaDescripcion" rows="4" value="<?php echo $bebida->getDescripcion();?>"></textarea>
            </div>
            <div class="form-edicion">
                <label for="">Categoria:</label>
                <select id="bebidaCategoriaId" name="bebidaCategoriaId" required>
                    <option value="" disabled>Seleccionar Categoría</option>
                    <?php

                        foreach ($categorias as $categoria) {
                            $selected = ($categoria['id'] === $bebida->getCategoriaId()) ? 'selected' : '';
                            echo '<option value="' . htmlspecialchars($categoria['id']) . '" ' . $selected . '>' . htmlspecialchars($categoria['nombre']) . '</option>' . "\n";
                        }

                    ?>
                </select>
            </div>
            <div class="form-edicion">
                <label for="">Precio unitario</label>
                <input type="number" id="bebidaPrecioUnitario" name="bebidaPrecioUnitario" step="0.01" value="<?php echo $bebida->getPrecioUnitario()?>" required>
            </div>
            <div class="form-edicion">
                <label for="">Stock:</label>
                <input type="number" id="bebidaStock" name="bebidaStock" min="0" value="<?php echo $bebida->getStock()?>" required>
            </div>
            <div class="form-edicion">
                <label for="">Marca:    </label>
                <input type="text" id="bebidaMarca" name="bebidaMarca" value="<?php echo $bebida->getMarca()?>" required>
            </div>
            <div class="form-edicion">
                <label for="">Proveedor</label>
                <select id="bebidaProveedorId" name="bebidaProveedorId" required>
                    <option value="<?php echo $bebida->getProveedorId()?>" disabled selected>Seleccionar Proveedor</option>
                    <?php

                        foreach ($proveedores as $proveedor) {
                            $selected = ($proveedor['id'] === $bebida->getProveedorId()) ? 'selected' : '';
                            echo '<option value="' . htmlspecialchars($proveedor['id']) . '" ' . $selected . '>' . htmlspecialchars($proveedor['nombre']) . '</option>' . "\n";
                        }

                    ?>
                </select>
            </div>
            <button type="button" id="btn-bebida-actualizar" data-id="<?php echo $bebida->getId(); ?>">Actualizar Bebida</button>
        </form>
    </div>
</section>