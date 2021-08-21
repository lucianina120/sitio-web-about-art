<?php include('template/cabecera.php');?>



    
            <div class="col-md-12">
                <div class="jumbotron">
                    <h1 class="display-3">Bienvenida <?php echo $nombreUsuario?></h1>
                    <p class="lead">Vamos a administrar tus secciones en el Sitio Web</p>
                    <hr class="my-2">
                    <p>Acciones</p>
                    <p class="lead">
                        <a class="btn btn-primary btn-lg" href="seccion/peticiones.php" role="button">Bandeja de entrada</a>
                        <br><br>
                        <a class="btn btn-primary btn-lg" href="seccion/galerias.php" role="button">Administrar galeria</a>
                        <br><br>
                        <a class="btn btn-primary btn-lg" href="seccion/comisiones.php" role="button">Administrar comisiones</a>
                        <br><br>
                        <a class="btn btn-primary btn-lg" href="seccion/terminos.php" role="button">Administrar terminos y condiciones</a>
                    </p>
                </div>
            </div>

        
<?php include('template/pie.php');?>