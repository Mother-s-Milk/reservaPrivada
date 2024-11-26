<?php

    require_once "../app/vendor/autoload.php";
    require_once "../app/config/DBConfig.php";

    use app\core\service\Service;
    use app\core\service\ProveedorService;

    use app\core\model\base\InterfaceDTO;
    use app\core\model\dto\ProveedorDTO;

    try {
        echo '<p>Hola desde el test del service</p>';

        $newProveedor = [
            "id" => 0,
            "nombre" => "Bety Marcel",
            "telefono" => "268-898657",
            "email" => "vieja@gmail.com",
            "direccion"=> "Por ahi"
        ];

        $proveedorService = new ProveedorService();

        try {
            /*$proveedorService->save($newProveedor);
            echo '<p>Proveedor agregado desde el service</p>';*/
            /*try {
                $proveedorService->delete(12);
            }
            catch (\Exception $ex) {
                echo '<p>Error al querer eliminar.</p>';
            }*/
            /*try {
                echo "Listando proveedores...\n";
                $proveedores = $proveedorService->list();
                print_r($proveedores);*/
                /*try {
                    $id = 10;
                    echo "<p>Cargando proveedor con ID {$id}</p>";
                    $proveedor = new ProveedorDTO();
                    $proveedor = $proveedorService->load($id);
                    print_r($proveedor->getId());
                    print_r($proveedor->getNombre());
                    print_r($proveedor->getTelefono());
                }
                catch (\Exception $ex) {
                    print_r($ex->getMessage());
                }*/
                try {
                    $proveedorActualizado = [
                        'id' => 9,
                        'nombre' => "Putito",
                        'telefono' => "297-9584744",
                        'email' => "elNegro@gmail.com",
                        'direccion' => "En una zanja"
                    ];
                    $proveedorService->update($proveedorActualizado);
                    echo "Proveedor actualizado.\n";
                }
                catch (\Exception $ex) {
                    print_r($ex->getMessage());
                }
            /*}
            catch (\Exception $ex) {
                print_r($ex->getMessage());
            }*/

        }
        catch (\Exception $ex) {
            print_r($ex->getMessage());
        }
    }
    catch (PDOException $ex) {
        print_r($ex->getMessage());
    }


?>