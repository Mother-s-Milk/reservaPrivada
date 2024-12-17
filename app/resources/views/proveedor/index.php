<h1 class="breadcrumbs">Proveedores</h1>

<section class="container section">
    <div class="header-actions gadget">
        <h2>Lista de Proveedores</h2>
        <button type="button" class="btn-add" onclick="window.location.href='proveedor/create'">Agregar Proveedor</button>
    </div>
    <div class="section-filter">
        <aside class="gadget">
            <h2>Filtros</h2>
        </aside>
        <main class="gadget">
            <table class="tabla-lista">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Nombre</th>
                        <th>Teléfono</th>
                        <th>Email</th>
                        <th>Localidad</th>
                        <th>Dirección</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody id="proveedores-body">
                </tbody>
            </table>
        </main>
    </div>
</section>