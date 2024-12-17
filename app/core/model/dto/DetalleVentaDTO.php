<?php

    namespace app\core\model\dto;

    use app\core\model\base\InterfaceDTO;

    final class DetalleVentaDTO implements InterfaceDTO {

        private $id, $ventaId, $bebidaId, $precio, $cantidad;

        public function __construct ($data = []) {
            $this->setId($data["id"] ?? 0);
            $this->setVentaId($data["ventaId"] ?? 0);
            $this->setBebidaId($data["bebidaId"] ?? 0);
            $this->setPrecio($data["precio"] ?? 0);
            $this->setCantidad($data["cantidad"] ?? 0);
        }

        /*********/
        /*Getters*/
        /*********/
        public function getId (): int {
            return $this->id;
        }

        public function getVentaId (): int {
            return $this->ventaId;
        }

        public function getBebidaId (): int {
            return $this->bebidaId;
        }

        public function getPrecio (): float {
            return $this->precio;
        }

        public function getCantidad (): int {
            return $this->cantidad;
        }

        /*********/
        /*Setters*/
        /*********/
        public function setId ($id): void {
            $this->id = (is_integer($id) && $id > 0) ? $id : 0;
        }

        public function setVentaId ($ventaId): void {
            $this->ventaId = (is_integer($ventaId) && $ventaId > 0) ? $ventaId : 0;
        }

        public function setBebidaId ($bebidaId): void {
            $this->bebidaId = (is_integer($bebidaId) && $bebidaId > 0) ? $bebidaId : 0;
        }

        public function setPrecio ($precio): void {
            $this->precio = (is_numeric($precio) && $precio > 0) ? floatval($precio) : 0;
        }

        public function setCantidad ($cantidad): void {
            $this->cantidad = (is_integer($cantidad) && $cantidad > 0) ? $cantidad : 0;
        }

        /*********/
        /*Metodos*/
        /*********/
        public function toArray (): array {
            return [
                "id" => $this->getId(),
                "ventaId" => $this->getVentaId(),
                "bebidaId" => $this->getBebidaId(),
                "precio" => $this->getPrecio(),
                "cantidad" => $this->getCantidad()
            ];
        }

    }

?>