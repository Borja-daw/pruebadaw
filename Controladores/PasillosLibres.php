<?php
include_once '../DAO/DAOAlmacen.php';
session_start();
try{
    $pasillosdisponibles= DAOAlmacen::pasillosLibres();//Funcion que obtendrá los pasillos que estan en la base de datos y que tienen huecos disponibles
    if(!empty($pasillosdisponibles)){
    $_SESSION['PasillosLibres']=$pasillosdisponibles;
    header("Location:../Vistas/VistaAltaEstanteria.php");//Con los datos obtenidos de la funcion, redireccionamos a la vista que mostrará los pasillos para que el usuario señale en cual se colocará la estanteria
    }   
}catch(EstanteriaException $EE){
    header("Location:../Vistas/Errores.php?error=$EE");//Notificamos el error
    exit;
}catch (Exception $E) {
    header("Location:../Vistas/Errores.php?error=$E");//Notificamos el error
    exit;
}
