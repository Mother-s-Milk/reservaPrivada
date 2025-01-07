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

<h1 class="breadcrumbs">Bebidas</h1>

<section class="container section">
    <div class="encabezado-index gadget">
        <h2>Lista de Bebidas</h2>
        <div>
            <button type="button" class="btn-add" onclick="window.location.href='bebida/create'">Agregar Bebida</button>
            <button type="button" class="btn-pdf" id="btn-pdf">PDF</button>
            <button type="button" class="btn-excel" id="btn-excel">Excel</button>
        </div>
    </div>
    <div class="one">
        <aside class="gadget">
            <h2>Filtros</h2>
            <form id="filtros-form">
                <div>
                    <label for="filtro-categoria">Categoría:</label>
                    <select id="bebidaCategoriaId" name="bebidaCategoriaId" required>
                        <option value=""   selected>Seleccionar categoría</option>
                            <?php

                            foreach ($categorias as $categoria) {
                                echo '<option value="' . htmlspecialchars($categoria['id']) . '">' . htmlspecialchars($categoria['nombre']) . '</option>' . "\n";
                            }

                        ?>
                    </select>
                </div>
                <div>
                    <label for="filtro-proveedor">Proveedor:</label>
                    <select id="bebidaProveedorId" name="bebidaProveedorId" required>
                        <option value=""  selected>Seleccionar Proveedor</option>
                            <?php

                                foreach ($proveedores as $proveedor) {
                                echo '<option value="' . htmlspecialchars($proveedor['id']) . '">' . htmlspecialchars($proveedor['nombre']) . '</option>' . "\n";
                            }

                        ?>
                    </select>
                </div>
                <div>
                    <label for="filtro-nombre">Nombre:</label>
                    <input type="text" id="bebidaNombre" name="bebidaNombre" placeholder="Nombre de la bebida">
                </div>
                <div>
                    <label for="filtro-stock">Cantidad de Stock:</label>
                    <input type="number" id="bebidaStock" name="bebidaStock" placeholder="Cantidad de stock">
                </div>
                <button type="button" id="btn-filtrar" class="btn-form">Aplicar Filtros</button>
                <button type="button" id="btn-borrar-filtrar" class="btn-reset">Borrar Filtros</button>
            </form>
        </aside>
        <main class="gadget">
            <table class="tabla-lista">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Nombre</th>
                        <th>Descripción</th>
                        <th>Categoría</th>
                        <th>Precio</th>
                        <th>Stock</th>
                        <th>Marca</th>
                        <th>Proveedor</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody id="bebidas-body">
                </tbody>
            </table>
            <div id="pagination" class="pagination">
                <!-- Botones de paginación se agregarán aquí -->
            </div>
        </main>
    </div>
</section>