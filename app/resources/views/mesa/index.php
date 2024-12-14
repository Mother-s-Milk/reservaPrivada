<h1 class="breadcrum">Categorias</h1>

<section class="container section">
    <div class="header-actions gadget">
        <h2>Lista de Mesas</h2>
        <button type="button" class="btn-add" onclick="window.location.href='mesa/create'">Agregar Mesa</button>
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
                        <th>Descripcion</th>
                        <th>Estado</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody id="mesas-body">
                </tbody>
            </table>
        </main>
    </div>
</section>