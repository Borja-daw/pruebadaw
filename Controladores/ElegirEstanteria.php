<?php
include_once '../DAO/DAOAlmacen.php';
include_once "../Modelo/EstanteriaException.php";
session_start();
try{
    $estdisponibles= DAOAlmacen::listadoEstanterias();//Obtenemos un listado de estanterias para que aparezcan sus respectivos codigos en la vista y asi señalar cual borrar
    if(!empty($estdisponibles)){
    $_SESSION['Est']=$estdisponibles;
    header("Location:../Vistas/VistaElegirEstanteria.php");//Redirigimos a la vista
    }
}catch(EstanteriaException $EE){
    header("Location:../Vistas/Errores.php?error=$EE");//Notificamos el error
    exit;
}catch (Exception $E) {
    header("Location:../Vistas/Errores.php?error=$E");//Notificamos el error
    exit;
}