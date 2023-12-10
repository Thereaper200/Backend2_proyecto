<?php include("../template/cabecera.php");?>

<?php
include("../config/db.php");

$txtLider=(isset($_POST["txtLider"])) ? $_POST["txtLider"] : "";
$txtColaborador=(isset($_POST["txtColaborador"])) ? $_POST["txtColaborador"] : "";
$txtSN=(isset($_POST["txtSN"])) ? $_POST["txtSN"] : "";

?>

<div class="card">
    <div class="card-body">
        <h4 class="card-title">Datos</h4>

        <form method="POST" enctype="multipart/form-data">
            
        </form>

    </div>
</div>
