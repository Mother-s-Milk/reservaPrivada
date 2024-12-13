<?php

    namespace app\core\model\dto;

    use app\core\model\base\InterfaceDTO;

    final class ProveedorDTO implements InterfaceDTO {

        private $id, $nombre, $telefono, $email, $localidad, $direccion;

        public function __construct ($data = []) {
            $this->setId($data["id"] ?? 0);
            $this->setNombre($data["nombre"] ?? "");
            $this->setTelefono($data["telefono"] ?? "");
            $this->setEmail($data["email"] ?? "");
            $this->setLocalidad($data["localidad"] ?? "");
            $this->setDireccion($data["direccion"] ?? "");
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

        public function getTelefono (): string {
            return $this->telefono;
        }

        public function getEmail (): string {
            return $this->email;
        }

        public function getLocalidad (): string {
            return $this->localidad;
        }

        public function getDireccion (): string {
            return $this->direccion;
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

        public function setTelefono ($telefono): void {
            $this->telefono = (is_string($telefono) && strlen(trim($telefono)) <= 45) ? trim($telefono) : "";
        }

        public function setEmail ($email): void {
            $this->email = filter_var($email, FILTER_VALIDATE_EMAIL) ? $email : "";
        }

        public function setLocalidad ($localidad): void {
            $this->localidad = (is_string($localidad) && strlen(trim($localidad)) <= 90) ? trim($localidad) : "";
        }

        public function setDireccion ($direccion): void {
            $this->direccion = (is_string($direccion) && strlen(trim($direccion)) <= 90) ? trim($direccion) : "";
        }

        /*********/
        /*Metodos*/
        /*********/
        public function toArray (): array {
            return [
                "id" => $this->getId(),
                "nombre" => $this->getNombre(),
                "telefono" => $this->getTelefono(),
                "email" => $this->getEmail(),
                "localidad" => $this->getLocalidad(),
                "direccion" => $this->getDireccion()
            ];
        }

    }

?>