<?php

class Pasillo {
   private $id_pasillo;
   private $letra_pasillo;
   private $huecos_ocupados;
   
   function __construct($letra_pasillo, $huecos_ocupados) {
      $this->setLetra_pasillo($letra_pasillo);
        $this->setHuecos_Ocupados($huecos_ocupados);
   }
   function setId_pasillo($id_pasillo) {
       $this->id_pasillo = $id_pasillo;
   }

   function setLetra_pasillo($letra_pasillo) {
       $this->letra_pasillo = $letra_pasillo;
   }

   function setHuecos_ocupados($huecos_ocupados) {
       $this->huecos_ocupados = $huecos_ocupados;
   }
   
   function getId() {
       return $this->id;
   }

   function getLetra_pasillo() {
       return $this->letra_pasillo;
   }

   function getHuecos_ocupados() {
       return $this->huecos_ocupados;
   }

   public function __toString() {
        return "Id pasillo: " .$this->id_pasillo.
               " Letra pasillo: " .$this->letra_pasillo.
               " Huecos pasillos: " .$this->huecos_ocupados;

   }

}