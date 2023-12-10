<?php 
session_start();
  if(!isset($_SESSION["usuario"])){
    header("location:../index.php");
  }else{
    if($_SESSION["usuario"]=="ok"){
      $nombreUsuario=$_SESSION[];
    }
  }

?>