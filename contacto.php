<?php
//captura de datos
$txtNombre=(isset($_POST['txtNombre']))?$_POST['txtNombre']:"";
$txtEmail=(isset($_POST['txtEmail']))?$_POST['txtEmail']:"";
$txtCanal=(isset($_POST['txtCanal']))?$_POST['txtCanal']:"";
$txtAsunto=(isset($_POST['txtAsunto']))?$_POST['txtAsunto']:"";
$txtMensaje=(isset($_POST['txtMensaje']))?$_POST['txtMensaje']:"";

$accion=(isset($_POST['accion']))?$_POST['accion']:"";

//conexion con la base de datos
include('./administrador/config/bd.php');

if($accion=="Enviar"){
    $sentenciaSQL= $conexion->prepare("INSERT INTO peticiones (nombre, email, canal, asunto, mensaje) VALUES (:nombre, :email, :canal, :asunto, :mensaje);");
    $sentenciaSQL->bindParam(':nombre',$txtNombre);
    $sentenciaSQL->bindParam(':email',$txtEmail);
    $sentenciaSQL->bindParam(':canal',$txtCanal);
    $sentenciaSQL->bindParam(':asunto',$txtAsunto);
    $sentenciaSQL->bindParam(':mensaje',$txtMensaje);
    
    $sentenciaSQL->execute();
    header("Location:contacto.php");
}
?>
<?php include("template/cabecera.php"); ?>
<div class="container">
    <div class="row pt-5">
        <div class="jumbotron">
            <h2 class="display-4 text-center ">CONTACTO</h2>
            <p class="lead text-center">Contactame por cualquier pregunta</p>
        </div>

        <div class="col-md-6 mx-auto">
            <div class="card">
                <div class="card-header">
                    Formulario de contacto
                </div>

                <div class="card-body">
                    <form method="post" class="row">
                        <div class="col-md-6">
                            <label for="txtNombre">Nombre:</label>
                            <input type="text" required class="form-control" name="txtNombre" id="txtNombre"
                                placeholder="Tu nombre">
                        </div>

                        <div class="col-md-6">
                            <label for="txtEmail">Email:</label>
                            <input type="email" required class="form-control" name="txtEmail" id="txtEmail"
                                placeholder="Tu email">
                        </div>
                        <br><br><br>
                        <div class="mb-3">
                            <label for="txtCanal">Canal:</label>
                            <input type="text" class="form-control" name="txtCanal" id="txtCanal"
                                placeholder="Canal de Twitch/YouTube/Discord">
                        </div>
                        <div class="mb-3">
                            <label for="txtAsunto" class="form-label">Asunto:</label>
                            <input type="text" class="form-control" name="txtAsunto" id="txtAsunto"
                                placeholder="Asunto/Tipo de comision">
                        </div>
                        <div class="mb-3">
                            <label for="txtMensaje" class="form-label">Mensaje</label>
                            <textarea class="form-control" name="txtMensaje" id="txtMensaje" rows="3"
                                placeholder="Cuentame tu idea"></textarea>
                        </div>
                        <input type="submit" name="accion" value="Enviar" class="btn btn-primary">
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<?php include("template/pie.php"); ?>