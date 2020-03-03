<?php
include_once '../DAO/Conexion.php';
include_once '../Modelo/CajaBackup.php';
//Miramos si existe y si lo hace, se borra
$borrar="DROP TRIGGER IF EXISTS trigger_devolucion";
$resul=$conexion->query($borrar)or die("Trigger no encontrado");

$codigo=$CajaB->getCodigo_caja();
$material=$CajaB->getMaterial_caja();
$color=$CajaB->getColor();
$alto=$CajaB->getAltura();
$ancho=$CajaB->getAnchura();
$profundidad=$CajaB->getProfundidad();
$contenido=$CajaB->getContenido();
$idestanteria=$CajaB->getId_est();
$leja=$CajaB->getLeja_ocupada();

//Creamos el Trigger
$trigger="CREATE TRIGGER trigger_devolucion
AFTER DELETE ON cajabackup
FOR EACH ROW
BEGIN
INSERT INTO caja VALUES(null,'".$codigo."','".$alto."','".$ancho."','".$profundidad."','".$color."','".$material."','".$contenido."',CURRENT_DATE());
INSERT INTO ocupacion_estanteria VALUES(null,'".$idestanteria."','".$leja."',(SELECT MAX(id_caja) FROM caja));
UPDATE estanteria SET lejas_ocupadas=lejas_ocupadas+1 WHERE id_est='".$idestanteria."';
END";
$resul2=$conexion->query($trigger);
