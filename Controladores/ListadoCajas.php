<?php
include "../DAO/DAOAlmacen.php";
include_once "../Modelo/CajaException.php";
session_start();
try{
    $ArrayCajas=DAOAlmacen::listadoCajas();//Funcion que obtiene datos de las cajas en la base de datos para luego hacer un listado de ellas
    if(!empty($ArrayCajas)){
        $_SESSION['$ArrayCajas']=$ArrayCajas;
        header("Location:../Vistas/VistaListadoCajas.php");
    }
} catch (CajaException $EE) {
    header("Location:../Vistas/Errores.php?error=$EE");//Notificamos el error
    exit;
} catch (Exception $E) {
    header("Location:../Vistas/Errores.php?error=$E");//Notificamos el error
    exit;
}