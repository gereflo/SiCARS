<?php
	session_start();
	if($_SESSION['alias'] == NULL){
		header("Location:index.html");
	}
	include 'acceso.php';
	
	$orderby = 0;
	$perif = 4;
	$most_perif = "Todas";
	$fase = 0;

	if(isset($_GET["orderby"])){
		$orderby = $_GET["orderby"];
	}

	if(isset($_GET["perif"])){
		$perif = $_GET["perif"];

		if($perif == 0){
			$most_perif = "Nucleo";
		}
		else if($perif == 1){
			$most_perif = "Primera";
		}
		else if($perif == 2){
			$most_perif = "Segunda";
		}
		else if($perif == 3){
			$most_perif = "Tercera";
		}
		else if($perif == 4){
			$most_perif = "Todas";
		}
		else{
			$perif = 4;
			$most_perif = "Todas";
		};
	};
	
	if(isset($_GET["fase"])){
		$fase = $_GET["fase"];
	}

	$tabla = NULL;
	$mostrando = "No se ha sleccionado ninguna";
	$relacion_palabrasumatoria= [];
	$relacion_palabrasumatoriaMujer= [];
	$relacion_palabrasumatoriaHombre= [];

	function separa_periferiasV1($arreglo)
	{
    	//echo 'Función separa <br>';
    	$relacion_palabrasumatoria_conperiferia = [];
    	$limites = [3,5,0,0,0];
    	$bandera_limite = false;
    	$periferia = ["Nucleo", "Primera", "Segunda", "Tercera", "Cuarta", "Quinta"];
    	//echo "elementos en arreglo: ".count($arreglo);

    	$i = 0;
    	$j = 0;
    	$comparador = 0;
    	$elementos_extra = 0;
		foreach( $arreglo as $key => $palabra ) {
    		//echo '<ul>'. $key;
    		$id = NULL;
    		$pal = NULL;
    		$mencion =  NULL;
    		$suma = NULL;
        	foreach( $palabra as $attribute => $value ) {
            	//echo '<li>' . $attribute . ': ' . $value . '</li>';
            	if($attribute == "suma" && $value <=10 && $value >=6){
            		//echo "valor menor a 10 y mayor a 5";
            		$i = 3;
            	}
            	else if($attribute == "suma" && $value <=5){
            		//echo "valor menoro igual 5";
            		$i = 4;
            	}
            	else if($j == $limites[$i] && $attribute == "suma"){
            		$bandera_limite = true;
            		$limites[$i] = $limites[$i] + 1;
            		//echo "entre";
            		//echo $comparador." : ".$value;
            		if($comparador != $value){
            			$i = $i+1;
            			$bandera_limite = false;
            			$j = 0;
            		}
            	}
            	if($attribute == "suma"){
            		$comparador = $value;
            		$suma = $value; 
            	}
            	if($attribute == "id"){
            		$id = $value; 
            	}
            	if($attribute == "palabra"){
            		$pal= $value;
            	}
            	if($attribute == "menciones"){
            		$mencion = $value; 
            	}
        	}
        	//echo '<li> Periferia: ' . $periferia[$i] .'</li>';
        	$tupla = ["id" => $id, "palabra" => $pal, "menciones" => $mencion, "suma" => $suma, "periferia" => $periferia[$i]];
        	array_push ( $relacion_palabrasumatoria_conperiferia , $tupla );
    		//echo '</ul>';
    		$j = $j + 1;
		}

    	return $relacion_palabrasumatoria_conperiferia;
	}

	function separa_periferias($arreglo, $p) //P es la cantidad de periferias a mostrar
	{
    	//echo 'Función separa <br>';
    	$relacion_palabrasumatoria_conperiferia = [];
    	$limites = [3,5,0,0,0];
    	$bandera_limite = false;
    	$periferia = ["Nucleo", "Primera", "Segunda", "Tercera", "Cuarta", "Quinta"];
    	//echo "elementos en arreglo: ".count($arreglo);

    	$i = 0;
    	$j = 0;
    	$comparador = 0;
    	$elementos_extra = 0;
		foreach( $arreglo as $key => $palabra ) {
    		//echo '<ul>'. $key;
    		$id = NULL;
    		$pal = NULL;
    		$mencion =  NULL;
    		$suma = NULL;
        	foreach( $palabra as $attribute => $value ) {
            	//echo '<li>' . $attribute . ': ' . $value . '</li>';
            	if($attribute == "suma" && $value <=10 && $value >=6){
            		//echo "valor menor a 10 y mayor a 5";
            		$i = 3;
            	}
            	else if($attribute == "suma" && $value <=5){
            		//echo "valor menoro igual 5";
            		$i = 4;
            	}
            	else if($j == $limites[$i] && $attribute == "suma"){
            		$bandera_limite = true;
            		$limites[$i] = $limites[$i] + 1;
            		//echo "entre";
            		//echo $comparador." : ".$value;
            		if($comparador != $value){
            			$i = $i+1;
            			$bandera_limite = false;
            			$j = 0;
            		}
            	}
            	if($attribute == "suma"){
            		$comparador = $value;
            		$suma = $value; 
            	}
            	if($attribute == "id"){
            		$id = $value; 
            	}
            	if($attribute == "palabra"){
            		$pal= $value;
            	}
            	if($attribute == "menciones"){
            		$mencion = $value; 
            	}
        	}
        	//echo '<li> Periferia: ' . $periferia[$i] .'</li>';
        	if($p >=  $i){
        		$tupla = ["id" => $id, "palabra" => $pal, "menciones" => $mencion, "suma" => $suma, "periferia" => $periferia[$i]];
        		array_push ( $relacion_palabrasumatoria_conperiferia , $tupla );
        	}
        	else{
        		break;
        	}
    		//echo '</ul>';
    		$j = $j + 1;
		}

    	return $relacion_palabrasumatoria_conperiferia;
	}

	function hacer_tabla($arreglo){
		$tabla = NULL;

		foreach( $arreglo as $key => $tupla ){
			//echo '<ul>';
			$id = NULL;
    		$pal = NULL;
    		$mencion =  NULL;
    		$suma = NULL;
    		$periferia = NULL;
			foreach( $tupla as $attribute => $value ){
				//echo '<li>' . $attribute . ': ' . $value . '</li>';
				if($attribute == "suma"){
            		$suma = $value; 
            	}
            	if($attribute == "id"){
            		$id = $value; 
            	}
            	if($attribute == "palabra"){
            		$pal= $value;
            	}
            	if($attribute == "menciones"){
            		$mencion = $value; 
            	}
            	if($attribute == "periferia"){
            		$periferia = $value; 
            		//$periferia = "bg-info";
            	}
			}
			//echo '</ul>';
			$tabla = $tabla.'<tr class="'.$periferia.'">
								<th scope="row">'.$id.'</th>
								<td><a class="'.$periferia.'" href="https://www.google.com.mx/search?q=define%3A+'.$pal.'">'.$pal.'</a></td>
								<td>'.$mencion.'</td>
								<td>'.$suma.'</td>
								<td>'.$periferia.'</td>
							</tr>';
		}

		return $tabla;
	}


	function sort_by_suma ($a, $b) {
    	return $a['suma'] - $b['suma'];
	}

	function sort_by_palabra ($a, $b) {
  		return strcasecmp($a["palabra"], $b["palabra"]);
	}




	if($orderby == 0){
		$mostrando = "Todas las palabras";
		$idpal = NULL;
		$pal = NULL;
		$mencion = NULL;
		$sumatoria = NULL;
		
		$consultatodaspalabras = "SELECT DISTINCT palabras_id_palabra FROM registros";
		$resultadoconsultapal = mysqli_query( $conexion, $consultatodaspalabras ) or die ( "Algo ha ido mal en la consulta a la base de datos 1");
		while ($row = mysqli_fetch_array( $resultadoconsultapal )){
			$idpal = $row['palabras_id_palabra'];
			//echo $idpal;
						
			$consultaidpalaba = "SELECT palabra FROM palabras WHERE id_palabra =".$idpal;
			$resultadoidpal = mysqli_query( $conexion, $consultaidpalaba ) or die ( "Algo ha ido mal en la consulta a la base de datos 2");
			while ($row1 = mysqli_fetch_array( $resultadoidpal )){
				$pal = $row1['palabra'];
				//echo $pal;
			};
			
			$consultamenciones = "Select Count(palabras_id_palabra) as menciones from registros WHERE palabras_id_palabra =".$idpal;
			$resultadomenciones = mysqli_query( $conexion, $consultamenciones ) or die ( "Algo ha ido mal en la consulta a la base de datos 3");
			$rows2 = $resultadomenciones->fetch_assoc();
			$mencion = $rows2['menciones'];
			//echo $mencion;
			
			$consultasumatoria = "SELECT SUM(valor) as total FROM registros WHERE palabras_id_palabra = ".$idpal;
			$resultadosumatoria = mysqli_query( $conexion, $consultasumatoria ) or die ( "Algo ha ido mal en la consulta a la base de datos 3");
			$rows2 = $resultadosumatoria->fetch_assoc();
			$sumatoria = $rows2['total'];
			//echo $sumatoria;
			
			//$tabla = $tabla.'<tr><th scope="row">'.$idpal.'</th><td>'.$pal.'</td><td>'.$mencion.'</td><td>'.$sumatoria.'</td></tr>';

			$tupla = ["id" => $idpal, "palabra" => $pal, "menciones" => $mencion, "suma" => $sumatoria];
			array_push ( $relacion_palabrasumatoria , $tupla );
		
		};
		
		//-------------Consulta solo mujeres------------
		//SELECT DISTINCT palabras_id_palabra FROM registros INNER JOIN alumnos ON alumnos_id_alumno=id_alumno WHERE generos_id_genero = 1 
		$consultatodaspalabras = "SELECT DISTINCT palabras_id_palabra FROM registros INNER JOIN alumnos ON alumnos_id_alumno=id_alumno WHERE generos_id_genero = 1";
		$resultadoconsultapal = mysqli_query( $conexion, $consultatodaspalabras ) or die ( "Algo ha ido mal en la consulta a la base de datos 1");
		while ($row = mysqli_fetch_array( $resultadoconsultapal )){
			$idpal = $row['palabras_id_palabra'];
			//echo $idpal . ", ";
						
			$consultaidpalaba = "SELECT palabra FROM palabras WHERE id_palabra =".$idpal;
			$resultadoidpal = mysqli_query( $conexion, $consultaidpalaba ) or die ( "Algo ha ido mal en la consulta a la base de datos 2");
			while ($row1 = mysqli_fetch_array( $resultadoidpal )){
				$pal = $row1['palabra'];
				//echo $pal;
			};
			
			$consultamenciones = "Select Count(palabras_id_palabra) as menciones from registros INNER JOIN alumnos ON alumnos_id_alumno=id_alumno WHERE generos_id_genero = 1 AND palabras_id_palabra = ".$idpal;
			$resultadomenciones = mysqli_query( $conexion, $consultamenciones ) or die ( "Algo ha ido mal en la consulta a la base de datos 39");
			$rows2 = $resultadomenciones->fetch_assoc();
			$mencion = $rows2['menciones'];
			//echo $mencion;
			
			$consultasumatoria = "SELECT SUM(valor) as total FROM registros INNER JOIN alumnos ON alumnos_id_alumno=id_alumno WHERE generos_id_genero = 1 AND palabras_id_palabra = ".$idpal;
			$resultadosumatoria = mysqli_query( $conexion, $consultasumatoria ) or die ( "Algo ha ido mal en la consulta a la base de datos 499");
			$rows2 = $resultadosumatoria->fetch_assoc();
			$sumatoria = $rows2['total'];
			//echo $sumatoria;
			
			//$tabla = $tabla.'<tr><th scope="row">'.$idpal.'</th><td>'.$pal.'</td><td>'.$mencion.'</td><td>'.$sumatoria.'</td></tr>';

			$tupla = ["id" => $idpal, "palabra" => $pal, "menciones" => $mencion, "suma" => $sumatoria];
			array_push ( $relacion_palabrasumatoriaMujer , $tupla );
		};
		
		//-------------Consulta solo Hombres------------

		$consultatodaspalabras = "SELECT DISTINCT palabras_id_palabra FROM registros INNER JOIN alumnos ON alumnos_id_alumno=id_alumno WHERE generos_id_genero = 2";
		$resultadoconsultapal = mysqli_query( $conexion, $consultatodaspalabras ) or die ( "Algo ha ido mal en la consulta a la base de datos 1");
		while ($row = mysqli_fetch_array( $resultadoconsultapal )){
			$idpal = $row['palabras_id_palabra'];
			//echo $idpal . ", ";
						
			$consultaidpalaba = "SELECT palabra FROM palabras WHERE id_palabra =".$idpal;
			$resultadoidpal = mysqli_query( $conexion, $consultaidpalaba ) or die ( "Algo ha ido mal en la consulta a la base de datos 2");
			while ($row1 = mysqli_fetch_array( $resultadoidpal )){
				$pal = $row1['palabra'];
				//echo $pal;
			};
			
			$consultamenciones = "Select Count(palabras_id_palabra) as menciones from registros INNER JOIN alumnos ON alumnos_id_alumno=id_alumno WHERE generos_id_genero = 2 AND palabras_id_palabra =".$idpal;
			$resultadomenciones = mysqli_query( $conexion, $consultamenciones ) or die ( "Algo ha ido mal en la consulta a la base de datos 37");
			$rows2 = $resultadomenciones->fetch_assoc();
			$mencion = $rows2['menciones'];
			//echo $mencion;
			
			$consultasumatoria = "SELECT SUM(valor) as total FROM registros INNER JOIN alumnos ON alumnos_id_alumno=id_alumno WHERE generos_id_genero = 2 AND palabras_id_palabra = ".$idpal;
			$resultadosumatoria = mysqli_query( $conexion, $consultasumatoria ) or die ( "Algo ha ido mal en la consulta a la base de datos 48");
			$rows2 = $resultadosumatoria->fetch_assoc();
			$sumatoria = $rows2['total'];
			//echo $sumatoria;
			
			//$tabla = $tabla.'<tr><th scope="row">'.$idpal.'</th><td>'.$pal.'</td><td>'.$mencion.'</td><td>'.$sumatoria.'</td></tr>';

			$tupla = ["id" => $idpal, "palabra" => $pal, "menciones" => $mencion, "suma" => $sumatoria];
			array_push ( $relacion_palabrasumatoriaHombre , $tupla );
		};
		
	}
	elseif($orderby == 1 || $orderby == 2 || $orderby == 3 ||$orderby == 4 || $orderby == 5 || $orderby == 6 || $orderby == 7 || $orderby == 8){
		$mostrando = $mostrando;
		$idpal = NULL;
		$pal = NULL;
		$mencion = NULL;
		$sumatoria = NULL;
		
		$consultaestimulo = "SELECT pal_estimulo from estimulos where id_estimulo =".$orderby."";
		$resultadoconsultapal = mysqli_query( $conexion, $consultaestimulo ) or die ( "Algo ha ido mal en la consulta a la base de datos 0");
		while ($row1 = mysqli_fetch_array( $resultadoconsultapal )){
				$mostrando = $row1['pal_estimulo'];
		};
		
		$consultatodaspalabras = "SELECT DISTINCT palabras_id_palabra FROM registros JOIN alumnos ON alumnos_id_alumno = id_alumno WHERE estimulos_id_estimulo =".$orderby." AND fase =".$fase;
		//echo $consultatodaspalabras."<br>";
		$resultadoconsultapal = mysqli_query( $conexion, $consultatodaspalabras ) or die ( "Algo ha ido mal en la consulta a la base de datos 1");
		while ($row = mysqli_fetch_array( $resultadoconsultapal )){
			$idpal = $row['palabras_id_palabra'];
			//echo $idpal;
						
			$consultaidpalaba = "SELECT palabra FROM palabras WHERE id_palabra =".$idpal;
			$resultadoidpal = mysqli_query( $conexion, $consultaidpalaba ) or die ( "Algo ha ido mal en la consulta a la base de datos 2");
			while ($row1 = mysqli_fetch_array( $resultadoidpal )){
				$pal = $row1['palabra'];
				//echo $pal;
			};
			
			//$consultamenciones = "SELECT Count(palabras_id_palabra) as menciones from registros WHERE palabras_id_palabra =".$idpal." AND estimulos_id_estimulo = ".$orderby;
			$consultamenciones = "SELECT Count(palabras_id_palabra) as menciones from registros JOIN alumnos ON alumnos_id_alumno = id_alumno WHERE palabras_id_palabra =".$idpal." AND estimulos_id_estimulo = ".$orderby." AND fase =".$fase;
			//echo $consultamenciones."<br>";
			$resultadomenciones = mysqli_query( $conexion, $consultamenciones ) or die ( "Algo ha ido mal en la consulta a la base de datos 3");
			$rows2 = $resultadomenciones->fetch_assoc();
			$mencion = $rows2['menciones'];
			//echo $mencion."<br>";
			//echo $mencion;
			
			//$consultasumatoria = "SELECT SUM(valor) as total FROM registros WHERE palabras_id_palabra = ".$idpal." AND estimulos_id_estimulo = ".$orderby;
			$consultasumatoria = "SELECT SUM(valor) as total FROM registros JOIN alumnos ON alumnos_id_alumno = id_alumno WHERE palabras_id_palabra = ".$idpal." AND estimulos_id_estimulo = ".$orderby." AND fase =".$fase;
			$resultadosumatoria = mysqli_query( $conexion, $consultasumatoria ) or die ( "Algo ha ido mal en la consulta a la base de datos 3");
			$rows2 = $resultadosumatoria->fetch_assoc();
			$sumatoria = $rows2['total'];
			//echo $sumatoria."<br>";
			
			//$tabla = $tabla.'<tr><th scope="row">'.$idpal.'</th><td>'.$pal.'</td><td>'.$mencion.'</td><td>'.$sumatoria.'</td></tr>';

			$tupla = ["id" => $idpal, "palabra" => $pal, "menciones" => $mencion, "suma" => $sumatoria];//($sumatoria*100)/$sumatoriatot];
			array_push ( $relacion_palabrasumatoria , $tupla );
		};
		
		//-------------Consulta solo mujeres------------
		//SELECT DISTINCT palabras_id_palabra FROM registros INNER JOIN alumnos ON alumnos_id_alumno=id_alumno WHERE generos_id_genero = 1
		$consultaestimulo = "SELECT pal_estimulo from estimulos WHERE id_estimulo =".$orderby."";
		$resultadoconsultapal = mysqli_query( $conexion, $consultaestimulo ) or die ( "Algo ha ido mal en la consulta a la base de datos 0");
		while ($row1 = mysqli_fetch_array( $resultadoconsultapal )){
				$mostrando = $row1['pal_estimulo'];
		};
		
		$consultatodaspalabras = "SELECT DISTINCT palabras_id_palabra FROM registros INNER JOIN alumnos ON alumnos_id_alumno=id_alumno WHERE generos_id_genero = 1 AND estimulos_id_estimulo = ".$orderby." AND fase =".$fase;
		$resultadoconsultapal = mysqli_query( $conexion, $consultatodaspalabras ) or die ( "Algo ha ido mal en la consulta a la base de datos 1");
		while ($row = mysqli_fetch_array( $resultadoconsultapal )){
			$idpal = $row['palabras_id_palabra'];
			//echo $idpal;
						
			$consultaidpalaba = "SELECT palabra FROM palabras WHERE id_palabra =".$idpal;
			$resultadoidpal = mysqli_query( $conexion, $consultaidpalaba ) or die ( "Algo ha ido mal en la consulta a la base de datos 2");
			while ($row1 = mysqli_fetch_array( $resultadoidpal )){
				$pal = $row1['palabra'];
				//echo $pal;
			};
			
			$consultamenciones = "Select Count(palabras_id_palabra) as menciones from registros INNER JOIN alumnos ON alumnos_id_alumno=id_alumno WHERE generos_id_genero = 1 AND palabras_id_palabra =".$idpal." AND estimulos_id_estimulo = ".$orderby." AND fase =".$fase;
			$resultadomenciones = mysqli_query( $conexion, $consultamenciones ) or die ( "Algo ha ido mal en la consulta a la base de datos 31");
			$rows2 = $resultadomenciones->fetch_assoc();
			$mencion = $rows2['menciones'];
			//echo $mencion;
			
			$consultasumatoria = "SELECT SUM(valor) as total FROM registros INNER JOIN alumnos ON alumnos_id_alumno=id_alumno WHERE generos_id_genero = 1 AND palabras_id_palabra = ".$idpal." AND estimulos_id_estimulo = ".$orderby." AND fase =".$fase;
			$resultadosumatoria = mysqli_query( $conexion, $consultasumatoria ) or die ( "Algo ha ido mal en la consulta a la base de datos 44");
			$rows2 = $resultadosumatoria->fetch_assoc();
			$sumatoria = $rows2['total'];
			//echo $sumatoria;
			
			//$tabla = $tabla.'<tr><th scope="row">'.$idpal.'</th><td>'.$pal.'</td><td>'.$mencion.'</td><td>'.$sumatoria.'</td></tr>';

			$tupla = ["id" => $idpal, "palabra" => $pal, "menciones" => $mencion, "suma" => $sumatoria];
			array_push ( $relacion_palabrasumatoriaMujer , $tupla );
		};
		
		//-------------Consulta solo Hombres------------

		$consultaestimulo = "SELECT pal_estimulo from estimulos WHERE id_estimulo =".$orderby."";
		$resultadoconsultapal = mysqli_query( $conexion, $consultaestimulo ) or die ( "Algo ha ido mal en la consulta a la base de datos 0");
		while ($row1 = mysqli_fetch_array( $resultadoconsultapal )){
				$mostrando = $row1['pal_estimulo'];
		};
		
		$consultatodaspalabras = "SELECT DISTINCT palabras_id_palabra FROM registros INNER JOIN alumnos ON alumnos_id_alumno=id_alumno WHERE generos_id_genero = 2 AND estimulos_id_estimulo = ".$orderby." AND fase =".$fase;
		$resultadoconsultapal = mysqli_query( $conexion, $consultatodaspalabras ) or die ( "Algo ha ido mal en la consulta a la base de datos 1");
		while ($row = mysqli_fetch_array( $resultadoconsultapal )){
			$idpal = $row['palabras_id_palabra'];
			//echo $idpal;
						
			$consultaidpalaba = "SELECT palabra FROM palabras WHERE id_palabra =".$idpal;
			$resultadoidpal = mysqli_query( $conexion, $consultaidpalaba ) or die ( "Algo ha ido mal en la consulta a la base de datos 2");
			while ($row1 = mysqli_fetch_array( $resultadoidpal )){
				$pal = $row1['palabra'];
				//echo $pal;
			};
			
			$consultamenciones = "Select Count(palabras_id_palabra) as menciones from registros INNER JOIN alumnos ON alumnos_id_alumno=id_alumno WHERE generos_id_genero = 2 AND palabras_id_palabra =".$idpal." AND estimulos_id_estimulo = ".$orderby." AND fase =".$fase;
			$resultadomenciones = mysqli_query( $conexion, $consultamenciones ) or die ( "Algo ha ido mal en la consulta a la base de datos 31");
			$rows2 = $resultadomenciones->fetch_assoc();
			$mencion = $rows2['menciones'];
			//echo $mencion;
			
			$consultasumatoria = "SELECT SUM(valor) as total FROM registros INNER JOIN alumnos ON alumnos_id_alumno=id_alumno WHERE generos_id_genero = 2 AND palabras_id_palabra = ".$idpal." AND estimulos_id_estimulo = ".$orderby." AND fase =".$fase;
			$resultadosumatoria = mysqli_query( $conexion, $consultasumatoria ) or die ( "Algo ha ido mal en la consulta a la base de datos 44");
			$rows2 = $resultadosumatoria->fetch_assoc();
			$sumatoria = $rows2['total'];
			//echo $sumatoria;
			
			//$tabla = $tabla.'<tr><th scope="row">'.$idpal.'</th><td>'.$pal.'</td><td>'.$mencion.'</td><td>'.$sumatoria.'</td></tr>';

			$tupla = ["id" => $idpal, "palabra" => $pal, "menciones" => $mencion, "suma" => $sumatoria];
			array_push ( $relacion_palabrasumatoriaHombre , $tupla );
		};
		
		
	}
	else{
		$conteode = 'nada';
	};
	
?>
<html lang="es">
	<head>
		<title>Comparativa por géneros de RS</title>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
		<link href="https://fonts.googleapis.com/css?family=Abel|Arsenal|Oswald" rel="stylesheet">
		<style>
			.Nucleo{color:#da0000;}
			.Primera{color:#dba004;}
			.Segunda{color:#a6cb03;}
			.Tercera{color:#11a2e2;}
			.Cuarta{color:#c630b8;}
			tr:hover{color:white;font-size: 21px;}

		</style>
		<link rel="stylesheet" type="text/css" href="css/ase.css">
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
		<script type="text/javascript" src="js/jquery-latest.js"></script>
		<script type="text/javascript" src="js/jquery.tablesorter.js"></script>
		<script type="text/javascript" src="js/d3.js"></script>
	<script>
	$(document).ready(function() 
		{ 
			$("#myTable").tablesorter(); 
		} 
	);
	</script>
	</head>
	<body>
		<div class="container">
			<div>
			<h1 class="display-4"><?php echo $_SESSION['alias'] ?>, En esta sección puedes ver la comparativa de géneros</h1>
			<p class="lead">Aquí puedes seleccionar la manera en que se visualiza la información:</p>
				<div class="container">
				  <div class="row">
					<div class="col-sm">
						<p class="lead">Tabla a mostrar:</p>
						<?php
							if($fase == 0){
								$f = "Investigación";
							}
							else{
								$f = $fase;
							}
							echo "Gráfica: ".$mostrando.'<br>';
							echo "Periferias: ".$most_perif.'<br>';
							echo "Fase: ".$f;
						?>
					</div>
					<div class="col-sm">
					<p class="lead">
						<img src="img/perif (1).png" style="width:15px;" HSPACE="3" >Núcleo<br>
						<img src="img/perif (4).png" style="width:15px;" HSPACE="3" >Primera<br>
						<img src="img/perif (5).png" style="width:15px;" HSPACE="3" >Segunda<br>
						<img src="img/perif (3).png" style="width:15px;" HSPACE="3" >Tercera<br>
						<img src="img/perif (2).png" style="width:15px;" HSPACE="3" >Cuarta<br>
					</p>
					</div>
					<div class="col-sm">
					<div class="btn-group" role="group">
							<button id="btnGroupDrop1" type="button" class="btn btn-info dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
							  Selección: <?php echo $mostrando?>
							</button>
							<div class="dropdown-menu" aria-labelledby="btnGroupDrop1">
							  <!--<a class="dropdown-item" href="graficas_palabrascompara.php?orderby=0">Todas las palabras</a>-->
							  <a class="dropdown-item" href="graficas_palabrascompara.php?orderby=1">Abuso</a>
							  <a class="dropdown-item" href="graficas_palabrascompara.php?orderby=2">Acoso</a>
							  <a class="dropdown-item" href="graficas_palabrascompara.php?orderby=3">Hostigamiento</a>
							  <a class="dropdown-item" href="graficas_palabrascompara.php?orderby=4">Abuso Sexual</a>
							  <a class="dropdown-item" href="graficas_palabrascompara.php?orderby=5">Acoso Sexual</a>
							  <a class="dropdown-item" href="graficas_palabrascompara.php?orderby=6">Hostigamiento Sexual</a>
							  <a class="dropdown-item" href="graficas_palabrascompara.php?orderby=7">Feminismo</a>
							  <a class="dropdown-item" href="graficas_palabrascompara.php?orderby=8">Machismo</a>
							</div>
					</div>
					<br>
					<br>
					<div class="btn-group" role="group">
							<button id="btnGroupDrop1" type="button" class="btn btn-success dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
								Periferias a mostrar: <?php echo $most_perif?>
							</button>
							<div class="dropdown-menu" aria-labelledby="btnGroupDrop1">
							  <a class="dropdown-item" href="graficas_palabrascompara.php?orderby=<?php echo $orderby."&perif=0";?>">Nucleo</a>
							  <a class="dropdown-item" href="graficas_palabrascompara.php?orderby=<?php echo $orderby."&perif=1";?>">Primera</a>
							  <a class="dropdown-item" href="graficas_palabrascompara.php?orderby=<?php echo $orderby."&perif=2";?>">Segunda</a>
							  <a class="dropdown-item" href="graficas_palabrascompara.php?orderby=<?php echo $orderby."&perif=3";?>">Tercera</a>
							  <a class="dropdown-item" href="graficas_palabrascompara.php?orderby=<?php echo $orderby."&perif=4"?>">Cuarta</a>
							</div>
						</div>
						<br>
					<br>
					<div class="btn-group" role="group">
							<button id="btnGroupDrop1" type="button" class="btn dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
								Fase: <?php echo $f?>
							</button>
							<div class="dropdown-menu" aria-labelledby="btnGroupDrop1">
							  <!--<a class="dropdown-item" href="graficas_palabras.php?orderby=<?php echo $orderby."&perif=".$perif;?>">Todas</a>-->
							  <a class="dropdown-item" href="graficas_palabrascompara.php?orderby=<?php echo $orderby."&perif=".$perif."&fase=0";?>">Investigación</a>
							  <a class="dropdown-item" href="graficas_palabrascompara.php?orderby=<?php echo $orderby."&perif=".$perif."&fase=1";?>">Uno</a>
							  <a class="dropdown-item" href="graficas_palabrascompara.php?orderby=<?php echo $orderby."&perif=".$perif."&fase=2";?>">Dos</a>
							  <a class="dropdown-item" href="graficas_palabrascompara.php?orderby=<?php echo $orderby."&perif=".$perif."&fase=3";?>">Tres</a>
							  <a class="dropdown-item" href="graficas_palabrascompara.php?orderby=<?php echo $orderby."&perif=".$perif."&fase=4";?>">General</a>
							</div>
						</div>
					</div>
				  </div>
				</div>
				<hr class="my-4">
				
					<!--<table class="table table-striped" id="myTable">
					  <thead>
						<tr>
						  <th scope="col">No. palabra</th>
						  <th scope="col">Palabra</th>
						  <th scope="col">Veces mencionadas</th>
						  <th scope="col">Sumatoria de puntajes</th>
						  <th scope="col">Periferia</th>
						</tr>
					  </thead>
					  <tbody>-->
							<?php 
								//echo $tabla;
								//ksort($relacion_palabrasumatoria);
								//var_dump($relacion_palabrasumatoria);
								//print_r($relacion_palabrasumatoria);
								usort($relacion_palabrasumatoriaMujer, 'sort_by_suma');
								$reversed = array_reverse($relacion_palabrasumatoriaMujer);
								//print_r($relacion_palabrasumatoria);
								$reversed = separa_periferias($reversed, $perif);
								//print_r($reversed);
								$json_valM = json_encode($reversed, JSON_UNESCAPED_UNICODE);
								$tabla = NULL;
								$tabla = hacer_tabla($reversed);
								//echo $tabla;
								//print_r($reversed);
								usort($reversed, 'sort_by_palabra');
								$json_alfabeticoM = json_encode($reversed, JSON_UNESCAPED_UNICODE);
								//echo $json_val;
								
								usort($relacion_palabrasumatoriaHombre, 'sort_by_suma');
								$reversed = array_reverse($relacion_palabrasumatoriaHombre);
								//print_r($relacion_palabrasumatoria);
								$reversed = separa_periferias($reversed, $perif);
								//print_r($reversed);
								$json_valH = json_encode($reversed, JSON_UNESCAPED_UNICODE);
								$tabla = NULL;
								$tabla = hacer_tabla($reversed);
								//echo $tabla;
								//print_r($reversed);
								usort($reversed, 'sort_by_palabra');
								$json_alfabeticoH = json_encode($reversed, JSON_UNESCAPED_UNICODE);
								//echo $json_val;
							?>
					  <!--</tbody>
					</table>-->
				<br>
				<div>
					<div id="grafikM" style="float:left;">
					</div>
					<div id="grafikH" style="float:left;">
					</div>
				</div>
				<br>
				<br>
			<br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>
		<a href="bienvenida.php" class="btn btn-primary btn-lg active" role="button" aria-pressed="true">Salir</a>
			</div>
		</div>
		
	</body>


<!-- D3 Code Start here -->

	<script type="text/javascript">
		var font = "Abel"
		var data = <?php echo $json_alfabeticoM; ?>;
		var data_valores = <?php echo $json_valM; ?>;
		var width = 550;
		var height = 550;
		var circulo_base_separacion = 30;
		var tamano_ciculobase = (height/2)-circulo_base_separacion*2;

		var palabras_para_graficar = Object.keys(data).length;
		var grados_para_aumentar = 360/palabras_para_graficar;
		var angulo_inicio = -90; //Este angulo se asigna para empezar en la pocicion sumperior del circulo
		var g = 0;
		var periferias_a_graficar = <?php echo $perif; ?>;
		//console.log("periferias: " + periferias_a_graficar);

		function torad (deg) {
    		return deg * Math.PI / 180;
		};

		function todegree(radians) {
  			return radians * 180 / Math.PI;
		};
		

		function Coordenadas_circunferenciaX(centX, centY, grados, radio){
    		x = centX + radio * Math.cos(torad (grados));
    		//console.log("X: " + x);
   			//y = centY + radio * math.sin(math.radians(grados));
   			return x;
		}

		function Coordenadas_circunferenciaY(centX, centY, grados, radio){
    		//x = centX + radio * math.cos(math.radians(grados));
   			y = centY + radio * Math.sin(torad (grados));
   			//console.log("Y: " + y);
   			return y;
		}
    	
    	//var periferia = ["Nucleo", "Primera", "Segunda", "Tercera", "Cuarta", "Quinta"];
    	var j = 0;
    	var suma_mayores = 0;
    	var comparador = "Nucleo";
    	var mayores_por_priferia = [];
    	for(var i = 0; i < data_valores.length; i++) {
    		var obj = data_valores[i];
    		//console.log(obj.palabra);
    		//console.log(obj.suma);
    		//console.log("Comparando : " + obj.periferia + " con: " + periferia[j]);
    		//comparador = obj.periferia;
    		if(i==0){
    			//console.log(obj.suma);
    			suma_mayores = suma_mayores + parseInt(obj.suma);
    			mayores_por_priferia.push(parseInt(obj.suma));	
    		};
    		if(obj.periferia != comparador){
    			//console.log("Iguales")
    			//console.log(obj.palabra);
    			//console.log(obj.suma);
    			comparador = obj.periferia;
    			suma_mayores = suma_mayores + parseInt(obj.suma);
    			mayores_por_priferia.push(parseInt(obj.suma));	
    			j = j + 1;
    		};
		}
		//console.log(suma_mayores);
		//console.log(mayores_por_priferia);

		//tamano_ciculobase = suma_mayores; //Si se aciva esta opcion se activa el tamaño real de la grafica


		
		//Se crea el contenedor SVG y se asigna al DIV correspondiente
		var svgcontainer = d3.select("#grafikM").append("svg")
								.attr("width", width)
								.attr("height", height)
								.attr("id", "visualization")
								.attr("xmlns", "http://www.w3.org/2000/svg");

		//Marco para saber donde empieza y acaba el dibijo SVG
		var marco = svgcontainer.append("rect")
								.attr("width", width)
								.attr("height", height)
								//.attr("stroke", "pink")
								.attr("fill","white")
								.attr("stroke-width","6");

		//Circulo base, dentro ira todo lo necesario
		var circulo_base = svgcontainer.append("circle")
								.attr("cx", width/2)
								.attr("cy", height/2)
								.attr("r", tamano_ciculobase)
								.attr("stroke-width",2)
								.attr("stroke","black")
								.attr("opacity", .5)
								.attr("fill","white")
								.attr("stroke-dasharray","10 5");

		//Marca de ciculo central solo referencia
		var circulo_centro = svgcontainer.append("circle")
								.attr("cx", width/2)
								.attr("cy", height/2)
								.attr("r", 1)
								.attr("fill","black");

		//Primero se dibujan las palabras y lineas dentro del ciculo de referencia						
 			var polygons = svgcontainer.selectAll("polygon.back")
             					.data(data)
             					.enter()
             					.append("polygon");

            var texts = svgcontainer.selectAll("text.back")
             					.data(data)
             					.enter()
             					.append("text")
             					.text(function(d) {
												var texto = d.palabra;
												var arregloDeSubCadenas = texto.split("/");
												console.log(arregloDeSubCadenas);
												return arregloDeSubCadenas[0];
												//return texto;
											});
            g = 0;		
        	var polygon = polygons
        					.attr("points", function(d) {
        										grados = angulo_inicio + g;
        										var grados_referencia_mas = grados+grados_para_aumentar/3;
        										var grados_referencia_menos = grados-grados_para_aumentar/3;
        										var cadena = "";

        										for (i=grados_referencia_menos;i<=grados_referencia_mas;i++){
        												x1 = Coordenadas_circunferenciaX(width/2, height/2, i, tamano_ciculobase);
        												y1 = Coordenadas_circunferenciaY(width/2, height/2, i, tamano_ciculobase);
        											cadena = cadena + " "+x1+","+y1+"";
												}
        										g = g + grados_para_aumentar;
												return width/2+","+height/2+cadena;
											})
        					.attr("opacity", "0.07")
   							.attr("fill", "#ff33e3")
							//.attr("fill", "black")
   							.attr("stroke","none")
   							.attr("stroke-width","1");
   			g = 0;
   			var text = texts
        					.attr("x", function(d, x) {
        										grados = angulo_inicio + g;
        										x = Coordenadas_circunferenciaX(width/2, height/2, grados, tamano_ciculobase+5);
        										g = g + grados_para_aumentar;
												return x;
											})
        					.attr("y",function(d, y) {
        										grados = angulo_inicio + g;
        										y = Coordenadas_circunferenciaY(width/2, height/2, grados, tamano_ciculobase+5);
        										g = g + grados_para_aumentar;
												return y;
											})
   							.attr("fill", "black")
   							.attr("transform", function(d) {
        										grados = angulo_inicio + g;
        										x = Coordenadas_circunferenciaX(width/2, height/2, grados, tamano_ciculobase+5);
        										y = Coordenadas_circunferenciaY(width/2, height/2, grados, tamano_ciculobase+5);
        										g = g + grados_para_aumentar;
												return "rotate("+grados+","+x+","+y+")";
											})
   							.attr("text-anchor","start")
   							.attr("font-family", font)
   							.attr("dominant-baseline","middle")
   							.attr("font-size", function(d) {
												//console.log(periferias_a_graficar)
												if(periferias_a_graficar < 3){
													return "0px"
												}
												else{
													return "14px"
												}
											});
   		//Fin del dibujado de palabras

   		if(periferias_a_graficar == 10){
   			console.log("Nada por aqui nada por alla");
   		}

   		else{
   			var escala = (tamano_ciculobase/suma_mayores);
   			//console.log("escala: " + escala);
   			var radio_anterior = 0;
   			var x_anterior = 0;
   			var y_anterios = 0;
   			var valor = 0;
   			var circulo_referencia = tamano_ciculobase/2;
   			var referencia = 0;
   			var arr_circulos_referencia = [];

   			for (var k=0;k<mayores_por_priferia.length;k++){
   				//console.log(referencia);
   				if(k == 0){
   					referencia = mayores_por_priferia[k]*escala;
   					arr_circulos_referencia.push(parseInt(referencia));
   				}
   				else{
   					referencia = mayores_por_priferia[k]*escala+referencia;
   					arr_circulos_referencia.push(parseInt(referencia));
   				}
   				var circulo_medio = svgcontainer.append("circle")
								.attr("cx", width/2)
								.attr("cy", height/2)
								.attr("r", referencia)
								.attr("stroke-width",1)
								.attr("stroke","black")
								//.attr("stroke-opacity", .6)
								.attr("fill-opacity",0)
								.attr("fill", "white")
								.attr("stroke-dasharray","10 5");
   			}



   			var centros = [];
   			for (var k = 0;k<arr_circulos_referencia.length;k++){
   				//console.log(referencia);
   				if(k == 0){
   					var c = arr_circulos_referencia[k]/2;
   					centros.push(c);
   				}
   				else{
   					var c = (arr_circulos_referencia[k-1]+arr_circulos_referencia[k])/2;
   					console.log(c)
   					centros.push(c);
   				}
   				
   				var circulo_rojo = svgcontainer.append("circle")
								.attr("cx", width/2)
								.attr("cy", height/2)
								//.attr("r", c)
								.attr("stroke-width",1)
								.attr("stroke","red")
								//.attr("opacity", .1)
								.attr("fill-opacity",0)
								.attr("stroke-dasharray","3 3");
   			};
   			g = 0;


				var circles = svgcontainer.selectAll("circle.small")
	             					.data(data)
	             					.enter()
	             					.append("circle");

	        	var circle = circles.attr("cx",function(d, i, x) {
	        											p = d.periferia;

	   													if(p == "Nucleo"){	
	   														rad = centros[0];
	   													}
	   													else if(p == "Primera"){
	   														rad = centros[1];
	   													}
	   													else if(p == "Segunda"){	
	   														rad = centros[2];
	   													}
	   													else if(p == "Tercera"){	
	   														rad = centros[3];
	   													}
	   													else if (p == "Cuarta"){	
	   														rad = centros[4];
	   													}
	        										grados = angulo_inicio + g;
        											x = Coordenadas_circunferenciaX(width/2, height/2, grados,rad);
        											g = g + grados_para_aumentar;
													return x;
													})
	        					.attr("cy",function(d, i, y) {
	        										p = d.periferia;

	   													if(p == "Nucleo"){	
	   														rad = centros[0];
	   													}
	   													else if(p == "Primera"){
	   														rad = centros[1];
	   													}
	   													else if(p == "Segunda"){	
	   														rad = centros[2];
	   													}
	   													else if(p == "Tercera"){	
	   														rad = centros[3];
	   													}
	   													else if (p == "Cuarta"){	
	   														rad = centros[4];
	   													}
	        										grados = angulo_inicio + g;
        											y = Coordenadas_circunferenciaY(width/2, height/2, grados, rad);
        											g = g + grados_para_aumentar;
													return y;
													})
	   							.attr("r", function(d) {
	   											var r =  (d.suma)/2*escala;
	   											//radio_anterior = r;
	   											//console.log("radio "+ d.palabra +": " + r)
	   											return r;
	   										})
	   							.attr("fill", function(d) {
	   													p = d.periferia;

	   													if(p == "Nucleo"){	
	   														return "#da0000"
	   													}
	   													else if(p == "Primera"){
	   														return "#dba004"
	   													}
	   													else if(p == "Segunda"){	
	   														return "#a6cb03"
	   													}
	   													else if(p == "Tercera"){	
	   														return "#11a2e2"
	   													}
	   													else if (p == "Cuarta"){	
	   														return "#c630b8"
	   													}
	   												})
	   							.attr("opacity", "0.6")
	   							.attr("id", function(d) {
	   													return d.palabra;
	   												});
	   			g = 0;
	   			var texts = svgcontainer.selectAll("text.small")
             					.data(data)
             					.enter()
             					.append("text")
             					.text(function(d) {
												var texto = d.palabra;
												var arregloDeSubCadenas = texto.split("/");
												//console.log(arregloDeSubCadenas);
												return arregloDeSubCadenas[0];
											});

             		var text = texts
        					.attr("x", function(d, i, x) {
	        											p = d.periferia;

	   													if(p == "Nucleo"){	
	   														rad = centros[0];
	   													}
	   													else if(p == "Primera"){
	   														rad = centros[1];
	   													}
	   													else if(p == "Segunda"){	
	   														rad = centros[2];
	   													}
	   													else if(p == "Tercera"){	
	   														rad = centros[3];
	   													}
	   													else if (p == "Cuarta"){	
	   														rad = centros[4];
	   													}
	        										grados = angulo_inicio + g;
        											x = Coordenadas_circunferenciaX(width/2, height/2, grados,rad);
        											g = g + grados_para_aumentar;
													return x;
													})
        					.attr("y",function(d, i, y) {
	        										p = d.periferia;

	   													if(p == "Nucleo"){	
	   														rad = centros[0];
	   													}
	   													else if(p == "Primera"){
	   														rad = centros[1];
	   													}
	   													else if(p == "Segunda"){	
	   														rad = centros[2];
	   													}
	   													else if(p == "Tercera"){	
	   														rad = centros[3];
	   													}
	   													else if (p == "Cuarta"){	
	   														rad = centros[4];
	   													}
	        										grados = angulo_inicio + g;
        											y = Coordenadas_circunferenciaY(width/2, height/2, grados, rad);
        											g = g + grados_para_aumentar;
													return y;
													})
   							.attr("fill", "black")
   							.attr("text-anchor","middle")
   							.attr("font-family", font)
   							.attr("dominant-baseline","middle")
   							.attr("font-size",function(d, i, y) {
	        										p = d.periferia;

	   													if(p == "Nucleo"){	
	   														f = 16;
	   													}
	   													else if(p == "Primera"){
	   														f = 14;
	   													}
	   													else if(p == "Segunda"){	
	   														f = 12;
	   													}
	   													else{	
	   														f = 0;
	   													}
													return f + "px";
													});
   		};
		
		
		
		
		
		
//------------------Comienzo grafik 2-------------------------------------------------------------------		
		var font = "Abel"
		var data = <?php echo $json_alfabeticoH; ?>;
		var data_valores = <?php echo $json_valH; ?>;
		//var width = 500;
		//var height = 500;
		//var circulo_base_separacion = 50;
		var tamano_ciculobase = (height/2)-circulo_base_separacion*2;

		var palabras_para_graficar = Object.keys(data).length;
		var grados_para_aumentar = 360/palabras_para_graficar;
		//var angulo_inicio = -90; //Este angulo se asigna para empezar en la pocicion sumperior del circulo
		var g = 0;
		var periferias_a_graficar = <?php echo $perif; ?>;
		//console.log("periferias: " + periferias_a_graficar);

    	
    	//var periferia = ["Nucleo", "Primera", "Segunda", "Tercera", "Cuarta", "Quinta"];
    	var j = 0;
    	var suma_mayores = 0;
    	var comparador = "Nucleo";
    	var mayores_por_priferia = [];
    	for(var i = 0; i < data_valores.length; i++) {
    		var obj = data_valores[i];
    		//console.log(obj.palabra);
    		//console.log(obj.suma);
    		//console.log("Comparando : " + obj.periferia + " con: " + periferia[j]);
    		//comparador = obj.periferia;
    		if(i==0){
    			//console.log(obj.suma);
    			suma_mayores = suma_mayores + parseInt(obj.suma);
    			mayores_por_priferia.push(parseInt(obj.suma));	
    		};
    		if(obj.periferia != comparador){
    			//console.log("Iguales")
    			//console.log(obj.palabra);
    			//console.log(obj.suma);
    			comparador = obj.periferia;
    			suma_mayores = suma_mayores + parseInt(obj.suma);
    			mayores_por_priferia.push(parseInt(obj.suma));	
    			j = j + 1;
    		};
		}
		//console.log(suma_mayores);
		//console.log(mayores_por_priferia);

		//tamano_ciculobase = suma_mayores; //Si se aciva esta opcion se activa el tamaño real de la grafica


		
		//Se crea el contenedor SVG y se asigna al DIV correspondiente
		var svgcontainer = d3.select("#grafikH").append("svg")
								.attr("width", width)
								.attr("height", height)
								.attr("id", "visualization")
								.attr("xmlns", "http://www.w3.org/2000/svg");

		//Marco para saber donde empieza y acaba el dibijo SVG
		var marco = svgcontainer.append("rect")
								.attr("width", width)
								.attr("height", height)
								//.attr("stroke", "blue")
								.attr("fill","white")
								.attr("stroke-width","6");

		//Circulo base, dentro ira todo lo necesario
		var circulo_base = svgcontainer.append("circle")
								.attr("cx", width/2)
								.attr("cy", height/2)
								.attr("r", tamano_ciculobase)
								.attr("stroke-width",2)
								.attr("stroke","black")
								.attr("opacity", .5)
								.attr("fill","white")
								.attr("stroke-dasharray","10 5");

		//Marca de ciculo central solo referencia
		var circulo_centro = svgcontainer.append("circle")
								.attr("cx", width/2)
								.attr("cy", height/2)
								.attr("r", 1)
								.attr("fill","black");

		//Primero se dibujan las palabras y lineas dentro del ciculo de referencia						
 			var polygons = svgcontainer.selectAll("polygon.back")
             					.data(data)
             					.enter()
             					.append("polygon");

            var texts = svgcontainer.selectAll("text.back")
             					.data(data)
             					.enter()
             					.append("text")
             					.text(function(d) {
												var texto = d.palabra;
												var arregloDeSubCadenas = texto.split("/");
												console.log(arregloDeSubCadenas);
												return arregloDeSubCadenas[0];
												//return texto;
											});
            g = 0;		
        	var polygon = polygons
        					.attr("points", function(d) {
        										grados = angulo_inicio + g;
        										var grados_referencia_mas = grados+grados_para_aumentar/3;
        										var grados_referencia_menos = grados-grados_para_aumentar/3;
        										var cadena = "";

        										for (i=grados_referencia_menos;i<=grados_referencia_mas;i++){
        												x1 = Coordenadas_circunferenciaX(width/2, height/2, i, tamano_ciculobase);
        												y1 = Coordenadas_circunferenciaY(width/2, height/2, i, tamano_ciculobase);
        											cadena = cadena + " "+x1+","+y1+"";
												}
        										g = g + grados_para_aumentar;
												return width/2+","+height/2+cadena;
											})
        					.attr("opacity", "0.07")
   							.attr("fill", "#0b2ef1")
							//.attr("fill", "black")
   							.attr("stroke","none")
   							.attr("stroke-width","1");
   			g = 0;
   			var text = texts
        					.attr("x", function(d, x) {
        										grados = angulo_inicio + g;
        										x = Coordenadas_circunferenciaX(width/2, height/2, grados, tamano_ciculobase+5);
        										g = g + grados_para_aumentar;
												return x;
											})
        					.attr("y",function(d, y) {
        										grados = angulo_inicio + g;
        										y = Coordenadas_circunferenciaY(width/2, height/2, grados, tamano_ciculobase+5);
        										g = g + grados_para_aumentar;
												return y;
											})
   							.attr("fill", "black")
   							.attr("transform", function(d) {
        										grados = angulo_inicio + g;
        										x = Coordenadas_circunferenciaX(width/2, height/2, grados, tamano_ciculobase+5);
        										y = Coordenadas_circunferenciaY(width/2, height/2, grados, tamano_ciculobase+5);
        										g = g + grados_para_aumentar;
												return "rotate("+grados+","+x+","+y+")";
											})
   							.attr("text-anchor","start")
   							.attr("font-family", font)
   							.attr("dominant-baseline","middle")
   							.attr("font-size", function(d) {
												//console.log(periferias_a_graficar)
												if(periferias_a_graficar < 3){
													return "0px"
												}
												else{
													return "14px"
												}
											});
   		//Fin del dibujado de palabras

   		if(periferias_a_graficar == 10){
   			console.log("Nada por aqui nada por alla");
   		}

   		else{
   			var escala = (tamano_ciculobase/suma_mayores);
   			//console.log("escala: " + escala);
   			var radio_anterior = 0;
   			var x_anterior = 0;
   			var y_anterios = 0;
   			var valor = 0;
   			var circulo_referencia = tamano_ciculobase/2;
   			var referencia = 0;
   			var arr_circulos_referencia = [];

   			for (var k=0;k<mayores_por_priferia.length;k++){
   				//console.log(referencia);
   				if(k == 0){
   					referencia = mayores_por_priferia[k]*escala;
   					arr_circulos_referencia.push(parseInt(referencia));
   				}
   				else{
   					referencia = mayores_por_priferia[k]*escala+referencia;
   					arr_circulos_referencia.push(parseInt(referencia));
   				}
   				var circulo_medio = svgcontainer.append("circle")
								.attr("cx", width/2)
								.attr("cy", height/2)
								.attr("r", referencia)
								.attr("stroke-width",1)
								.attr("stroke","black")
								//.attr("stroke-opacity", .6)
								.attr("fill-opacity",0)
								.attr("fill", "white")
								.attr("stroke-dasharray","10 5");
   			}



   			var centros = [];
   			for (var k = 0;k<arr_circulos_referencia.length;k++){
   				//console.log(referencia);
   				if(k == 0){
   					var c = arr_circulos_referencia[k]/2;
   					centros.push(c);
   				}
   				else{
   					var c = (arr_circulos_referencia[k-1]+arr_circulos_referencia[k])/2;
   					console.log(c)
   					centros.push(c);
   				}
   				
   				var circulo_rojo = svgcontainer.append("circle")
								.attr("cx", width/2)
								.attr("cy", height/2)
								//.attr("r", c)
								.attr("stroke-width",1)
								.attr("stroke","red")
								//.attr("opacity", .1)
								.attr("fill-opacity",0)
								.attr("stroke-dasharray","3 3");
   			};
   			g = 0;


				var circles = svgcontainer.selectAll("circle.small")
	             					.data(data)
	             					.enter()
	             					.append("circle");

	        	var circle = circles.attr("cx",function(d, i, x) {
	        											p = d.periferia;

	   													if(p == "Nucleo"){	
	   														rad = centros[0];
	   													}
	   													else if(p == "Primera"){
	   														rad = centros[1];
	   													}
	   													else if(p == "Segunda"){	
	   														rad = centros[2];
	   													}
	   													else if(p == "Tercera"){	
	   														rad = centros[3];
	   													}
	   													else if (p == "Cuarta"){	
	   														rad = centros[4];
	   													}
	        										grados = angulo_inicio + g;
        											x = Coordenadas_circunferenciaX(width/2, height/2, grados,rad);
        											g = g + grados_para_aumentar;
													return x;
													})
	        					.attr("cy",function(d, i, y) {
	        										p = d.periferia;

	   													if(p == "Nucleo"){	
	   														rad = centros[0];
	   													}
	   													else if(p == "Primera"){
	   														rad = centros[1];
	   													}
	   													else if(p == "Segunda"){	
	   														rad = centros[2];
	   													}
	   													else if(p == "Tercera"){	
	   														rad = centros[3];
	   													}
	   													else if (p == "Cuarta"){	
	   														rad = centros[4];
	   													}
	        										grados = angulo_inicio + g;
        											y = Coordenadas_circunferenciaY(width/2, height/2, grados, rad);
        											g = g + grados_para_aumentar;
													return y;
													})
	   							.attr("r", function(d) {
	   											var r =  (d.suma)/2*escala;
	   											//radio_anterior = r;
	   											//console.log("radio "+ d.palabra +": " + r)
	   											return r;
	   										})
	   							.attr("fill", function(d) {
	   													p = d.periferia;

	   													if(p == "Nucleo"){	
	   														return "#da0000"
	   													}
	   													else if(p == "Primera"){
	   														return "#dba004"
	   													}
	   													else if(p == "Segunda"){	
	   														return "#a6cb03"
	   													}
	   													else if(p == "Tercera"){	
	   														return "#11a2e2"
	   													}
	   													else if (p == "Cuarta"){	
	   														return "#c630b8"
	   													}
	   												})
	   							.attr("opacity", "0.6")
	   							.attr("id", function(d) {
	   													return d.palabra;
	   												});
	   			g = 0;
	   			var texts = svgcontainer.selectAll("text.small")
             					.data(data)
             					.enter()
             					.append("text")
             					.text(function(d) {
												var texto = d.palabra;
												var arregloDeSubCadenas = texto.split("/");
												//console.log(arregloDeSubCadenas);
												return arregloDeSubCadenas[0];
											});

             		var text = texts
        					.attr("x", function(d, i, x) {
	        											p = d.periferia;

	   													if(p == "Nucleo"){	
	   														rad = centros[0];
	   													}
	   													else if(p == "Primera"){
	   														rad = centros[1];
	   													}
	   													else if(p == "Segunda"){	
	   														rad = centros[2];
	   													}
	   													else if(p == "Tercera"){	
	   														rad = centros[3];
	   													}
	   													else if (p == "Cuarta"){	
	   														rad = centros[4];
	   													}
	        										grados = angulo_inicio + g;
        											x = Coordenadas_circunferenciaX(width/2, height/2, grados,rad);
        											g = g + grados_para_aumentar;
													return x;
													})
        					.attr("y",function(d, i, y) {
	        										p = d.periferia;

	   													if(p == "Nucleo"){	
	   														rad = centros[0];
	   													}
	   													else if(p == "Primera"){
	   														rad = centros[1];
	   													}
	   													else if(p == "Segunda"){	
	   														rad = centros[2];
	   													}
	   													else if(p == "Tercera"){	
	   														rad = centros[3];
	   													}
	   													else if (p == "Cuarta"){	
	   														rad = centros[4];
	   													}
	        										grados = angulo_inicio + g;
        											y = Coordenadas_circunferenciaY(width/2, height/2, grados, rad);
        											g = g + grados_para_aumentar;
													return y;
													})
   							.attr("fill", "black")
   							.attr("text-anchor","middle")
   							.attr("font-family", font)
   							.attr("dominant-baseline","middle")
   							.attr("font-size",function(d, i, y) {
	        										p = d.periferia;

	   													if(p == "Nucleo"){	
	   														f = 16;
	   													}
	   													else if(p == "Primera"){
	   														f = 14;
	   													}
	   													else if(p == "Segunda"){	
	   														f = 12;
	   													}
	   													else{	
	   														f = 0;
	   													}
													return f + "px";
													});
   		};

        </script>

<!-- D3 Code finish here -->



</html> 