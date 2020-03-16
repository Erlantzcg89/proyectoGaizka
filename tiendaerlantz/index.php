<!DOCTYPE html>
<html>
<head>
	<title>Tienda Erlantz</title>
	<meta charset="utf-8">
    <link href='https://fonts.googleapis.com/css?family=Open Sans' rel='stylesheet'>
    <link rel="icon" type="icon/ico" href="imagenes/favicon.ico"/>
    <link rel="stylesheet" type="text/css" href="css/index.css">

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

    <div class="login">
        <h3>Login:</h3>
        <br>

        <div class="formulario">
        <form action="miperfil.php" method="post">
            <label>Nombre: </label><input type="text" name="nombre"><br>
            <label>Contraseña: </label><input type="password" name="contra"><br><br>
            <input type="submit" value="Iniciar Sesión" class="boton">
        </form>
        </div>
        <br>
        <p>Si todavía no tienes una cuenta, <a href="registro.php">REGISTRATE AQUÍ</a></p><br>

    </div>

    <div class="nueve"></a>
        <a href="tienda.php"><img id="nueve" src="imagenes/caratulas.png"></a>
    </div>

<div class="log">
<h3 style="color:#D55439;">Log:</h3>
<br>
<?php 

// conexión mysqli
$conexion=new mysqli("localhost", "admin", "archive");
if ($conexion->connect_error) {
    die("Error en la conexion: ".$conexion->connect_error)."<br>";
} 

// creación de la base de datos tiendaerlantz
$creabdd="CREATE DATABASE if not exists tiendaerlantz";

if ($conexion->query($creabdd) === TRUE) {
    echo "Se ha creado la base de datos <strong>tiendaerlantz</strong><br>";
} else {
    echo "Error al crear la base de datos <strong>tiendaerlantz</strong>: ".$conexion->error."<br>";
}

// seleccionar la base de datos tiendaerlantz
mysqli_select_db($conexion,"tiendaerlantz");

echo "<br>";

// preparar sql y crear tabla1 canciones
$creatabla1="CREATE TABLE if not exists canciones(id_cancion int(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,titulo varchar(50), autor varchar(25), estilo varchar(25), precio int(20) UNSIGNED, url_cancion varchar(100), imagen_cancion varchar(100))";

if ($conexion->query($creatabla1) === TRUE) {
    echo "Tabla <strong>canciones</strong> creada con exito<br>";
} else {
    echo "Error al crear la tabla <strong>canciones</strong>: ".$conexion->error."<br>";
}


// preparar sql y crear tabla2 usuarios
$creatabla2="CREATE TABLE if not exists usuarios(id_usuario int(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,nombre varchar(50),correo varchar(25), contra varchar(25), dinero int(20) UNSIGNED, fecha varchar(25),foto varchar(25))";

if ($conexion->query($creatabla2) === TRUE) {
    echo "Tabla <strong>usuarios</strong> creada con exito<br>";
} else {
    echo "Error al crear la tabla <strong>usuarios</strong>: ".$conexion->error."<br>";
}

// preparar sql y crear tabla3 cancionesu
$creatabla3="CREATE TABLE if not exists cancionesu(id_usuario int(6), id_cancion int(6))";

if ($conexion->query($creatabla3) === TRUE) {
    echo "Tabla <strong>cancionesusuario</strong> creada con exito<br>";
} else {
    echo "Error al crear la tabla <strong>cancionesusuario</strong>: ".$conexion->error."<br>";
}

// preparar sql y crear tabla4 compras
$creatabla4="CREATE TABLE if not exists compras(id_usuario int(6), id_cancion int(6), fecha datetime)";

if ($conexion->query($creatabla4) === TRUE) {
    echo "Tabla <strong>compras</strong> creada con exito<br>";
} else {
    echo "Error al crear la tabla <strong>compras</strong>: ".$conexion->error."<br>";
}

echo "<br>";

// introducir la canción 1 en la tabla canciones
$insertarcancion1 = "INSERT INTO canciones (titulo, autor, estilo, precio, url_cancion) SELECT * FROM (SELECT 'positive vibration', 'Bob Marley', 'reggae', '5', 'audios/positivevibration.ogg') As tmp WHERE NOT EXISTS (SELECT titulo FROM canciones WHERE titulo='positive vibration')";

if ($conexion->query($insertarcancion1) === TRUE) {
    echo "Cancion 'positive vibration' introducida con éxito<br>";
} else {
    echo "Error al introducir la cancion positive 'vibration': " . $insertarcancion1 . "<br>" . mysqli_error($conexion)."<br>";
}

// introducir la canción 2 en la tabla canciones
$insertarcancion2 = "INSERT INTO canciones (titulo, autor, estilo, precio, url_cancion) SELECT * FROM (SELECT 'havana', 'Camila Cabello', 'latin pop', '5', 'audios/havana.ogg') As tmp WHERE NOT EXISTS (SELECT titulo FROM canciones WHERE titulo='havana')";

if ($conexion->query($insertarcancion2) === TRUE) {
    echo "Cancion 'havana' introducida con éxito<br>";
} else {
    echo "Error al introducir la cancion 'havana': " . $insertarcancion2 . "<br>" . mysqli_error($conexion)."<br>";
}

// introducir la canción 3 en la tabla canciones
$insertarcancion3 = "INSERT INTO canciones (titulo, autor, estilo, precio, url_cancion) SELECT * FROM (SELECT 'issues', 'Julia Michaels', 'pop', '5', 'audios/issues.ogg') As tmp WHERE NOT EXISTS (SELECT titulo FROM canciones WHERE titulo='issues')";

if ($conexion->query($insertarcancion3) === TRUE) {
    echo "Cancion 'issues' introducida con éxito<br>";
} else {
    echo "Error al introducir la cancion 'issues': " . $insertarcancion3 . "<br>" . mysqli_error($conexion)."<br>";
}

// introducir la canción 4 en la tabla canciones
$insertarcancion4 = "INSERT INTO canciones (titulo, autor, estilo, precio, url_cancion) SELECT * FROM (SELECT 'heaven', 'Julia Michaels', 'pop', '5', 'audios/heaven.ogg') As tmp WHERE NOT EXISTS (SELECT titulo FROM canciones WHERE titulo='heaven')";

if ($conexion->query($insertarcancion4) === TRUE) {
    echo "Cancion 'heaven' introducida con éxito<br>";
} else {
    echo "Error al introducir la cancion 'heaven': " . $insertarcancion4 . "<br>" . mysqli_error($conexion)."<br>";
}

// introducir la canción 5 en la tabla canciones
$insertarcancion5 = "INSERT INTO canciones (titulo, autor, estilo, precio, url_cancion) SELECT * FROM (SELECT 'you dont know what love is', 'Nina Simone', 'jazz', '5', 'audios/youdontknow.ogg') As tmp WHERE NOT EXISTS (SELECT titulo FROM canciones WHERE titulo='you dont know what love is')";

if ($conexion->query($insertarcancion5) === TRUE) {
    echo "Cancion 'you dont know what love is' introducida con éxito<br>";
} else {
    echo "Error al introducir la cancion 'you dont know what love is': " . $insertarcancion5 . "<br>" . mysqli_error($conexion)."<br>";
}

// introducir la canción 6 en la tabla canciones
$insertarcancion6 = "INSERT INTO canciones (titulo, autor, estilo, precio, url_cancion) SELECT * FROM (SELECT 'depende', 'Jarabe de Palo', 'pop', '5', 'audios/depende.ogg') As tmp WHERE NOT EXISTS (SELECT titulo FROM canciones WHERE titulo='depende')";

if ($conexion->query($insertarcancion6) === TRUE) {
    echo "Cancion 'depende' introducida con éxito<br>";
} else {
    echo "Error al introducir la cancion 'depende': " . $insertarcancion6 . "<br>" . mysqli_error($conexion)."<br>";
}

// introducir la canción 7 en la tabla canciones
$insertarcancion7 = "INSERT INTO canciones (titulo, autor, estilo, precio, url_cancion) SELECT * FROM (SELECT 'grita', 'Jarabe de Palo', 'pop', '5', 'audios/grita.ogg') As tmp WHERE NOT EXISTS (SELECT titulo FROM canciones WHERE titulo='grita')";

if ($conexion->query($insertarcancion7) === TRUE) {
    echo "Cancion 'grita' introducida con éxito<br>";
} else {
    echo "Error al introducir la cancion 'grita': " . $insertarcancion7 . "<br>" . mysqli_error($conexion)."<br>";
}

// introducir la canción 8 en la tabla canciones
$insertarcancion8 = "INSERT INTO canciones (titulo, autor, estilo, precio, url_cancion) SELECT * FROM (SELECT 'el lado oscuro', 'Jarabe de Palo', 'pop', '5', 'audios/elladooscuro.ogg') As tmp WHERE NOT EXISTS (SELECT titulo FROM canciones WHERE titulo='el lado oscuro')";

if ($conexion->query($insertarcancion8) === TRUE) {
    echo "Cancion 'el lado oscuro' introducida con éxito<br>";
} else {
    echo "Error al introducir la cancion 'el lado oscuro': " . $insertarcancion8 . "<br>" . mysqli_error($conexion)."<br>";
}

// introducir la canción 9 en la tabla canciones
$insertarcancion9 = "INSERT INTO canciones (titulo, autor, estilo, precio, url_cancion) SELECT * FROM (SELECT 'la fuerza del corazon', 'Alejandro Sanz', 'pop', '5', 'audios/lafuerzadelcor.ogg') As tmp WHERE NOT EXISTS (SELECT titulo FROM canciones WHERE titulo='la fuerza del corazon')";

if ($conexion->query($insertarcancion9) === TRUE) {
    echo "Cancion 'la fuerza del corazon' introducida con éxito<br>";
} else {
    echo "Error al introducir la cancion 'la fuerza del corazon': " . $insertarcancion9 . "<br>" . mysqli_error($conexion)."<br>";
}

// introducir la canción 10 en la tabla canciones
$insertarcancion10 = "INSERT INTO canciones (titulo, autor, estilo, precio, url_cancion) SELECT * FROM (SELECT 'a la primera persona', 'Alejandro Sanz', 'pop', '5', 'audios/alaprimerapersona.ogg') As tmp WHERE NOT EXISTS (SELECT titulo FROM canciones WHERE titulo='a la primera persona')";

if ($conexion->query($insertarcancion10) === TRUE) {
    echo "Cancion 'a la primera persona' introducida con éxito<br>";
} else {
    echo "Error al introducir la cancion 'a la primera persona': " . $insertarcancion10 . "<br>" . mysqli_error($conexion)."<br>";
}

// introducir la canción 11 en la tabla canciones
$insertarcancion11 = "INSERT INTO canciones (titulo, autor, estilo, precio, url_cancion) SELECT * FROM (SELECT 'boogaloo', 'Kase.O', 'rap', '5', 'audios/boogaloo.ogg') As tmp WHERE NOT EXISTS (SELECT titulo FROM canciones WHERE titulo='boogaloo')";

if ($conexion->query($insertarcancion11) === TRUE) {
    echo "Cancion 'boogaloo' introducida con éxito<br>";
} else {
    echo "Error al introducir la cancion 'boogaloo': " . $insertarcancion11 . "<br>" . mysqli_error($conexion)."<br>";
}

// introducir la canción 12 en la tabla canciones
$insertarcancion12 = "INSERT INTO canciones (titulo, autor, estilo, precio, url_cancion) SELECT * FROM (SELECT 'lover man', 'Charlie Parker', 'jazz', '5', 'audios/loverman.ogg') As tmp WHERE NOT EXISTS (SELECT titulo FROM canciones WHERE titulo='lover man')";

if ($conexion->query($insertarcancion12) === TRUE) {
    echo "Cancion 'lover man' introducida con éxito<br>";
} else {
    echo "Error al introducir la cancion 'lover man': " . $insertarcancion12 . "<br>" . mysqli_error($conexion)."<br>";
}

// introducir la canción 13 en la tabla canciones
$insertarcancion13 = "INSERT INTO canciones (titulo, autor, estilo, precio, url_cancion) SELECT * FROM (SELECT 'all the things you are', 'Charlie Parker', 'jazz', '5', 'audios/birdofparadise.ogg') As tmp WHERE NOT EXISTS (SELECT titulo FROM canciones WHERE titulo='all the things you are')";

if ($conexion->query($insertarcancion13) === TRUE) {
    echo "Cancion 'all the things you are' introducida con éxito<br>";
} else {
    echo "Error al introducir la cancion 'all the things you are': " . $insertarcancion13 . "<br>" . mysqli_error($conexion)."<br>";
}

// cierre de conexión
$conexion->close();

?>
</div>

<div class="footer">
    <p>&copy; Erlantz Caballero 2018</p>
</div>

</div>




</body>
</html>