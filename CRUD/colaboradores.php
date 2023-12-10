<?php
include("template/cabecera.php");
include("admin/config/db.php");

try {
    $conexion = new PDO("mysql:host=$host;dbname=$db", $usuario, $password);
} catch (Exception $ex) {
    echo $ex->getMessage();
}

$search = isset($_GET['search']) ? $_GET['search'] : '';

if (!empty($search)) {
    $sentenciaSQL = $conexion->prepare("SELECT * FROM colaboradores WHERE numero_empleado LIKE :search");
    $sentenciaSQL->bindValue(':search', "%$search%");
    $sentenciaSQL->execute();
    $datos = $sentenciaSQL->fetchAll(PDO::FETCH_ASSOC);
} else {
    $sentenciaSQL = $conexion->prepare("SELECT * FROM colaboradores");
    $sentenciaSQL->execute();
    $datos = $sentenciaSQL->fetchAll(PDO::FETCH_ASSOC);
}
?>

<style>
        .form-group {
            display: inline-block; 
            margin-right: 10px; 
        }

        .form-control {
            width: 200px; 
        }

        .card {
            margin: 10px;
        }

        .card-title {
            font-size: 18px;
        }

        .card-text {
            font-size: 14px;
        }

        .busqueda {
            width: 10%;
        }
    </style>

<div class="row">
    <div class="col-md-12">
        <form method="GET">
            <div class="form-group">
                <input type="text" name="search" class="form-control" placeholder="Buscar por número de serie">
            </div>
            <button type="submit" class="btn btn-primary busqueda">Buscar</button>
        </form>
    </div>
</div>

<div class="row">
    <?php foreach ($datos as $item) { ?>
        <div class="col-md-3">
            <div class="card">
                <img class="card-img-top" src="<?php echo $item['foto_empleado']; ?>" alt="">
                <div class="card-body">
                    <h4 class="card-title"><?php echo $item['nombre'] . ' ' . $item['apellido']; ?></h4>
                    <p class="card-text">Numero de empleado: <?php echo $item['numero_empleado']; ?></p>
                    <p class="card-text">Oficina: <?php echo $item['oficina_empleado']; ?></p>
                    <p class="card-text">Lider: <?php echo $item['lider']; ?></p>
                    <a href="#" class="btn btn-primary">Ver más</a>
                </div>
            </div>
        </div>
    <?php } ?>
</div>

<?php include("template/pie.php"); ?>
