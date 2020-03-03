<?php
include_once '../DAO/DAOAlmacen.php';
include_once "../Modelo/AlmacenException.php";
session_start();
$usu=$_REQUEST['usu'];
$pass=$_REQUEST['pass'];
try{
    DAOAlmacen::Registrar($usu,$pass);//Funcion que registra los datos introducidos por el administrador en la base de datos, codificando la contraseña
    header("Location:../Controladores/Inicio.php");
    
}catch(AlmacenException $AE){
    header("Location:../Vistas/ErrorLogin.php?error=$AE");//Notificamos el error
    exit;
}catch (Exception $E) {
    header("Location:../Vistas/ErrorLogin.php?error=$E");//Notificamos el error
    exit;
}