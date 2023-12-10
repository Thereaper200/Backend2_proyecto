<?php 
ini_set('display_errors',0);

error_reporting(E_ALL & ~E_NOTICE);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CRUD test</title>
    <link rel="stylesheet" href="./css/bootstrap.min.css" />
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
        <ul class="nav navbar-nav">
            <li class="nav-item">
                <a class="nav-link" href="https://portal.tacna.net/login">
                    <img src="img/logos/tacna_logo.png" alt="Logo de Tacna AI" width="150px" height="50px">
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="index.php">Inicio</a>
            </li>

            <li class="nav-item">
                <a class="nav-link" href="colaboradores.php">Colaboradores</a>
            </li>

            <li class="nav-item">
                <a class="nav-link" href="inventario.php">Inventario</a>
            </li>

            <li class="nav-item">
                <a class="nav-link" href="api.php">Facturas</a>
            </li>

            <li class="nav-item">
                <a class="nav-link" href="./admin/index.php">Administrativos</a>
            </li>

        </ul>
    </nav>

    <div class="container">
        <div class="row">