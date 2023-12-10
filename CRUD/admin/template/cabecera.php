<?php 
ini_set('display_errors',0);

error_reporting(E_ALL & ~E_NOTICE);

?>

<!doctype html>
<html lang="en">
  <head>
    <title>Portal de Administrador</title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link  type="text/css" rel="stylesheet" href="<?php echo $url; ?>/admin/css/estilos.css">
    <link  type="text/css" rel="stylesheet" href="<?php echo $url; ?>../../css/bootstrap.min.css">
  </head>
  <body>
    <?php $url="http://".$_SERVER["HTTP_HOST"]."/CRUD";  ?>
    <nav class="navbar navbar-expand navbar-light bg-primary">
        <div class="nav navbar-nav">
            <a class="nav-item nav-link active" href="<?php echo $url; ?>/admin/inicio.php">Administrador<span class="sr-only">(current)</span></a>
            <a class="nav-item nav-link" href="<?php echo $url; ?>/admin/section/supervisor_inventario.php">Inventario Supervisor</a>
            <a class="nav-item nav-link" href="<?php echo $url; ?>/admin/section/inventario.php">Inventario</a>
            <a class="nav-item nav-link" href="<?php echo $url; ?>/admin/section/pedidos.php">Pedidos</a>
            <a class="nav-item nav-link" href="<?php echo $url; ?>/admin/section/colaboradores.php">Colaboradores</a>
            <a class="nav-item nav-link" href="<?php echo $url; ?>/admin/section/invent_test.php">Test</a>
            <a class="nav-item nav-link" href="<?php echo $url; ?>">Cerrar sesion</a>

        </div>
    </nav>

    <div class="container">
        <br>
        <div class="row">