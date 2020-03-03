<?php

session_start();
//Recogemos los datos
$Vcodigo_caja = $_REQUEST['codigo_caja'];
$Valtura = $_REQUEST['altura'];
$Vanchura = $_REQUEST['anchura'];
$Vprofundidad = $_REQUEST['profundidad'];
$Vcolor = $_REQUEST['color'];
$Vmaterial_caja = $_REQUEST['material_caja'];
$Vcontenido = $_REQUEST['contenido'];
$VEstanteria = $_REQUEST['estanteria'];
$VLeja = $_REQUEST['lejaslibres'];

//Crear Caja
include_once '../Modelo/Caja.php';
include_once '../Modelo/OcupacionEstanteria.php';
$Caja = new Caja($Vcodigo_caja, $Valtura, $Vanchura, $Vprofundidad, $Vcolor, $Vmaterial_caja, $Vcontenido, date("y/m/d"));
$Ocupacion = new OcupacionEstanteria($VEstanteria, $VLeja);

include_once '../DAO/DAOAlmacen.php';
include_once '../Modelo/CajaException.php';
$conexion->autocommit(false);
try {
    DAOAlmacen::insertarCaja($Caja, $Ocupacion);//Se ejecuta la funcion de DAO con los objetos creados
    $conexion->commit();
    $conexion->autocommit(true);
    header("Location:../Vistas/Mensajes.php?Mensaje=Insercion Correcta");//Mandamos un mensaje de que todo fue bien
    exit;
} catch (CajaException $CE) {
    $conexion->rollback();
    $conexion->autocommit(true);
    header("Location:../Vistas/Errores.php?error=$CE");//Se notifica el error
    exit;
} catch (Exception $E) {
    $conexion->rollback();
    $conexion->autocommit(true);
    header("Location:../Vistas/Errores.php?error=$E");//Se notifica el error
    exit;
}
