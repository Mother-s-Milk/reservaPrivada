<?php

    namespace app\core\model\dto;

    use app\core\model\base\InterfaceDTO;

    final class BebidaDTO implements InterfaceDTO {

        private $id, $nombre, $descripcion, $categoriaId, $precioUnitario, $stock, $marca, $proveedorId;

        public function __construct ($data = []) {
            $this->setId($data["id"] ?? 0);
            $this->setNombre($data["nombre"] ?? "");
            $this->setDescripcion($data["descripcion"] ?? "");
            $this->setCategoriaId($data["categoriaId"] ?? 0);
            $this->setPrecioUnitario($data["precioUnitario"] ?? 0);
            $this->setStock($data["stock"] ?? 0);
            $this->setMarca($data["marca"] ?? "");
            $this->setProveedorId($data["proveedorId"] ?? 0);
        }

        /*********/
        /*Getters*/
        /*********/
        public function getId (): int {
            return $this->id;
        }

        public function getNombre (): string {
            return $this->nombre;
        }

        public function getDescripcion (): string {
            return $this->descripcion;
        }

        public function getCategoriaId (): int {
            return $this->categoriaId;
        }

        public function getPrecioUnitario (): float {
            return $this->precioUnitario;
        }

        public function getStock (): int {
            return $this->stock;
        }

        public function getMarca (): string {
            return $this->marca;
        }

        public function getProveedorId (): int {
            return $this->proveedorId;
        }

        /*********/
        /*Setters*/
        /*********/
        public function setId ($id): void {
            $this->id = (is_integer($id) && $id > 0) ? $id : 0;
        }

        public function setNombre ($nombre): void {
            $this->nombre = (is_string($nombre) && strlen(trim($nombre)) <= 45) ? trim($nombre) : "";
        }

        public function setDescripcion ($descripcion): void {
            $this->descripcion = (is_string($descripcion) && strlen(trim($descripcion)) <= 100) ? trim($descripcion) : "";
        }

        public function setCategoriaId ($categoriaId): void {
            $this->categoriaId = (is_integer($categoriaId) && $categoriaId > 0) ? $categoriaId : 0;
        }

        public function setPrecioUnitario ($precioUnitario): void {
            $this->precioUnitario = (is_numeric($precioUnitario) && $precioUnitario > 0) ? floatval($precioUnitario) : 0;
        }

        public function setStock ($stock): void {
            $this->stock = (is_integer($stock) && $stock > 0) ? $stock : 0;
        }

        public function setMarca ($marca): void {
            $this->marca = (is_string($marca) && strlen(trim($marca)) <= 45) ? trim($marca) : "";
        }

        public function setProveedorId ($proveedorId): void {
            $this->proveedorId = (is_integer($proveedorId) && $proveedorId > 0) ? $proveedorId : 0;
        }

        /*********/
        /*Metodos*/
        /*********/
        public function toArray (): array {
            return [
                "id" => $this->getId(),
                "nombre" => $this->getNombre(),
                "descripcion" => $this->getDescripcion(),
                "categoriaId" => $this->getCategoriaId(),
                "precioUnitario" => $this->getPrecioUnitario(),
                "stock" => $this->getStock(),
                "marca" => $this->getMarca(),
                "proveedorId" => $this->getProveedorId()
            ];
        }

    }

?>