<?php
	session_start();
	if($_SESSION['alias'] == NULL){
		header("Location:index.html");
	}
	include 'acceso.php';
	
	$usr =  $_POST['usr'];
	$pass =  $_POST['Password1'];
	$tipo =  $_POST['tipo'];
	
	echo $usr; 
	echo $pass;
	echo $tipo;
	
	$consulta2 = "INSERT INTO capturadores (alias, pass, usr) VALUES ('".$usr."', '".$pass."', '".$tipo."')";
	$resultado2 = mysqli_query( $conexion, $consulta2 ) or die ( "Algo ha ido mal en la consulta a la base de datos 1");
	
	
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