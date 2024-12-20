<?php

    namespace app\core\model\dto;

    use app\core\model\base\InterfaceDTO;

    final class MesaDTO implements InterfaceDTO {

        private $id, $disponibilidad, $descripcion;

        public function __construct ($data = []) {
            $this->setId($data["id"] ?? 0);
            $this->setDescripcion($data["descripcion"] ?? "");
            $this->setDisponibilidad($data["disponibilidad"] ?? 0);
        }

        /*********/
        /*Getters*/
        /*********/
        public function getId (): int {
            return $this->id;
        }

        public function getDisponibilidad (): string {
            return $this->disponibilidad;
        }

        public function getDescripcion (): string {
            return $this->descripcion;
        }

        /*********/
        /*Setters*/
        /*********/
        public function setId ($id): void {
            $this->id = (is_integer($id) && $id > 0) ? $id : 0;
        }

        public function setDisponibilidad($disponibilidad): void {
            $this->disponibilidad = ($disponibilidad === 0 || $disponibilidad === 1) ? $disponibilidad : 0;
        }
        

        public function setDescripcion ($descripcion): void {
            $this->descripcion = (is_string($descripcion) && strlen(trim($descripcion)) <= 100) ? trim($descripcion) : "";
        }

        /*********/
        /*Metodos*/
        /*********/
        public function toArray (): array {
            return [
                "id" => $this->getId(),
                "disponibilidad" => $this->getDisponibilidad(),
                "descripcion" => $this->getDescripcion()
            ];
        }

    }

?>