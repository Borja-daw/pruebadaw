<?php
include_once "../DAO/DAOAlmacen.php";
include_once "../Modelo/CajaException.php";
include_once "../Modelo/EstanteriaException.php";
session_start();
try {
    $Inventario = DAOAlmacen::Inventario();//Funcion que obtiene los datos necesarios de la base de datos para hacer el inventario

    if (!empty($Inventario)) {
        $_SESSION['Inventario'] = $Inventario;
        header("Location:../Vistas/VistaInventario.php");//Si lo obtenido de la funcion no esta vacio lleva a la vista del inventario
    }
} catch (CajaException $CE) {
    header("Location:../Vistas/Errores.php?error=$CE");//Notificamos el error
    exit;
} catch (EstanteriaException $EE) {
    header("Location:../Vistas/Errores.php?error=$EE");//Notificamos el error
    exit;
} catch (Exception $E) {
    header("Location:../Vistas/Errores.php?error=$E");//Notificamos el error
    exit;
}