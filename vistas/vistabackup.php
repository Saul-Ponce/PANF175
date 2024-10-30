<?php
session_start();
if(!isset($_SESSION['usuario'])){
    echo '
    <script>
        alert("Por favor Inicia Sesión");
        window.location = "../index.html"
    </script>
    ';
    session_destroy();
    die();
}

include("../includes/sidebar.php");
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <title>Backup</title>
    <link rel="stylesheet" href="../assets/css/bootstrap.min.css">
    <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700,200" rel="stylesheet" />
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css" />
    <script src="https://kit.fontawesome.com/16e0069a57.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

    <!-- CSS Files -->
    <link href="../assets/css/bootstrap.min.css" rel="stylesheet" />
    <link href="../assets/css/light-bootstrap-dashboard.css" rel="stylesheet" />

    <!-- Core JS Files -->

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- Plugin for Switches, full documentation here: http://www.jque.re/plugins/version3/bootstrap.switch/ -->
    <script src="../assets/js/plugins/bootstrap-switch.js"></script>

    <!-- Notifications Plugin -->
    <script src="../assets/js/plugins/bootstrap-notify.js"></script>
    <!-- Control Center for Light Bootstrap Dashboard: scripts for the example pages etc -->
    <script src="../assets/js/light-bootstrap-dashboard.js?v=2.0.0 " type="text/javascript"></script>
</head>

<body>

    <div class="row justify-content-center align-items-center" style="height: 50vh; width: 225vh;">
        <div class="col-md-6 offset-md-2 d-flex justify-content-center align-items-center">
            <div class="card text-center">
                <div class="card-header bg">
                    <h1>Crear Respaldo de la Base de Datos</h1>
                </div>
                <div class="card-body">
                    <a href="./backup.php" class="btn btn-success">Crear Respaldo</a>
                </div>
            </div>
        </div>
    </div>

    <div class="row justify-content-center align-items-center" style="height: 20vh; width: 225vh;">
        <div class="col-md-6 offset-md-2 d-flex justify-content-center align-items-center">
            <div class="card text-center">
                <div class="card-header bg">
                    <h1>Realizar Restauración de la Base de Datos</h1>
                </div>
                <div class="card-body">
                    <form action="./restaurarbd.php" method="POST">
                        <label>Selecciona un punto de restauración</label><br>
                        <select name="restorePoint">
                            <option value="" disabled="" selected="">Selecciona un punto de restauración</option>
                            <?php include_once './connet.php';
                                $ruta=BACKUP_PATH;
                                if(is_dir($ruta)){
                                    if($aux=opendir($ruta)){
                                        while(($archivo = readdir($aux)) !== false){
                                            if($archivo!="."&&$archivo!=".."){
                                                $nombrearchivo=str_replace(".sql", "", $archivo);
                                                $nombrearchivo=str_replace("-", ":", $nombrearchivo);
                                                $ruta_completa=$ruta.$archivo;
                                                if(is_dir($ruta_completa)){
                                                }else{
                                                    echo '<option value="'.$ruta_completa.'">'.$nombrearchivo.'</option>';
                                                }
                                            }
                                        }
                                        closedir($aux);
                                    }
                                }else{
                                    echo $ruta." No es ruta válida";
                                }
                            ?>
                        </select>
                        <button type="submit" class="btn btn-primary">Restaurar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>

</html>
