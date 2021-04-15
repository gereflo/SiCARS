<?php
	session_start();
	if($_SESSION['alias'] == NULL){
		header("Location:index.html");
	}
	include 'acceso.php';
	
	$usr =  $_POST['usr'];
	$pass =  $_POST['pass'];
	$tipo =  $_POST['tipo'];
	$id =  $_POST['id'];
	
	echo $usr; 
	echo $pass;
	echo $tipo;
	echo $id;
	
	//$consulta2 = "INSERT INTO capturadores (alias, pass, usr) VALUES ('".$usr."', '".$pass."', '".$tipo."')";
	$consulta2 = "UPDATE capturadores SET alias = '".$usr."' WHERE capturadores.id_capturador =".$id;
	$consulta3 = "UPDATE capturadores SET pass = '".$pass."' WHERE capturadores.id_capturador =".$id;
	$consulta4 = "UPDATE capturadores SET usr = '".$tipo."' WHERE capturadores.id_capturador =".$id;
	$resultado2 = mysqli_query( $conexion, $consulta2 ) or die ( "Algo ha ido mal en la consulta a la base de datos 1");
	$resultado3 = mysqli_query( $conexion, $consulta3 ) or die ( "Algo ha ido mal en la consulta a la base de datos 2");
	$resultado4 = mysqli_query( $conexion, $consulta4 ) or die ( "Algo ha ido mal en la consulta a la base de datos 3");
	
	
	header("Location:adminusr.php");
	
?>
<html lang="es">
	<head>
	  <title>Borrado de alumno!</title>
	  <meta charset="utf-8">
	  <meta name="viewport" content="width=device-width, initial-scale=1">
	  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
	  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
	  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
	  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
	</head>
	<body>
	</body>
</html> 