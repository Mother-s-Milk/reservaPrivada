<h1 class="breadcrum">Proveedor->Index</h1>

<section class="container section">
    <div class="header-actions">
        <h2>Lista de Proveedores</h2>
        <button type="button" class="btn-add" onclick="window.location.href='proveedor/create'">Agregar Proveedor</button>
    </div>
    <table class="tabla-lista">
        <thead>
            <tr>
                <th>#</th>
                <th>Nombre</th>
                <th>Telefono</th>
                <th>Email</th>
                <th>Direccion</th>
                <th>Opciones</th>
            </tr>
        </thead>
        <tbody id="proveedores-body">
        </tbody>
    </table>
</section>