<h1 class="breadcrumbs">Ventas</h1>

<section class="container section">
    <div class="header-actions gadget">
        <h2>Historial de Ventas</h2>
        <button type="button" class="btn-add" onclick="window.location.href='venta/create'">Nueva venta</button>
    </div>
    <div class="one">
        <aside class="gadget">
            <h2>Filtros</h2>
        </aside>
        <main class="gadget">
            <table class="tabla-lista">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Fecha</th>
                        <th>Hora</th>
                        <th>Forma de pago</th>
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