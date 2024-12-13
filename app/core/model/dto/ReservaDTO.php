<?php

    namespace app\core\model\dto;

    use app\core\model\base\InterfaceDTO;

    final class ReservaDTO implements InterfaceDTO {

        private $id, $apellido, $nombres, $telefono, $fecha, $hora, $personas, $detalles, $estado;

        private const ESTADOS_VALIDOS = ['Pendiente', 'Confirmada', 'Cancelada'];

        public function __construct ($data = []) {
            $this->setId($data["id"] ?? 0);
            $this->setApellido($data["apellido"] ?? "");
            $this->setNombres($data["nombres"] ?? "");
            $this->setTelefono($data["telefono"] ?? "");
            $this->setFecha($data["fecha"] ?? "");
            $this->setHora($data["hora"] ?? "");
            $this->setPersonas($data["personas"] ?? 0);
            $this->setDetalles($data["detalles"] ?? "");
            $this->setEstado($data["estado"] ?? "");
        }

        /*********/
        /*Getters*/
        /*********/
        public function getId (): int {
            return $this->id;
        }

        public function getApellido (): string {
            return $this->apellido;
        }

        public function getNombres (): string {
            return $this->nombres;
        }

        public function getTelefono (): string {
            return $this->telefono;
        }

        public function getFecha (): string {
            return $this->fecha;
        }

        public function getHora (): string {
            return $this->hora;
        }

        public function getPersonas (): int {
            return $this->personas;
        }

        public function getDetalles (): string {
            return $this->detalles;
        }

        public function getEstado (): string {
            return $this->estado;
        }

        /*********/
        /*Setters*/
        /*********/
        public function setId ($id): void {
            $this->id = (is_integer($id) && $id > 0) ? $id : 0;
        }

        public function setApellido ($apellido): void {
            $this->apellido = (is_string($apellido) && strlen(trim($apellido)) <= 45) ? trim($apellido) : "";
        }

        public function setNombres ($nombres): void {
            $this->nombres = (is_string($nombres) && strlen(trim($nombres)) <= 60) ? trim($nombres) : "";
        }

        public function setTelefono ($telefono): void {
            $this->telefono = (is_string($telefono) && strlen(trim($telefono)) <= 45) ? $telefono : "";
        }

        public function setFecha ($fecha): void {
            $this->fecha = (is_string($fecha) && strlen(trim($fecha)) <= 30) ? $fecha : "";
        }

        public function setHora ($hora): void {
            $this->hora = (is_string($hora) && strlen(trim($hora)) <= 30) ? $hora : "";
        }

        public function setPersonas ($personas): void {
            $this->personas = (is_integer($personas) && $personas > 0) ? $personas : 0;
        }

        public function setDetalles ($detalles): void {
            $this->detalles = (is_string($detalles) && strlen(trim($detalles)) <= 90) ? trim($detalles) : "";
        }

        public function setEstado ($estado): void {
            $this->estado = in_array($estado, self::ESTADOS_VALIDOS, true) ? $estado : 'Pendiente';
        }

        /*********/
        /*Metodos*/
        /*********/
        public function toArray (): array {
            return [
                "id" => $this->getId(),
                "apellido" => $this->getApellido(),
                "nombres" => $this->getNombres(),
                "telefono" => $this->getTelefono(),
                "fecha" => $this->getFecha(),
                "hora" => $this->getHora(),
                "personas" => $this->getPersonas(),
                "detalles" => $this->getDetalles(),
                "estado" => $this->getEstado()
            ];
        }

    }

?>