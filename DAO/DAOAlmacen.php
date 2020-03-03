<?php

include "Conexion.php";
include_once "../Modelo/Caja.php";
include_once "../Modelo/CajaBackup.php";
include_once "../Modelo/Estanteria.php";
include_once "../Modelo/Pasillo.php";
include_once "../Modelo/OcupacionEstanteria.php";
include_once "../Modelo/CajaException.php";
include_once "../Modelo/EstanteriaException.php";

class DAOAlmacen {

    public function insertarCaja($OCaja, $Ocupacion) {
        global $conexion;

        //Obtenemos los datos de los objetos
        $codigo_caja = $OCaja->getCodigo_caja();
        $altura = $OCaja->getAltura();
        $anchura = $OCaja->getAnchura();
        $profundidad = $OCaja->getProfundidad();
        $color = $OCaja->getColor();
        $material_caja = $OCaja->getMaterial_caja();
        $contenido = $OCaja->getContenido();
        $fecha_alta_caja = $OCaja->getFecha_alta_caja();
        $idEstanteria = $Ocupacion->getIdestanteria();
        $leja = $Ocupacion->getLeja();

        //Obtenemos el ID de la ultima caja para ponerle el siguiente numero a la nueva caja. Si no hay cajas se le pone el 1 
        $buscarIdC = "SELECT id_caja FROM caja ORDER BY id_caja DESC LIMIT 1";
        $resultadoIdC = $conexion->query($buscarIdC);
        if ($resultadoIdC->num_rows == 1) {
            $fila = $resultadoIdC->fetch_assoc();
            $id_caja = $fila['id_caja'] + 1;
        } else {
            $id_caja = 1;
        }

        //Comprobamos que se han introducido todo los datos
        if (!$id_caja || !$codigo_caja || !$altura || !$anchura || !$profundidad || !$color || !$material_caja || !$contenido || !$fecha_alta_caja) {
            $mensaje = $conexion->error;
            $codigo = $conexion->errno;
            $lugar = "Faltan datos por poner";
            throw new CajaException($mensaje, $codigo, $lugar);
        }

        //Insertamos la caja en su tabla
        $ordenSQL = "INSERT INTO caja VALUES(?,?,?,?,?,?,?,?,?)";
        $sentencia = $conexion->prepare($ordenSQL);
        $sentencia->bind_param("issssssss", $id_caja, $codigo_caja, $altura, $anchura, $profundidad, $color, $material_caja, $contenido, $fecha_alta_caja);
        $sentencia->execute();

        if ($sentencia->affected_rows == 1) {

            //Al igual que antes obtenemos el ID de la ultima ocupacion para ponerle el siguiente numero a la nueva. Si no hay se le pone el 1 
            $buscarIdOc = "SELECT id_oe FROM ocupacion_estanteria ORDER BY id_oe DESC LIMIT 1";
            $resultadoIdOc = $conexion->query($buscarIdOc);
            if ($resultadoIdOc->num_rows == 1) {
                $fila = $resultadoIdOc->fetch_assoc();
                $id_OE = $fila['id_oe'] + 1;
            } else {
                $id_OE = 1;
            }

            //Insertamos los datos en la tabla ocupacion
            $orden = "INSERT INTO ocupacion_estanteria VALUES(?,?,?,?)";
            $sentencia1 = $conexion->prepare($orden);
            $sentencia1->bind_param("iiii", $id_OE, $idEstanteria, $leja, $id_caja);
            $sentencia1->execute();

            if ($sentencia1->affected_rows == 1) {

                //Actualizamos las lejas ocupadas de la estanteria
                $sql = "UPDATE estanteria SET lejas_ocupadas=lejas_ocupadas+1 WHERE id_est='$idEstanteria'";
                $sentencia2 = $conexion->query($sql);

                if ($sentencia2 == 1) {
                    return;
                } else {
                    $mensaje = $conexion->error;
                    $codigo = $conexion->errno;
                    $lugar = "No se ha podido realizar el Update de Estanteria -> insertarCaja()";
                    throw new EstanteriaException($mensaje, $codigo, $lugar);
                }
            } else {
                $mensaje = $conexion->error;
                $codigo = $conexion->errno;
                $lugar = "No se ha podido insertar la fila de Ocupacion -> insertarCaja()";
                throw new CajaException($mensaje, $codigo, $lugar);
            }
        } else {
            $mensaje = $conexion->error;
            $codigo = $conexion->errno;
            $lugar = "No se ha podido insertar la caja en la base de datos -> en insertarCaja()";
            throw new CajaException($mensaje, $codigo, $lugar);
        }
    }

    public function insertarEstanteria($OEstanteria) {
        global $conexion;

        //Obtenemos los datos de la estanteria
        $codigo_est = $OEstanteria->getCodigo_est();
        $material_est = $OEstanteria->getMaterial_est();
        $num_lejas = $OEstanteria->getNum_lejas();
        $lejas_ocupadas = $OEstanteria->getLejas_ocupadas();
        $fecha_alta_est = $OEstanteria->getFecha_alta_est();
        $pasillo = $OEstanteria->getPasillo();
        $numero = $OEstanteria->getNumero();

        //Obtenemos el ID de la ultima estanteria para ponerle el siguiente numero a la nueva. Si no hay estanterias se le pone el 1 
        $buscarIdE = "SELECT id_est FROM estanteria ORDER BY id_est DESC LIMIT 1";
        $resultadoIdE = $conexion->query($buscarIdE);
        if ($resultadoIdE->num_rows == 1) {
            $fila = $resultadoIdE->fetch_assoc();
            $id_est = $fila['id_est'] + 1;
        } else {
            $id_est = 1;
        }

        //Comprobamos que se han escrito todos los datos
        if (!$id_est || !$codigo_est || !$material_est || !$num_lejas || !$pasillo || !$numero) {
            $mensaje = $conexion->error;
            $codigo = $conexion->errno;
            $lugar = "Faltan datos";
            throw new EstanteriaException($mensaje, $codigo, $lugar);
        }

        //Introducimos la estanteria en la tabla
        $ordenSQL = "INSERT INTO estanteria VALUES(?,?,?,?,?,?,?,?)";
        $sentencia = $conexion->prepare($ordenSQL);
        $sentencia->bind_param("isssssss", $id_est, $codigo_est, $material_est, $num_lejas, $lejas_ocupadas, $fecha_alta_est, $pasillo, $numero);
        $sentencia->execute();

        if ($sentencia->affected_rows == 1) {
            //Actualizamos la tabla pasillo para añadir un hueco ocupado
            $sql = "UPDATE pasillo SET huecos_pasillo = huecos_pasillo +1 WHERE id_pasillo='$pasillo'";
            $sentencia1 = $conexion->query($sql);

            if ($sentencia1 == 1) {
                return;
            } else {
                $mensaje = $conexion->error;
                $codigo = $conexion->errno;
                $lugar = "No se ha podido realizar el Update de Pasillo -> insertarEstanteria()";
                throw new EstanteriaException($mensaje, $codigo, $lugar);
            }
        } else {
            $mensaje = $conexion->error;
            $codigo = $conexion->errno;
            $lugar = "No se ha podido insertar la estanteria en la base de datos -> insertarEstanteria()";
            throw new EstanteriaException($mensaje, $codigo, $lugar);
        }
    }

    public function listadoCajas() {
        global $conexion;
        $ArrayObjects = array(); //Creamos un array en el que se almacenarán las cajas obtenidas de la tabla
        //Obtenemos los datos de las cajas de la tabla
        $ordenSQL = "SELECT * FROM caja C, ocupacion_estanteria O, estanteria E WHERE C.id_caja=O.id_caja AND O.id_estanteria=E.id_est ";
        $resultado = $conexion->query($ordenSQL);
        if ($resultado->num_rows > 0) {
            $Obj = $resultado->fetch_object();
            while ($Obj) {
                $ArrayObjects[] = $Obj;
                $Obj = $resultado->fetch_object();
            }
        }
        if (!empty($ArrayObjects)) {
            return $ArrayObjects; //Devolvemos el array con todas las cajas para ser mostradas
        } else {
            $mensaje = $conexion->error;
            $codigo = $conexion->errno;
            $lugar = "No hay Cajas";
            throw new CajaException($mensaje, $codigo, $lugar);
        }
    }

    public function listadoEstanterias() {
        global $conexion;
        $ArrayObjects = array(); //Creamos un array en el que se almacenarán las estanterias obtenidas de la tabla
        //Obtenemos los datos de las estanterias de la tabla
        $ordenSQL = "SELECT * FROM estanteria E, pasillo P WHERE P.id_pasillo=E.pasillo ORDER BY P.letra_pasillo, E.numero";
        $resultado = $conexion->query($ordenSQL);
        if ($resultado->num_rows > 0) {
            $Obj = $resultado->fetch_object();
            while ($Obj) {
                $ArrayObjects[] = $Obj;
                $Obj = $resultado->fetch_object();
            }
        }
        if (!empty($ArrayObjects)) {
            return $ArrayObjects; //Devolvemos el array con todas las estanterias para ser mostradas
        } else {
            $mensaje = $conexion->error;
            $codigo = $conexion->errno;
            $lugar = "No hay Estanterias";
            throw new EstanteriaException($mensaje, $codigo, $lugar);
        }
    }

    public function estanteriasLibres() {
        global $conexion;
        $Estanterias = Array();
        //Obtenemos todos los datos de la estanteria
        $orden = "SELECT * FROM estanteria";
        $resultado = $conexion->query($orden);

        if ($resultado->num_rows > 0) {
            $fila = $resultado->fetch_assoc();
            while ($fila) {
                if ($fila['num_lejas'] > $fila['lejas_ocupadas']) {
                    //Almacenamos los datos de la estanteria en variables
                    $id = $fila['id_est'];
                    $codigo = $fila['codigo_est'];
                    $material = $fila['material_est'];
                    $num_lejas = $fila['num_lejas'];
                    $lejasOcupadas = $fila['lejas_ocupadas'];
                    $fecha_alta = $fila['fecha_alta_est'];
                    $pasillo = $fila['pasillo'];
                    $numero = $fila['numero'];

                    //Creamos un objeto estanteria con las variables anteriores
                    $Estanteria = new Estanteria($codigo, $material, $num_lejas, $lejasOcupadas, $fecha_alta, $pasillo, $numero);
                    $Estanteria->setId_est($id);
                    $Estanterias[] = $Estanteria;
                }
                $fila = $resultado->fetch_assoc();
            }
        }
        if (!empty($Estanterias)) {
            return $Estanterias;
        } else {
            $mensaje = $conexion->error;
            $codigo = $conexion->errno;
            $lugar = "No se han encontrado estanterias -> estanteriasLibres()";
            throw new EstanteriaException($mensaje, $codigo, $lugar);
        }
    }

    public function lejasDisponibles($idEstanteria) {
        global $conexion;
        $arrayLejas = array();
        $arrayDisponibles = array();
        //Obtenemos las lejas de la estanteria cuyo id le pasamos y las lejas ocupadas de ésta estantería
        $ordenSQL = "SELECT num_lejas FROM estanteria WHERE id_est=$idEstanteria";
        $sql = "SELECT leja_ocupada FROM ocupacion_estanteria WHERE id_estanteria=$idEstanteria";
        $resultado = $conexion->query($ordenSQL);
        $resultado2 = $conexion->query($sql);

        if ($resultado->num_rows > 0) {
            $fila = $resultado->fetch_assoc();
            $NumeroLejas = $fila['num_lejas'];
            $fila2 = $resultado2->fetch_assoc();
            while ($fila2) {
                $arrayLejas[] = $fila2['leja_ocupada'];
                $fila2 = $resultado2->fetch_assoc();
            }
            for ($i = 0; $i < $NumeroLejas; $i++) {
                if (!in_array($i, $arrayLejas)) {
                    $arrayDisponibles[] = $i;
                }
            }
            return $arrayDisponibles; //Devolvemos el array de lejas disponibles al que ya hemos quitado las lejas que fueron ocupadas
        } else {
            $mensaje = $conexion->error;
            $codigo = $conexion->errno;
            $lugar = "No se han encontrado lejas -> lejasDisponibles()";
            throw new EstanteriaExceptionException($mensaje, $codigo, $lugar);
        }
    }

    public function pasillosLibres() {
        global $conexion;
        $Pasillos = array();
        //Obtenemos los pasillos del almacen junto con su letra
        $ordenSQL = "SELECT id_pasillo, letra_pasillo FROM pasillo P,almacen A WHERE P.huecos_pasillo < A.numero_huecos_pasillo";
        $resultado = $conexion->query($ordenSQL);

        if ($resultado->num_rows > 0) {
            $fila = $resultado->fetch_object();

            while ($fila) {
                $Pasillos[] = $fila;
                $fila = $resultado->fetch_object();
            }
        }
        if (!empty($Pasillos)) {
            return $Pasillos;
        } else {
            $mensaje = $conexion->error;
            $codigo = $conexion->errno;
            $lugar = "Todos los pasillos ocupados -> pasillosLibres()";
            throw new AlmacenException($mensaje, $codigo, $lugar);
        }
    }

    public function huecosDisponibles($idPasillo) {
        global $conexion;
        $AHuecosOcupados = array(); //Array en el que se guardarán los huecos 
        $ANumeros = array(); //Array con los numeros ocupados de un pasillo
        $ADisp = array(); //Crearmos el array de huecos disponibles
        //
        //Obtenemos el número total de huecos de cada pasillo
        $sql = "SELECT numero_huecos_pasillo FROM almacen";
        $rHuecos = $conexion->query($sql);

        if ($rHuecos->num_rows == 1) {
            $fila = $rHuecos->fetch_assoc();
            $TotalHuecos = $fila['numero_huecos_pasillo'];
        }

        //Obtenemos el numero de huecos sin ocupar del pasillo señalado
        $sql2 = $conexion->prepare("SELECT huecos_pasillo FROM pasillo WHERE id_pasillo= ?");
        $sql2->bind_param('i', $idPasillo);
        $sql2->execute();
        $rHuecosOcupados = $sql2->get_result();

        if ($rHuecosOcupados->num_rows > 0) {
            $Obj = $rHuecosOcupados->fetch_array()['huecos_pasillo'];

            while ($Obj) {
                $AHuecosOcupados[] = $Obj;
                $Obj = $rHuecosOcupados->fetch_array()['huecos_pasillo'];
            }
        }

        //Guardamos los numeros ocupados
        $sql3 = $conexion->prepare("SELECT numero FROM estanteria WHERE pasillo= ?");
        $sql3->bind_param('i', $idPasillo);
        $sql3->execute();
        $numOcupado = $sql3->get_result();

        if ($numOcupado->num_rows > 0) {
            $Obj = $numOcupado->fetch_array()['numero'];

            while ($Obj) {
                $ANumeros[] = $Obj;
                $Obj = $numOcupado->fetch_array()['numero'];
            }
        }

        for ($i = 1; $i <= $TotalHuecos; $i++) {
            if (!in_array($i, $ANumeros)) {
                $ADisp[] = $i;
            }
        }
        return $ADisp;
    }

    public function Inventario() {
        global $conexion;
        $AInventario = array();
        //Hacemos una consulta que nos dará los datos de las estanterias con sus cajas y la ocupación de ambas en pasillos y lejas respectivamente para luego ser ordenado en el inventario
        $ordenSQL = "SELECT * FROM estanteria E
            LEFT JOIN ocupacion_estanteria O ON O.id_estanteria = E.id_est
            LEFT JOIN caja C ON O.id_caja = C.id_caja
            LEFT JOIN pasillo P ON P.id_pasillo = E.pasillo 
            ORDER BY E.pasillo, E.numero, O.leja_ocupada";

        $resultado = $conexion->query($ordenSQL);
        if ($resultado->num_rows > 0) {
            $Obj = $resultado->fetch_object();

            while ($Obj) {
                $AInventario[] = $Obj;
                $Obj = $resultado->fetch_object();
            }
        }
        if (!empty($AInventario)) {
            return $AInventario;
        } else {
            $mensaje = $conexion->error;
            $codigo = $conexion->errno;
            $lugar = "No hay estanterias en el almacén -> Inventario()";
            throw new EstanteriaException($mensaje, $codigo, $lugar);
        }
    }

    public function MostrarCaja($OCaja) {
        global $conexion;
        $codigo_caja = $OCaja->getCodigo_caja();
        $ArrayObjects = array();
        //Según el codigo señalado en la vista obtenemos la caja con el mismo código para poder mostrarla en la vista
        $ordenSQL = "SELECT * FROM caja C, ocupacion_estanteria O, estanteria E WHERE C.codigo_caja='$codigo_caja' AND C.id_caja=O.id_caja AND O.id_estanteria=E.id_est ";
        $resultado = $conexion->query($ordenSQL);
        if ($resultado->num_rows > 0) {
            $Obj = $resultado->fetch_object();
            while ($Obj) {
                $ArrayObjects[] = $Obj;
                $Obj = $resultado->fetch_object();
            }
        }
        if (!empty($ArrayObjects)) {
            return $ArrayObjects;
        } else {
            $mensaje = $conexion->error;
            $codigo = $conexion->errno;
            $lugar = "No hay Cajas";
            throw new CajaException($mensaje, $codigo, $lugar);
        }
    }

    public function MostrarEst($OEst) {
        global $conexion;
        $codigo_est = $OEst->getCodigo_est();
        $ArrayObjects = array();
        //Según el codigo señalado en la vista obtenemos la caja con el mismo código para poder mostrarla en la vista
        $ordenSQL = "SELECT * FROM estanteria E
            LEFT JOIN ocupacion_estanteria O ON O.id_estanteria = E.id_est
            LEFT JOIN caja C ON O.id_caja = C.id_caja
            LEFT JOIN pasillo P ON P.id_pasillo = E.pasillo WHERE E.codigo_est='$codigo_est'";
        $resultado = $conexion->query($ordenSQL);
        if ($resultado->num_rows > 0) {
            $Obj = $resultado->fetch_object();
            while ($Obj) {
                $ArrayObjects[] = $Obj;
                $Obj = $resultado->fetch_object();
            }
        }
        if (!empty($ArrayObjects)) {
            return $ArrayObjects;
        } else {
            $mensaje = $conexion->error;
            $codigo = $conexion->errno;
            $lugar = "No hay Cajas";
            throw new CajaException($mensaje, $codigo, $lugar);
        }
    }

    public function BorrarCaja($OCaja) {
        global $conexion;
        $codigo_caja = $OCaja->getCodigo_caja();
        //Borramos la caja cuyo codigo sea igual al selecionado en la vista
        $ordenSQL = "DELETE FROM caja WHERE codigo_caja='$codigo_caja'";
        $sentencia = $conexion->query($ordenSQL);
        if ($sentencia == 1) {
            return;
        } else {
            $mensaje = $conexion->error;
            $codigo = $conexion->errno;
            $lugar = "No se ha podido borrar -> borrarCaja()";
            throw new CajaException($mensaje, $codigo, $lugar);
        }
    }

    public function BorrarEstanteria($OEst) {
        global $conexion;
        $codigo_est = $OEst->getCodigo_est();
        $ordenSQL = "SELECT * FROM estanteria WHERE codigo_est='$codigo_est' AND lejas_ocupadas='0'";
        $sentencia = $conexion->query($ordenSQL);
        if ($sentencia->num_rows == 1) {
            //Borramos la estanteria cuyo codigo sea igual al selecionado en la vista
            $ordenSQL2 = "DELETE FROM estanteria WHERE codigo_est='$codigo_est'";
            $sentencia2 = $conexion->query($ordenSQL2);
            if ($sentencia2 == 1) {
                return;
            } else {
                $mensaje = $conexion->error;
                $codigo = $conexion->errno;
                $lugar = "No se ha podido borrar -> borrarEstanteria()";
                throw new CajaException($mensaje, $codigo, $lugar);
            }
        }else{
            $mensaje = $conexion->error;
                $codigo = $conexion->errno;
                $lugar = "No se ha podido borrar -> Hay cajas dentro";
                throw new CajaException($mensaje, $codigo, $lugar);
        }
    }
    
    public function ListadoCajasSegunEst($OEst){
         global $conexion;
         $codigo_est = $OEst->getCodigo_est();
         $OrdenSQL="SELECT id_est FROM estanteria WHERE codigo_est='$codigo_est'";
         $id_est = $conexion->query($ordenSQL);
         $OrdenSQL2="SELECT * FROM caja C, ocupacion_estanteria O WHERE C.id_caja=O.id_caja AND O.id_estanteria='$id_est'";
         $sentencia= $conexion->query($ordenSQL2);
    }

    public function listadoCajasDevol() {
        global $conexion;
        $ArrayObjects = array();
        //Obtenemos un listado de las cajas que estan en backup para ser devueltas
        $ordenSQL = "SELECT * FROM cajabackup";
        $resultado = $conexion->query($ordenSQL);
        if ($resultado->num_rows > 0) {
            $Obj = $resultado->fetch_object();
            while ($Obj) {
                $ArrayObjects[] = $Obj;
                $Obj = $resultado->fetch_object();
            }
        }
        if (!empty($ArrayObjects)) {
            return $ArrayObjects;
        } else {
            $mensaje = $conexion->error;
            $codigo = $conexion->errno;
            $lugar = "No hay Cajas";
            throw new CajaException($mensaje, $codigo, $lugar);
        }
    }

    public function MostrarCajaBackup($OCaja) {
        global $conexion;
        $codigo_caja = $OCaja->getCodigo_caja();
        $ArrayObjects = array();
        //Obtenemos la caja de la tabla backup cuyo codigo coincida con el señalado en la vista para despues ser mostrada
        $ordenSQL = "SELECT * FROM cajabackup WHERE codigo_caja='$codigo_caja'";
        $resultado = $conexion->query($ordenSQL);
        if ($resultado->num_rows > 0) {
            $Obj = $resultado->fetch_object();
            while ($Obj) {
                $ArrayObjects[] = $Obj;
                $Obj = $resultado->fetch_object();
            }
        }
        if (!empty($ArrayObjects)) {
            return $ArrayObjects;
        } else {
            $mensaje = $conexion->error;
            $codigo = $conexion->errno;
            $lugar = "No hay Cajas";
            throw new CajaException($mensaje, $codigo, $lugar);
        }
    }

    public function DevolverCaja($OCaja) {
        global $conexion;
        $codigo_caja = $OCaja->getCodigo_caja();
        $nuevaest = $OCaja->getId_est();
        $nuevaleja = $OCaja->getLeja_ocupada();
        //Obtenemos la caja de la tabla backup cuyo codigo coincida con el señalado en la vista
        $ordenSQL = "SELECT * FROM cajabackup WHERE codigo_caja='$codigo_caja'";
        $resultado = $conexion->query($ordenSQL);

        if ($resultado->num_rows > 0) {
            $fila = $resultado->fetch_assoc();
            $codigo_caja = $fila['codigo_caja'];
            $altura = $fila['altura'];
            $anchura = $fila['anchura'];
            $profundidad = $fila['profundidad'];
            $color = $fila['color'];
            $material_caja = $fila['material_caja'];
            $contenido = $fila['contenido'];
            $fecha_alta_caja = $fila['fecha_alta_caja'];
            $fecha_baja_caja = $fila['fecha_baja_caja'];
            $id_est = $nuevaest;
            $leja_ocupada = $nuevaleja;

            //La almacenamos en un objeto
            $CajaB = new CajaBackup($codigo_caja, $altura, $anchura, $profundidad, $color, $material_caja, $contenido, $fecha_alta_caja, $fecha_baja_caja, $id_est, $leja_ocupada);

            //Incluimos un trigger que se creará si no existe y si existe se ejecutará antes del borrado en cajabackup
            include_once "../Modelo/TriggerDevolucion.php";

            //Borramos la caja de la tabla backup
            $ordenSQL2 = "DELETE FROM cajabackup WHERE codigo_caja='$codigo_caja'";
            $sentencia2 = $conexion->query($ordenSQL2);
            if ($sentencia2 == 1) {
                return;
            } else {
                $mensaje = $conexion->error;
                $codigo = $conexion->errno;
                $lugar = "No se ha podido borrar -> borrarCaja()";
                throw new CajaException($mensaje, $codigo, $lugar);
            }
        } else {
            $mensaje = $conexion->error;
            $codigo = $conexion->errno;
            $lugar = "Error obteniendo Caja de backup";
            throw new CajaException($mensaje, $codigo, $lugar);
        }
    }

    public function DetectarUsuario() {
        global $conexion;
        //Obtenemos los datos de la tabla administrador para ver si hay registros de uno dentro
        $ordenSQL = "SELECT * FROM administrador";
        $resultado = $conexion->query($ordenSQL);
        if (!empty($resultado)) {
            if ($resultado->num_rows > 0) {
                return 1; //Hay datos
            } else {
                return 0; //No hay datos
            }
        } else {
            $mensaje = $conexion->error;
            $codigo = $conexion->errno;
            $lugar = "Error detectando usuario";
            throw new AlmacenException($mensaje, $codigo, $lugar);
        }
    }

    public function Registrar($usu, $pass) {
        global $conexion;
        //Ciframos la contraseña dada por el admin
        $passcifrada = password_hash($pass, PASSWORD_BCRYPT);
        //Insertamos los datos dados, con la contraseña ya cifrada, en la tabla administrador
        $ordenSQL = "INSERT INTO administrador VALUES(?,?)";
        $sentencia1 = $conexion->prepare($ordenSQL);
        $sentencia1->bind_param("ss", $usu, $passcifrada);
        $sentencia1->execute();
        if ($sentencia1->affected_rows == 1) {
            return;
        } else {
            $mensaje = $conexion->error;
            $codigo = $conexion->errno;
            $lugar = "Error al registrar";
            throw new AlmacenException($mensaje, $codigo, $lugar);
        }
    }

    public function Login($usu, $pass) {
        global $conexion;
        //Obtenemos los datos de la tabla
        $ordenSQL = "SELECT * FROM administrador";
        $resultado = $conexion->query($ordenSQL);

        if ($resultado->num_rows > 0) {
            $fila = $resultado->fetch_assoc();
            $usuadmin = $fila['usuario'];
            $passadmin = $fila['contraseña'];
            if ($usuadmin == $usu && password_verify($pass, $passadmin)) {//Verificamos que los datos obtenidos del login y los de la tabla, verificando la contraseña, son correctos
                return;
            } else {
                $mensaje = $conexion->error;
                $codigo = $conexion->errno;
                $lugar = "Error de login";
                throw new AlmacenException($mensaje, $codigo, $lugar);
            }
        } else {
            $mensaje = $conexion->error;
            $codigo = $conexion->errno;
            $lugar = "Error de login";
            throw new AlmacenException($mensaje, $codigo, $lugar);
        }
    }

}
