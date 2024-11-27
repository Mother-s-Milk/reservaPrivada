<?php
        use app\core\model\dao\CategoriaDAO;
        use app\libs\Connection\Connection;
        
        $id = $_GET['id'];
        $conn = Connection::get();
        
        $dao= new CategoriaDAO($conn);
        $categoria = $dao->load($id);

?>

<h1>Categoria->Actualizar</h1>

<form id="categoria-form">
    <div>
        <label for="categoriaNombre">Nombre de la categoria</label>
        <input type="text" id="categoriaNombre" name="categoriaNombre" value="<?php echo $categoria->getNombre()?>" required>
    </div>
    <button type="button" id="btn-categoria-actualizar" data-id="<?php echo $categoria->getId(); ?>">Actualizar Categoria</button>
</form>