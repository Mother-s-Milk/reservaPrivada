<h1 class="breadcrum">Proveedores</h1>

<section class="container section">
    <div class="header-actions gadget">
        <h2>Lista de Proveedores</h2>
        <button type="button" class="btn-add" onclick="window.location.href='proveedor/create'">Agregar Proveedor</button>
    </div>
    <div class="section-filter">
        <aside class="gadget">
            <h2>Filtros</h2>
            <ul>
                <li><button type="button" class="filter-button active" data-filter="todas">Todos</button></li>
            </ul>
        </aside>
        <main class="gadget">
            <table class="tabla-lista">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Nombre</th>
                        <th>Telefono</th>
                        <th>Email</th>
                        <th>Localidad</th>
                        <th>Direccion</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody id="proveedores-body">
                </tbody>
            </table>
        </main>
    </div>
</section>