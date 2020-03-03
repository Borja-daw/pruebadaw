<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title></title>
    </head>
    <body>
       <?php
        include_once '../DAO/DAOAlmacen.php';
        //Obtenemos el id de la estantería señalada
        $idEstanteria=$_REQUEST['estanteriasDisponibles'];
        
        $lejaslibres= DAOAlmacen::lejasDisponibles($idEstanteria);//Funcion a la que le mandamos el id de la estantería y que devolverá las lejas disponibles de ésta
 
        //Hacemos el foreach que sacará las opciones
        foreach($lejaslibres as $leja){
       ?>
       <option value="<?php echo $leja;?>"> <?php echo "".($leja+1);?> </option>
       <?php
           }
       ?>
    </body>
</html>