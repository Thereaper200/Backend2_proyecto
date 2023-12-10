<?php include("../template/cabecera.php"); ?>

<?php
$txtSN = (isset($_POST["txtSN"])) ? $_POST["txtSN"] : "";
$txtBill = (isset($_POST["txtBill"])) ? $_POST["txtBill"] : ""; 
$txtCom = (isset($_POST["txtCom"])) ? $_POST["txtCom"] : "";
$lsModel = (isset($_POST["slModel"])) ? $_POST["slModel"] : "";
$lsUbic = (isset($_POST["slUbic"])) ? $_POST["slUbic"] : "";
$txtBus = (isset($_POST["txtBus"])) ? $_POST["txtBus"] : "";
$accion = (isset($_POST["accion"])) ? $_POST["accion"] : "";

include("../config/db.php");




switch ($accion) {
    case "Agregar":
        $serialNumbers = explode(",", $txtSN);
    
        foreach ($serialNumbers as $serial) {
            // Verificar si el número de serie ya existe en la base de datos
            $consultaExistencia = $conexion->prepare("SELECT COUNT(*) as count FROM tacnadb WHERE sn = :sn");
            $consultaExistencia->bindParam(":sn", $serial);
            $consultaExistencia->execute();
            $resultado = $consultaExistencia->fetch(PDO::FETCH_ASSOC);
    
            if ($resultado['count'] > 0) {
                echo "<script>alert('El número de serie $serial ya existe en la base de datos.')</script>";
                continue; // Saltar el proceso de inserción
            }
    
            // Si el número de serie no existe, procede con la inserción
            $sentenciaSQL = $conexion->prepare("INSERT INTO `tacnadb` (`sn`, `facturas`, `comentarios`, `modelo`, `ubicacion`) VALUES (:sn, :facturas, :comentarios, :modelo, :ubicacion)");
            $sentenciaSQL->bindParam(":sn", $serial);
            $sentenciaSQL->bindParam(":facturas", $txtBill);
            $sentenciaSQL->bindParam(":comentarios", $txtCom);
            $sentenciaSQL->bindParam(":modelo", $lsModel);
            $sentenciaSQL->bindParam(":ubicacion", $lsUbic);
            $sentenciaSQL->execute();
        }
        break;
    

    case "Modificar":
        $sentenciaSQL = $conexion->prepare("UPDATE tacnadb SET facturas = :facturas, comentarios = :comentarios, modelo = :modelo, ubicacion = :ubicacion WHERE sn = :sn");
        $sentenciaSQL->bindParam(":sn", $txtSN);
        $sentenciaSQL->bindParam(":facturas", $txtBill); 
        $sentenciaSQL->bindParam(":comentarios", $txtCom);
        $sentenciaSQL->bindParam(":modelo", $lsModel);
        $sentenciaSQL->bindParam(":ubicacion", $lsUbic);
        $sentenciaSQL->execute();
        break;

    case "Cancelar":
        $txtSN = "";
        $txtBill = "";
        $txtCom = "";
        $lsModel = "";
        $lsUbic = "";
        break;

    case "Seleccionar":
        $sentenciaSQL = $conexion->prepare("SELECT * FROM tacnadb WHERE sn = :sn");
        $sentenciaSQL->bindParam(":sn", $txtSN);
        $sentenciaSQL->execute();
        $listainventario = $sentenciaSQL->fetch(PDO::FETCH_LAZY);

        $txtSerialSelec = $listainventario["sn"];
        $txtBill = $listainventario["facturas"];
        $txtCom = $listainventario["comentarios"];
        $lsModelSelec = $listainventario["modelo"];
        $lsUbicSelec = $listainventario["ubicacion"];
        break;

    case "Borrar":
        $sentenciaSQL = $conexion->prepare("DELETE FROM tacnadb WHERE sn = :sn");
        $sentenciaSQL->bindParam(":sn", $txtSN);
        $sentenciaSQL->execute();
        break;
        

    case "Ubic":
        $serialNumbers = explode(",", $txtSN);
        $sentenciaSQL = $conexion->prepare("UPDATE tacnadb SET ubicacion = :ubicacion WHERE sn = :sn");
                
        foreach ($serialNumbers as $serial) {
            $sentenciaSQL->bindParam(":sn", $serial);
            $sentenciaSQL->bindParam(":ubicacion", $lsUbic);
            $sentenciaSQL->execute();
        }
        break;
        
    case "Buscar":
        $txtBus = "%" . $txtBus . "%"; 
        
        $sentenciaSQL = $conexion->prepare("SELECT * FROM `tacnadb` WHERE `sn` LIKE :sn");
        $sentenciaSQL->bindParam(":sn", $txtBus);
        $sentenciaSQL->execute();
        
        $resultadosBusqueda = $sentenciaSQL->fetchAll(PDO::FETCH_ASSOC); 
        break;


}

$sentenciaSQL = $conexion->prepare("SELECT * FROM tacnadb");
//$sentenciaSQL = $conexion->prepare("SELECT * FROM tacnadb INNER JOIN ipad_models ON tacnadb.modelo = ipad_models.model;");
$sentenciaSQL->execute();
$listainventario = $sentenciaSQL->fetchAll(PDO::FETCH_ASSOC);

$sentenciaSQL_conjunta = $conexion->prepare("SELECT * FROM tacnadb INNER JOIN ipad_models ON tacnadb.modelo = ipad_models.model;");
$sentenciaSQL_conjunta->execute();
$listainventarioCombinada = $sentenciaSQL_conjunta->fetchAll(PDO::FETCH_ASSOC);

$listaCombinada = array_merge($listainventarioCombinada, $listainventario);
$listaUnica = array_unique($listaCombinada);

$dispositivosUnicos = array();

// Recorre la lista combinada y agrega los dispositivos únicos al array
foreach ($listaCombinada as $dispositivo) {
    $serial = $dispositivo["sn"];
    if (!in_array($serial, array_column($dispositivosUnicos, "sn"))) {
        $dispositivosUnicos[] = $dispositivo;
    }
}

?>


<div class="col-md-5">
    <div class="card tabla-izquierda">
        <div class="card-header">
            Inventario
        </div>
        <div class="card-body">
            <form method="POST" enctype="multipart/form-data">
                
                <div class="form-group">
                    <label for="txtBus">Busqueda:</label>
                    <input type="text" class="form-control" value="<?php echo $txtBus; ?>" name="txtBus" id="txtBus" placeholder="Busqueda" autocomplete="off">
                    <br>
                    <input type="submit" name="accion" value="Buscar" class="btn btn-primary">
                </div>
                
                <div class="form-group">
                    <label for="txtSN">Serial Number:</label>
                    <input type="text" class="form-control" value="<?php echo $txtSN; ?>" name="txtSN" id="txtSN" placeholder="SN" pattern="[a-z, A-Z, 0-9]{0,32}" autocomplete="off">
                </div>

                <div class="form-group">
                    <label for="txtBill">Factura:</label>
                    <input type="text" class="form-control" value="<?php echo $txtBill; ?>" name="txtBill" id="txtBill" placeholder="Factura" pattern="[a-z, A-Z, 0-9, \-]{0,32}" autocomplete="off">
                </div>

                <div class="form-group">
                    <label for="txtCom">Comentarios:</label>
                    <input type="text" class="form-control" value="<?php echo $txtCom; ?>" name="txtCom" id="txtCom" placeholder="Comentarios" pattern="[a-z, A-Z, 0-9]{0,}" autocomplete="off">
                </div>

                <div class="form-group">
                    <label for="slModel">Modelo:</label>
                    <input type="text" class="form-control" value="<?php echo $lsModel; ?>" name="slModel" id="slModel" placeholder="Modelo" pattern="[a-zA-Z0-9]{0,32}" autocomplete="off">
                </div>

                <br>
        
                
                <label for="slUbic">Ubicacion:</label>
                <select class="form-group" name="slUbic">
                    <option selected disabled>-- Seleccione la ubicación --</option>
                    <option value="Oficina 1"<?php if ($lsUbicSelec == 'Oficina 1') echo ' selected'; ?>>Oficina 1</option>
                    <option value="Oficina 2"<?php if ($lsUbicSelec == 'Oficina 2') echo ' selected'; ?>>Oficina 2</option>
                    <option value="Oficina 3"<?php if ($lsUbicSelec == 'Oficina 3') echo ' selected'; ?>>Oficina 3</option>
                    <option value="Oficina 4"<?php if ($lsUbicSelec == 'Oficina 4') echo ' selected'; ?>>Oficina 4</option>
                    <option value="Oficina 5"<?php if ($lsUbicSelec == 'Oficina 5') echo ' selected'; ?>>Oficina 5</option>
                    <option value="AgTech"<?php if ($lsUbicSelec == 'AgTech') echo ' selected'; ?>>AgTech</option>
                    <option value="Phoenix"<?php if ($lsUbicSelec == 'Phoenix') echo ' selected'; ?>>Phoenix</option>
                    <option value="QC"<?php if ($lsUbicSelec == 'QC') echo ' selected'; ?>>QC</option>
                    <option value="Alpha"<?php if ($lsUbicSelec == 'Alpha') echo ' selected'; ?>>Alpha</option>
                    <option value="Azkaban"<?php if ($lsUbicSelec == 'Azkaban') echo ' selected'; ?>>Azkaban</option>
                    <option value="Cabina"<?php if ($lsUbicSelec == 'Cabina') echo ' selected'; ?>>Cabina</option>
                    <option value="Administrativo"<?php if ($lsUbicSelec == 'Administrativo') echo ' selected'; ?>>Administrativo</option>
                </select>

                <br>
                
                <div class="btn-group" role="group" aria-label="">
                    <button type="submit" name="accion" value="Agregar" class="btn btn-success">Agregar</button>
                    <button type="submit" name="accion" value="Modificar" class="btn btn-warning">Modificar</button>
                    <button type="submit" name="accion" value="Cancelar" class="btn btn-danger">Cancelar</button>
                    <button type="submit" name="accion" value="Ubic" class="btn btn-primary">Update Ubic</button>
                </div>
            </form>
        </div>
    </div>
</div>


<div class="col-md-7">
    <table class="table table-bordered tabla-izquierda">
        
        <thead>
            <tr>
                <th>SN</th>
                <th>Factura</th>
                <th>Comentarios</th>
                <!--<th>Modelo</th>-->
                <th>Dispositivo</th>
                <th>Ubicacion</th>
                <th>Opciones</th>
            </tr>
        </thead>
        <tbody>
        

        <?php foreach($dispositivosUnicos as $dispositivo):  ?>
            <tr>
                <td><?php echo $dispositivo["sn"];?></td>
                <td><?php echo $dispositivo["facturas"];?></td>
                <td><?php echo $dispositivo["comentarios"];?></td>
                <!--<td><?php //echo $dispositivo["modelo"];?></td>-->
                <td><?php echo $dispositivo["device"];?></td>
                <td><?php echo $dispositivo["ubicacion"];?></td>
                <td>
                    <form method="POST">
                        <input type="hidden" name="txtSN" id="txtSN" value="<?php echo $dispositivo["sn"];?>" />
                        <input type="hidden" name="slModel" value="<?php echo $lsModelSelec; ?>" />
                        <input type="submit" name="accion" value="Seleccionar" class="btn btn-primary">
                        <input type="submit" name="accion" value="Borrar" class="btn btn-danger">
                    </form>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</div>

<div class="col-md-5">
    <table class="table table-bordered tabla-izquierda">
        <thead>
            <tr>
                <th>SN</th>
                <th>Factura</th>
                <th>Comentarios</th>
                <th>Ubicacion</th>
                <th>Opciones</th>
            </tr>
        </thead>
        <tbody>
        <?php foreach($resultadosBusqueda as $encontrado): ?>

            <tr>
                <td><?php echo $encontrado["sn"]; ?></td>
                <td><?php echo $encontrado["facturas"]; ?></td>
                <td><?php echo $encontrado["comentarios"]; ?></td>
                <td><?php echo $encontrado["ubicacion"]; ?></td>
                <td>
                    <form method="POST">
                        <input type="hidden" name="txtSN" value="<?php echo $encontrado["sn"]; ?>" />
                        <input type="submit" name="accion" value="Seleccionar" class="btn btn-primary">
                        <input type="submit" name="accion" value="Borrar" class="btn btn-danger">
                    </form>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</div>

<?php include("../template/pie.php"); ?>
