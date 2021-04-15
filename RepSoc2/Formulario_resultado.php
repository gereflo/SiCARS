<?php
	session_start();
	if($_SESSION['alias'] == NULL){
		header("Location:index.html");
	}
	include 'acceso.php';
	
	$consulta = "SELECT * FROM palabras";
	$resultado = mysqli_query( $conexion, $consulta ) or die ( "Algo ha ido mal en la consulta a la base de datos1");
	
	$consulta2 = "SELECT * FROM estimulos" ;
	$resultado2 = mysqli_query( $conexion, $consulta2 ) or die ( "Algo ha ido mal en la consulta a la base de datos2");
	
	//$consulta3 = "SELECT * FROM programas" ;
	//$resultado3 = mysqli_query( $conexion, $consulta3 ) or die ( "Algo ha ido mal en la consulta a la base de datos");
	
	//$consulta4 = "SELECT * FROM generos" ;
	//$resultado4 = mysqli_query( $conexion, $consulta4 ) or die ( "Algo ha ido mal en la consulta a la base de datos");
	
	$inputcount = 1; //da un id unico a cada input
	$numencuestasxfila = 4; //Encuestas que debe de tener cada fila

	$dia = htmlspecialchars($_POST['date']);
	$edad = htmlspecialchars($_POST['age']);
	$prog = htmlspecialchars($_POST['prog']);
	$genero = htmlspecialchars($_POST['gender']);
	$fase = htmlspecialchars($_POST['fase']);
	if ($fase == "Fase Investigación"){
		$fase = 0;
	}
	elseif ($fase == "Fase 1"){
		$fase = 1;
	}
	elseif ($fase == "Fase 2"){
		$fase = 2;
	}
	elseif ($fase == "Fase 3"){
		$fase = 3;
	}
	else{
		$fase = 4;
	}
	//echo $fase;
	
	$consultaidprg = "SELECT * FROM programas WHERE programa = '".$prog."'";
	$resultado5 = mysqli_query( $conexion, $consultaidprg ) or die ( "Algo ha ido mal en la consulta a la base de datos3");
	while($row = $resultado5->fetch_assoc()) {
        $prog = $row["id_programa"];
		$row["programa"];
	}
	
	$consultaidprg = "SELECT * FROM generos WHERE genero = '".$genero."'";
	$resultado5 = mysqli_query( $conexion, $consultaidprg ) or die ( "Algo ha ido mal en la consulta a la base de datos4");
	while($row = $resultado5->fetch_assoc()) {
        $genero = $row["id_genero"];
		$row["genero"];
	}

	$dia = date("Y-m-d", strtotime($dia) );
	
	$idAlumnoconsulta = "INSERT INTO alumnos (edad, fecha, generos_id_genero, programas_id_programa, capturadores_id_capturador, fase) 
					VALUES ('".$edad."', '".$dia."', '".$genero."', '".$prog."', '".$_SESSION['id_alias']."', '".$fase."')";
					
	$resultado5 = mysqli_query( $conexion, $idAlumnoconsulta ) or die ( "Algo ha ido mal en la consulta a la base de datos5");
	$idalumno=mysqli_insert_id($conexion);
	//echo $idalumno;
				
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
	<style> 
	#rcorners1 {
		border-radius: 25px;
		background: rgba(130, 130, 130, 0.5);
		margin:20px 50px
	}
	</style>
	<link rel="stylesheet" type="text/css" href="css/ase.css">
</head>

<body>
	<form action="Formulario_resultado.php" method="post">
		<div class="form-group" id="rcorners1" >
		<h1>Se ha capturado el registro No. <?php echo $idalumno; echo " por "; echo $_SESSION['alias'];?></h1>
			<div class="row">
				<div class="col"> 
					<input class="form-control" type="text" placeholder="<?php echo $dia?>" readonly>
				</div>
				<div class="col">
					<input class="form-control" id="exampleFormControlSelect1" placeholder="<?php echo $_POST['gender'] ?>" readonly>
				</div>
				<div class="col">
					<input class="form-control" type="number" placeholder="<?php echo $edad?>" readonly>
				</div>
				<div class="col">
					<input class="form-control" id="exampleFormControlSelect1" placeholder="<?php echo $_POST['prog']?>" readonly> 
				</div>
			</div>
			<br>
			<?php
				$count = 1; //contador para numero de filas, no mover!
				$idpalabra = NULL; //Se inicializa la variable por si no hay registro de palabra al principio
				
				$consultaidprg = "SELECT * FROM palabras"; //toma la tabla palabras para hacer la busqueda del id
				
				
				while ($columna = mysqli_fetch_array( $resultado2 )){
					if($count == 1){
					echo "<div class='row'>";
					}
					echo "<div class='col'>";
					echo "<label for='exampleFormControlInput1'>".$columna['pal_estimulo']."</label>";
					echo "<br>";
					for ($j = 5; $j >= 1; $j--) {
						$captura = htmlspecialchars($_POST['palabra'.$inputcount]);
						
						$tabla_palabras = mysqli_query( $conexion, $consultaidprg ) or die ( "Algo ha ido mal en la consulta a la base de datos");
						while($row = mysqli_fetch_assoc($tabla_palabras)) {
							if($captura == $row["palabra"])
							$idpalabra = $row["id_palabra"];
						}
						
						echo '<div class="input-group mb-3">';
						echo '<div class="input-group-prepend">';
						echo '<span class="input-group-text" id="basic-addon1">'.$j.'</span>';
						echo '</div>';
						if($idpalabra != NULL){
							echo '<input type="text" class="form-control" placeholder="'.$captura." - ".$idpalabra.'" aria-label="Username" aria-describedby="basic-addon1" readonly>';
						}
						else{
							echo '<input type="text" class="form-control" aria-label="Username" aria-describedby="basic-addon1" readonly>';
						}
						//echo '<input type="text" class="form-control" id="palabra'.$inputcount.'" placeholder="Palabra '.$j.'">';
						//echo '<input type="text" class="form-control" aria-describedby="basic-addon1" id="palabra'.$inputcount.'">';
						echo '</div>';
						

						//Si la palabra es encontrada en la base se asocia al alumno
						if($idpalabra != NULL){
							$insertRegistro = "INSERT INTO `registros` (id_registro, valor, estimulos_id_estimulo, alumnos_id_alumno, palabras_id_palabra) 
											VALUES (NULL, '".$j."', '".$columna['id_estimulo']."', '".$idalumno."', '".$idpalabra."')";
							$resultRegistro = mysqli_query( $conexion, $insertRegistro ) or die ( "Algo ha ido mal en la consulta a la base de datos");
						}
						
						$idpalabra = NULL;
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
		<a href="Form_capturacompleta.php" class="btn btn-outline-primary btn-lg" role="button" aria-pressed="true">Capturar Siguiente</a>
		<a href="bienvenida.php" class="btn btn-primary btn-lg active" role="button" aria-pressed="true">Salir</a>
		</div>
	</form>
</body>
</html>

