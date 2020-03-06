<?php

include("conexion.php");
$conexion = conectarse();

//valores por defecto
$nombre = "defecto";
$contra = "defecto";

// recibir los post
if (!empty($_POST["nombre"]) && !empty($_POST["contra"])) {
	$nombre = $_POST["nombre"];
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

		$_SESSION['id'] = $row['id_u'];
	}
}

if (isset($_SESSION["nombre"])) {
	echo "<div class='bienvenida'>";
	echo "<br>";
	echo "<p>Bienvenido, " . $_SESSION["nombre"] . "</p><br>";

	echo "<form action='salir.php' method='post'>
    <input type='submit' value='Cerrar sesion'>
    </form><br>";
	echo "</div>";

	// consulta sql y bucle while

	$sql = "SELECT * FROM productos";

	// SELECT * FROM mytable WHERE column1 LIKE '%word1%'

	$productos = mysqli_query($conexion, $sql);

	echo "<table>";
	while ($fila = mysqli_fetch_assoc($productos)) {
		echo "
            <tr><td><img src='" . $fila['imagen_p'] . "'>></td></tr>
            <tr><td><b>" . $fila['nombre_p'] . "</b></td></tr>
            <tr><td>" . $fila['categoria'] . "</td></tr>
            <tr><td><b>Precio inicial:</b> " . $fila['precioinicial'] . " &#8364;</td></tr>
            <tr><td><b>Fecha inicio:</b> " . $fila['fechainicio'] . "</td></tr>
            <tr><td><b>Fecha fin:</b> " . $fila['fechafin'] . "</td></tr>
            <tr><td><form action='subasta.php' method='post'>
            <input type='hidden' name='imagen_p' value='" . $fila['imagen_p'] . "'>
            <input type='hidden' name='nombre_p' value='" . $fila['nombre_p'] . "'>
            <input type='hidden' name='id_p' value='" . $fila['id_p'] . "'>
            <input type='submit' value='Pujar'></input></form><br></td></tr>";
	}
	echo "</table>";
} else {
	echo "no estas registrado";
}

// cierre de conexión
$conexion->close();


?>
</div>


<!--- Connect -->
<div class="container-fluid padding">
	<div class="row text-center padding">
		<div class="col-12">
			<h2>Conecta con nosotros</h2>
		</div>
		<div class="col-12 social padding">
			<a href="#"><i class="fab fa-facebook"></i></a>
			<a href="#"><i class="fab fa-twitter"></i></a>
			<a href="#"><i class="fab fa-google-plus-g"></i></a>
			<a href="#"><i class="fab fa-instagram"></i></a>
			<a href="#"><i class="fab fa-youtube"></i></a>
		</div>
	</div>
</div>

<!--- Footer -->
<footer>
	<div class="container-fluid padding">
		<div class="row text-center">
			<div class="col-md-4">
				<img src="img/w3newbie.png">
				<hr class="light">
				<p>678-444-215</p>
				<p>erlantzcg89@gmail.com</p>
			</div>
			<div class="col-md-4">
				<hr class="light">
				<h5>Horarios</h5>
				<hr class="light">
				<p>Lunes: 9am - 5 pm</p>
				<p>Sábados: 10am - 4 pm</p>
			</div>
			<div class="col-md-4">
				<hr class="light">
				<h5>Dirección</h5>
				<hr class="light">
				<p>Malecón s/n</p>
				<p>48940 Costa, Bizkaia</p>
			</div>
			<div class="col-12">
				<hr class="light">
				<h5>Diseño</h5>
				<h5>&copy; erlybid.com</h5>
			</div>
		</div>
	</div>

</footer>

</body>

</html>