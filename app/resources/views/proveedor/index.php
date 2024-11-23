<h1>Proveedor->Index</h1>

<div>
    <button type="button" onclick="window.location.href='proveedor/create'">Agregar nuevo</button>
</div>

<section class="container section animation-section">
    <header class="header-section">
        <h2>Bebidas</h2>
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
        <section class="bebidas-tabla" id="proveedores-index">
            <table>
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Nombre</th>
                        <th>Telefono</th>
                        <th>Email</th>
                        <th>Direccion</th>
                    </tr>
                </thead>
                <tbody id="proveedores-body">
                </tbody>
            </table>
        </section>
    </div>
</section>