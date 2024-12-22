<h1 class="breadcrumbs">Bebidas</h1>

<section class="container section">
    <div class="header-actions gadget">
        <h2>Lista de Bebidas</h2>
        <button type="button" class="btn-add" onclick="window.location.href='bebida/create'">Agregar Bebida</button>
    </div>
    <div class="one">
        <aside class="gadget">
            <h2>Filtros</h2>
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
        </main>
    </div>
</section>