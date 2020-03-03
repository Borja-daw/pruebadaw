<?php
include_once '../DAO/DAOAlmacen.php';
include_once "../Modelo/EstanteriaException.php";
session_start();
//Obtenemos el codigo de la caja que vamos a borrar
$Vcodigoest = $_REQUEST['codigoest'];
$Estanteria = new Estanteria($Vcodigoest, null, null, null, null, null, null);
try {
    DAOAlmacen::BorrarEstanteria($Estanteria);//Mandamos a DAO una estanteria con el codigo obtenido para poder identificarla en la base de datos y borrarla
    $conexion->commit();
    $conexion->autocommit(true);
    header("Location:../Vistas/Mensajes.php?Mensaje=Borrado Correcto");//Mandamos un mensaje de que todo fue bien
    exit;
} catch (EstanteriaException $EE) {
    $conexion->rollback();
    $conexion->autocommit(true);
    header("Location:../Vistas/Errores.php?error=$EE");//Se notifica el error
    exit;
} catch (Exception $E) {
    $conexion->rollback();
    $conexion->autocommit(true);
    header("Location:../Vistas/Errores.php?error=$E");//Se notifica el error
    exit;
}