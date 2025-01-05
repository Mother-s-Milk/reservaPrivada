<h1 class="breadcrumbs">Categorías</h1>

<section class="container section">
    <div class="header-actions gadget">
        <h2>Lista de Categorías</h2>
        <div>
            <button type="button" class="btn-add" onclick="window.location.href='categoria/create'">Agregar Categoría</button>
            <button type="button" class="btn-pdf" id="btn-pdf">PDF</button>
            <button type="button" class="btn-excel" id="btn-excel">Excel</button>
        </div>
    </div>
    <div class="one">
        <main class="gadget">
            <table class="tabla-lista">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Nombre</th>
                        <th>Descripción</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody id="categorias-body">
                </tbody>
            </table>
            <div id="pagination" class="pagination">
                <!-- Botones de paginación se agregarán aquí -->
            </div>
        </main>
    </div>
</section>