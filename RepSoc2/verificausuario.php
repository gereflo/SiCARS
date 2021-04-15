<?php
	// Ejemplo de conexión a base de datos MySQL con PHP.
	//
	include 'acceso.php';
	$consulta = "SELECT * FROM capturadores";
	$resultado = mysqli_query( $conexion, $consulta ) or die ( "Algo ha ido mal en la consulta a la base de datos 1");
	$usrfomr = htmlspecialchars($_POST['usuario']);//captuta del formulario index 
	$passform = htmlspecialchars($_POST['pass']);
	$pass = 1;
	$consulta = "SELECT * FROM capturadores WHERE alias='".$usrfomr."'";
	$resultado = mysqli_query( $conexion, $consulta ) or die ( "Algo ha ido mal en la consulta a la base de datos 2");
	while($row = $resultado->fetch_assoc()) {
		$id_captu = $row["id_capturador"];
		$alias = $row["alias"];
		$pass = $row["pass"];
		break;
	}
	if ($pass == $passform && $usrfomr == $alias){
		//Iniciando variable de session
		session_start();
		//echo "bienvenido";
		$_SESSION['alias']=$_REQUEST['usuario'];
		$_SESSION['id_alias']=$id_captu;
		header("Location:bienvenida.php");
	}
	else{
		echo "Acceso denegado";
		header("Location:index.html");
	}	
?>
<html lang="es">
	<head>
		<title>Captura el encuestra de representaciones socuales</title>
		<meta http-equiv="Content-type" content="text/html; charset=utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1">
		
		<!-- Bootstrap -->
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">  
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
	  
		<!-- Autocomplete -->
		<script src="./demo/jquery.js" type="text/javascript"></script>
		<script src="./demo/prettify.js" type="text/javascript"></script>
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
		<link rel="stylesheet" href="./ccs/jquery.autocomplete.css">
		<script src="./js/jquery.autocomplete.js" type="text/javascript"></script>
		
	</head>
	<body>
	</body>
</html>
