<?php include("../template/cabecera.php"); ?>

<?php
$txtID = (isset($_POST["txtID"])) ? $_POST["txtID"] : "";
$txtSupervisor = (isset($_POST["txtSupervisor"])) ? $_POST["txtSupervisor"] : "";
$txtPedido = (isset($_POST["txtPedido"])) ? $_POST["txtPedido"] : "";
$txtComentarios = (isset($_POST["txtComentarios"])) ? $_POST["txtComentarios"] : "";
$accion = (isset($_POST["accion"])) ? $_POST["accion"] : "";


include("../config/db.php");


//INSERT INTO `pedidos` (`id`, `oficina`, `pedido`, `comentario`, `fecha_pedido`) VALUES ('1', 'Oficina 1', '50 Pencils', 'Nos faltan lapices en la oficina', '2023-10-18');
//UPDATE `pedidos_prueba` SET `comentario` = 'cheems' WHERE `pedidos_prueba`.`id` = 2;
//UPDATE `pedidos_prueba` SET `oficina` = 'Cheems', `pedido` = 'chikito', `comentario` = 'de la vida' WHERE `pedidos_prueba`.`id` = 1;


switch ($accion) {
    case "Agregar":
        $sentenciaSQL = $conexion->prepare("INSERT INTO `pedidos_prueba` (`oficina`, `pedido`, `comentario`) VALUES (:oficina, :pedido, :comentario)");
        $sentenciaSQL->bindParam(":oficina", $txtSupervisor);
        $sentenciaSQL->bindParam(":pedido", $txtPedido);
        $sentenciaSQL->bindParam(":comentario", $txtComentarios);
        $sentenciaSQL->execute();
        break;

    case "Modificar":
        $sentenciaSQL = $conexion->prepare("UPDATE pedidos_prueba SET oficina = :oficina, pedido = :pedido, comentario = :comentario WHERE id = :id");
        $sentenciaSQL->bindParam(":id", $txtID);
        $sentenciaSQL->bindParam(":oficina", $txtSupervisor); 
        $sentenciaSQL->bindParam(":pedido", $txtPedido);
        $sentenciaSQL->bindParam(":comentario", $txtComentarios);
        $sentenciaSQL->execute();
        break;

    case "Cancelar":
        $txtID = "";
        $txtSupervisor = "";
        $txtPedido = "";
        $txtComentarios = "";
        $txtFechaPedido = "";
        break;


    case "Seleccionar":
        $sentenciaSQL = $conexion->prepare("SELECT * FROM pedidos_prueba WHERE id = :id");
        $sentenciaSQL->bindParam(":id", $txtID);
        $sentenciaSQL->execute();
        $listainventario = $sentenciaSQL->fetch(PDO::FETCH_LAZY);

        $txtSerialSelec = $listainventario["id"];
        $txtSupervisor = $listainventario["oficina"];
        $txtPedido = $listainventario["pedido"];
        $txtComentarios = $listainventario["comentario"];
        
        break;

    case "Borrar":
        $sentenciaSQL = $conexion->prepare("DELETE FROM pedidos_prueba WHERE id = :id");
        $sentenciaSQL->bindParam(":id", $txtID);
        $sentenciaSQL->execute();
        break;
}

$sentenciaSQL = $conexion->prepare("SELECT * FROM pedidos_prueba");
$sentenciaSQL->execute();
$listainventario = $sentenciaSQL->fetchAll(PDO::FETCH_ASSOC);
?>



<div class="col-md-5">
    <div class="card">
        <div class="card-header">
            Pedidos
        </div>
        <div class="card-body">
            <form method="POST" enctype="multipart/form-data">
                

                <div class="form-group">
                    <label for="txtSupervisor">Supervisor:</label>
                    <input type="text" class="form-control" value="<?php echo $txtSupervisor; ?>" name="txtSupervisor" id="txtSupervisor" placeholder="Supervisor" pattern="[a-z, A-Z]{4,8}" autocomplete="off">
                </div>

                <div class="form-group">
                    <label for="txtPedido">Pedido:</label>
                    <input type="text" class="form-control" value="<?php echo $txtPedido; ?>" name="txtPedido" id="txtPedido" placeholder="Pedido" pattern="[a-z, A-Z, 0-9]{0,255}" autocomplete="off">
                </div>

                
                <div class="form-group">
                    <label for="txtComentarios">Comentarios:</label>
                    <input type="text" class="form-control" value="<?php echo $txtComentarios; ?>" name="txtComentarios" id="txtComentarios" placeholder="Comentarios" pattern="[a-z, A-Z, 0-9]{0,255}" autocomplete="off">
                </div>

                <div class="btn-group" role="group" aria-label="">
                    <button type="submit" name="accion" value="Agregar" class="btn btn-success">Agregar</button>
                    <button type="submit" name="accion" value="Modificar" class="btn btn-warning">Modificar</button>
                    <button type="submit" name="accion" value="Cancelar" class="btn btn-danger">Cancelar</button>
                </div>
            </form>
        </div>
    </div>
</div>



<div class="col-md-7">
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Supervisor</th>
                <th>Pedido</th>
                <th>Fecha del pedido</th>
                <th>Comentarios</th>
                <th>Opciones</th>
            </tr>
        </thead>
        <tbody>
        <?php foreach($listainventario as $dispositivo):  ?>
            <tr>
                <td><?php echo $dispositivo["id"];?></td>
                <td><?php echo $dispositivo["oficina"];?></td>
                <td><?php echo $dispositivo["pedido"];?></td>
                <td><?php echo $dispositivo["fecha_time"];?></td>
                <td><?php echo $dispositivo["comentario"];?></td>
                <td>
                    <form method="POST">
                        <input type="hidden" name="txtID" id="txtID" value="<?php echo $dispositivo["id"];?>" />
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
