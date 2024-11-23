<?php

    namespace app\core\model\dto;

    use app\core\model\base\InterfaceDTO;

    final class ProveedorDTO implements InterfaceDTO {

        private $id, $nombre, $telefono, $email, $direccion;

        public function __construct ($data = []) {
            $this->setId($data["id"] ?? 0);
            $this->setNombre($data["nombre"] ?? "");
            $this->setTelefono($data["telefono"] ?? "");
            $this->setEmail($data["email"] ?? "");
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
            $this->nombre = (preg_match('/^[\p{L}\s.]{1,45}$/u', $nombre)) ? $nombre : "";
        }

        public function setTelefono ($telefono): void {
            $this->telefono = (preg_match('/^[\+\d\(\)\-\s]{10,45}$/', $telefono)) ? $telefono : "";
        }

        public function setEmail ($email): void {
            $this->email = filter_var($email, FILTER_VALIDATE_EMAIL) ? $email : "";
        }

        public function setDireccion ($direccion): void {
            $this->direccion = (preg_match('/^[\p{L}\p{N}\s,.]{1,150}$/u', $direccion)) ? $direccion : "";
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
                "direccion" => $this->getDireccion()
            ];
        }

    }

?>