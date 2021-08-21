<?php
//captura de datos
$txtID=(isset($_POST['txtID']))?$_POST['txtID']:"";
$txtItem=(isset($_POST['txtItem']))?$_POST['txtItem']:"";

$accion=(isset($_POST['accion']))?$_POST['accion']:"";

include('../config/bd.php');

//accion ejecutada
switch($accion){
    
    case "Guardar":
        $sentenciaSQL= $conexion->prepare("UPDATE terminos SET item=:item WHERE id=:id;");
        $sentenciaSQL->bindParam(':item',$txtItem);
        $sentenciaSQL->bindParam(':id',$txtID);
        $sentenciaSQL->execute();

        header("Location:terminos.php");

        break;

        case "Modificar":

            $sentenciaSQL= $conexion->prepare("SELECT * FROM terminos WHERE id=:id");
            $sentenciaSQL->bindParam(':id',$txtID);
            $sentenciaSQL->execute();
            $terminos=$sentenciaSQL->fetch(PDO::FETCH_LAZY);
    
            $txtItem=$terminos['item']; //los valores recuperados
            break;

    case "Cancelar":

        header("Location:terminos.php");
        break;
}

//los que se muestra en la tabla
$sentenciaSQL= $conexion->prepare("SELECT * FROM terminos");
$sentenciaSQL->execute();
$Terminos=$sentenciaSQL->fetch();
?>
<?php include('../template/cabecera.php');?>
<div class="col-lg-12">
    <h2 class="text-center ">Terminos y condiciones</h2>
</div>

<div class="col-lg-12">
<div class="card">

<div class="card-header">
    Terminos y condiciones
</div>

<div class="card-body">
    <form method="POST"> 
    <div class="form-group">
                    <input type="text" required hidden readonly class="form-control" value="<?php echo $Terminos['id']; ?>" name="txtID" id="txtID" placeholder="ID">
                </div>
        <div class="form-group">
            <label for="txtItem">Contenido:</label>
            <textarea class="form-control" <?php echo ($accion!="Modificar")?"readonly":"";?> name="txtItem" id="txtItem" rows="10"><?php echo $Terminos['item']; ?></textarea>

        </div>
        <button type="submit" name="accion" <?php echo ($accion=="Modificar")?"disabled hidden":"";?> value="Modificar" class="btn btn-success">Modificar</button>
        <button type="submit" name="accion" <?php echo ($accion!="Modificar")?"disabled hidden":"";?> value="Cancelar" class="btn btn-info">Cancelar</button>
        <button type="submit" name="accion" <?php echo ($accion!="Modificar")?"disabled hidden":"";?> value="Guardar" class="btn btn-warning">Guardar</button>
    </form>
</div>
</div>
</div>

<?php include('../template/pie.php');?>