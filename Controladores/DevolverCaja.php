<?php
include_once '../DAO/DAOAlmacen.php';
include_once "../Modelo/EstanteriaException.php";
include_once "../Modelo/CajaException.php";
session_start();
//Obtenemos el codigo de la caja que vamos a devolver
$Vcodigocaja = $_REQUEST['codigocaja'];
$VEstanteria = $_REQUEST['estanteria'];
$VLeja = $_REQUEST['lejaslibres'];
$Caja = new CajaBackup($Vcodigocaja, null, null, null, null, null, null, null, null, $VEstanteria, $VLeja);
try {
    DAOAlmacen::DevolverCaja($Caja);//Mandamos a DAO una caja de tipo cajabackup con el codigo obtenido para poder identificarla en la base de datos y devolverla de la tabla cajabackup a la tabla caja
    $conexion->commit();
    $conexion->autocommit(true);
    header("Location:../Vistas/Mensajes.php?Mensaje=Devolución Correcta");//Mandamos un mensaje de que todo fue bien
    exit;
} catch (CajaException $CE) {
    $conexion->rollback();
    $conexion->autocommit(true);
    header("Location:../Vistas/Errores.php?error=$CE");//Se notifica el error
    exit;
}catch(EstanteriaException $EE){
    header("Location:../Vistas/Errores.php?error=$EE");//Notificamos el error
    exit;
}catch (Exception $E) {
    $conexion->rollback();
    $conexion->autocommit(true);
    header("Location:../Vistas/Errores.php?error=$E");//Se notifica el error
    exit;
}