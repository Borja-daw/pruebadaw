<?php
include_once '../DAO/DAOAlmacen.php';
include_once "../Modelo/EstanteriaException.php";
session_start();
try{
    $estanteriasdisponibles= DAOAlmacen::estanteriasLibres();//Funcion que obtendrá el id y el codigo de las estanterias que estan en la base de datos y tienen lejas disponibles
    if(!empty($estanteriasdisponibles)){
    $_SESSION['EstanteriasLibres']=$estanteriasdisponibles;
    header("Location:../Vistas/VistaAltaCaja.php");//Con los datos obtenidos de la funcion, redireccionamos a la vista que mostrará los codigos para que el usuario señale en que estantería se pondrá la caja
    }
}catch(EstanteriaException $EE){
    header("Location:../Vistas/Errores.php?error=$EE");//Notificamos el error
    exit;
}catch (Exception $E) {
    header("Location:../Vistas/Errores.php?error=$E");//Notificamos el error
    exit;
}
