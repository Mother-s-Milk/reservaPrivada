<?php
        use app\core\model\dao\ProveedorDAO;
        use app\libs\Connection\Connection;
        
        $id = $_GET['id'];
        $conn = Connection::get();
        
        $dao= new ProveedorDAO($conn);
        $proveedor = $dao->load($id);

?>

<h1>Proveedor->Edicion</h1>

<form id="proveedor-form">
    <div>
        <label for="proveedorNombre">Nombre del proveedor</label>
        <input type="text" id="proveedorNombre" name="proveedorNombre" value="<?php echo $proveedor->getNombre()?>" required>
    </div>
    <div>
        <label for="proveedorTelefono">Telefono</label>
        <input type="text" id="proveedorTelefono" name="proveedorTelefono" value="<?php echo $proveedor->getTelefono()?>" required>
    </div>
    <div>
        <label for="proveedorEmail">Email</label>
        <input type="email" id="proveedorEmail" name="proveedorEmail" value="<?php echo $proveedor->getEmail()?>" required>
    </div>
    <div>
        <label for="proveedorDireccion">Direccion</label>
        <input type="text" id="proveedorDireccion" name="proveedorDireccion" value="<?php echo $proveedor->getDireccion()?>" required>
    </div>
    <button type="button" id="btn-proveedor-actualizar" data-id="<?php echo $proveedor->getId(); ?>">Actualizar datos</button>
</form>