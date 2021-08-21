<?php
//captura de datos
$txtID=(isset($_POST['txtID']))?$_POST['txtID']:"";
$txtNombre=(isset($_POST['txtNombre']))?$_POST['txtNombre']:"";
$txtPrecio=(isset($_POST['txtPrecio']))?$_POST['txtPrecio']:"";
$txtDescripcion=(isset($_POST['txtDescripcion']))?$_POST['txtDescripcion']:"";
$txtDetalle=(isset($_POST['txtDetalle']))?$_POST['txtDetalle']:"";
$txtImagen=(isset($_FILES['txtImagen']['name']))?$_FILES['txtImagen']['name']:"";

$accion=(isset($_POST['accion']))?$_POST['accion']:"";


include('../config/bd.php');

//accion ejecutada
switch($accion){
    case "Agregar":
        $sentenciaSQL= $conexion->prepare("INSERT INTO comisiones (nombre, precio, detalle, descripcion, imagen) VALUES (:nombre, :precio, :detalle, :descripcion, :imagen);");
        $sentenciaSQL->bindParam(':nombre',$txtNombre);
        $sentenciaSQL->bindParam(':precio',$txtPrecio);
        $sentenciaSQL->bindParam(':detalle',$txtDetalle);
        $sentenciaSQL->bindParam(':descripcion',$txtDescripcion);
        
        $fecha= new DateTime();
        $nombreArchivo=($txtImagen!="")?$fecha->getTimestamp()."_".$_FILES["txtImagen"]["name"]:"imagen.jpg";
        
        $tmpImagen=$_FILES["txtImagen"]["tmp_name"];
        
        if($tmpImagen!=""){
            move_uploaded_file($tmpImagen,"../../img/".$nombreArchivo);
        }
        
        
        $sentenciaSQL->bindParam(':imagen',$nombreArchivo);
        $sentenciaSQL->execute();
        header("Location:comisiones.php");
        break;

    case "Modificar":
        $sentenciaSQL= $conexion->prepare("UPDATE comisiones SET nombre=:nombre, precio=:precio, descripcion=:descripcion, detalle=:detalle WHERE id=:id;");
        $sentenciaSQL->bindParam(':nombre',$txtNombre);
        $sentenciaSQL->bindParam(':precio',$txtPrecio);
        $sentenciaSQL->bindParam(':detalle',$txtDetalle);
        $sentenciaSQL->bindParam(':descripcion',$txtDescripcion);
        $sentenciaSQL->bindParam(':id',$txtID);
        $sentenciaSQL->execute();

        if ($txtImagen != ""){

            //se crea nuevo nombre para la img
            $fecha= new DateTime();
            $nombreArchivo=($txtImagen!="")?$fecha->getTimestamp()."_".$_FILES["txtImagen"]["name"]:"imagen.jpg";
            $tmpImagen=$_FILES["txtImagen"]["tmp_name"];

            move_uploaded_file($tmpImagen,"../../img/".$nombreArchivo); //mueve la img de la ubicacion tmp a img

            //borramos la imagen anterior
            $sentenciaSQL= $conexion->prepare("SELECT imagen FROM comisiones WHERE id=:id");
            $sentenciaSQL->bindParam(':id',$txtID);
            $sentenciaSQL->execute();
            $comision=$sentenciaSQL->fetch(PDO::FETCH_LAZY);

            if(isset($comision["imagen"]) && ($comision["imagen"]!="imagen.jpg")){
                if(file_exists("../../img/".$comision["imagen"])){
                    unlink("../../img/".$comision["imagen"]);
                }
            }


            $sentenciaSQL= $conexion->prepare("UPDATE comisiones SET imagen=:imagen WHERE id=:id;");
            $sentenciaSQL->bindParam(':imagen',$nombreArchivo);
            $sentenciaSQL->bindParam(':id',$txtID);
            $sentenciaSQL->execute();
            header("Location:comisiones.php");
        }

        break;

    case "Cancelar":
        header("Location:comisiones.php");
        break;

    case "Seleccionar":
        $sentenciaSQL= $conexion->prepare("SELECT * FROM comisiones WHERE id=:id");
        $sentenciaSQL->bindParam(':id',$txtID);
        $sentenciaSQL->execute();
        $comision=$sentenciaSQL->fetch(PDO::FETCH_LAZY);

        $txtNombre=$comision['nombre']; //los valores recuperados
        $txtPrecio=$comision['precio'];
        $txtDescripcion=$comision['descripcion'];
        $txtDetalle=$comision['detalle'];
        $txtImagen=$comision['imagen'];
        break;

    case "Borrar":

        $sentenciaSQL= $conexion->prepare("SELECT imagen FROM comisiones WHERE id=:id");
        $sentenciaSQL->bindParam(':id',$txtID);
        $sentenciaSQL->execute();
        $libro=$sentenciaSQL->fetch(PDO::FETCH_LAZY);

        if(isset($libro["imagen"]) && ($libro["imagen"]!="imagen.jpg")){
            if(file_exists("../../img/".$libro["imagen"])){
                unlink("../../img/".$libro["imagen"]);
            }
        }

        $sentenciaSQL= $conexion->prepare("DELETE FROM comisiones WHERE id=:id");
        $sentenciaSQL->bindParam(':id',$txtID);
        $sentenciaSQL->execute(); 
        header("Location:comisiones.php");
        break;
}
//los que se muestra en la tabla
$sentenciaSQL= $conexion->prepare("SELECT * FROM comisiones");
$sentenciaSQL->execute();
$listaComisiones=$sentenciaSQL->fetchAll(PDO::FETCH_ASSOC);
?>
<?php include('../template/cabecera.php');?>
<div class="col-lg-12">
    <h2 class="text-center ">Comisiones</h2>
</div>
<div class="col-md-5">

    <div class="card bg-light">

        <div class="card-header">
            Datos de comision
        </div>

        <div class="card-body">
            <form method="POST" enctype="multipart/form-data"> <!-- para captar las imagenes-->
                <div class="form-group">
                    <label for="txtID">ID:</label>
                    <input type="text" required readonly class="form-control" value="<?php echo $txtID; ?>" name="txtID" id="txtID" placeholder="ID">
                </div>

                <div class="form-group">
                    <label for="txtNombre">Nombre:</label>
                    <input type="text" required class="form-control" value="<?php echo $txtNombre; ?>"name="txtNombre" id="txtNombre" placeholder="Nombre">
                </div>
                <div class="form-group">
                    <label for="txtPrecio">Precio:</label>
                    <input type="text" required class="form-control" value="<?php echo $txtPrecio; ?>"name="txtPrecio" id="txtPrecio" placeholder="Precio">
                </div>
                <div class="form-group">
                    <label for="txtDescripcion">Descripcion:</label>
                    <input type="text" required class="form-control" value="<?php echo $txtDescripcion; ?>"name="txtDescripcion" id="txtDescripcion" placeholder="Descripcion">
                </div>
                <div class="form-group">
                    <label for="txtDetalle">Detalle:</label>
                    <textarea class="form-control" name="txtDetalle" id="txtDetalle" rows="3" placeholder="Detalle"><?php echo $txtDetalle; ?></textarea>
               
                </div>

                <div class="form-group">
                    <label for="txtImagen">Imagen:</label>

                    </br>
                    <?php if($txtImagen!=""){?>
                    <img class="img-thumbnail rounded" src="../../img/<?php echo $txtImagen?>" width="100px" alt="">
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
                <th>Precio</th>
                <th>Descripcion</th>
                <th>Detalle</th>
                <th>Imagen</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
        <?php foreach($listaComisiones as $comision){?>
            <tr>
                <td><?php echo $comision['nombre'];?></td>
                <td><?php echo $comision['precio'];?></td>
                <td><?php echo $comision['descripcion'];?></td>
                <td><?php echo $comision['detalle'];?></td>
                <td>
                <img class="img-thumbnail rounded" src="../../img/<?php echo $comision['imagen']?>" width="100px" alt="">
                
                </td>

                <td>

                <form method="post">

                    <input type="hidden" name="txtID" id="txtID" value="<?php echo $comision['id'];?>">

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