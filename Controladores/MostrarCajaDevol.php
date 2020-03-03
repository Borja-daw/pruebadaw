<?php
include_once '../DAO/DAOAlmacen.php';
include_once "../Modelo/CajaException.php";
session_start();
$Vcodigo_caja=$_REQUEST['caja'];//Obtenemos el codigo de la caja señalada por el usuario
$CajaB = new CajaBackup($Vcodigo_caja, null, null, null, null, null, null, null, null, null, null);
try{
    $cajamostrar= DAOAlmacen::mostrarCajaBackup($CajaB);//Mostramos los datos de caja segun el codigo señalado en la vista
    $estanteriasdisponibles= DAOAlmacen::estanteriasLibres();//Funcion que obtendrá el id y el codigo de las estanterias que estan en la base de datos y tienen lejas disponibles
    if(!empty($cajamostrar && $estanteriasdisponibles)){
    $_SESSION['EstanteriasLibres']=$estanteriasdisponibles;
    $_SESSION['cajamostrar']=$cajamostrar;
    header("Location:../Vistas/VistaMostrarCajaDevol.php");//Redirigimos a una vista que mostrará los datos de la caja en una tabla y pedirá la confirmación para su devolución
    }
}catch(CajaException $CE){
    header("Location:../Vistas/Errores.php?error=$CE");//Notificamos el error
    exit;
}catch (Exception $E) {
    header("Location:../Vistas/Errores.php?error=$E");//Notificamos el error
    exit;
}