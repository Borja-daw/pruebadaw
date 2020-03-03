<!doctype html>
<html lang="en">
    <head>
        <!-- Required meta tags -->
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

        <!-- Bootstrap CSS -->
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" 
              integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
        <link rel="stylesheet" href="css/sidebar.css">
        <link rel="stylesheet" href="css/Vistas.css">
        <title>Borrar</title>
        <!-- Font Awesome JS -->
        <script defer src="https://use.fontawesome.com/releases/v5.0.13/js/solid.js" integrity="sha384-tzzSw1/Vo+0N5UhStP3bvwWPq+uvzCMfrN1fEFe+xBmv1C/AtVX5K0uZtmcHitFZ" crossorigin="anonymous"></script>
        <script defer src="https://use.fontawesome.com/releases/v5.0.13/js/fontawesome.js" integrity="sha384-6OIrr52G08NpOFSZdxxz1xdNSndlD4vdcf/q2myIUVO0VsqaGHJsB0RaBE01VTOY" crossorigin="anonymous"></script>
        <script src="js/js.js"></script>
    </head>
    <body>
        <?php
        include_once "../Modelo/Estanteria.php";
        session_start();
        $arrayEstLibres = $_SESSION['Est'];
        ?>
        <div class="wrapper">
            <!-- Sidebar  -->
            <nav id="sidebar">
                <div class="sidebar-header">
                    <h3>Almacen de Cajas </h3>
                    <img src="img/icon.png" id="icono">
                </div>

                <ul class="list-unstyled components">
                    <li class="active">
                        <a href="#homeSubmenu" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">
                            <i class="fas fa-box-open"></i>
                            Caja
                        </a>
                        <ul class="collapse list-unstyled" id="homeSubmenu">
                            <li>
                                <a href="../Controladores/EstanteriasLibres.php">Alta</a>
                            </li>
                            <li>
                                <a href="../Controladores/ElegirCaja.php">Baja</a>
                            </li>
                            <li>
                                <a href="../Controladores/ElegirCajaDevol.php">Devolución</a>
                            </li>
                            <li>
                                <a href="../Controladores/ListadoCajas.php">Listado</a>
                            </li>
                        </ul>
                    </li>
                    <li>
                        <a href="#pageSubmenu" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">
                            <i class="fas fa-pallet"></i>
                            Estanteria
                        </a>
                        <ul class="collapse list-unstyled" id="pageSubmenu">
                            <li>
                                <a href="../Controladores/PasillosLibres.php">Alta</a>
                            </li>
                            <li>
                                <a href="../Controladores/ElegirEstanteria.php">Baja</a>
                            </li>
                            <li>
                                <a href="../Controladores/ListadoEstanterias.php">Listado</a>
                            </li>
                        </ul>
                    </li>
                    <li>
                        <a href="../Controladores/Inventario.php">
                            <i class="fas fa-clipboard-list"></i>
                            Inventario
                        </a>
                    </li>
                    <li>
                        <a href="Menu.php">
                            <i class="fas fa-reply"></i>
                            Volver al Menú
                        </a>
                    </li>
                </ul>

            </nav>
            <!--Contenido-->
            <div id="content">
                <nav class="navbar navbar-expand-lg tit">
                    <button type="button" id="sidebarCollapse" class="btn btn-infolg"><i class="fas fa-align-left"></i></button>
                    <div class="collapse navbar-collapse justify-content-center" id="titulo">
                        <h1>Borrar</h1>
                    </div>
                </nav>
                <form name="elegirEstanterias" action="../Controladores/MostrarEstanteria.php" method="POST">
                    <div class="form-row justify-content-center">
                        <div class="form-group col-md-4">
                            <select class="form-control " name="estanteria">
                                <option values="nulo" selected="selected">Elije Estanteria</option>
                                <?php foreach ($arrayEstLibres as $Estanteria) { ?>
                                    <option value="<?php echo $Estanteria->codigo_est ?>">
                                        <?php echo $Estanteria->codigo_est; ?>
                                    <?php } ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-row justify-content-center">
                    <button class="btn btn-success" name="enviar" value="enviar" type="submit">Confirmar</button>
                    </div>
                </form>
            </div>
        </div>

        <!-- jQuery first, then Popper.js, then Bootstrap JS -->
        <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
        <!-- Optional JavaScript -->
        <script type="text/javascript">
            $(document).ready(function () {
                $('#sidebarCollapse').on('click', function () {
                    $('#sidebar').toggleClass('active');
                });
            });
        </script>
    </body>
</html>