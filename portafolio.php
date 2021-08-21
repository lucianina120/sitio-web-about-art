<?php
include("administrador/config/bd.php");

$sentenciaSQL= $conexion->prepare("SELECT * FROM trabajos");
$sentenciaSQL->execute();
$listaTrabajos=$sentenciaSQL->fetchAll(PDO::FETCH_ASSOC);

//calculo para la paginacion
$articulos_por_pagina=8;

$total_articulos_bd = $sentenciaSQL->rowCount();
$paginas=$total_articulos_bd/8;
$paginas=ceil($paginas);

//paginacion
if(!$_GET){
    header('Location:portafolio.php?pagina=1');
}
if($_GET['pagina']>$paginas || ($_GET['pagina']<=0)){
    header('Location:portafolio.php?pagina=1');
}

$iniciar = ($_GET['pagina']-1)* $articulos_por_pagina;

$sentenciaSQL= $conexion->prepare("SELECT * FROM trabajos ORDER BY fecha DESC LIMIT :iniciar, :narticulos");
$sentenciaSQL->bindParam(':iniciar',$iniciar, PDO::PARAM_INT);
$sentenciaSQL->bindParam(':narticulos',$articulos_por_pagina, PDO::PARAM_INT);
$sentenciaSQL->execute();
$listaTrabajos=$sentenciaSQL->fetchAll(PDO::FETCH_ASSOC);
?>
<?php include("template/cabecera.php"); ?>
<div class="container">
    <div class="row pt-5">
        <div class="jumbotron">
            <h2 class="display-4 text-center">PORTAFOLIO</h2>
            <p class="lead text-center">Estas son la mayoría de las comisiones que he realizado para creadores de
                contenido</p>
        </div>

        <?php foreach($listaTrabajos as $trabajo){?>
        <div class="col-md-3">
            <div class="card">


                <div class="card-body">
                    <h4 class="card-title text-center"><?php echo $trabajo["nombre_cliente"]?></h4>
                    <img class="card-img-top" src="./img/trabajos/<?php echo $trabajo["imagen"]?>" alt="">
                    <h5 class="card-title text-center"><?php echo $trabajo["tipo"]?></h5>
                </div>


            </div>
        </div>
        <?php } ?>
        
        <nav aria-label="Page navigation example">
            <ul class="pagination">
                <li class="page-item <?php echo $_GET['pagina']<=1 ? 'disabled': '';  ?>"><a class="page-link "
                        href="portafolio.php?pagina=<?php echo $_GET['pagina']-1?>">Anterior</a></li>

                <?php for($i=0;$i<$paginas;$i++){ ?>
                <li class="page-item <?php echo $_GET['pagina']==$i+1 ? 'active': '';  ?>"><a class="page-link"
                        href="portafolio.php?pagina=<?php echo $i+1 ?>">
                        <?php 
            echo$i+1;
        ?>
                    </a></li>

                <?php } ?>

                <li class="page-item <?php echo $_GET['pagina']>=$paginas ? 'disabled': '';  ?>"><a class="page-link "
                        href="portafolio.php?pagina=<?php echo $_GET['pagina']+1?>">Siguiente</a></li>
            </ul>
        </nav>
    </div>
</div>
<?php include("template/pie.php"); ?>