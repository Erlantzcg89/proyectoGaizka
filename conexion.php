<?php
function conectarse(){
// conexión mysqli
$conexion=new mysqli("localhost", "admin", "archive");
if ($conexion->connect_error) {
    die("Error en la conexion: ".$conexion->connect_error)."<br>";
}

// seleccionar la base de datos subastaserlantz
mysqli_select_db($conexion,"subastaserlantz");

return $conexion;
}

?>