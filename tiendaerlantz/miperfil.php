<!DOCTYPE html>
<html>

<head>
    <title>Mi perfil</title>
    <meta charset="utf-8">
    <link href='https://fonts.googleapis.com/css?family=Open Sans' rel='stylesheet'>
    <link rel="icon" type="icon/ico" href="imagenes/favicon.ico" />
    <link rel="stylesheet" type="text/css" href="css/miperfil.css">

    <script type="application/javascript">
        function dibujar1() {
            var canvas = document.getElementById("logo");
            if (canvas.getContext) {
                var lienzo = canvas.getContext("2d");

                // cuadrados
                lienzo.fillStyle = "rgb(253,222,116)";
                lienzo.fillRect(10, 10, 55, 50);

                lienzo.fillStyle = "rgba(57, 192, 213, 0.5)";
                lienzo.fillRect(30, 30, 55, 50);


            }
        }

        function dibujar2() {
            var canvas = document.getElementById("logo2");
            if (canvas.getContext) {
                var lienzo = canvas.getContext("2d");


                //pentagrama
                for (var i = 0; i < 5; i++) {
                    lienzo.beginPath();
                    lienzo.moveTo(20, 25 + i * 10);
                    lienzo.lineTo(130, 25 + i * 10);
                    lienzo.lineWidth = 2;
                    lienzo.strokeStyle = "    #FFFFFF";
                    lienzo.stroke();
                }
                //circulo y palo de la notanota
                lienzo.save();
                lienzo.scale(2, 1);
                lienzo.beginPath();
                lienzo.arc(45, 45, 5, 0, 2 * Math.PI, false);
                lienzo.fillStyle = "#FDDE74";
                lienzo.fill();
                lienzo.lineWidth = 1;
                lienzo.strokeStyle = "    #FDDE74";
                lienzo.stroke();
                lienzo.restore();

                lienzo.beginPath();
                lienzo.moveTo(100, 46);
                lienzo.lineTo(100, 15);
                lienzo.lineWidth = 2;
                lienzo.strokeStyle = "    #FDDE74";
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

            <div class="login">
                <?php

                // conexión mysqli
                $conexion = new mysqli("localhost", "admin", "archive");
                if ($conexion->connect_error) {
                    die("Error en la conexion: " . $conexion->connect_error) . "<br>";
                }

                // seleccionar la base de datos tiendaerlantz
                mysqli_select_db($conexion, "tiendaerlantz");

                //valores por defecto
                $nombre = "defecto";
                $contra = "defecto";

                // recibir los post
                if (!empty($_POST["ingresar"])) {
                    $ingresar = $_POST["ingresar"];
                    $contra = $_POST["contra"];




                    $check = "SELECT * FROM usuarios WHERE nombre = '" . $nombre . "' AND contra = '" . $contra . "'";



                    $login = $conexion->query($check);

                    //checkear la validez de la cuenta para iniciar sesion
                    if ($login->num_rows == 1) {
                        //session_start();
                        $_SESSION['nombre'] = $nombre;

                        //guardar en sesion id_usuario
                        $sql = "SELECT * FROM usuarios WHERE nombre = '" . $_SESSION['nombre'] . "'";

                        $consulta = mysqli_query($conexion, $sql);
                        $row = mysqli_fetch_assoc($consulta);

                        $_SESSION['id'] = $row['id_usuario'];
                    }
                }


                //si la sesion esta on
                if (isset($_SESSION['nombre'])) {

                    echo "<p>Bienvenido, " . $_SESSION["nombre"] . "</p><br>";

                    // ingreso de dinero
                    if (isset($_POST['ingreso'])) {

                        //modificar dinero de la cuenta
                        $cantidad = $_POST['ingreso'];

                        $sql = "UPDATE usuarios SET dinero=dinero+" . $cantidad . " WHERE nombre='" . $_SESSION['nombre'] . "'";

                        if ($conexion->query($sql) === TRUE) {
                            echo "Dinero ingresado con éxito<br><br>";
                        } else {
                            echo "Error al ingresar la pasta" . $conexion->error;
                        }
                    }

                    // mostrar el saldo de la columna dinero del usuario
                    $saldo = "SELECT dinero FROM usuarios WHERE nombre = '" . $_SESSION['nombre'] . "'";

                    $saldoactual = mysqli_query($conexion, $saldo);
                    $row = mysqli_fetch_assoc($saldoactual);

                    echo "<p>Su saldo es de: " . $row['dinero'] . " &#8364;</p><br>";
                    echo "<form action='salir.php' method='post'>
    <input type='submit' value='Cerrar sesion'>
    </form><br>";


                    //selector de ingreso de dinero

                    echo "<form action='miperfil.php' method='post'>";
                    echo "Ingresar dinero en la cuenta: ";
                    echo "<input type='hidden' name='nombre' value='" . $_SESSION['nombre'] . "'></input>";
                    echo "<select name='ingreso'>
		<option value='0' selected='selected'>0 &#8364;</option>
		<option value='5'>5 &#8364;</option>
		<option value='20'>20 &#8364;</option>
		<option value='50'>50 &#8364;</option>
	</select><br><br>";
                    echo "<input type='submit' value='Ingresar dinero'></input>";
                    echo "</form>";
                } else {
                    echo "<p>Para ver tu perfil crea tu cuenta en la página de inicio.</p>";
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