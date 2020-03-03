<?php

class OcupacionEstanteria{
    private $id_oe;
    private $idestanteria;
    private $leja;
    private $idcaja;
    
    function __construct($idestanteria, $leja) {
        $this->setIdestanteria($idestanteria);
        $this->setLeja($leja);
    }
    
    function getId_oe() {
        return $this->id_oe;
    }

    function getIdestanteria() {
        return $this->idestanteria;
    }

    function getLeja() {
        return $this->leja;
    }

    function getIdcaja() {
        return $this->idcaja;
    }

    function setId_oe($id_oe) {
        $this->id_oe = $id_oe;
    }

    function setIdestanteria($idestanteria) {
        $this->idestanteria = $idestanteria;
    }

    function setLeja($leja) {
        $this->leja = $leja;
    }

    function setIdcaja($idcaja) {
        $this->idcaja = $idcaja;
    }

    public function __toString() {
        return "Id: " .$this->id_oe .
               " Id de estanteria: " .$this->idestanteria .
               " Leja ocupada: " .$this->leja .
               " Id de caja: " .$this->idcaja;
    }

}