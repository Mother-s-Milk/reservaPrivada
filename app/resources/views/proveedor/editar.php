<?php
        use app\core\model\dao\ProveedorDAO;
        use app\libs\Connection\Connection;
        
        $id = $_GET['id'];
        $conn = Connection::get();
        
        $dao= new ProveedorDAO($conn);
        $proveedor = $dao->load($id);

?>

<h1 class="breadcrumbs">Proveedores/Editar</h1>
<section class="container section">
    <div class="gadget">
        <header class="titulo-formulario">
            <h1>Formulario de Proveedores</h1>
        </header>
        <form id="proveedor-form" class="form">
            <div class="form-edicion">
                <label for="proveedorNombre">Nombre:</label>
                <input type="text" id="proveedorNombre" name="proveedorNombre" value="<?php echo $proveedor->getNombre()?>" required>
            </div>
            <div class="form-edicion">
                <label for="proveedorTelefono">Telefono:</label>
                <input type="text" id="proveedorTelefono" name="proveedorTelefono" value="<?php echo $proveedor->getTelefono()?>" required>
            </div>
            <div class="form-edicion">
                <label for="proveedorEmail">Email:</label>
                <input type="email" id="proveedorEmail" name="proveedorEmail" value="<?php echo $proveedor->getEmail()?>" required>
            </div>
            <div class="form-edicion">
                <label for="proveedorLocalidad">Localidad:</label>
                <input type="text" id="proveedorLocalidad" name="proveedorLocalidad" value="<?php echo $proveedor->getLocalidad()?>" required>
            </div>
            <div class="form-edicion">
                <label for="proveedorDireccion">Dirección:</label>
                <input type="text" id="proveedorDireccion" name="proveedorDireccion" value="<?php echo $proveedor->getDireccion()?>" required>
            </div>
            <button type="button" id="btn-proveedor-actualizar" class="btn-form" data-id="<?php echo $proveedor->getId(); ?>">Actualizar Proveedor</button>
        </form>
    </div>
</section>