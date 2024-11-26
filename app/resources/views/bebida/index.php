<h1>Bebida->Index</h1>

<div>
    <button type="button" onclick="window.location.href='bebida/create'">Agregar bebida</button>
</div>

<section class="container section animation-section">
    <header class="header-section">
        <h2>Bebidas</h2>
    </header>
    <div class="section-filter">
        <section class="bebidas-tabla" id="bebidas-index">
            <table>
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Nombre</th>
                        <th>Descripcion</th>
                        <th>Categoria</th>
                        <th>Precio</th>
                        <th>Stock</th>
                        <th>Marca</th>
                        <th>Proveedor</th>
                        <th>Opciones</th>
                    </tr>
                </thead>
                <tbody id="bebidas-body">
                </tbody>
            </table>
        </section>
    </div>
</section>