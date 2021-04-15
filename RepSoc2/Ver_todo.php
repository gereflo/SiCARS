<?php
	session_start();
	if($_SESSION['alias'] == NULL){
		header("Location:index.html");
	}
	include 'acceso.php';
	
	$orderby= $_GET["orderby"];
	
	if($orderby == 0){
		$consultaalumno = "SELECT id_alumno, edad, fecha, genero, id_genero, id_programa,programa, id_capturador ,alias, fase FROM alumnos
							left JOIN generos ON generos_id_genero = id_genero 
							left JOIN programas ON programas_id_programa = id_programa 
							left JOIN capturadores ON capturadores_id_capturador = id_capturador
							ORDER by id_alumno ASC";
	}
	if($orderby == 1){
		$consultaalumno = "SELECT id_alumno, edad, fecha, genero, id_genero, id_programa,programa, id_capturador ,alias, fase FROM alumnos 
							JOIN generos ON generos_id_genero = id_genero 
							JOIN programas ON programas_id_programa = id_programa 
							JOIN capturadores ON capturadores_id_capturador = id_capturador
							ORDER BY edad ASC";
	}
	if($orderby == 2){
		$consultaalumno = "SELECT id_alumno, edad, fecha, genero, id_genero, id_programa,programa, id_capturador ,alias, fase FROM alumnos
							JOIN generos ON generos_id_genero = id_genero 
							JOIN programas ON programas_id_programa = id_programa 
							JOIN capturadores ON capturadores_id_capturador = id_capturador
							ORDER BY edad DESC";
	}
	if($orderby == 3){
		$consultaalumno = "SELECT id_alumno, edad, fecha, genero, id_genero, id_programa,programa, id_capturador ,alias, fase FROM alumnos 
							left JOIN generos ON generos_id_genero = id_genero 
							left JOIN programas ON programas_id_programa = id_programa 
							left JOIN capturadores ON capturadores_id_capturador = id_capturador
							ORDER BY id_genero ASC";
	}
	if($orderby == 4){
		$consultaalumno = "SELECT id_alumno, edad, fecha, genero, id_genero, id_programa,programa, id_capturador ,alias, fase FROM alumnos 
							left JOIN generos ON generos_id_genero = id_genero 
							left JOIN programas ON programas_id_programa = id_programa 
							left JOIN capturadores ON capturadores_id_capturador = id_capturador
							ORDER BY id_genero DESC";
	}
	if($orderby == 5){
		$consultaalumno = "SELECT id_alumno, edad, fecha, genero, id_genero, id_programa,programa, fase FROM alumnos 
							JOIN generos ON generos_id_genero = id_genero 
							JOIN programas ON programas_id_programa = id_programa 
							ORDER BY id_programa ASC";
	}
	if($orderby == 6){
		$consultaalumno = "SELECT id_alumno, edad, fecha, genero, id_genero, id_programa,programa, fase FROM alumnos 
							JOIN generos ON generos_id_genero = id_genero 
							JOIN programas ON programas_id_programa = id_programa 
							ORDER BY id_programa DESC";
	}
	if($orderby == 7){
		$consultaalumno = "SELECT id_alumno, edad, fecha, genero, id_genero, id_programa,programa, id_capturador ,alias, fase FROM alumnos 
							JOIN generos ON generos_id_genero = id_genero 
							JOIN programas ON programas_id_programa = id_programa 
							JOIN capturadores ON capturadores_id_capturador = id_capturador
							ORDER BY id_capturador DESC";
	}
	if($orderby == 8){
		$consultaalumno = "SELECT id_alumno, edad, fecha, genero, id_genero, id_programa,programa, id_capturador ,alias, fase FROM alumnos 
							JOIN generos ON generos_id_genero = id_genero 
							JOIN programas ON programas_id_programa = id_programa 
							JOIN capturadores ON capturadores_id_capturador = id_capturador
							ORDER BY id_capturador DESC";
	}
	

	$resultadoalumno = mysqli_query( $conexion, $consultaalumno ) or die ( "Algo ha ido mal en la consulta a la base de datos");
	$row_cnt = $resultadoalumno->num_rows;
	
?>
<html lang="es">
	<head>
	  <title>Lista de alumnos registrados Sicars</title>
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
			<h1 class="display-4"><?php echo $_SESSION['alias'] ?>, en esta sección puedes seleccionar un alumno para ver de manera individual sus respuestas</h1>
			<p class="lead">Aquí puedes seleccionar la manera en que se visualiza la información:</p>
				<div class="container">
				  <div class="row">
					<div class="col-sm">
						<p class="lead">Ordenando por:</p>
						<?php
								if($orderby == 0){
									echo 'Secuencia de captura';
								}
								elseif($orderby == 1){
									echo 'Edad Acendente';
								}
								elseif($orderby == 2){
									echo 'Edad Decendente';
								}
								elseif($orderby == 3){
									echo 'Genero Acendente';
								}
								elseif($orderby == 4){
									echo 'Genero Dedendente';
								}
								elseif($orderby == 5){
									echo 'Programa de estudios Acendente';
								}
								elseif($orderby == 6){
									echo 'Programa de estudios Decendente';
								}
								elseif($orderby == 7){
									echo 'Caprurador Acendente';
								}
								elseif($orderby == 8){
									echo 'Capturador Decendente';
								}
							?>
					</div>
					<div class="col-sm">
					<p class="lead">
					Llave<br>
					  		<?php
								if($orderby == 0){
									echo '<img src="img/persona (3).png" style="width:10px;" HSPACE="3" >Investigación<br>';
									echo '<img src="img/persona (4).png" style="width:10px;" HSPACE="3" >Fase 1<br>';
									echo '<img src="img/persona (5).png" style="width:10px;" HSPACE="3" >Fase 2<br>';
									echo '<img src="img/persona (6).png" style="width:10px;" HSPACE="3" >Fase 3<br>';
									echo '<img src="img/persona (1).png" style="width:10px;" HSPACE="3" >Sin Fase<br>';
	
								}
								elseif($orderby == 1 || $orderby == 2 || $orderby == 3 || $orderby == 4){
									echo '<img src="img/peoplef.png" style="width:10px;" HSPACE="3" >Mujer<br>';
									echo '<img src="img/peoplem.png" style="width:10px;" HSPACE="3" >Hombre<br>';
									echo '<img src="img/peopleg.png" style="width:10px;" HSPACE="3" >Otro genero<br>';
								}
								if($orderby == 5 || $orderby == 6){
									echo '<img src="img/persona (1).png" style="width:10px;" HSPACE="3" >Diseño<br>';
									echo '<img src="img/persona (2).png" style="width:10px;" HSPACE="3" >Ciencias de la Comunicación<br>';
									echo '<img src="img/persona (3).png" style="width:10px;" HSPACE="3" >Tecnologías y Sistemas de Información<br>';
									echo '<img src="img/persona (7).png" style="width:10px;" HSPACE="3" >Derecho<br>';
									echo '<img src="img/persona (5).png" style="width:10px;" HSPACE="3" >Administración<br>';
									echo '<img src="img/persona (6).png" style="width:10px;" HSPACE="3" >Estudios Socioterritoriales<br>';
									echo '<img src="img/persona (4).png" style="width:10px;" HSPACE="3" >Humanidades<br>';
									echo '<img src="img/persona (8).png" style="width:10px;" HSPACE="3" >Biología Molecular<br>';
									echo '<img src="img/persona (9).png" style="width:10px;" HSPACE="3" >Ingeniería Biológica<br>';
									echo '<img src="img/persona (11).png" style="width:10px;" HSPACE="3" >Ingeniería en Computación<br>';
									echo '<img src="img/persona (10).png" style="width:10px;" HSPACE="3" >Matemáticas Aplicadas<br>';
									echo '<img src="img/persona (12).png" style="width:10px;" HSPACE="3" >MADIC<br>';
									echo '<img src="img/persona (13).png" style="width:10px;" HSPACE="3" >Sin especificar<br>';									
								}
								if($orderby == 7 || $orderby == 8){
									echo '<img src="img/persona (1).png" style="width:10px;" HSPACE="3" >Vanesa<br>';
									echo '<img src="img/persona (9).png" style="width:10px;" HSPACE="3" >Karina<br>';
									echo '<img src="img/persona (10).png" style="width:10px;" HSPACE="3" >Carolina<br>';
									echo '<img src="img/peopleg.png" style="width:10px;" HSPACE="3" >Gerardo<br>';	
								}
							?>
					</p>
					</div>
					<div class="col-sm">
					<div class="btn-group" role="group">
							<button id="btnGroupDrop1" type="button" class="btn btn-info dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
							  Ordenar por:
							</button>
							<div class="dropdown-menu" aria-labelledby="btnGroupDrop1">
							  <a class="dropdown-item" href="Ver_todo.php?orderby=0">Captura</a>
							  <!--<a class="dropdown-item" href="Ver_todo.php?orderby=1">edad (Asendente)</a>
							  <a class="dropdown-item" href="Ver_todo.php?orderby=2">edad (Decendente)</a>-->
							  <a class="dropdown-item" href="Ver_todo.php?orderby=3">Género (Ascendente)</a>
							  <a class="dropdown-item" href="Ver_todo.php?orderby=4">Género (Descendente)</a>
							  <a class="dropdown-item" href="Ver_todo.php?orderby=5">Programa de estudios (Ascendente)</a>
							  <a class="dropdown-item" href="Ver_todo.php?orderby=6">Programa de estudios (Descendente)</a>
							  <!--<a class="dropdown-item" href="Ver_todo.php?orderby=7">Capturador (Asendente)</a>
							  <a class="dropdown-item" href="Ver_todo.php?orderby=8">Capturador (Decendente)</a>-->
							</div>
						</div>
					</div>
				  </div>
				</div>
				<hr class="my-4">
				<p>Selecciona el alumno a verificar</p>
				<?php
					while ($columna = mysqli_fetch_array( $resultadoalumno )){
						$id_alumno = $columna['id_alumno'];
						$edad = $columna['edad'];
						$fecha = $columna['fecha'];
						$genero = $columna['id_genero'];
						//$alias = $columna['alias'];
						$programa = $columna['id_programa'];
						//$id_capturador = $columna['id_capturador'];
						$fase = $columna['fase'];
						//echo $id_alumno;
						//echo $genero;
						//echo $fase;
						if($orderby == 0){
							if($fase == 0){
								echo '<a href="Ver_formulario.php?id_alumn='.$id_alumno.'"><img src="img/persona (3).png" style="width:20px;" HSPACE="3" ></a>';
							}
							elseif($fase == 1){
								echo '<a href="Ver_formulario.php?id_alumn='.$id_alumno.'"><img src="img/persona (4).png" style="width:20px;" HSPACE="3" ></a>';
							}
							elseif($fase == 2){
								echo '<a href="Ver_formulario.php?id_alumn='.$id_alumno.'"><img src="img/persona (5).png" style="width:20px;" HSPACE="3" ></a>';
							}
							elseif($fase == 3){
								echo '<a href="Ver_formulario.php?id_alumn='.$id_alumno.'"><img src="img/persona (6).png" style="width:20px;" HSPACE="3" ></a>';
							}
							elseif($fase > 3){
								echo '<a href="Ver_formulario.php?id_alumn='.$id_alumno.'"><img src="img/persona (1).png" style="width:20px;" HSPACE="3" ></a>';
							}
						}
						elseif($orderby == 1 || $orderby == 2 || $orderby == 3 || $orderby == 4){
							if($genero == 1){
								echo '<a href="Ver_formulario.php?id_alumn='.$id_alumno.'"><img src="img/peoplef.png" style="width:20px;" HSPACE="3" ></a>';
							}
							elseif($genero == 2){
								echo '<a href="Ver_formulario.php?id_alumn='.$id_alumno.'"><img src="img/peoplem.png" style="width:20px;" HSPACE="3"></a>';
							}
							else{
								echo '<a href="Ver_formulario.php?id_alumn='.$id_alumno.'"><img src="img/peopleg.png" style="width:20px;" HSPACE="3"></a>';
							}
						}
						elseif($orderby == 5 || $orderby == 6){
							if($programa == 1){
								echo '<a href="Ver_formulario.php?id_alumn='.$id_alumno.'"><img src="img/persona (1).png" style="width:20px;" HSPACE="3" ></a>';
							}
							elseif($programa == 2){
								echo '<a href="Ver_formulario.php?id_alumn='.$id_alumno.'"><img src="img/persona (2).png" style="width:20px;" HSPACE="3" ></a>';
							}
							elseif($programa == 3){
								echo '<a href="Ver_formulario.php?id_alumn='.$id_alumno.'"><img src="img/persona (3).png" style="width:20px;" HSPACE="3" ></a>';
							}
							elseif($programa == 7){
								echo '<a href="Ver_formulario.php?id_alumn='.$id_alumno.'"><img src="img/persona (4).png" style="width:20px;" HSPACE="3" ></a>';
							}
							elseif($programa == 5){
								echo '<a href="Ver_formulario.php?id_alumn='.$id_alumno.'"><img src="img/persona (5).png" style="width:20px;" HSPACE="3" ></a>';
							}
							elseif($programa == 6){
								echo '<a href="Ver_formulario.php?id_alumn='.$id_alumno.'"><img src="img/persona (6).png" style="width:20px;" HSPACE="3" ></a>';
							}
							elseif($programa == 4){
								echo '<a href="Ver_formulario.php?id_alumn='.$id_alumno.'"><img src="img/persona (7).png" style="width:20px;" HSPACE="3" ></a>';
							}
							elseif($programa == 8){
								echo '<a href="Ver_formulario.php?id_alumn='.$id_alumno.'"><img src="img/persona (8).png" style="width:20px;" HSPACE="3" ></a>';
							}
							elseif($programa == 9){
								echo '<a href="Ver_formulario.php?id_alumn='.$id_alumno.'"><img src="img/persona (9).png" style="width:20px;" HSPACE="3" ></a>';
							}
							elseif($programa == 11){
								echo '<a href="Ver_formulario.php?id_alumn='.$id_alumno.'"><img src="img/persona (10).png" style="width:20px;" HSPACE="3" ></a>';
							}
							elseif($programa == 10){
								echo '<a href="Ver_formulario.php?id_alumn='.$id_alumno.'"><img src="img/persona (11).png" style="width:20px;" HSPACE="3" ></a>';
							}
							elseif($programa == 12){
								echo '<a href="Ver_formulario.php?id_alumn='.$id_alumno.'"><img src="img/persona (12).png" style="width:20px;" HSPACE="3" ></a>';
							}
							elseif($programa == 13){
								echo '<a href="Ver_formulario.php?id_alumn='.$id_alumno.'"><img src="img/persona (13).png" style="width:20px;" HSPACE="3" ></a>';
							}
						}
						elseif($orderby == 7 || $orderby == 8){
							if($id_capturador == 1){
								echo '<a href="Ver_formulario.php?id_alumn='.$id_alumno.'"><img src="img/persona (1).png" style="width:20px;" HSPACE="3" ></a>';
							}
							elseif($id_capturador == 2){
								echo '<a href="Ver_formulario.php?id_alumn='.$id_alumno.'"><img src="img/persona (9).png" style="width:20px;" HSPACE="3" ></a>';
							}
							elseif($id_capturador == 3){
								echo '<a href="Ver_formulario.php?id_alumn='.$id_alumno.'"><img src="img/persona (10).png" style="width:20px;" HSPACE="3" ></a>';
							}
							elseif($id_capturador == 4){
								echo '<a href="Ver_formulario.php?id_alumn='.$id_alumno.'"><img src="img/peopleg.png" style="width:20px;" HSPACE="3" ></a>';
							}
						}
					}
				?>
			<br><br><br>
			<a href="bienvenida.php" class="btn btn-primary btn-lg active" role="button" aria-pressed="true">Salir</a>
			</div>
		</div>
	</body>
</html> 