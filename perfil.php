<!doctype html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<title>Gaizka Ugalde</title>
	<base href="/gaizka/">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="icon" type="image/x-icon" href="favicon.ico">

	<!-- bootstrap cdn -->
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">

	<!-- font awesome cdn -->
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.11.2/css/all.css">

	<link href="css/estilo.css" rel="stylesheet" type="text/css">

	<link href="css/index.css" rel="stylesheet" type="text/css">

</head>

<body onload="activarReloj();">



	<?php


	session_start();

	include 'conexion.php';
	$conexion = conectarse();


	?>




	<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
		<a class="navbar-brand" href="index.php"><i class="fas fa-home"></i> Inicio</a>
		<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
			<span class="navbar-toggler-icon"></span>
		</button>

		<div class="collapse navbar-collapse" id="navbarSupportedContent">
			<ul class="navbar-nav mr-auto">


				<li class="nav-item">

					<div class="dropdown">
						<button class="btn btn-dark dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
							<i class="fas fa-users"></i> Login
						</button>
						<div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
							<a class="dropdown-item" href="loginnuevo.php"><i class="fas fa-sign-in-alt"></i> Login</a>
							<a class="dropdown-item" href="registrousuario.php"><i class="fas fa-user-plus"></i> Registrarse</a>

						</div>
					</div>
				</li>

				<li class="nav-item">

					<div class="dropdown">
						<button class="btn btn-dark dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
							<i class="fas fa-gift"></i> Tienda
						</button>
						<div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
							<a class="dropdown-item" href="tienda.php"><i class="fas fa-table-tennis mr-1"></i> Palas</a>
							<a class="dropdown-item" href="tiendazapatillas.php"><i class="fas fa-shoe-prints mr-1"></i> Zapatillas</a>
							<a class="dropdown-item" href="tiendapelotas.php"><i class="fas fa-baseball-ball mr-1"></i> Pelotas</a>
							<a class="dropdown-item" href="tiendaaccesorios.php"><i class="fas fa-suitcase mr-1"></i> Paleteros y Accesorios</a>
						</div>
					</div>
				</li>

				<?php

				if (isset($_SESSION['nombre'])) {


					echo '<li class="nav-item">';
					echo '<a class="nav-link text-white" href="perfilusuario.php">';
					echo '<i class="fas fa-user"></i> Mi perfil';
					echo '</a>';
					echo '</li>';
				}


				?>


			</ul>
		</div> <!-- div izquierda -->

		<div class="navbar-collapse collapse">
			<ul class="navbar-nav ml-auto">

				<?php

				if (isset($_SESSION['nombre'])) {

					echo '<li class="nav-item">';
					echo '<span class="dropdown-item">';
					echo "Bienvenido: " . $_SESSION['nombre'];
					echo '</span>';
					echo '</li>';
				}


				if (isset($_SESSION['nombre'])) {

					echo '<li class="nav-item">';
					echo "<form action='salir.php' method='post'>
	<button class='btn btn-outline-danger' type'submit'>Cerrar Sesion <i class='fas fa-sign-out-alt'></i></button>
	</form>";
				}


				?>
				</li>
			</ul>
		</div> <!-- div derecha -->


		<span id="reloj"></span>
		<script>
			function activarReloj() {
				date = new Date();
				hora = formatearHora(date.getHours());
				minuto = formatearHora(date.getMinutes());
				segundo = formatearHora(date.getSeconds());

				document.getElementById("reloj").innerHTML = hora + ":" + minuto + ":" + segundo;

				setInterval(
					function() {
						date = new Date();
						hora = formatearHora(date.getHours());
						minuto = formatearHora(date.getMinutes());
						segundo = formatearHora(date.getSeconds());

						document.getElementById("reloj").innerHTML = hora + ":" + minuto + ":" + segundo;
					}, 1000
				);
			}


			function formatearHora(num) {
				if (num < 10) {
					num = "0" + num;
				}

				return num;
			}
		</script>
	</nav>



	<div class="row">
		<div class="col-4 p-4">
			<div class="perfilizquierda">
				<img src="imagenes/fotoo.png" class="img-thumbnail">

<?php 

if (isset($_SESSION['nombre'])) {

	//rellenar ficha de usuario
	$sql="SELECT * FROM usuario WHERE nombre = '".$_SESSION['nombre']."'";

	$consulta = mysqli_query($conexion, $sql);
    $row = mysqli_fetch_assoc($consulta);

    $dinero=$row['dinero'];

?>

				<p><strong>Gaizka</strong></p>
				<p><strong>Ugalde</strong></p>
				<p><strong>Correo:</strong></p>
				<p><strong>Saldo disponible:</strong></p>

				<input type="number" min="1" max="10000" />
				<button class="btn btn-success" type="submit">Ingresar</button>

			</div>
		</div>
		<div class="col-8 p-4">
			<p>Productos comprados:</p>
			<ul>
				<li>Producto 1. 30 Euros</li>
				<li>Producto 2. 30 Euros</li>
				<li>Producto 3. 30 Euros</li>
				<li>Producto 4. 30 Euros</li>
			</ul>
			<p>Total gastado: 120 euros</p>
		</div>
	</div>
    

    <?php









	//es por si el usuario mete mal los datos para que le salga la alerta
	if (!isset($_SESSION['nombre'])) {

		$nombre = "";
		$contrasena = "";


		if (!empty($_POST["nombre"]) && !empty($_POST["contrasena"])) {
			$nombre = $_POST["nombre"];
			$contrasena = $_POST["contrasena"];
		} // si llegan nombre nuevo



		$consulta = "SELECT * FROM usuarios WHERE nombre='" . $nombre . "' AND contrasena='" . $contrasena . "';";


		$ejecutar = $conexion->query($consulta);




		//SI AL EJECUTAR OBETENMOS EXACTANMENTE UN RESULTADO METEMOS ESE USUARIO EN LA SESION


		if ($ejecutar->num_rows == 1) {

			$_SESSION['nombre'] = $nombre;

			header("Refresh:0");
		} else {


			echo '<div class="alert alert-danger" role="alert">';
			echo "Error, el usuario introducido'" . $nombre . ' NO existe, <a href="registrousuario.php">Registrate</a> para poder logearte';
			echo '</div>';
		} // else

		// si sesion no está logueada ^

	} else {

		//rellenar ficha de usuario
	$sql="SELECT * FROM usuarios WHERE nombre = '".$_SESSION['nombre']."'";

	$consulta = mysqli_query($conexion, $sql);
    $row = mysqli_fetch_assoc($consulta);

    $dinero=$row['dinero'];

		// si sesion si esta logueada 

        if (!empty($_POST["ingresar"])) {
            $ingresar = $_POST["igresar"];
            
            //update aqui

            

		} // si llega ingreso



	}





	?>





	<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js"></script>
	<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>




</body>

</html>