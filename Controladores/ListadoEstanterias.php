<?php
include "../DAO/DAOAlmacen.php";
include_once "../Modelo/EstanteriaException.php";
session_start();
try{
    $ArrayEst=DAOAlmacen::listadoEstanterias();//Funcion que obtiene datos de las estanterias en la base de datos para luego hacer un listado de ellas
    if(!empty($ArrayEst)){
        $_SESSION['$ArrayEst']=$ArrayEst;
        header("Location:../Vistas/VistaListadoEstanterias.php");
    }
} catch (EstanteriaException $EE) {
    header("Location:../Vistas/Errores.php?error=$EE");//Notificamos el error
    exit;
} catch (Exception $E) {
    header("Location:../Vistas/Errores.php?error=$E");//Notificamos el error
    exit;
}