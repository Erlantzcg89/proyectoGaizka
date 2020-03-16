<!DOCTYPE html>
<html>
<head>
	<title>Salir</title>
	<meta charset="utf-8">
	<link href='https://fonts.googleapis.com/css?family=Open Sans' rel='stylesheet'>
	<link rel="icon" type="icon/ico" href="imagenes/favicon.ico"/>
    <link rel="stylesheet" type="text/css" href="css/salir.css">

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

	<div>
	<div class="despedida">
	<?php 

	unset($_SESSION); // destruyo todas las variables de sesión creadas
	// obtengo los parámetros de la cookie de sesión
	// los necesitaré para poder destruirla
	$datos_cookie = session_get_cookie_params();
	// sobreescribo la cookie de sesión -la elimino
	setcookie( session_name(), NULL, time()-999999, $datos_cookie["path"], $datos_cookie["domain"], $datos_cookie["secure"],
	$datos_cookie["httponly"]);
	session_destroy(); // destruyo la sesión
	echo "Has cerrado la sesión. Vuelve cuando quieras.<br>";

	 ?>
	 </div>

     <div class="footer">
    <p>&copy; Erlantz Caballero 2018</p>
</div>

</body>
</html>