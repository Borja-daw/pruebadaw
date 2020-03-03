<?php
@$conexion = new mysqli("localhost", "root", "");

$conexion->set_charset("utf8");

if(!$conexion->connect_errno){
    echo "<h2>conexion establecida</h2>";
    $conexion->select_db("almacen") or die("base de datos no encontrada");
    echo "<h2>conexion establecida con la base de datos almacen</h2>";
}else{
    echo "<h2>No ha sido posible conectar con el servidor</h2>";
}

?>