<?php include('../template/cabecera.php');?>
Cerrar
<?php include('../template/pie.php');?>

<?php
session_start();
session_destroy();
header("Location:../index.php")
?>