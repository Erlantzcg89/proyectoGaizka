<!DOCTYPE html>
<html>
<head>
	<title>Registro</title>
	<meta charset="utf-8">
	<link href='https://fonts.googleapis.com/css?family=Open Sans' rel='stylesheet'>
	<link rel="icon" type="icon/ico" href="imagenes/favicon.ico"/>
    <link rel="stylesheet" type="text/css" href="css/registro.css">

	<script type="application/javascript">
    function dibujar1() {
      var canvas = document.getElementById("logo");
      if (canvas.getContext) {
        var lienzo = canvas.getContext("2d");

        // cuadrados
        lienzo.fillStyle = "rgb(253,222,116)";
        lienzo.fillRect (10, 10, 55, 50);

        lienzo.fillStyle = "rgba(57, 192, 213, 0.5)";
        lienzo.fillRect (30, 30, 55, 50);


      }
    }
    function dibujar2() {
      var canvas = document.getElementById("logo2");
      if (canvas.getContext) {
        var lienzo = canvas.getContext("2d");

      
        //pentagrama
        for (var i = 0;i<5;i++) {
            lienzo.beginPath();
            lienzo.moveTo(20,25+i*10);
            lienzo.lineTo(130,25+i*10);
            lienzo.lineWidth=2;
            lienzo.strokeStyle="    #FFFFFF";
            lienzo.stroke();
        }
        //circulo y palo de la notanota
        lienzo.save();
        lienzo.scale(2,1);
        lienzo.beginPath();
        lienzo.arc(45,45,5,0,2*Math.PI, false);
        lienzo.fillStyle = "#FDDE74";
        lienzo.fill();
        lienzo.lineWidth = 1;
        lienzo.strokeStyle="    #FDDE74";
        lienzo.stroke();
        lienzo.restore();

        lienzo.beginPath();
        lienzo.moveTo(100,46);
        lienzo.lineTo(100,15);
        lienzo.lineWidth=2;
        lienzo.strokeStyle="    #FDDE74";
        lienzo.stroke();


      }
    }
  </script>
</head>
<body onload="dibujar1(), dibujar2()">

	<div class="contenedor">

		<div class="header">
            <div class="canvas1">
                <canvas id="logo" width="150" height="75"></canvas>
            </div>
            <div class="nombre">
			<h1>Música para disfrutar</h1>
            </div>
            <div class="canvas2">
                <canvas id="logo2" width="150" height="75"></canvas>
            </div>
            




		</div>

		<div class="menu">
			<ul>
			<li><a href="index.php">Inicio</a></li>
			<li><a href="tienda.php">Tienda</a></li>
			<li><a href="miperfil.php">Mi perfil</a></li>
			 <li class="dropdown">
                <a href="javascript:void(0)" class="dropbtn">Mi música</a>
                <div class="dropdown-content">
                    <a href="mimusica.php" class="oculto">Canciones</a>
                    <a href="videos.php" class="oculto">Videos</a>
                </div>
            </li>
			</ul>
		</div>

		<!-- Formulario de registro -->
		<div class="formulario">
			<form action="registro.php"method="post">
				<label>Nombre (Nickname): </label><input type="text" name="nombre" required><br>
				<label>Correo: </label><input type="email" name="correo" required"><br>
				<label>Contraseña: </label><input type="password" name="contra" required pattern="[a-zA-Z0-9]{6,}" title="La contraseña ha tener 6 o más digitos."><br>
				<input type="submit" value="Enviar"><br>
			</form>
		

<?php 

if (!empty($_POST["nombre"]) && !empty($_POST["correo"])&& !empty($_POST["contra"])){

// conexión mysqli
$conexion=new mysqli("localhost", "admin", "archive");
if ($conexion->connect_error) {
    die("Error en la conexion: ".$conexion->connect_error)."<br>";
} 

	$nombre=$_POST["nombre"];
	$correo=$_POST["correo"];
	$contra=$_POST["contra"];

// seleccionar la base de datos tiendaerlantz
mysqli_select_db($conexion,"tiendaerlantz");

echo "<br>";

	
// introducir el usuario en la tabla usuarios
$insertarusuario = "INSERT INTO usuarios (nombre, correo, contra, dinero) SELECT * FROM (SELECT '".$nombre."', '".$correo."', '".$contra."', '0') As tmp WHERE NOT EXISTS (SELECT nombre FROM usuarios WHERE nombre='".$nombre."')";

if ($conexion->query($insertarusuario) === TRUE) {
    echo "Usuario '".$nombre."' introducido con éxito<br>";
    
    //registrar ingreso de usuario en un archivo de texto
    $archivoregistro=fopen("registro.txt", "a+");
    $entrada="Nombre: ".$nombre.", E-mail: ".$correo.", Contraseña:".$contra."\r\n";
    fwrite($archivoregistro, $entrada);
    fclose($archivoregistro);

} else {
    echo "Error al introducir el usuario '".$nombre."': " . $insertarusuario . "<br>" . mysqli_error($conexion)."<br>";
}
			

// cierre de conexión
$conexion->close();
		
}
?>
</div>


		<div class="footer">
    		<p>&copy;Erlantz Caballero 2018</p>
		</div>


	</div>

</body>
</html>