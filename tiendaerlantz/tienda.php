<!DOCTYPE html>
<html>
<head>
	<title>Tienda</title>
	<meta charset="utf-8">
	<link href='https://fonts.googleapis.com/css?family=Open Sans' rel='stylesheet'>
	<link rel="icon" type="icon/ico" href="imagenes/favicon.ico"/>
    <link rel="stylesheet" type="text/css" href="css/tienda.css">

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
    <?php 
    //iniciar sesión
    session_start(); ?>

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

<div class="tienda">
<?php 


// conexión mysqli
$conexion=new mysqli("localhost", "admin", "archive");
if ($conexion->connect_error) {
    die("Error en la conexion: ".$conexion->connect_error)."<br>";
} 

// seleccionar la base de datos tiendaerlantz
mysqli_select_db($conexion,"tiendaerlantz");

if (isset($_SESSION['nombre'])) {
	echo "<div class='bienvenida'>";
	echo "<p>Bienvenido, ".$_SESSION["nombre"]."</p><br>";
	// mostrar el saldo de la columna dinero del usuario
	$saldo="SELECT dinero FROM usuarios WHERE nombre = '".$_SESSION['nombre']."'";

	$saldoactual = mysqli_query($conexion, $saldo);
    $row = mysqli_fetch_assoc($saldoactual);

    echo "<p>Su saldo es de: ".$row['dinero']." &#8364;</p><br>";
    echo "<form action='salir.php' method='post'>
    <input type='submit' value='Cerrar sesion'>
    </form><br>";
	echo "</div>";

	$sql="SELECT * FROM canciones";

	$canciones = mysqli_query($conexion, $sql);
 

    echo "<table>";
    echo "<tr><th>Titulo</th><th>Artista</th><th>Estilo</th><th>Precio<th></tr>";
	while($fila = mysqli_fetch_assoc($canciones)){   
	echo "<tr><td>" . $fila['titulo'] . "</td><td>" . $fila['autor'] . "</td><td>" . $fila['estilo'] . "</td><td>" . $fila['precio'] . "  &#8364;</td><td><form action='compra.php' method='post'>
			<input type='hidden' name='titulo' value='".$fila['titulo']."'><input type='hidden' name='precio' value='".$fila['precio']."'>
			<input type='hidden' name='id_cancion' value='".$fila['id_cancion']."'>
			<input type='submit' value='Comprar'></input></form></td></tr>"; 
	}
		echo "</table>";

	
}else{
	

	$sql="SELECT * FROM canciones";

	$canciones = mysqli_query($conexion, $sql);
 

    echo "<table>";
    echo "<tr><th>Titulo</th><th>Artista</th><th>Estilo</th></tr>";
	while($fila = mysqli_fetch_assoc($canciones)){   
	echo "<tr><td>" . $fila['titulo'] . "</td><td>" . $fila['autor'] . "</td><td>" . $fila['estilo'] . "</td></tr>"; 
	}
	echo "</table>";

}
	

	// cierre de conexión
	$conexion->close();	 
?>
</div>




		<div class="footer">
    		<p>&copy;Erlantz Caballero 2018</p>
		</div>


	</div>

</body>
</html>