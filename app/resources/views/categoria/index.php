<h1>Categoria->Index</h1>

<div>
    <button type="button" onclick="window.location.href='categoria/create'">Agregar Nueva</button>
</div>

<section class="container section animation-section">
    <header class="header-section">
        <h2>Categorias</h2>
    </header>
    <div class="section-filter">
        <aside class="aside-filter">
            <h2>Filtros</h2>
            <ul>
                <!-- <li class="active"><button type="button" class="filter-button" data-filter="todas">Todas</button></li> -->
                <li><button type="button" class="filter-button active" data-filter="todas">Todas</button></li>
                <li><button type="button" class="filter-button" data-filter="1">Vinos</button></li>
                <li><button type="button" class="filter-button" data-filter="2">Cervezas</button></li>
                <li><button type="button" class="filter-button" data-filter="3">Sin alcohol</button></li>
            </ul>
        </aside>
        <section class="bebidas-tabla" id="bebidas-index">
            <table>
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Nombre</th>
                        <th>Opciones</th>
                    </tr>
                </thead>
                <tbody id="categorias-body">
                </tbody>
            </table>
        </section>
    </div>
</section>