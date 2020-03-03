<?php
include_once '../DAO/DAOAlmacen.php';
include_once "../Modelo/CajaException.php";
session_start();
$Vcodigo_caja=$_REQUEST['caja'];//Obtenemos el codigo de la caja señalada por el usuario
$Caja = new Caja($Vcodigo_caja, null, null, null, null, null, null, null);
$Ocupacion = new OcupacionEstanteria(null, null);
try{
    $cajamostrar= DAOAlmacen::mostrarCaja($Caja);//Mostramos los datos de caja segun el codigo señalado en la vista
    if(!empty($cajamostrar)){
    $_SESSION['cajamostrar']=$cajamostrar;
    header("Location:../Vistas/VistaMostrarCaja.php");//Redirigimos a una vista que mostrará los datos de la caja en una tabla y pedirá la confirmación para su borrado
    }
}catch(CajaException $CE){
    header("Location:../Vistas/Errores.php?error=$CE");//Notificamos el error
    exit;
}catch (Exception $E) {
    header("Location:../Vistas/Errores.php?error=$E");//Notificamos el error
    exit;
}