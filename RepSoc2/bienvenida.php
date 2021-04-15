<?php
	session_start();
	if($_SESSION['alias'] == NULL){
		header("Location:index.html");
	}
	include 'acceso.php';
	
	$consulta2 = "SELECT id_alumno FROM alumnos ORDER BY id_alumno" ;//Se consulta la tabla alumnos para saber cuantos alumnos hay
	$resultado2 = mysqli_query( $conexion, $consulta2 ) or die ( "Algo ha ido mal en la consulta a la base de datos");
	
	$row_cnt = $resultado2->num_rows;
	
	while ($columna = mysqli_fetch_array( $resultado2 )){
		$id_alumno = $columna['id_alumno'];
		break;
		}
		
	$consultaadmin = "SELECT usr FROM capturadores WHERE alias = '".$_SESSION['alias']."'"; 
	//echo $consultaadmin;
	$adminresultado = mysqli_query( $conexion, $consultaadmin ) or die ( "Algo ha ido mal en la consulta a la base de datos45");
	$a = mysqli_fetch_assoc($adminresultado);
	$a = $a['usr'];
?>
<html lang="es">
	<head>
	  <title>Bienvenid@ SICARS</title>
	  <meta charset="utf-8">
	  <meta name="viewport" content="width=device-width, initial-scale=1">
	  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
	  <link href="https://fonts.googleapis.com/css?family=Abel|Arsenal|Oswald" rel="stylesheet">
	  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
	  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
	  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
	  <link rel="stylesheet" type="text/css" href="css/ase.css">
	</head>
	<body>

	<div class="container">
	  <div>
		  <h1 class="display-4">Bienvenid@ <?php echo $_SESSION['alias'] ?>
			  <a href="cerrar.php" class="btn btn-outline-danger btn-lg" role="button" aria-disabled="False">Cerrar Sesión</a>
			</h1>
		  <p class="lead">Se han capturado <?php echo $row_cnt?> alumnos en total</p>
		  <hr class="my-4">
		  <?php
				if ($a == "a"){
					echo '<p>Acciones generales del Administrador</p>';
				}
				elseif ($a == "i"){
					echo '<p>Acciones generales del Investigador</p>';
				}
					
			?>
		  
		  <a class="btn btn-outline-success" href="Form_capturacompleta.php" role="button">Introducir nuevo registro de Alumno</a>
		  <?php
				if ($a == "a"){
					echo '<a class="btn btn-outline-success" href="adminpalabras.php" role="button" aria-disabled="true">Lista de palabras</a>&nbsp;';
					echo '<a class="btn btn-outline-success" href="adminprog.php" role="button" aria-disabled="true">Lista de Carreras</a>&nbsp;';
					echo '<a class="btn btn-outline-success" href="underconstruction.php" role="button" aria-disabled="true">Administracion de pagina web</a>&nbsp;';
					echo '<a class="btn btn-outline-success" href="adminusr.php" role="button" aria-disabled="true">Administracion de usuarios</a>&nbsp;';
				}
		?>
		  <!--<a class="btn btn-outline-primary btn-lg btn-block" href="Ver_formulario.php?id_alumn=<?php echo $id_alumno;?>" role="button">Ver datos</a>-->
		</div>
		<br><br><br><br><br>
		<div class="row">
			<div class="col-sm">
				<p class="lead">
					<div style="width: 15rem;">
						<img class="card-img-top" src="img/tablaspersona.png" alt="Card image cap" height="150">
						<div class="card-body">
						<h5 class="card-title">Pictogramas de alumnos</h5>
						<p class="card-text">En este apartado se pueden visualizar las respuestas de cada estudiante que se ha dado de alta</p>
						<a class="btn btn-outline-primary btn-lg btn-block" href="Ver_todo.php?orderby=0" role="button">Ver datos</a>
						</div>
					</div>
				</p>
			</div>
			<div class="col-sm">
				<p class="lead">
					<div style="width: 15rem;">
						<img class="card-img-top" src="img/donut.jpg" alt="Card image cap" height="150">
						<div class="card-body">
						<h5 class="card-title">Gráficas de dona</h5>
						<p class="card-text">En este apartado se pueden ver gráficas clásicas de los datos de los alumnos en conjunto</p>
						<a class="btn btn-outline-primary btn-lg btn-block" href="clasicgraf.php?orderby=0" role="button">Ver datos</a>
						</div>
					</div>
				</p>
			</div>
			<div class="col-sm">
				<p class="lead">
					<div style="width: 15rem;">
						<img class="card-img-top" src="img/telaraña.jpg" alt="Card image cap" height=150">
						<div class="card-body">
						<h5 class="card-title">Gráficas de telaraña</h5>
						<p class="card-text">Gráficas de telaraña y tablas con las palabras registradas dentro de cada Representación Social</p>
						<a class="btn btn-outline-primary btn-lg btn-block" href="graficas_palabras.php?orderby=1" role="button">Ver datos</a>
						</div>
					</div>
				</p>
			</div>
			<div class="col-sm">
				<p class="lead">
					<div style="width: 15rem;">
						<img class="card-img-top" src="img/hombrevsmujer.jpg" alt="Card image cap" height="150">
						<div class="card-body">
						<h5 class="card-title">Gráfica comparativa</h5>
						<p class="card-text">Gráficas comparativas entre la representación social de las mujeres y de los hombres</p>
						<a class="btn btn-outline-primary btn-lg btn-block" href="graficas_palabrascompara.php?orderby=1" role="button">Ver datos</a>
						</div>
					</div>
				</p>
			</div>
		</div>
	</div>
	</body>
</html> 