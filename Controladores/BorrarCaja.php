<?php
include_once '../DAO/DAOAlmacen.php';
include_once "../Modelo/CajaException.php";
session_start();
//Obtenemos el codigo de la caja que vamos a borrar
$Vcodigocaja = $_REQUEST['codigocaja'];
$Caja = new Caja($Vcodigocaja, null, null, null, null, null, null, null);
try {
    DAOAlmacen::BorrarCaja($Caja);//Mandamos a DAO una caja con el codigo obtenido para poder identificarla en la base de datos y borrarla
    $conexion->commit();
    $conexion->autocommit(true);
    header("Location:../Vistas/Mensajes.php?Mensaje=Borrado Correcto");//Mandamos un mensaje de que todo fue bien
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