<?php include("config/db.php");?>

<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $usuario = $_POST["usuario"];
    $clave = $_POST["clave"];

    $sql = "SELECT * FROM usuarios WHERE usuario = :usuario";
    $stmt = $conexion->prepare($sql);
    $stmt->bindParam(":usuario", $usuario);
    $stmt->execute();

    if ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        if (password_verify($clave, $row["clave"])) {
            header("Location: inicio.php");
        } else {
            echo '<script type="text/javascript">
            window.alert("Contraseña Incorrecta");
         </script>';
        }
    } else {
        echo '<script type="text/javascript">
            window.alert("Usuario Incorrecta");
         </script>';
    }
}
?>

<!doctype html>
<html lang="en">
  <head>
    <title>Administrador Portal</title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
  </head>
  <body>

    <div class="container">
        <div class="row">

            <div class="col-md-4">
                
            </div>

            <div class="col-md-4">
            <br><br><br><br></br>

                <div class="card">
                    <div class="card-header">
                        Login
                    </div>
                    <div class="card-body">

                        <form method="POST">
                        <div class = "form-group">
                        <label>Usuario: </label>
                        <input type="text" class="form-control" name="usuario" placeholder="Ingresa tu usuario" autocomplete="off">
                        <small id="emailHelp" class="form-text text-muted">Nunca compartas tu contraseña con nadie</small>
                        </div>
                        <div class="form-group">
                        <label>Contraseña: </label>
                        <input type="password" class="form-control" name="clave" placeholder="Ingresa tu contraseña" autocomplete="off">
                        </div>
              
                        <button type="submit" class="btn btn-primary">Ingresar</button>
                        </form>
                        
                        

                    </div>
                </div>
            </div>
            
        </div>
    </div>

  </body>
</html>