<?php

class Estanteria {

    private $id_est;
    private $codigo_est;
    private $material_est;
    private $num_lejas;
    private $lejas_ocupadas;
    private $fecha_alta_est;
    private $pasillo;
    private $numero;

    function __construct($codigo_est, $material_est, $num_lejas, $lejas_ocupadas, $fecha_alta_est, $pasillo, $numero) {
        $this->setCodigo_est($codigo_est);
        $this->setMaterial_est($material_est);
        $this->setNum_lejas($num_lejas);
        $this->setLejas_ocupadas($lejas_ocupadas);
        $this->setFecha_alta_est($fecha_alta_est);
        $this->setPasillo($pasillo);
        $this->setNumero($numero);
    }

    function getId_est() {
        return $this->id_est;
    }

    function setId_est($id_est) {
        $this->id_est = $id_est;
    }

    function getCodigo_est() {
        return $this->codigo_est;
    }

    function getMaterial_est() {
        return $this->material_est;
    }

    function getNum_lejas() {
        return $this->num_lejas;
    }

    function getLejas_ocupadas() {
        return $this->lejas_ocupadas;
    }

    function getFecha_alta_est() {
        return $this->fecha_alta_est;
    }

    function getPasillo() {
        return $this->pasillo;
    }

    function getNumero() {
        return $this->numero;
    }

    function setCodigo_est($codigo_est) {
        $this->codigo_est = $codigo_est;
    }

    function setMaterial_est($material_est) {
        $this->material_est = $material_est;
    }

    function setNum_lejas($num_lejas) {
        $this->num_lejas = $num_lejas;
    }

    function setLejas_ocupadas($lejas_ocupadas) {
        $this->lejas_ocupadas = $lejas_ocupadas;
    }

    function setFecha_alta_est($fecha_alta_est) {
        $this->fecha_alta_est = $fecha_alta_est;
    }

    function setPasillo($pasillo) {
        $this->pasillo = $pasillo;
    }

    function setNumero($numero) {
        $this->numero = $numero;
    }

    public function __toString() {
        return "Codigo :" . $this->codigo_est .
                "  Material :" . $this->material_est .
                "  Num_Lejas :" . $this->num_lejas .
                "  Lejas_Ocupadas :" . $this->lejas_ocupadas .
                "  Fecha_Alta :" . $this->fecha_alta_est .
                "  Pasillo :" . $this->pasillo .
                "  Numero :" . $this->numero . "<br>";
    }

}
