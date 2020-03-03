<?php
include_once '../DAO/DAOAlmacen.php';
include_once "../Modelo/EstanteriaException.php";
session_start();
$Vcodigo_est=$_REQUEST['estanteria'];//Obtenemos el codigo de la estanteria señalada por el usuario
$Est = new Estanteria($Vcodigo_est, null, null, null, null, null, null);
try{
    $estmostrar= DAOAlmacen::mostrarEst($Est);//Mostramos los datos de estanteria segun el codigo señalado en la vista
    if(!empty($estmostrar)){
    $_SESSION['estmostrar']=$estmostrar;
    header("Location:../Vistas/VistaMostrarEstanteria.php");//Redirigimos a una vista que mostrará los datos de la estanteria en una tabla y pedirá la confirmación para su borrado
    }
}catch(EstanteriaException $EE){
    header("Location:../Vistas/Errores.php?error=$EE");//Notificamos el error
    exit;
}catch (Exception $E) {
    header("Location:../Vistas/Errores.php?error=$E");//Notificamos el error
    exit;
}