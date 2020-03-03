<?php
include_once '../DAO/DAOAlmacen.php';
include_once "../Modelo/AlmacenException.php";
session_start();
$usu=$_REQUEST['usu'];
$pass=$_REQUEST['pass'];
try{
    DAOAlmacen::Login($usu,$pass);//Funcion que verifica que los datos introducidos por el administrador coinciden con los datos de la base de datos
    header("Location:../Vistas/Menu.php");
}catch(AlmacenException $AE){
    header("Location:../Vistas/ErrorLogin.php?error=$AE");//Notificamos el error
    exit;
}catch (Exception $E) {
    header("Location:../Vistas/ErrorLogin.php?error=$E");//Notificamos el error
    exit;
}