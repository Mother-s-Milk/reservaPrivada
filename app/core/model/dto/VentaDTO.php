<?php

    namespace app\core\model\dto;

    use app\core\model\base\InterfaceDTO;

    final class VentaDTO implements InterfaceDTO {

        private $id, $fecha, $hora, $formaPago, $detalles, $total;

        public function __construct ($data = []) {
            $this->setId($data["id"] ?? 0);
            $this->setFecha($data["fecha"] ?? "");
            $this->setHora($data["hora"] ?? "");
            $this->setFormaPago($data["formaPago"] ?? "");
            $this->setDetalles($data["detalles"] ?? []);
            $this->setTotal($data["total"] ?? 0);
        }

        /*********/
        /*Getters*/
        /*********/
        public function getId (): int {
            return $this->id;
        }

        public function getFecha (): string {
            return $this->fecha;
        }

        public function getHora (): string {
            return $this->hora;
        }

        public function getFormaPago (): string {
            return $this->formaPago;
        }

        public function getDetalles (): array {
            return $this->detalles;
        }

        public function getTotal (): float {
            return $this->total;
        }

        /*********/
        /*Setters*/
        /*********/
        public function setId ($id): void {
            $this->id = (is_integer($id) && $id > 0) ? $id : 0;
        }

        public function setFecha ($fecha): void {
            $this->fecha = (is_string($fecha) && strtotime($fecha)) ? $fecha : "";
        }

        public function setHora ($hora): void {
            $this->hora = (is_string($hora)) ? $hora : "";
        }

        public function setFormaPago ($formaPago): void {
            $this->formaPago = (is_string($formaPago) && strlen(trim($formaPago)) <= 45) ? trim($formaPago) : "";
        }

        public function setDetalles ($detalles): void {
            $this->detalles = is_array($detalles) ? $detalles : [];
        }

        public function setTotal ($total): void {
            $this->total = (is_numeric($total) && $total > 0) ? floatval($total) : 0;
        }

        /*********/
        /*Metodos*/
        /*********/
        public function toArray(): array {
            return [
                "id" => $this->getId(),
                "fecha" => $this->getFecha(),
                "hora" => $this->getHora(),
                "formaPago" => $this->getFormaPago(),
                "detalles" => $this->getDetalles(),
                "total" => $this->getTotal()
        ];
        }
    }

?>