<h1 class="breadcrum">Categorias</h1>

<section class="container section">
    <div class="header-actions gadget">
        <h2>Lista de Categorias</h2>
        <button type="button" class="btn-add" onclick="window.location.href='categoria/create'">Agregar Categoria</button>
    </div>
    <div class="section-filter">
        <aside class="gadget">
            <h2>Filtros</h2>
            <ul>
                <li><button type="button" class="filter-button active" data-filter="todas">Todas</button></li>
            </ul>
        </aside>
        <main class="gadget">
            <table class="tabla-lista">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Nombre</th>
                        <th>Descripcion</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody id="categorias-body">
                </tbody>
            </table>
        </main>
    </div>
</section>