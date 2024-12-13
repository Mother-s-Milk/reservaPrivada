<?php
        use app\core\model\dao\CategoriaDAO;
        use app\libs\Connection\Connection;
        
        $id = $_GET['id'];
        $conn = Connection::get();
        
        $dao= new CategoriaDAO($conn);
        $categoria = $dao->load($id);

?>

<h1 class="breadcrum">Categorias/Editar</h1>
<section class="container section">
    <div class="gadget">
        <header class="titulo-formulario">
            <h1>Formulario de Categorias</h1>
        </header>
        <form id="categoria-form" class="form">
            <div class="form-edicion">
                <label for="categoriaNombre">Nombre:</label>
                <input type="text" id="categoriaNombre" name="categoriaNombre" value="<?php echo $categoria->getNombre()?>" required>
            </div>
            <div class="form-edicion">
                <label for="">Descripcion:</label>
                <textarea id="categoriaDescripcion" name="categoriaDescripcion" rows="4"></textarea>
            </div>
            <button type="button" id="btn-categoria-actualizar" class="btn-form" data-id="<?php echo $categoria->getId(); ?>">Actualizar Categoria</button>
        </form>
    </div>
</section>