<?php
include("administrador/config/bd.php");

$sentenciaSQL= $conexion->prepare("SELECT * FROM trabajos ORDER BY fecha DESC LIMIT 0,8 ");
$sentenciaSQL->execute();
$listaTrabajos=$sentenciaSQL->fetchAll(PDO::FETCH_ASSOC);
?>

<?php include("template/cabecera.php"); ?>

<section id="sec-bienvenida">
    <div class="container">

        <div class="row pt-5">
            <div class="jumbotron">
                <h1 class="text-center">Hola! Soy Giuz09</h1>
                <p class="lead text-center">Streamer y artista</p>
                <hr class="my-2">
            </div>
        </div>

        <div class="row pt-5 pb-5">
            <div class="col-md-8">
                
                <p class="lead"><br>
                   <span class="display-6"> Quiero traer a la vida ese diseño que ronda por tu mente</span> <br> 
                   Proponerte ideas en caso que no las tengas,<br> 
                   mi meta es crear algo que sea de tu agrado!
                </p>
            </div>
            <div class="col-md-4 text-center">
                <img src="./img/image.jpg" alt="">
            </div>
        </div>
    </div>
</section>

<section id="sec-comisiones-recientes">
    <div class="container">
        <div class="row pt-5 pb-5">
            <div class="jumbotron pt-5 pb-4">
                <h2 class="display-4 text-center">Comisiones recientes</h2>
                <hr class="my-2">
            </div>

            <?php foreach($listaTrabajos as $trabajo){?>
            <div class="col-12 col-md-4 col-lg-3 pt-3 pb-3">
                <div class="card ">
                    <div class="card-body">
                        <h4 class="card-title text-center"><?php echo $trabajo["nombre_cliente"]?></h4>
                        <img class="card-img-top" src="./img/trabajos/<?php echo $trabajo["imagen"]?>" alt="">
                        <h5 class="card-title text-center"><?php echo $trabajo["tipo"]?></h5>
                    </div>
                </div>
            </div>
            <?php } ?>
        </div>
    </div>
</section>
<?php include("template/pie.php"); ?>