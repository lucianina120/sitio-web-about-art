<?php
session_start();

if(!isset($_SESSION['usuario'])){
    header("Location:../index.php");
}else{
    if($_SESSION['usuario']=="ok"){
        $nombreUsuario=$_SESSION["nombreUsuario"];
    }
}
?>

<!doctype html>
<html lang="en">

<head>
    <title>Admin</title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
        integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
        
</head>

<body>

<?php $url="http://".$_SERVER['HTTP_HOST']."/sitioweb"?>
  <nav class="navbar navbar-expand-md navbar-dark bg-dark">
    <div class="navbar-collapse collapse w-100 order-1 order-md-0 dual-collapse2">
        <ul class="navbar-nav mr-auto">
            <div class="nav navbar-nav">
            <a class="nav-item nav-link" href="<?php echo $url;?>/administrador/inicio.php">Inicio</a>
            <a class="nav-item nav-link" href="<?php echo $url;?>/administrador/seccion/peticiones.php">Bandeja de entrada</a>
            <a class="nav-item nav-link" href="<?php echo $url;?>/administrador/seccion/comisiones.php">Tipos de comision</a>
            <a class="nav-item nav-link" href="<?php echo $url;?>/administrador/seccion/galerias.php">Galerias</a>
            <a class="nav-item nav-link" href="<?php echo $url;?>/administrador/seccion/terminos.php">Terminos</a>
        </div>
        </ul>
    </div>
    <div class="mx-auto order-0">
        <a class="navbar-brand mx-auto" href="<?php echo $url;?>/administrador/inicio.php">Administrador</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target=".dual-collapse2">
            <span class="navbar-toggler-icon"></span>
        </button>
    </div>
    <div class="navbar-collapse collapse w-100 order-3 dual-collapse2">
        <ul class="navbar-nav ml-auto">
            <li class="nav-item">
            <a class="nav-item nav-link" href="<?php echo $url;?>">Ver sitio web</a>
            </li>
            <li class="nav-item">
            <a class="nav-item nav-link" href="<?php echo $url;?>/administrador/seccion/cerrar.php">Cerrar sesion</a>
            </li>
        </ul>
    </div>
</nav>
    <div class="container">
    <br>
        <div class="row">