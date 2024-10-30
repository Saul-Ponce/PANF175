<?php

function connection(){
    $host = "108.181.201.116";
    $port = "37540";
    $user = "root";
    $password = "XE0OScsljFbXAQF0EfVQ7wUOl6AQecPZmxUZFyMe7SdoAt59ut1pyDFapWNgD86t";
    $dbname = "anf175";

    $conexion = mysqli_connect($host, $user, $password, $dbname, $port);
    mysqli_select_db($conexion,$dbname);

    return $conexion;
}
?>

