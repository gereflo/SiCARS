<?php
	session_start();
	if($_SESSION['alias'] == NULL){
		header("Location:index.html");
	}
	include 'acceso.php';
	
	$orderby= $_GET["orderby"];
	
	$datadonut = NULL;
	$conteode = null;
	
	if($orderby == 0){
		$conteode = 'generos';
		$consultageneros = "SELECT * FROM ".$conteode;
		$resultadogeneros = mysqli_query( $conexion, $consultageneros ) or die ( "Algo ha ido mal en la consulta a la base de datos 1");
		while ($row = mysqli_fetch_array( $resultadogeneros )){
			//echo $row['id_genero']. '-' . $row['genero'].'<br>';
			$conteom = "Select Count(generos_id_genero) as cantidadgenero from alumnos WHERE generos_id_genero =".$row['id_genero'];
			$resultadoconteo = mysqli_query( $conexion, $conteom ) or die ( "Algo ha ido mal en la consulta a la base de datos 2");
			$rows = $resultadoconteo->fetch_assoc();
			$conteo = $rows['cantidadgenero'];
			//echo $row['genero'].' - '.$conteo;
			if($conteo !=0){
				$datadonut = $datadonut."['".$row['genero']."',     ".$conteo."],\r\n\t\t";
			}
		};
		$conteode = 'géneros';
	}
	elseif($orderby == 1){
		$conteode = 'programas';
		$consultageneros = "SELECT * FROM ".$conteode;
		$resultadoprogramas = mysqli_query( $conexion, $consultageneros ) or die ( "Algo ha ido mal en la consulta a la base de datos 3");
		while ($row = mysqli_fetch_array( $resultadoprogramas )){
			//echo $row['id_programa']. '-' . $row['programa'].'<br>';
			$conteom = "Select Count(programas_id_programa) as cantidadprogramas from alumnos WHERE programas_id_programa = ".$row['id_programa'];
			$resultadoconteo = mysqli_query( $conexion, $conteom ) or die ( "Algo ha ido mal en la consulta a la base de datos 4");
			$rows = $resultadoconteo->fetch_assoc();
			$conteo = $rows['cantidadprogramas'];
			//echo $row['genero'].' - '.$conteo;
			if($conteo !=0){
				$datadonut = $datadonut."['".$row['programa']."',     ".$conteo."],\r\n\t\t";
			}
		};
	}
	elseif($orderby == 2){
		$conteode = 'edad';
		$consultaedades = "SELECT * FROM `alumnos` GROUP BY ".$conteode;
		$resultadoedades = mysqli_query( $conexion, $consultaedades ) or die ( "Algo ha ido mal en la consulta a la base de datos 5");
		while ($row = mysqli_fetch_array( $resultadoedades )){
			//echo $row['edad'].'<br>';
			$conteom = "Select Count(edad) as cantidadedad from alumnos WHERE edad =".$row['edad'];
			//echo $conteom."<br>";
			$resultadoconteo = mysqli_query( $conexion, $conteom ) or die ( "Algo ha ido mal en la consulta a la base de datos 6");
			$rows = $resultadoconteo->fetch_assoc();
			$conteo = $rows['cantidadedad'];
			//echo $row['genero'].' - '.$conteo;
			if($conteo !=0){
				if ($row['edad'] == 0){
					$datadonut = $datadonut."['".'Sin especificar'."',     ".$conteo."],\r\n\t\t";
				}
				else{
					$datadonut = $datadonut."['".$row['edad']."',     ".$conteo."],\r\n\t\t";
				}	
			}
		};
	}
	elseif($orderby == 3){
		$conteode = 'fase';
		$consultaedades = "SELECT * FROM `alumnos` GROUP BY ".$conteode;
		$resultadoedades = mysqli_query( $conexion, $consultaedades ) or die ( "Algo ha ido mal en la consulta a la base de datos 5");
		while ($row = mysqli_fetch_array( $resultadoedades )){
			//echo $row['edad'].'<br>';
			$conteom = "Select Count(fase) as cantidadedad from alumnos WHERE fase =".$row['fase'];
			$resultadoconteo = mysqli_query( $conexion, $conteom ) or die ( "Algo ha ido mal en la consulta a la base de datos 7");
			$rows = $resultadoconteo->fetch_assoc();
			$conteo = $rows['cantidadedad'];
			//echo $row['genero'].' - '.$conteo;
			if($conteo !=0){
				if ($row['fase'] == 0){
					$datadonut = $datadonut."['".'Fase Investigación'."',     ".$conteo."],\r\n\t\t";
				}
				else{
					$datadonut = $datadonut."['".'Fase '.$row['fase']."',     ".$conteo."],\r\n\t\t";
				}	
			}
		};
	}
	else{
		$conteode = 'nada';
	};
	
?>
<html lang="es">
	<head>
	  <title>Gráficas generales</title>
	  <meta charset="utf-8">
	  <meta name="viewport" content="width=device-width, initial-scale=1">
	  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
	  <link href="https://fonts.googleapis.com/css?family=Abel|Arsenal|Oswald" rel="stylesheet">
	  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
	  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
	  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
	  <style>
		.mujer{
		background-color: #777799;
		}
	</style>
	<link rel="stylesheet" type="text/css" href="css/ase.css">
	<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
      google.charts.load("current", {packages:["corechart"]});
      google.charts.setOnLoadCallback(drawChart);
      function drawChart() {
        var data = google.visualization.arrayToDataTable([
          ['Genero', 'Conteo'],
		  <?php echo $datadonut; ?>
        ]);

        var options = {
          title: 'Gráfica del total de <?php echo$conteode?> de alumnos registrados',
          pieHole: 0.4,
		  backgroundColor:'transparent',
		  pieSliceText: 'percentage',
		  //pieSliceText: 'value',
		  //legend: { position: 'labeled', maxLines: 3 },
		  //is3D:'true',
		  //colors:['red','#004411'],
        };

        var chart = new google.visualization.PieChart(document.getElementById('donutchart'));
        chart.draw(data, options);
      }
    </script>
	</head>
	<body>
		<div class="container">
			<div>
			<h1 class="display-4">En esta sección puedes ver los conjuntos de datos generales por característica de alumnos <?php echo $_SESSION['alias'] ?></h1>
			<p class="lead">Aquí puedes seleccionar la manera en que se visualiza la información:</p>
				<div class="container">
				  <div class="row">
					<div class="col-sm">
						<p class="lead">Ordenando por:</p>
						<?php
								if($orderby == 0){
									echo 'Género';
								}
								elseif($orderby == 1){
									echo 'Programa';
								}
								elseif($orderby == 2){
									echo 'Edad';
								}
								elseif($orderby == 3){
									echo 'Fase';
								}
							?>
					</div>
					<div class="col-sm">
					<p class="lead">
					</p>
					</div>
					<div class="col-sm">
					<div class="btn-group" role="group">
							<button id="btnGroupDrop1" type="button" class="btn btn-info dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
							  Ordenar por:
							</button>
							<div class="dropdown-menu" aria-labelledby="btnGroupDrop1">
							  <a class="dropdown-item" href="clasicgraf.php?orderby=0">Géneros</a>
							  <a class="dropdown-item" href="clasicgraf.php?orderby=1">Programas</a>
							  <a class="dropdown-item" href="clasicgraf.php?orderby=2">Edad</a>
							  <a class="dropdown-item" href="clasicgraf.php?orderby=3">Fase</a>
							</div>
						</div>
					</div>
				  </div>
				</div>
				<hr class="my-4">
				
					<div id="donutchart" style="width: 900px; height: 500px; background-color:white; "></div>
					
				<br><br><br>
				<a href="bienvenida.php" class="btn btn-primary btn-lg active" role="button" aria-pressed="true">Salir</a>
			</div>
		</div>
	</body>
</html> 