<?php
$host="localhost";
$db="basedeprueba";
$usuario="root";
$password="";

try {
    $conexion=new PDO("mysql:host=$host;dbname=$db",$usuario,$password);
    //if($conexion){echo "Conectado a la base de datos...";}
} catch ( Exception $ex) {
    echo $ex->getMessage();
}
?>