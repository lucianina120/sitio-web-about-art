<?php
//config coneccion a base de datos

$host="localhost";
$db="sitio";
$usuario="root";
$contrasenia="";

try {

    $conexion = new PDO("mysql:host=$host;dbname=$db",$usuario,$contrasenia);
    
} catch ( Exception $ex) {

    echo $ex->getMessage();
}
?>