<?php include("template/cabecera.php"); ?>

<?php

include("administrador/config/bd.php");

$sentenciaSQL= $conexion->prepare("SELECT * FROM comisiones");
$sentenciaSQL->execute();
$listaComisiones=$sentenciaSQL->fetchAll(PDO::FETCH_ASSOC);

$sentenciaSQL= $conexion->prepare("SELECT * FROM terminos");
$sentenciaSQL->execute();
$terminos=$sentenciaSQL->fetch();

?>
<div class="container">
    <div class="row pt-5">
        <div class="jumbotron">
            <h2 class="display-4 text-center">INFORMACION COMISIONES</h2>
            <p class="lead text-center">Estos son los servicios que actualmente ofrezco para streamers y creadores de
                contenido. <br> Por
                favor
                lee abajo la informacion para ordenar y los terminos del servicio.</p>
            <br>
        </div>

        <?php foreach($listaComisiones as $comision){?>
        <br>
        <div class="card">
            <div class="card-header">
                <h1 class="text-primary text-center"><?php echo $comision['nombre'];?> - PRECIO
                    $<?php echo $comision['precio'];?> </h1>
                <p class="lead text-secondary text-center"><?php echo $comision['descripcion'];?></p>
            </div>

            <div class="card-body row">
                <div class="col-md-8">
                    <p><?php echo $comision['detalle'];?></p>

                </div>
                <div class="col-md-4 text-center">
                    <img src="./img/<?php echo $comision["imagen"]?>" alt="">

                </div>
            </div>
            <button type="button" class="btn btn-md btn-primary mx-auto">Solicitar</button>
            <br><br><br>
        </div>

        <?php } ?>

        <div class="jumbotron">
            <br><br><br>
            <h1 class="display-3 text-center">TERMINOS Y CONDICIONES</h1>
            <p class="lead"><?php echo $terminos['item']?></p>
            <br>
        </div>
    </div>
</div>
<?php include("template/pie.php"); ?>