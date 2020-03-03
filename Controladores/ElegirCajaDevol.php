<?php
include_once '../DAO/DAOAlmacen.php';
include_once "../Modelo/CajaException.php";
session_start();
try{
    $cajasdisponibles= DAOAlmacen::listadoCajasDevol();//Obtenemos un listado de cajas para que aparezcan sus respectivos codigos en la vista y asi señalar cual devolver
    if(!empty($cajasdisponibles)){
    $_SESSION['Cajas']=$cajasdisponibles;
    header("Location:../Vistas/VistaDevolucion.php");//Redirigimos a la vista
    }
}catch(CajaException $CE){
    header("Location:../Vistas/Errores.php?error=$CE");//Notificamos el error
    exit;
}catch (Exception $E) {
    header("Location:../Vistas/Errores.php?error=$E");//Notificamos el error
    exit;
}