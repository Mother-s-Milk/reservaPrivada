<h1 class="breadcrum">Bebida->Index</h1>

<section class="container section">
    <div class="header-actions">
        <h2>Lista de Bebidas</h2>
        <button type="button" class="btn-add" onclick="window.location.href='bebida/create'">Agregar Bebida</button>
    </div>
    <div class="section-filter">
        <aside class="aside-filter">
            <h2>Filtros</h2>
                <ul>
                    <li><button type="button" class="filter-button active" data-filter="todas">Todas</button></li>
                    <li><button type="button" class="filter-button" data-filter="1">Vinos</button></li>
                    <li><button type="button" class="filter-button" data-filter="2">Cervezas</button></li>
                    <li><button type="button" class="filter-button" data-filter="3">Sin alcohol</button></li>
                </ul>
            </aside>
        <table class="tabla-lista">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Nombre</th>
                    <th>Descripcion</th>
                    <th>Categoria</th>
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
    </div>
</section>