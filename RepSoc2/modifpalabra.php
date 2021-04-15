<?php
	session_start();
	if($_SESSION['alias'] == NULL){
		header("Location:index.html");
	}
	include 'acceso.php';
	
	$no =  $_POST['no'];
	$nonuevo =  $_POST['nonuevo'];
	$palabra =  $_POST['palabra'];
	
	echo $no;
	echo $nonuevo;
	echo $palabra;
	echo '<br>';

	
	//$consulta2 = "INSERT INTO capturadores (alias, pass, usr) VALUES ('".$usr."', '".$pass."', '".$tipo."')";
	$consulta2 = 'UPDATE palabras SET palabra = "'.$palabra.'" WHERE palabras.id_palabra = '.$no;
	$consulta3 = 'UPDATE palabras SET id_palabra = '.$nonuevo.' WHERE palabras.id_palabra = '.$no;
	//$consulta4 = "UPDATE capturadores SET usr = '".$tipo."' WHERE capturadores.id_capturador =".$id;
	echo $consulta2;
	echo '<br>';
	echo $consulta3;
	$resultado2 = mysqli_query( $conexion, $consulta2 ) or die ( "Algo ha ido mal en la consulta a la base de datos 1");
	$resultado3 = mysqli_query( $conexion, $consulta3 ) or die ( "Algo ha ido mal en la consulta a la base de datos 2");
	//$resultado4 = mysqli_query( $conexion, $consulta4 ) or die ( "Algo ha ido mal en la consulta a la base de datos 3");
	
	
	header("Location:adminpalabras.php");
	
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