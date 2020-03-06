<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Subastas Erlantz</title>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
	<script
  src="https://code.jquery.com/jquery-3.3.1.js"
  integrity="sha256-2Kok7MbOyxpgUVvAk/HJ2jigOSYS2auK4Pfzbm7uH60="
  crossorigin="anonymous"></script>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
	<script src="https://use.fontawesome.com/releases/v5.0.8/js/all.js"></script>

	<link href="style.css" rel="stylesheet">
</head>
<body>
	<?php 
    //iniciar sesión
    session_start(); ?>

<!-- Navigation -->
<nav class="navbar navbar-expand-md navbar-light bg-light sticky-top">
<div class="container-fluid">
	<a class="navbar-brand" href="#"><img src="img/logo.png"></a>
	<button type="button" class="navbar-toggler" data-togle="collapse" data-target="#navbarResponsive">
		<span class="navbar-toggler-icon"></span>
	</button>
	<div class="collapse navbar-collapse" id="navbarResponsive">
		<ul class="navbar-nav ml-auto">
			<li class="nav-item">
				<a class="nav-link" href="index.php">Inicio</a>
			</li>
			<li class="nav-item">
				<a class="nav-link" href="usuario.php">Usuarios</a>
			</li>
			<li class="nav-item">
				<a class="nav-link" href="administrador.php">Administradores</a>
			</li>
<!-- 			<li class="nav-item">
				<a class="nav-link" href="#">Ayuda</a>
			</li>
			<li class="nav-item">
				<a class="nav-link" href="#">Buscar</a>
			</li> -->
		</ul>
	</div>

</div>
</nav>

<!--- Image Slider -->
<div id="slides" class="carousel slide" data-ride="carousel">
<ul class="carousel-indicators">
	<li data-target="#slides" data-slide-to="0" class="active"></li>
	<li data-target="#slides" data-slide-to="1"></li>
	<li data-target="#slides" data-slide-to="2"></li>
	<li data-target="#slides" data-slide-to="3"></li>
</ul>
<div class="carousel-inner">
		<div class="carousel-item active">
			<img src="img/background.png" class="img-fluid">
			<div class="carousel-caption">
				<h1 class="display-2">Subastas</h1>
				<h3>¡Puja por tus favoritos!</h3>
				<button onclick="window.location='usuario.php';" type="button" class="btn btn-outline-light btn-lg">Usuarios</button>
				<button onclick="window.location='registrousuario.php';" type="button" class="btn btn-primary btn-lg">Registrarse</button>
			</div>
		</div>
		<div class="carousel-item">
			<img src="img/background2.png" class="img-fluid">
		</div>
		<div class="carousel-item">
			<img src="img/background3.png" class="img-fluid">
		</div>
		<div class="carousel-item">
			<img src="img/background4.png" class="img-fluid">
		</div>
	
</div>
</div>

<!--- Welcome Section -->
<div class="container-fluid padding">
<?php 

include("conexion.php");
$conexion=conectarse();

//valores por defecto
$nombre="defecto";
$contra="defecto";

// recibir los post
if (!empty($_POST["nombre"]) && !empty($_POST["contra"])){
	$nombre=$_POST["nombre"];
	$contra=$_POST["contra"];

	
	

$check="SELECT * FROM usuarios WHERE nombre = '".$nombre."' AND contra = '".$contra."'";



$login =$conexion->query($check);

//checkear la validez de la cuenta para iniciar sesion
if($login->num_rows == 1){
	//session_start();
	$_SESSION['nombre'] = $nombre;

	//guardar en sesion id_usuario
	$sql="SELECT * FROM usuarios WHERE nombre = '".$_SESSION['nombre']."'";

	$consulta = mysqli_query($conexion, $sql);
    $row = mysqli_fetch_assoc($consulta);

    $_SESSION['id']=$row['id_u'];
}
}

if (isset($_SESSION["nombre"])) {
    echo "<div class='bienvenida'>";
    echo "<br>";
    echo "<p>Bienvenido, ".$_SESSION["nombre"]."</p><br>";
  
    echo "<form action='salir.php' method='post'>
    <input type='submit' value='Cerrar sesion'>
    </form><br>";
    echo "</div>";

    $sql="SELECT * FROM productos";

    $productos = mysqli_query($conexion, $sql);
 

    // echo "<table>";
    // echo "<tr><th>Imagen</th><th>Nombre</th><th>Categoría</th><th>Precio inicial<th><th>Fecha inicio<th><th>Fecha fin<th><th>Subasta<th></tr>";
    // while($fila = mysqli_fetch_assoc($productos)){   
    // echo "<tr><td>" . $fila['imagen_p'] . "</td><td>" . $fila['nombre_p'] . "</td><td>" . $fila['categoria'] . "</td><td>" . $fila['precioinicial'] . "  &#8364;</td><td>" . $fila['fechainicio'] . "</td><td>" . $fila['fechafin'] . "</td><td><form action='subasta.php' method='post'>
    //         <input type='hidden' name='imagen_p' value='".$fila['imagen_p']."'>
    //         <input type='hidden' name='nombre_p' value='".$fila['nombre_p']."'>
    //         <input type='hidden' name='id_p' value='".$fila['id_p']."'>
    //         <input type='submit' value='Pujar'></input></form></td></tr>" ;
    
    //     echo "</table>";
    //     }

    echo "<table>";
    while($fila = mysqli_fetch_assoc($productos)){   
    echo"
            <tr><td><img src='".$fila['imagen_p']."'>></td></tr>
            <tr><td><b>" . $fila['nombre_p'] . "</b></td></tr>
            <tr><td>" . $fila['categoria'] . "</td></tr>
            <tr><td><b>Precio inicial:</b> " . $fila['precioinicial'] . " &#8364;</td></tr>
            <tr><td><b>Fecha inicio:</b> " . $fila['fechainicio'] . "</td></tr>
            <tr><td><b>Fecha fin:</b> " . $fila['fechafin'] . "</td></tr>
            <tr><td><form action='subasta.php' method='post'>
            <input type='hidden' name='imagen_p' value='".$fila['imagen_p']."'>
            <input type='hidden' name='nombre_p' value='".$fila['nombre_p']."'>
            <input type='hidden' name='id_p' value='".$fila['id_p']."'>
            <input type='submit' value='Pujar'></input></form><br></td></tr>" ;
    }
        echo "</table>";
        

  
}else{echo "no estas registrado";}

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


