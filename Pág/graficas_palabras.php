<?php
	include 'acceso.php';
	
	$a1 = htmlspecialchars($_POST['a1']);
	$a2 = htmlspecialchars($_POST['a2']);
	$a3 = htmlspecialchars($_POST['a3']);
	$a4 = htmlspecialchars($_POST['a4']);
	$a5 = htmlspecialchars($_POST['a5']);
	
	$h1 = htmlspecialchars($_POST['h1']);
	$h2 = htmlspecialchars($_POST['h2']);
	$h3 = htmlspecialchars($_POST['h3']);
	$h4 = htmlspecialchars($_POST['h4']);
	$h5 = htmlspecialchars($_POST['h5']);
	
	$orderby= 0;
	$perif= 4;
	$most_perif = "Todas";

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

	$tabla = NULL;
	$mostrando = "No se ha sleccionado ninguna";
	$relacion_palabrasumatoria= [];

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

	function separa_periferias($arreglo, $p)
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
			$porciento = NULL;
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
				if($attribute == "porciento"){
            		$porciento = $value; 
            	}
        	}
        	//echo '<li> Periferia: ' . $periferia[$i] .'</li>';
        	if($p >=  $i){
        		$tupla = ["id" => $id, "palabra" => $pal, "menciones" => $mencion, "suma" => $suma, "periferia" => $periferia[$i],"porciento" => $porciento];
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
			$porciento = NULL;
			
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
				if($attribute == "porciento"){
            		$porciento = $value; 
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
								<td>'.$porciento.'</td>
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

	$consulta2 = "SELECT id_alumno FROM alumnos ORDER BY id_alumno" ;//Se consulta la tabla alumnos para saber cuantos alumnos hay
	$resultado2 = mysqli_query( $conexion, $consulta2 ) or die ( "Algo ha ido mal en la consulta a la base de datos");
	
	$row_cnt = $resultado2->num_rows;



	if($orderby == 0){
		$mostrando = "Todas las palabras";
		$idpal = NULL;
		$pal = NULL;
		$mencion = NULL;
		$sumatoria = NULL;
		$sumatoriatot = null;
		
		$consultasumatoriatot = "SELECT SUM(valor) as total FROM registros";
		$resultadosumatoriatot = mysqli_query( $conexion, $consultasumatoriatot ) or die ( "Algo ha ido mal en la consulta a la base de datos 3");
		$rows3 = $resultadosumatoriatot->fetch_assoc();
		$sumatoriatot = $rows3['total'];
		
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

			$tupla = ["id" => $idpal, "palabra" => $pal, "menciones" => $mencion, "suma" => $sumatoria, "porciento" => $mencion*100/$row_cnt];//($sumatoria*100)/$sumatoriatot];
			array_push ( $relacion_palabrasumatoria , $tupla );
		};
	}
	elseif($orderby == 1 || $orderby == 2 || $orderby == 3 ||$orderby == 4 || $orderby == 5 || $orderby == 6 || $orderby == 7 || $orderby == 8){
		$mostrando = $mostrando;
		$idpal = NULL;
		$pal = NULL;
		$mencion = NULL;
		$sumatoria = NULL;
		$sumatoriatot = null;
		
		$consultasumatoriatot = "SELECT SUM(valor) as total FROM registros WHERE estimulos_id_estimulo = ".$orderby;
		$resultadosumatoriatot = mysqli_query( $conexion, $consultasumatoriatot ) or die ( "Algo ha ido mal en la consulta a la base de datos 3");
		$rows3 = $resultadosumatoriatot->fetch_assoc();
		$sumatoriatot = $rows3['total'];
		
		$consultamenciones = "SELECT Count(palabras_id_palabra) as menciones from registros WHERE estimulos_id_estimulo = ".$orderby;
		$resultadomenciones = mysqli_query( $conexion, $consultamenciones ) or die ( "Algo ha ido mal en la consulta a la base de datos 3");
		$rows2 = $resultadomenciones->fetch_assoc();
		$mencion = $rows2['menciones'];
		
		$consultaestimulo = "SELECT pal_estimulo from estimulos where id_estimulo =".$orderby."";
		$resultadoconsultapal = mysqli_query( $conexion, $consultaestimulo ) or die ( "Algo ha ido mal en la consulta a la base de datos 0");
		while ($row1 = mysqli_fetch_array( $resultadoconsultapal )){
				$mostrando = $row1['pal_estimulo'];
		};
		
		$consultatodaspalabras = "SELECT DISTINCT palabras_id_palabra FROM registros WHERE estimulos_id_estimulo = ".$orderby;
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
			
			$consultamenciones = "SELECT Count(palabras_id_palabra) as menciones from registros WHERE palabras_id_palabra =".$idpal." AND estimulos_id_estimulo = ".$orderby;
			$resultadomenciones = mysqli_query( $conexion, $consultamenciones ) or die ( "Algo ha ido mal en la consulta a la base de datos 3");
			$rows2 = $resultadomenciones->fetch_assoc();
			$mencion = $rows2['menciones'];
			//echo $mencion;
			
			$consultasumatoria = "SELECT SUM(valor) as total FROM registros WHERE palabras_id_palabra = ".$idpal." AND estimulos_id_estimulo = ".$orderby;
			$resultadosumatoria = mysqli_query( $conexion, $consultasumatoria ) or die ( "Algo ha ido mal en la consulta a la base de datos 3");
			$rows2 = $resultadosumatoria->fetch_assoc();
			$sumatoria = $rows2['total'];
			//echo $sumatoria;
			
			//$tabla = $tabla.'<tr><th scope="row">'.$idpal.'</th><td>'.$pal.'</td><td>'.$mencion.'</td><td>'.$sumatoria.'</td></tr>';

			$tupla = ["id" => $idpal, "palabra" => $pal, "menciones" => $mencion, "suma" => $sumatoria, "porciento" => $mencion*100/$row_cnt];//($sumatoria*100)/$sumatoriatot];
			array_push ( $relacion_palabrasumatoria , $tupla );
		};
	}
	else{
		$conteode = 'nada';
	};
	
?>
<html lang="es">
	<head>
		<title>Tu resultado!</title>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
		<link href="https://fonts.googleapis.com/css?family=Abel|Arsenal" rel="stylesheet">
		<style>
			.Nucleo{color:#da0000;}
			.Primera{color:#dba004;}
			.Segunda{color:#a6cb03;}
			.Tercera{color:#11a2e2;}
			.Cuarta{color:#c630b8;}
			tr:hover{color:black;}

		</style>
		</style>
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
		<script src="https://cdn.rawgit.com/eligrey/canvas-toBlob.js/f1a01896135ab378aa5c0118eadd81da55e698d8/canvas-toBlob.js"></script>
		<script src="https://cdn.rawgit.com/eligrey/FileSaver.js/e9d941381475b5df8b7d7691013401e171014e89/FileSaver.min.js"></script>
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
		<?php
			echo $a1."<br>";
			echo $a2."<br>";
			echo $a3."<br>";
			echo $a4."<br>";
			echo $a5."<br>";
			echo $h1."<br>";
			echo $h2."<br>";
			echo $h3."<br>";
			echo $h4."<br>";
			echo $h5."<br>";
		?>
		<div class="container">
			<div class="jumbotron">
			<h1 class="display-4">En esta sección puedes ver diferentes tablas con las palabras</h1>
			<p class="lead">Aquí puedes seleccionar la manera en que se visualiza la información:</p>
				<div class="container">
				  <div class="row">
					<div class="col-sm">
						<p class="lead">Tabla a mostrar:</p>
						<?php
							echo "Tabla: ".$mostrando.'<br>';
							echo "Periferias: ".$most_perif;
							?>
					</div>
					<div class="col-sm">
					<p class="lead">
						<img src="images/perif (1).png" style="width:15px;" HSPACE="3" >Nucleo<br>
						<img src="images/perif (4).png" style="width:15px;" HSPACE="3" >Primera<br>
						<img src="images/perif (5).png" style="width:15px;" HSPACE="3" >Segunda<br>
						<img src="images/perif (3).png" style="width:15px;" HSPACE="3" >Tercera<br>
						<img src="images/perif (2).png" style="width:15px;" HSPACE="3" >Cuarta<br>
					</p>
					</div>
					<div class="col-sm">
					<div class="btn-group" role="group">
							<button id="btnGroupDrop1" type="button" class="btn btn-info dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
							  Tabla a mostrar:
							</button>
							<div class="dropdown-menu" aria-labelledby="btnGroupDrop1">
							  <a class="dropdown-item" href="graficas_palabras.php?orderby=0">Todas las palabras</a>
							  <a class="dropdown-item" href="graficas_palabras.php?orderby=1">Abuso</a>
							  <a class="dropdown-item" href="graficas_palabras.php?orderby=2">Acoso</a>
							  <a class="dropdown-item" href="graficas_palabras.php?orderby=3">Hostigamiento</a>
							  <a class="dropdown-item" href="graficas_palabras.php?orderby=4">Abuso Sexual</a>
							  <a class="dropdown-item" href="graficas_palabras.php?orderby=5">Acoso Sexual</a>
							  <a class="dropdown-item" href="graficas_palabras.php?orderby=6">Hostimgamiento Sexual</a>
							  <a class="dropdown-item" href="graficas_palabras.php?orderby=7">Feminismo</a>
							  <a class="dropdown-item" href="graficas_palabras.php?orderby=8">Machismo</a>
							</div>
					</div>
					<br>
					<br>
					<div class="btn-group" role="group">
							<button id="btnGroupDrop1" type="button" class="btn btn-success dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
							  Periferias a mostrar:
							</button>
							<div class="dropdown-menu" aria-labelledby="btnGroupDrop1">
							  <a class="dropdown-item" href="graficas_palabras.php?orderby=<?php echo $orderby."&perif=0";?>">Nucleo</a>
							  <a class="dropdown-item" href="graficas_palabras.php?orderby=<?php echo $orderby."&perif=1";?>">Primera</a>
							  <a class="dropdown-item" href="graficas_palabras.php?orderby=<?php echo $orderby."&perif=2";?>">Segunda</a>
							  <a class="dropdown-item" href="graficas_palabras.php?orderby=<?php echo $orderby."&perif=3";?>">Tercera</a>
							  <a class="dropdown-item" href="graficas_palabras.php?orderby=<?php echo $orderby."&perif=4"?>">Cuarta</a>
							</div>
						</div>
					</div>
				  </div>
				</div>
				<hr class="my-4">
				
					<table class="table table-striped" id="myTable">
					  <thead>
						<tr>
						  <th scope="col">No. palabra</th>
						  <th scope="col">Palabra</th>
						  <th scope="col">Veces mencionadas</th>
						  <th scope="col">Sumatoria de puntajes</th>
						  <th scope="col">Periferia</th>
						  <th scope="col">Porcentaje mencion</th>
						</tr>
					  </thead>
					  <tbody>
							<?php 
								//echo $tabla;
								//ksort($relacion_palabrasumatoria);
								//var_dump($relacion_palabrasumatoria);
								//print_r($relacion_palabrasumatoria);
								usort($relacion_palabrasumatoria, 'sort_by_suma');
								$reversed = array_reverse($relacion_palabrasumatoria);
								$reversed = separa_periferias($reversed, $perif);
								$json_val = json_encode($reversed, JSON_UNESCAPED_UNICODE);
								$tabla = NULL;
								$tabla = hacer_tabla($reversed);
								//echo $tabla;
								//print_r($reversed);
								usort($reversed, 'sort_by_palabra');
								$json_alfabetico = json_encode($reversed, JSON_UNESCAPED_UNICODE);
								//echo $json_val;
							?>
					  </tbody>
					</table>
				<br>
				<div id="grafik">
					<button id='saveButton'>Export my D3 visualization to PNG</button>
				</div>
				<a id="download" href="#">Download SVG</button>
				<br>
				<br>
				<a href="bienvenida.php" class="btn btn-primary btn-lg active" role="button" aria-pressed="true">Salir</a>
			</div>
		</div>

	</body>


<!-- D3 Code Start here -->

	<script type="text/javascript">
		var font = "Abel"
		var data = <?php echo $json_alfabetico; ?>;
		var data_valores = <?php echo $json_val; ?>;
		var width = 1000;
		var height = 1000;
		var circulo_base_separacion = 50;
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
		var svgcontainer = d3.select("#grafik").append("svg")
								.attr("width", width)
								.attr("height", height)
								.attr("id", "visualization")
								.attr("xmlns", "http://www.w3.org/2000/svg");
								
		//Marco para saber donde empieza y acaba el dibijo SVG
		var marco = svgcontainer.append("rect")
								.attr("width", width)
								.attr("height", height)
								//.attr("stroke", "black")
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
												//console.log(arregloDeSubCadenas);
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
        					.attr("opacity", "0.05")
   							.attr("fill", "black")
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
   					//console.log(c)
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
	   														f = 18;
	   													}
	   													else if(p == "Primera"){
	   														f = 16;
	   													}
	   													else if(p == "Segunda"){	
	   														f = 14;
	   													}
	   													else{	
	   														f = 0;
	   													}
													return f + "px";
													});
													
												
			d3.select("#download").on("click", function(){
			d3.select(this)
			.attr("href", 'data:application/octet-stream;base64,' + btoa(d3.select("#grafik").html()))
			.attr("Download", "<?php echo $mostrando.'P'.$most_perif?>.svg") 
			})
		
   		};		

		
		
		
		// Set-up the export button
d3.select('#saveButton').on('click', function(){
	var svgString = getSVGString(svgcontainer.node());
	svgString2Image( svgString, 2*width, 2*height, 'png', save ); // passes Blob and filesize String to the callback

	function save( dataBlob, filesize ){
		saveAs( dataBlob, 'D3 vis exported to PNG.png' ); // FileSaver.js function
	}
});

// Below are the functions that handle actual exporting:
// getSVGString ( svgNode ) and svgString2Image( svgString, width, height, format, callback )
function getSVGString( svgNode ) {
	svgNode.setAttribute('xlink', 'http://www.w3.org/1999/xlink');
	var cssStyleText = getCSSStyles( svgNode );
	appendCSS( cssStyleText, svgNode );

	var serializer = new XMLSerializer();
	var svgString = serializer.serializeToString(svgNode);
	svgString = svgString.replace(/(\w+)?:?xlink=/g, 'xmlns:xlink='); // Fix root xlink without namespace
	svgString = svgString.replace(/NS\d+:href/g, 'xlink:href'); // Safari NS namespace fix

	return svgString;

	function getCSSStyles( parentElement ) {
		var selectorTextArr = [];

		// Add Parent element Id and Classes to the list
		selectorTextArr.push( '#'+parentElement.id );
		for (var c = 0; c < parentElement.classList.length; c++)
				if ( !contains('.'+parentElement.classList[c], selectorTextArr) )
					selectorTextArr.push( '.'+parentElement.classList[c] );

		// Add Children element Ids and Classes to the list
		var nodes = parentElement.getElementsByTagName("*");
		for (var i = 0; i < nodes.length; i++) {
			var id = nodes[i].id;
			if ( !contains('#'+id, selectorTextArr) )
				selectorTextArr.push( '#'+id );

			var classes = nodes[i].classList;
			for (var c = 0; c < classes.length; c++)
				if ( !contains('.'+classes[c], selectorTextArr) )
					selectorTextArr.push( '.'+classes[c] );
		}

		// Extract CSS Rules
		var extractedCSSText = "";
		for (var i = 0; i < document.styleSheets.length; i++) {
			var s = document.styleSheets[i];
			
			try {
			    if(!s.cssRules) continue;
			} catch( e ) {
		    		if(e.name !== 'SecurityError') throw e; // for Firefox
		    		continue;
		    	}

			var cssRules = s.cssRules;
			for (var r = 0; r < cssRules.length; r++) {
				if ( contains( cssRules[r].selectorText, selectorTextArr ) )
					extractedCSSText += cssRules[r].cssText;
			}
		}
		

		return extractedCSSText;

		function contains(str,arr) {
			return arr.indexOf( str ) === -1 ? false : true;
		}

	}

	function appendCSS( cssText, element ) {
		var styleElement = document.createElement("style");
		styleElement.setAttribute("type","text/css"); 
		styleElement.innerHTML = cssText;
		var refNode = element.hasChildNodes() ? element.children[0] : null;
		element.insertBefore( styleElement, refNode );
	}
}


function svgString2Image( svgString, width, height, format, callback ) {
	var format = format ? format : 'png';

	var imgsrc = 'data:image/svg+xml;base64,'+ btoa( unescape( encodeURIComponent( svgString ) ) ); // Convert SVG string to data URL

	var canvas = document.createElement("canvas");
	var context = canvas.getContext("2d");

	canvas.width = width;
	canvas.height = height;

	var image = new Image();
	image.onload = function() {
		context.clearRect ( 0, 0, width, height );
		context.drawImage(image, 0, 0, width, height);

		canvas.toBlob( function(blob) {
			var filesize = Math.round( blob.length/1024 ) + ' KB';
			if ( callback ) callback( blob, filesize );
		});

		
	};

	image.src = imgsrc;
}
		
        </script>

<!-- D3 Code finish here -->



</html> 