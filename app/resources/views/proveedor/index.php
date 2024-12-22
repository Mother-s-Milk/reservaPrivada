<h1 class="breadcrumbs">Proveedores</h1>

<section class="container section">
    <div class="one">
        <aside class="gadget">
            <h2>Filtros</h2>
            <form id="filtros-form">

                <div>
                    <label for="filtro-nombre">Nombre del Proveedor:</label>
                    <input type="text" id="filtro-nombre" name="nombre" placeholder="Ingrese el nombre del Proveedor">
                </div>

                <div>
                    <label for="filtro-localidad">Localidad:</label>
                    <select id="filtro-localidad" name="localidad">
                        <option value="">Todos</option>
                        <option value="Caleta Olivia">Caleta Olivia</option>
                        <option value="Las Heras">Las Heras</option>
                        <option value="Pico Truncado">Pico Truncado</option>
                        <option value="Comodoro Rivadavia">Comodoro Rivadavia</option>
                        <option value="Buenos Aires">Buenos Aires</option>
                        <option value="Buenos Aires">Mendoza</option>
                        <option value="Rosario">Rosario</option>
                    </select>
                </div>

                <button type="button" id="btn-filtrar" class="btn-form">Aplicar Filtros</button>
                <button type="button" id="btn-borrar-filtrar" class="btn-reset">Borrar Filtros</button>
                <button type="button" class="btn-add" onclick="window.location.href='proveedor/create'">Agregar Proveedor</button>
            </form>
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

            <div id="pagination" class="pagination">
                <!-- Botones de paginación se agregarán aquí -->
            </div>
        </main>
    </div>
</section>