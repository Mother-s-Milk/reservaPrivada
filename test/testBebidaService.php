<?php

    require_once "../app/vendor/autoload.php";
    require_once "../app/config/DBConfig.php";

    use app\core\service\Service;
    use app\core\service\BebidaService;

    use app\core\model\base\InterfaceDTO;
    use app\core\model\dto\BebidaDTO;

    try {
        echo '<p>Hola desde el test del service</p>';

        $bebida1 = [
            "id" => 0,
            "nombre" => "Coca-Cola Zero",
            "descripcion" => "Bebida sin azucar",
            "categoriaId" => 8,
            "precioUnitario"=> 5500,
            "stock" => 30,
            "marca" => "Coca-Cola",
            "proveedorId" => 3
        ];

        $bebida2 = [
            "id" => 0,
            "nombre" => "Coca-Cola",
            "descripcion" => "Bebida sabor cola",
            "categoriaId" => 8,
            "precioUnitario"=> 5500,
            "stock" => 30,
            "marca" => "Coca-Cola",
            "proveedorId" => 2
        ];

        $bebida3 = [
            "id" => 0,
            "nombre" => "Fanta Zero",
            "descripcion" => "Bebida sin azucar",
            "categoriaId" => 8,
            "precioUnitario"=> 4500,
            "stock" => 30,
            "marca" => "Coca-Cola",
            "proveedorId" => 1
        ];

        $bebidaService = new BebidaService();

        /*try {
            $bebidaService->save($bebida1);
            $bebidaService->save($bebida2);
            $bebidaService->save($bebida3);
            echo '<p>Bebidas agregadas desde el service</p>';*/
            /*try {
                $bebidaService->delete(8);
                $bebidaService->delete(10);
            }
            catch (\Exception $ex) {
                echo '<p>Error al querer eliminar.</p>';
            }*/
            /*try {
                echo "Listando bebidas...\n";
                $bebidas = $bebidaService->list();
                print_r($bebidas);*/
                //var_dump($bebidas);
                /*foreach ($bebidas as $bebida) {
                    print_r($bebidas["nombre"]);
                }*/
                /*try {
                    $id = 11;
                    echo "<p>Cargando bebida con ID {$id}</p>";
                    $bebida = new BebidaDTO();
                    $bebida = $bebidaService->load($id);
                    print_r($bebida->getId());
                    print_r($bebida->getNombre());
                    print_r($bebida->getDescripcion());
                }
                catch (\Exception $ex) {
                    print_r($ex->getMessage());
                }*/
                /*try {
                    $bebidaActualizada = [
                        'id' => 9,
                        'nombre' => "",
                        'descripcion' => "",
                        'categoriaId' => 3,
                        'precioUnitario' => 15.75,
                        'stock' => 40,
                        'marca' => "",
                        'proveedorId' => 1
                    ];
                    $bebidaService->update($bebidaActualizada);
                    echo "Bebida actualizada.\n";
                }
                catch (\Exception $ex) {
                    print_r($ex->getMessage());
                }*/
            /*}
            catch (\Exception $ex) {
                print_r($ex->getMessage());
            }*/

        /*}
        catch (\Exception $ex) {
            print_r($ex->getMessage());
        }*/
    }
    catch (PDOException $ex) {
        print_r($ex->getMessage());
    }


?>