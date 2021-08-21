<?php
//captura de datos
$txtID=(isset($_POST['txtID']))?$_POST['txtID']:"";
$txtNombre=(isset($_POST['txtNombre']))?$_POST['txtNombre']:"";
$txtEmail=(isset($_POST['txtEmail']))?$_POST['txtEmail']:"";
$txtCanal=(isset($_POST['txtCanal']))?$_POST['txtCanal']:"";
$txtAsunto=(isset($_POST['txtAsunto']))?$_POST['txtAsunto']:"";
$txtMensaje=(isset($_POST['txtMensaje']))?$_POST['txtMensaje']:"";
$txtFecha=(isset($_POST['txtFecha']))?$_POST['txtFecha']:"";

$accion=(isset($_POST['accion']))?$_POST['accion']:"";

include('../config/bd.php');

//accion ejecutada
switch($accion){
    
    case "Ver":
        $sentenciaSQL= $conexion->prepare("SELECT * FROM peticiones WHERE id=:id");
        $sentenciaSQL->bindParam(':id',$txtID);
        $sentenciaSQL->execute();
        $peticion=$sentenciaSQL->fetch(PDO::FETCH_LAZY);

        $txtNombre=$peticion['nombre']; //los valores recuperados
        $txtEmail=$peticion['email'];
        $txtCanal=$peticion['canal'];
        $txtAsunto=$peticion['asunto'];
        $txtMensaje=$peticion['mensaje'];
        $txtFecha=$peticion['fecha'];
        break;

    case "Cerrar":

        header("Location:peticiones.php");
        break;
}

//los que se muestra en la tabla
$sentenciaSQL= $conexion->prepare("SELECT * FROM peticiones");
$sentenciaSQL->execute();
$listaPeticiones=$sentenciaSQL->fetchAll(PDO::FETCH_ASSOC);
?>
<?php include('../template/cabecera.php');?>
<div class="col-lg-12">
    <h2 class="text-center ">Bandeja de entrada</h2>
</div>
<div class="col-lg-6">

        <table class="table border">
        <thead>
            <tr>
                <th>Nombre</th>
                <th>Asunto</th>
                <th>Fecha</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
        <?php foreach($listaPeticiones as $peticion){?>
            <tr>
                <td><?php echo $peticion['nombre'];?></td>
                <td><?php echo $peticion['asunto'];?></td>
                <td><?php echo $timeStamp = date( "d/m/Y", strtotime($peticion['fecha']));?></td>

                <td>

                <form method="post">

                    <input type="hidden" name="txtID" id="txtID" value="<?php echo $peticion['id'];?>">

                    <input type="submit" name="accion" value="Ver" class="btn btn-primary">


                </form>
                
                </td>
            </tr>
            <?php } ?>
        </tbody>
    </table>


</div>

<div class="col-lg-6">
<div class="card bg-light">

<div class="card-header">
    Mensaje
</div>

<div class="card-body">
    <form method="POST"> 
        
        <div class="form-group">
            <label for="txtFecha">Fecha:</label>
            <input type="text" readonly class="form-control" value="<?php echo $txtFecha; ?>"name="txtFecha" id="txtFecha" placeholder="">
        </div>
        <div class="form-group">
            <label for="txtNombre">Nombre:</label>
            <input type="text" readonly class="form-control" value="<?php echo $txtNombre; ?>"name="txtNombre" id="txtNombre" placeholder="">
        </div>
        <div class="form-group">
            <label for="txtCanal">Canal:</label>
            <input type="text" readonly class="form-control" value="<?php echo $txtCanal; ?>"name="txtCanal" id="txtCanal" placeholder="">
        </div>
        <div class="form-group">
            <label for="txtEmail">Email:</label>
            <input type="text" readonly class="form-control" value="<?php echo $txtEmail; ?>"name="txtEmail" id="txtEmail" placeholder="">
        </div>
        <div class="form-group">
            <label for="txtAsunto">Asunto:</label>
            <input type="text" readonly class="form-control" value="<?php echo $txtAsunto; ?>"name="txtAsunto" id="txtAsunto" placeholder="">
        </div>
        <div class="form-group">
            <label for="txtMensaje">Mensaje:</label>
            <input type="text" readonly class="form-control" value="<?php echo $txtMensaje; ?>"name="txtMensaje" id="txtMensaje" placeholder="">
        </div>

        <button type="submit" name="accion" <?php echo ($accion!="Ver")?"disabled":"";?> value="Cerrar" class="btn btn-info">Cerrar</button>
       
    </form>
</div>
</div>
</div>

<?php include('../template/pie.php');?>