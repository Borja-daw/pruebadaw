<?php

class Caja {

    private $id;
    private $codigo_caja;
    private $altura;
    private $anchura;
    private $profundidad;
    private $color;
    private $material_caja;
    private $contenido;
    private $fecha_alta_caja;

    function __construct($codigo_caja, $altura, $anchura, $profundidad, $color, $material_caja, $contenido, $fecha_alta_caja) {
        $this->setCodigo_caja($codigo_caja);
        $this->setAltura($altura);
        $this->setAnchura($anchura);
        $this->setProfundidad($profundidad);
        $this->setColor($color);
        $this->setMaterial_caja($material_caja);
        $this->setContenido($contenido);
        $this->setFecha_alta_caja($fecha_alta_caja);
    }
    function getId() {
        return $this->id;
    }

    function setId($id) {
        $this->id = $id;
    }
    
    function getCodigo_caja() {
        return $this->codigo_caja;
    }

    function getAltura() {
        return $this->altura;
    }

    function getAnchura() {
        return $this->anchura;
    }

    function getProfundidad() {
        return $this->profundidad;
    }

    function getColor() {
        return $this->color;
    }

    function getMaterial_caja() {
        return $this->material_caja;
    }

    function getContenido() {
        return $this->contenido;
    }

    function getFecha_alta_caja() {
        return $this->fecha_alta_caja;
    }

    function setCodigo_caja($codigo_caja) {
        $this->codigo_caja = $codigo_caja;
    }

    function setAltura($altura) {
        $this->altura = $altura;
    }

    function setAnchura($anchura) {
        $this->anchura = $anchura;
    }

    function setProfundidad($profundidad) {
        $this->profundidad = $profundidad;
    }

    function setColor($color) {
        $this->color = $color;
    }

    function setMaterial_caja($material_caja) {
        $this->material_caja = $material_caja;
    }

    function setContenido($contenido) {
        $this->contenido = $contenido;
    }

    function setFecha_alta_caja($fecha_alta_caja) {
        $this->fecha_alta_caja = $fecha_alta_caja;
    }

    public function __toString() {
        return "Codigo :" . $this->codigo_caja .
                "  Altura :" . $this->altura .
                "  Anchura :" . $this->anchura .
                "  Profundidad :" . $this->profundidad .
                "  Color :" . $this->color .
                "  Material :" . $this->material_caja .
                "  Contenido :" . $this->contenido .
                "  Fecha_Alta :" . $this->fecha_alta_caja . "<br>";
    }

}
