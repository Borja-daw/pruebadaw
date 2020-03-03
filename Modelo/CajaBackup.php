<?php

class CajaBackup extends Caja {
    private $fecha_baja_caja;
    private $id_est;
    private $leja_ocupada;
    
    public function __construct($codigo_caja, $altura, $anchura, $profundidad, $color, $material_caja, $contenido, $fecha_alta_caja, $fecha_baja_caja, $id_est, $leja_ocupada) {
        parent::__construct($codigo_caja, $altura, $anchura, $profundidad, $color, $material_caja, $contenido, $fecha_alta_caja);
        $this->fecha_baja_caja = $fecha_baja_caja;
        $this->id_est = $id_est;
        $this->leja_ocupada = $leja_ocupada;
    }
    function getFecha_baja_caja() {
        return $this->fecha_baja_caja;
    }

    function getId_est() {
        return $this->id_est;
    }

    function getLeja_ocupada() {
        return $this->leja_ocupada;
    }

    function setFecha_baja_caja($fecha_baja_caja) {
        $this->fecha_baja_caja = $fecha_baja_caja;
    }

    function setId_est($id_est) {
        $this->id_est = $id_est;
    }

    function setLeja_ocupada($leja_ocupada) {
        $this->leja_ocupada = $leja_ocupada;
    }


}
