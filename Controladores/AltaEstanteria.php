<?php

//Recogemos los datos
$Vcodigo_est=$_REQUEST['codigo_est'];
$Vnum_lejas=$_REQUEST['lejas'];
$Vmaterial_est=$_REQUEST['material_est'];
$Vlejas_ocupadas = "0";
$Vpasillo=$_REQUEST['pasillo'];
$Vhuecos=$_REQUEST['huecoslibres'];

//Creamos una estanteria
include_once "../Modelo/Estanteria.php";
$Estanteria= new Estanteria($Vcodigo_est, $Vmaterial_est, $Vnum_lejas, $Vlejas_ocupadas, date("y/m/d"), $Vpasillo, $Vhuecos);

include_once '../DAO/DAOAlmacen.php';
include_once "../Modelo/EstanteriaException.php";
$conexion->autocommit(false);
try {
    DAOAlmacen::insertarEstanteria($Estanteria);//Se ejecuta la funcion de DAO con el objeto creado
    $conexion->commit();
    $conexion->autocommit(true);
    header("Location:../Vistas/Mensajes.php?Mensaje=Insercion Correcta");//Se notifica de que todo fue bien
    exit;
} catch (EstanteriaException $EE) {
    $conexion->rollback();
    $conexion->autocommit(true);
    header("Location:../Vistas/Errores.php?error=$EE");//Se manda el error
    exit();
} catch (Exception $E) {
    $conexion->rollback();
    $conexion->autocommit(true);
    header("Location:../Vistas/Errores.php?error=$E");//Se manda el error
    exit();
}