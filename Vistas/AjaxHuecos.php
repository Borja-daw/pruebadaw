<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title></title>
    </head>
    <body>
       <?php
        include_once '../DAO/DAOAlmacen.php';
        //Obtenemos el id del pasillo señalado
        $idPasillo=$_REQUEST['pasillosDisponibles'];
 
        $huecoslibres= DAOAlmacen::huecosDisponibles($idPasillo);//Funcion a la que le mandamos el pasillo y que devolverá los huecos disponibles de éste
 
        //Hacemos el foreach que sacará las opciones
        foreach($huecoslibres as $hueco){
       ?>
       <option value="<?php echo $hueco;?>"> <?php echo "".$hueco;?> </option>
       <?php
           }
       ?>
    </body>
</html>