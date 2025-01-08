<h1 class="breadcrumbs">Mesas/Alta</h1>

<section class="container section">
    <div class="gadget">
        <header class="titulo-formulario">
            <h1>Formulario de Mesa</h1>
        </header>
        <form id="mesa-form" class="form">
            <div>
                <textarea id="mesaDescripcion" name="mesaDescripcion" rows="4" placeholder="Descripción"></textarea>
            </div>

            <div>
                <select id="mesaDisponible" name="mesaDisponible" required>
                    <option value="1">Disponible</option>
                    <option value="0">No disponible</option>
                </select>
            </div>


            <button type="button" id="btn-mesa-alta" class="btn-form">Guardar Mesa</button>
        </form>
    </div>
</section>