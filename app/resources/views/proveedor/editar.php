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
        <input type="text" id="proveedorNombre" name="proveedorNombre" placeholder="" required>
    </div>
    <div>
        <label for="proveedorTelefono">Telefono</label>
        <input type="text" id="proveedorTelefono" name="proveedorTelefono" required>
    </div>
    <div>
        <label for="proveedorEmail">Email</label>
        <input type="email" id="proveedorEmail" name="proveedorEmail" required>
    </div>
    <div>
        <label for="proveedorDireccion">Direccion</label>
        <input type="text" id="proveedorDireccion" name="proveedorDireccion" required>
    </div>
    <button type="button" id="btn-proveedor-alta">Guardar proveedor</button>
</form>