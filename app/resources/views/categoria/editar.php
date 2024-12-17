<?php
        use app\core\model\dao\CategoriaDAO;
        use app\libs\Connection\Connection;
        
        $id = $_GET['id'];
        $conn = Connection::get();
        
        $dao= new CategoriaDAO($conn);
        $categoria = $dao->load($id);

?>

<h1 class="breadcrumbs">Categorías/Editar</h1>
<section class="container section">
    <div class="gadget">
        <header class="titulo-formulario">
            <h1>Formulario de Categorias</h1>
        </header>
        <form id="categoria-form" class="form">
            <span id="error-nombre" class="error"></span>
            <div class="form-edicion">
                <label for="categoriaNombre">Nombre:</label>
                <input type="text" id="categoriaNombre" name="categoriaNombre" value="<?php echo $categoria->getNombre()?>" required>
            </div>
            <div class="form-edicion">
                <label for="">Descripción:</label>
                <textarea id="categoriaDescripcion" name="categoriaDescripcion" rows="4"><?php echo $categoria->getDescripcion()?></textarea>
            </div>
            <button type="button" id="btn-categoria-actualizar" class="btn-form" data-id="<?php echo $categoria->getId(); ?>">Actualizar Categoría</button>
        </form>
    </div>
</section>