<?php
	// Ejemplo de conexión a base de datos MySQL con PHP.
	//
	
	// Datos de la base de datos
	$usuario = "root";
	$password = "";
	$servidor = "localhost";
	$basededatos = "repsocdb";
	
	// creación de la conexión a la base de datos con mysql_connect()
	$conexion = mysqli_connect( $servidor, $usuario, "" ) or die ("No se ha podido conectar al servidor de Base de datos");
	$conexion->set_charset("utf8"); //Muy importante, sin esta liena no se mostraran las tildes por que la coneccion se hara en otra codificacion
	
	// Selección del a base de datos a utilizar
	$db = mysqli_select_db( $conexion, $basededatos ) or die ( "Upps! Pues va a ser que no se ha podido conectar a la base de datos" );
	// establecer y realizar consulta. guardamos en variable.
	
	$consulta = "SELECT * FROM palabras";
	$resultado = mysqli_query( $conexion, $consulta ) or die ( "Algo ha ido mal en la consulta a la base de datos");
	
	$consulta2 = "SELECT * FROM estimulos" ;
	$resultado2 = mysqli_query( $conexion, $consulta2 ) or die ( "Algo ha ido mal en la consulta a la base de datos");
	
	$consulta3 = "SELECT * FROM programas" ;
	$resultado3 = mysqli_query( $conexion, $consulta3 ) or die ( "Algo ha ido mal en la consulta a la base de datos");
	
	$consulta4 = "SELECT * FROM generos" ;
	$resultado4 = mysqli_query( $conexion, $consulta4 ) or die ( "Algo ha ido mal en la consulta a la base de datos");
	
	$inputcount = 1; //da un id unico a cada input
	$numencuestasxfila = 4 //Encuestas que debe de tener cada fila
	
?>
<html lang="es">
<head>
	<title>Captura el encuestra de representaciones socuales</title>
	<meta http-equiv="Content-type" content="text/html; charset=utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">  
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
  
  
	<script src="./demo/jquery.js" type="text/javascript"></script>
	<script src="./demo/prettify.js" type="text/javascript"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
	<link rel="stylesheet" href="./ccs/jquery.autocomplete.css">
	<script src="./js/jquery.autocomplete.js" type="text/javascript"></script>
</head>

<body>
	<form action="Formulario_resultado.php" method="post">
		<div class="form-group" style="margin:20px 50px;background-color:#cfcbca">
		<h1>Capturador representaciones sociales</h1>
			<div class="row">
				<div class="col"> 
					<input class="form-control" type="date" name="date" placeholder="Fecha">
				</div>
				<div class="col">
					<select class="form-control" id="exampleFormControlSelect1" name="gender">
					<?php
						while ($columna = mysqli_fetch_array( $resultado4 )){
							echo "<option>" . $columna['genero'] . "</option>";
						}
					?>
					</select>
				</div>
				<div class="col">
					<input class="form-control" type="number" placeholder="Edad" name="age">
				</div>
				<div class="col">
					<select class="form-control" id="exampleFormControlSelect1"name="prog">
					<?php
						while ($columna = mysqli_fetch_array( $resultado3 )){
							echo "<option>" . $columna['programa'] . "</option>";
						}
					?>
					</select>
				</div>
			</div>
			<br>
			<?php
				$count = 1;
				while ($columna = mysqli_fetch_array( $resultado2 )){
					if($count == 1){
					echo "<div class='row'>";
					}
					echo "<div class='col'>";
					echo "<label for='exampleFormControlInput1'>".$columna['pal_estimulo']."</label>";
					echo "<br>";
					for ($j = 1; $j <= 5; $j++) {
						echo '<div class="input-group mb-3">';
						echo '<div class="input-group-prepend">';
						echo '<span class="input-group-text" id="basic-addon1">'.$j.'</span>';
						echo '</div>';
						echo '<input type="text" id="palabra'.$inputcount.'" name="palabra'.$inputcount.'" class="form-control" placeholder="" aria-label="Username" aria-describedby="basic-addon1">';
						//echo '<input type="text" class="form-control" id="palabra'.$inputcount.'" placeholder="Palabra '.$j.'">';
						//echo '<input type="text" class="form-control" aria-describedby="basic-addon1" id="palabra'.$inputcount.'">';
						echo '</div>';
						
						$inputcount = $inputcount + 1;
					}
					echo "</div><br>";
					if($count == $numencuestasxfila){
						echo "</div><br>";
						$count = 0;
					}
					++$count;
				}
				if($numencuestasxfila%2 == 1){
					echo "</div>";
				}
			?>
			<input class="btn btn-primary btn-lg btn-block" role="button" type="submit" value="Revisar">
		</div>
	</form>
</body>
<script>
/********************************** local start ************************************************/
var pal = [
<?php
while ($columna = mysqli_fetch_array( $resultado ))
	echo "'".$columna['palabra']." - ".$columna['id_palabra']."',";
?>
];

<?php
for ($j = 1; $j <= $inputcount; $j++) {
	echo "$('#palabra".$j."').autocomplete({source:[pal]});";
}
?>

/*********************************** local end *****************************************************/
</script>
</html>

