<!DOCTYPE html>
<html>
<head>
	<title>Compra</title>
	<meta charset="utf-8">
	<link href='https://fonts.googleapis.com/css?family=Open Sans' rel='stylesheet'>
	<link rel="icon" type="icon/ico" href="imagenes/favicon.ico"/>
    <link rel="stylesheet" type="text/css" href="css/compra.css">

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
	<div class="compra">
	<?php 

	// conexión mysqli
	$conexion=new mysqli("localhost", "admin", "archive");
	if ($conexion->connect_error) {
    die("Error en la conexion: ".$conexion->connect_error)."<br>";
	} 

	// seleccionar la base de datos tiendaerlantz
	mysqli_select_db($conexion,"tiendaerlantz");

	//fetchear dinero precompra
	$sql="SELECT * FROM usuarios WHERE nombre = '".$_SESSION['nombre']."'";

	$consulta = mysqli_query($conexion, $sql);
    $row = mysqli_fetch_assoc($consulta);

    $dineropre=$row['dinero'];
    $id_usuario=$_SESSION['id'];


    // monitores para ver las variables
    // echo "id usuario: ".$id_usuario."<br>";
    // echo "id canción: ".$_POST['id_cancion']."<br>";
    // echo "dinero pre-compra: ".$dineropre."<br>";



	//Si llega el post con el comprar
	if (isset($_POST['titulo'])){

	//chequear que no se haya comprado la canción
	$check1="SELECT * FROM compras WHERE id_usuario = ".$id_usuario." AND id_cancion = ".$_POST['id_cancion']."";
	$checkcancion =$conexion->query($check1);

	
		if($checkcancion->num_rows >= 1){
		//error, el usuario ya tiene la canción
			echo "Error en la compra. El usuario ya tiene esa canción.<br>";
		}elseif ($dineropre < $_POST['precio']) {
			echo "Error en la compra. El saldo es insuficiente.<br>";
		}
		else{


		// mensaje informativo
		echo "<p>Gracias por comprar: ".$_POST['titulo']."</p>
		Se le descontarán: ".$_POST['precio']." Euros de su cuenta<br>";

		// introducir la compra en la tabla compras
		$insertarcompra = "INSERT INTO compras (id_usuario, id_cancion, fecha) VALUES ('".$id_usuario."', '".$_POST['id_cancion']."', now())";

			if ($conexion->query($insertarcompra) === TRUE) {
    		echo "Compra registrada con éxito<br>";
			} else {
    		echo "Error al registrar la compra: " . $insertarcompra . "<br>" . mysqli_error($conexion)."<br>";
			}

		// introducir la canción en la lista privada de canciones
		$insertarcancion = "INSERT INTO cancionesu (id_usuario, id_cancion) VALUES ('".$id_usuario."', '".$_POST['id_cancion']."')";

			if ($conexion->query($insertarcancion) === TRUE) {
    		echo "Cación añadida a la biblioteca privada.<br>";
			} else {
    		echo "Error al añadir la canción a la biblioteca: " . $insertarcancion . "<br>" . mysqli_error($conexion)."<br>";
			}

		// sustraer el importe de la cuenta de usuario
        $cantidad=$_POST['precio'];

        $sql = "UPDATE usuarios SET dinero=dinero-".$cantidad." WHERE nombre='".$_SESSION['nombre']."'";

		if ($conexion->query($sql) === TRUE) {
    		echo "Dinero sustraido con éxito<br><br>";
		} else {
    		echo "Error al sustraer la pasta" . $conexion->error;
		}

		}
	}

	// cierre de conexión
	$conexion->close();
	 ?>
	</div>

	<div class="footer">
    		<p>&copy;Erlantz Caballero 2018</p>
	</div>

</body>
</html>