<?php
//captura de datos
$txtID=(isset($_POST['txtID']))?$_POST['txtID']:"";
$txtNombre=(isset($_POST['txtNombre']))?$_POST['txtNombre']:"";
$txtTipo=(isset($_POST['txtTipo']))?$_POST['txtTipo']:"";
$txtImagen=(isset($_FILES['txtImagen']['name']))?$_FILES['txtImagen']['name']:"";

$accion=(isset($_POST['accion']))?$_POST['accion']:"";


include('../config/bd.php');

//accion ejecutada
switch($accion){
    case "Agregar":
        $sentenciaSQL= $conexion->prepare("INSERT INTO trabajos (nombre_cliente, tipo, imagen) VALUES (:nombre, :tipo, :imagen);");
        $sentenciaSQL->bindParam(':nombre',$txtNombre);
        $sentenciaSQL->bindParam(':tipo',$txtTipo);
        
        $fecha= new DateTime();
        $nombreArchivo=($txtImagen!="")?$fecha->getTimestamp()."_".$_FILES["txtImagen"]["name"]:"imagen.jpg";
        
        $tmpImagen=$_FILES["txtImagen"]["tmp_name"];
        
        if($tmpImagen!=""){
            move_uploaded_file($tmpImagen,"../../img/trabajos/".$nombreArchivo);
        }
        
        
        $sentenciaSQL->bindParam(':imagen',$nombreArchivo);
        $sentenciaSQL->execute();
        header("Location:galerias.php");
        break;

    case "Modificar":
        $sentenciaSQL= $conexion->prepare("UPDATE trabajos SET nombre_cliente=:nombre, tipo=:tipo WHERE id=:id;");
        $sentenciaSQL->bindParam(':nombre',$txtNombre);
        $sentenciaSQL->bindParam(':tipo',$txtTipo);
        $sentenciaSQL->bindParam(':id',$txtID);
        $sentenciaSQL->execute();

        if ($txtImagen != ""){

            //se crea nuevo nombre para la img
            $fecha= new DateTime();
            $nombreArchivo=($txtImagen!="")?$fecha->getTimestamp()."_".$_FILES["txtImagen"]["name"]:"imagen.jpg";
            $tmpImagen=$_FILES["txtImagen"]["tmp_name"];

            move_uploaded_file($tmpImagen,"../../img/trabajos/".$nombreArchivo); //mueve la img de la ubicacion tmp a img

            //borramos la imagen anterior
            $sentenciaSQL= $conexion->prepare("SELECT imagen FROM trabajos WHERE id=:id");
            $sentenciaSQL->bindParam(':id',$txtID);
            $sentenciaSQL->execute();
            $trabajo=$sentenciaSQL->fetch(PDO::FETCH_LAZY);

            if(isset($trabajo["imagen"]) && ($trabajo["imagen"]!="imagen.jpg")){
                if(file_exists("../../img/trabajos/".$trabajo["imagen"])){
                    unlink("../../img/trabajos/".$trabajo["imagen"]);
                }
            }


            $sentenciaSQL= $conexion->prepare("UPDATE trabajos SET imagen=:imagen WHERE id=:id;");
            $sentenciaSQL->bindParam(':imagen',$nombreArchivo);
            $sentenciaSQL->bindParam(':id',$txtID);
            $sentenciaSQL->execute();
            header("Location:galerias.php");
        }

        break;

    case "Cancelar":
        header("Location:galerias.php");
        break;

    case "Seleccionar":
        $sentenciaSQL= $conexion->prepare("SELECT * FROM trabajos WHERE id=:id");
        $sentenciaSQL->bindParam(':id',$txtID);
        $sentenciaSQL->execute();
        $trabajo=$sentenciaSQL->fetch(PDO::FETCH_LAZY);

        $txtNombre=$trabajo['nombre_cliente']; //los valores recuperados
        $txtTipo=$trabajo['tipo'];
        $txtImagen=$trabajo['imagen'];
        break;

    case "Borrar":

        $sentenciaSQL= $conexion->prepare("SELECT imagen FROM trabajos WHERE id=:id");
        $sentenciaSQL->bindParam(':id',$txtID);
        $sentenciaSQL->execute();
        $libro=$sentenciaSQL->fetch(PDO::FETCH_LAZY);

        if(isset($libro["imagen"]) && ($libro["imagen"]!="imagen.jpg")){
            if(file_exists("../../img/trabajos/".$libro["imagen"])){
                unlink("../../img/trabajos/".$libro["imagen"]);
            }
        }

        $sentenciaSQL= $conexion->prepare("DELETE FROM trabajos WHERE id=:id");
        $sentenciaSQL->bindParam(':id',$txtID);
        $sentenciaSQL->execute(); 
        header("Location:galerias.php");
        break;
}

//los que se muestra en la tabla
$sentenciaSQL= $conexion->prepare("SELECT * FROM trabajos");
$sentenciaSQL->execute();
$listaTrabajos=$sentenciaSQL->fetchAll(PDO::FETCH_ASSOC);
?>
<?php include('../template/cabecera.php');?>
<div class="col-lg-12">
    <h2 class="text-center ">Galeria</h2>
</div>
<div class="col-md-5">

    <div class="card bg-light">

        <div class="card-header">
            Datos de trabajo realizado
        </div>

        <div class="card-body">
            <form method="POST" enctype="multipart/form-data"> <!-- para captar las imagenes-->
                <div class="form-group">
                    <label for="txtID">ID:</label>
                    <input type="text" required readonly class="form-control" value="<?php echo $txtID; ?>" name="txtID" id="txtID" placeholder="ID">
                </div>

                <div class="form-group">
                    <label for="txtNombre">Nombre del cliente:</label>
                    <input type="text" required class="form-control" value="<?php echo $txtNombre; ?>"name="txtNombre" id="txtNombre" placeholder="Nombre">
                </div>
                <div class="form-group">
                    <label for="txtTipo">Tipo de comision:</label>
                    <input type="text" required class="form-control" value="<?php echo $txtTipo; ?>"name="txtTipo" id="txtTipo" placeholder="Tipo de comision">
                </div>

                <div class="form-group">
                    <label for="txtImagen">Imagen de la comision:</label>

                    </br>
                    <?php if($txtImagen!=""){?>
                    <img class="img-thumbnail rounded" src="../../img/trabajos/<?php echo $txtImagen?>" width="100px" alt="">
                    <?php } ?>
                    </br></br>

                    <input type="file"  class="form-control" name="txtImagen" id="txtImagen" placeholder="Imagen">
                </div>

                <div class="btn-group" role="group" aria-label="">
                    <button type="submit" name="accion" <?php echo ($accion=="Seleccionar")?"disabled":"";?> value="Agregar" class="btn btn-success">Agregar</button>
                    <button type="submit" name="accion" <?php echo ($accion!="Seleccionar")?"disabled":"";?> value="Modificar" class="btn btn-warning">Modificar</button>
                    <button type="submit" name="accion" <?php echo ($accion!="Seleccionar")?"disabled":"";?> value="Cancelar" class="btn btn-info">Cancelar</button>
                </div>
            </form>
        </div>
    </div>


</div>

<div class="col-md-7">
    <table class="table border">
        <thead>
            <tr>
                <th>Nombre</th>
                <th>Tipo</th>
                <th>Imagen</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
        <?php foreach($listaTrabajos as $trabajo){?>
            <tr>
                <td><?php echo $trabajo['nombre_cliente'];?></td>
                <td><?php echo $trabajo['tipo'];?></td>
                <td>
                <img class="img-thumbnail rounded" src="../../img/trabajos/<?php echo $trabajo['imagen']?>" width="100px" alt="">
                
                </td>

                <td>

                <form method="post">

                    <input type="hidden" name="txtID" id="txtID" value="<?php echo $trabajo['id'];?>">

                    <input type="submit" name="accion" value="Seleccionar" class="btn btn-primary">

                    <input type="submit" name="accion" value="Borrar" class="btn btn-danger">

                </form>
                
                </td>
            </tr>
            <?php } ?>
        </tbody>
    </table>
</div>

<?php include('../template/pie.php');?>