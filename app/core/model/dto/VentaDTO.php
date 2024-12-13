<?php

namespace app\core\model\dto;

use app\core\model\base\InterfaceDTO;

final class VentaDTO implements InterfaceDTO {

    private $id, $fecha, $hora, $detalles;

    public function __construct($data = []) {
        $this->setId($data["id"] ?? 0);
        $this->setFecha($data["fecha"] ?? "");
        $this->setHora($data["hora"] ?? "");
        $this->setDetalles($data["detalles"] ?? []);
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

    public function getDetalles (): array {
        return $this->detalles;
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
        $this->hora = (is_string($hora) && preg_match("/^([01]?[0-9]|2[0-3]):[0-5][0-9]$/", $hora)) ? $hora : "";
    }

    public function setDetalles ($detalles): void {
        $this->detalles = is_array($detalles) ? $detalles : [];
    }

    /*********/
    /*Metodos*/
    /*********/
    public function toArray(): array {
        /*$detallesArray = [];
        foreach ($this->getDetalles() as $detalle) {
            // Asegúrate de que el detalle tenga el método toArray() implementado
            $detallesArray[] = $detalle->toArray();  
        }*/

        return [
            "id" => $this->getId(),
            "fecha" => $this->getFecha(),
            "hora" => $this->getHora(),
            "detalles" => $this->getDetalles()
            //"detalles" => $detallesArray
        ];
    }
}

?>