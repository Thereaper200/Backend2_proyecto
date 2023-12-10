<?php include("../template/cabecera.php"); ?>



<?php

//error_reporting(E_ALL);
//ini_set('display_errors', 1);

$txtSN = (isset($_POST["txtSN"])) ? $_POST["txtSN"] : "";
$txtLider = (isset($_POST["txtLider"])) ? $_POST["txtLider"] : "";
$accion = (isset($_POST["accion"])) ? $_POST["accion"] : "";

include("../config/db.php");

$sentenciaSQLlideres = $conexion->prepare("SELECT * FROM lideres");
$sentenciaSQLlideres->execute();
$listalideres = $sentenciaSQLlideres->fetchAll(PDO::FETCH_ASSOC);

$sentenciaSQLcolaboradores = $conexion->prepare("SELECT * FROM colaboradores");
$sentenciaSQLcolaboradores->execute();
$listaColaboradores = $sentenciaSQLcolaboradores->fetchAll(PDO::FETCH_ASSOC);

switch ($accion) {
    case "Buscar":
        $sentenciaSQL = $conexion->prepare("SELECT * FROM `colaboradores` WHERE `lider` LIKE :lider");
        $sentenciaSQL->bindParam(":lider", $txtLider);
        $sentenciaSQL->execute();
        
        $resultadosLider = $sentenciaSQL->fetchAll(PDO::FETCH_ASSOC);
        break;


    case "Agregar":
    // Obtener el número de serie ingresado
    $txtSNArray = (isset($_POST["txtSN"])) ? $_POST["txtSN"] : array();
    
    // Recorrer los colaboradores obtenidos en la búsqueda y procesar el número de serie para cada uno
    foreach ($resultadosLider as $colaborador) {
        // Obtener el nombre del colaborador y el líder
        $nombreColaborador = $colaborador["nombre"];
        $liderColaborador = $colaborador["lider"];
        
        // Verificar si se ingresó un número de serie para este colaborador
        if (isset($txtSNArray[$i])) {
            $numeroSerie = $txtSNArray[$i];
            
            // Realizar la inserción en la base de datos con los datos obtenidos
            $sentenciaSQL = $conexion->prepare("INSERT INTO `diarios_prueba` (`colaborador`, `lider`, `sn`, `fecha`) VALUES (:colaborador, :lider, :sn, CURRENT_TIMESTAMP)");
            $sentenciaSQL->bindParam(":colaborador", $nombreColaborador);
            $sentenciaSQL->bindParam(":lider", $liderColaborador);
            $sentenciaSQL->bindParam(":sn", $numeroSerie);
            $sentenciaSQL->execute();
            var_dump($nombreColaborador, $liderColaborador, $numeroSerie);
        }
        $i++;
    }
    break;

        

    case "Guardar":
        echo "Datos capturados en Guardar: ";
        echo "Datos capturados en Guardar: ";
        var_dump($txtSN, $id);
        $sentenciaSQL = $conexion->prepare("UPDATE `inventario_diario` SET `iPad` = :sn WHERE `inventario_diario`.`id` = :id");
        $sentenciaSQL->bindParam(":sn", $txtSN);
        $sentenciaSQL->bindParam(":id", $id);
        $sentenciaSQL->execute();

        echo "Datos capturados en Guardar: ";
        var_dump($txtSN, $id);
        break;


    
}


    

?>

<div class="col-md-5">
    <div class="card">
        <div class="card-header">
            Inventario
        </div>
        <div class="card-body">
            <form method="POST"> 
                <div class="form-group">
                    <label for="txtLider">Lider:</label>
                    <select class="form-control" name="txtLider">
                        <option selected disabled>-- Seleccione al líder --</option>
                        <?php
                        foreach ($listalideres as $lider) {
                            $nombreLider = $lider['lider'];
                            $selected = ($txtLider == $nombreLider) ? 'selected' : '';
                            echo "<option value=\"$nombreLider\" $selected>$nombreLider</option>";
                        }
                        ?>
                    </select>
                </div>
                <br>
                <div>
                    <button type="submit" name="accion" value="Buscar" class="btn btn-success">Buscar</button>
                    <button type="submit" name="accion" value="Agregar" class="btn btn-danger">Agregar</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="col-md-7">
    <table class="table table-bordered">
        <thead> 
            <tr>
                <th>Colaborador</th>
                <th>Lider</th>
                <th>Numero de Serie</th>
            </tr>
        </thead>
        <form method="POST">
        <tbody>
            <?php 
            $i = 0;
            foreach ($resultadosLider as $colaborador):
            ?>
            <tr>
                <td><?php echo $colaborador["nombre"]; ?> <?php echo $colaborador["apellido"]; ?></td>
                <td><?php echo $colaborador["lider"]; ?></td>
                <td>
                    <input type="text" class="form-control" value="<?php echo $txtSN; ?>" name="txtSN[<?php echo $i; ?>]" id="txtSN" placeholder="Numero de Serie" pattern="[a-zA-Z0-9]{0,}" autocomplete="off">
                </td>
            </tr>
            <?php 
            $i++;
            endforeach; 
            ?>
        </tbody>
        <tfoot>
            <tr>
                <td colspan="3">
                    <button type="submit" name="accion" value="Guardar" class="btn btn-primary">Guardar</button>
                </td>
            </tr>
        </tfoot>
        </form>
    </table>
</div>

<?php include("../template/pie.php"); ?>
