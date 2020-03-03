<?php
include_once '../DAO/DAOAlmacen.php';
include_once "../Modelo/AlmacenException.php";
session_start();
try{
    $resul= DAOAlmacen::DetectarUsuario();//Funcion que accede a la base de datos y mira si hay ya un administrador registrado, si lo hay, devuelve 1 y lo manda al login; si no lo hay, devuelve 0 y lo manda a la vista de registro
    if($resul==0){
    header("Location:../Vistas/VistaRegistro.php");
    }elseif($resul==1){
    header("Location:../Vistas/VistaLogin.php");
    }
}catch(AlmacenException $AE){
    header("Location:../Vistas/Errores.php?error=$AE");//Notificamos el error
    exit;
}catch (Exception $E) {
    header("Location:../Vistas/Errores.php?error=$E");//Notificamos el error
    exit;
}