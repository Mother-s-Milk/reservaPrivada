<h1 class="breadcrum">Ventas</h1>

<section class="container section">
    <div class="header-actions gadget">
        <h2>Historial de Ventas</h2>
        <button type="button" class="btn-add" onclick="window.location.href='venta/create'">Nueva venta</button>
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
                        <th>Hora</th>
                        <th>Total</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody id="ventas-body">
                </tbody>
            </table>
        </main>
    </div>
</section>