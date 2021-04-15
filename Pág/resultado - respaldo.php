<!DOCTYPE html>

<?php
	
	include 'acceso.php';
	
	$time = time();
	//$edad = htmlspecialchars($_POST['age']);
	//$prog = htmlspecialchars($_POST['prog']);
	$genero = htmlspecialchars($_POST['gender']);
	
	$date = date("Y-m-d", $time);
	//echo $edad."<br>";
	//echo $prog."<br>";
	//echo $genero."<br>";
	//echo "<br>";
	
	$acosoPals1 = isset($_POST["a1"])? $_POST['a1'] : array();
	$acosoPals2 = isset($_POST["a2"])? $_POST['a2'] : array();
	$acosoPals3 = isset($_POST["a3"])? $_POST['a3'] : array();
	$acosoPals4 = isset($_POST["a4"])? $_POST['a4'] : array();
	$acosoPals5 = isset($_POST["a5"])? $_POST['a5'] : array();
	
	$acosoPals = array(reset($acosoPals1), reset($acosoPals2), reset($acosoPals3), reset($acosoPals4), reset($acosoPals5));
	
	$hostpals1 = isset($_POST['h1'])? $_POST['h1'] : array();
	$hostpals2 = isset($_POST['h2'])? $_POST['h2'] : array();
	$hostpals3 = isset($_POST['h3'])? $_POST['h3'] : array();
	$hostpals4 = isset($_POST['h4'])? $_POST['h4'] : array();
	$hostpals5 = isset($_POST['h5'])? $_POST['h5'] : array();
	
	$hostpals = array(reset($hostpals1), reset($hostpals2), reset($hostpals3), reset($hostpals4), reset($hostpals5));
	
	
	//echo json_encode($acosoPals);
	//echo "<br>";
	//echo json_encode($hostpals);
	
	//Funcion para ordenar una tupla por cierto valor en este casao por suma
	function sort_by_suma ($a, $b) {
    	return $a['suma'] - $b['suma'];
	}
	//Funcion para ordenar una tupla por cierto valor en este casao por suma
	function sort_by_palabra ($a, $b) {
  		return strcasecmp($a["palabra"], $b["palabra"]);
	}
	
	// Recibe un arreglo del tipo ["id" => $idpal, "palabra" => $pal, "menciones" => $mencion, "suma" => $sumatoria] y lo acomoda en la periferia correspondiente. ademas de la cantidad de periferias que se necesitan maximo 5 
	function separa_periferias($arreglo, $p){
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
			$usr = false;
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
				if($attribute == "usr"){
            		$usr = $value; 
            	}
        	}
        	if($p >=  $i){
        		$tupla = ["id" => $id, "palabra" => $pal, "menciones" => $mencion, "suma" => $suma, "periferia" => $periferia[$i], "usr" => $usr];
        		array_push ( $relacion_palabrasumatoria_conperiferia , $tupla );
        	}
        	else{
        		break;
        	}
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
	
	//Funcion que detecta si un palabra se encuenta en alguna periferia del arreglo devuleve: "Nucleo", "Primera", "Segunda", "Tercera", "Cuarta", "Quinta"
	function isInPerifery($arreglo, $busqueda){
	
		$pal = null;
		$perf = null;
		$flag = false;
		foreach( $arreglo as $key => $tupla ){
			foreach( $tupla as $attribute => $value ){
				if($attribute == "palabra"){
            		//echo $value;
					if($value == $busqueda){
							//echo $value;
							$pal = $value;
							$flag = true;
					}
            	}
				if($attribute == "periferia"){
					if ($flag == true)
					{
						//echo $value;
						$perf = $value;
						$flag = false;
					}
            	}
			}
			//echo "<br>";
		}
		return $perf;	
	}
	//Calcula los puntos de la semejanza segun la periferia
	function periferyPoints($periferia){
		if ($periferia == "Nucleo"){
			return 5;
		}
		else if ($periferia == "Primera"){
			return 4;
		}
		else if ($periferia == "Segunda"){
			return 3;
		}
		else if ($periferia == "Tercera"){
			return 2;
		}
		else if ($periferia == "Cuarta"){
			return 1;
		}
		else if ($periferia == "0"){
		 return 0;
		}
		
		return 0;
	}
	//Calcula los puntos de la semejanza segun la posicion
	function potitionPoints($arreglo, $busqueda, $lugar){
		$perif = isInPerifery($arreglo, $busqueda);
		//echo $perif;
		
		if(($lugar == 0 or $lugar == 1 or $lugar == 2) and $perif == "Nucleo"){
			//echo "entre";
			return 5;
		}
		else if($lugar == 3 and $perif == "Nucleo"){
			//echo "entre1";
			return 4;
		}
		else if($lugar == 4 and $perif == "Nucleo"){
			//echo "entre2";
			return 3;
		}
		
		else if(($lugar == 1 or $lugar == 2) and $perif == "Primera"){
			//echo "entre3";
			return 5;
		}
		else if(($lugar == 0  or $lugar == 3)and $perif == "Primera"){
			//echo "entre4";
			return 4;
		}
		else if($lugar == 4 and $perif == "Primera"){
			//echo "entre5";
			return 3;
		}
		
		else if($lugar == 2 and $perif == "Segunda"){
			//echo "entre6";
			return 5;
		}
		else if(($lugar == 1 or $lugar == 3) and $perif == "Segunda"){
			//echo "entre7";
			return 4;
		}
		else if(($lugar == 0 or $lugar == 4) and $perif == "Segunda"){
			//echo "entre8";
			return 3;
		}
		
		else if($lugar == 3 and $perif == "Tercera"){
			//echo "entre9";
			return 5;
		}
		else if(($lugar == 2 or $lugar == 4) and $perif == "Tercera"){
			//echo "entre10";
			return 4;
		}
		else if($lugar == 1 and $perif == "Tercera"){
			//echo "entre11";
			return 3;
		}
		else if($lugar == 0 and $perif == "Tercera"){
			//echo "entre11";
			return 2;
		}
		
		else if($lugar == 4 and $perif == "Cuarta"){
			//echo "entre12";
			return 5;
		}
		else if($lugar == 3 and $perif == "Cuarta"){
			//echo "entre13";
			return 4;
		}
		else if($lugar == 2 and $perif == "Cuarta"){
			//echo "entre14";
			return 3;
		}
		else if($lugar == 1 and $perif == "Cuarta"){
			//echo "entre15";
			return 2;
		}
		else if($lugar == 0 and $perif == "Cuarta"){
			//echo "entre16";
			return 1;
		}
		else if ($perif == null){
			//echo "entre17";
			return 0;
		}
		else{
			echo "entre18";
			return 0;
		}
	}
	//Imrpime los resultados de la semejanza
	function resultadotest($suma){
		$tex0 = "Formas parte de la representación social de los estudiantes de la UAM C, simplemente te recomendamos que pongas más atención en los pequeños detalles que diferencian acoso sexual y hostigamiento sexual. ¡Contamos con tu apoyo!!!";
		
		$tex1 = "Casi en la totalidad de tus respuestas te asemejas a la representación social de tus compañeras y compañeros de la UAM C, informate sobre el problema que significa el hostigamiento y acoso sexual. Sabemos que con tu ayuda podemos reducir estas prácticas!!!";
		
		$tex2 = "Una considerable parte de tus construcciones sociales sobre el hostigamiento y acoso sexual son similares a las de la comunidad estudiantil de la UAM C. La mejor idea es que no dejes de interesarte en este problema. Necesitamos de tu apoyo para reducir casos de HAS dentro de nuestra universidad.";
		
		$tex3 = "Tienes muy poca similitud con la representación social de los estudiantes de la UAM C, eso no es malo sólo que cuentas con información diferente. Continúa informándote!!!";
		
		$tex4 = "Te ubicas muy lejos de compartir la representación social sobre el hostigamiento y acoso sexual de los estudiantes de la UAM C, sin embargo no quiere decir que estés mal, sencillamente tienes otra información respecto al problema. Te recomendamos que no dejes de interesarte en el tema. Contamos contigo!!!";
		
		if($suma == 45 || $suma>=34){
			return "Mucha semejanza <br> <b>¿Y esto qué quiere decir?</b> <br> ".$tex0;
		}
		else if($suma >  34 || $suma>=23){
			return "Considerable semejanza <br> <b>¿Y esto qué quiere decir?</b> <br> ".$tex1;
		}
		else if($suma > 23 || $suma>=11){
			return "Semejanza <br> <b>¿Y esto qué quiere decir?</b> <br> ".$tex2;
		}
		else if($suma > 11 || $suma>=1){
			return "Poca semejanza <br> <b>¿Y esto qué quiere decir?</b> <br> ".$tex3;
		}
		else if($suma > 1 || $suma==0){
			return "<h4>Nula semejanza</h4> <br> <b>¿Y esto qué quiere decir?</b> <br> ".$tex4;
		}
	}
	
	//SECCION DE BASE DE DATOS
	function busquedaBase($conexion, $orderby1, $fase1){
		$relacion_palabrasumatoria= []; //Variable que almacena el arreglo total de palabras
		$orderby = $orderby1; //5 = Acoso Sexual 6 = Hostigamiento Sexual
		$mostrando = null;
		$idpal = NULL;
		$pal = NULL;
		$mencion = NULL;
		$sumatoria = NULL;
		$sumatoriatot = null;
		$fase = $fase1;
		$consultasumatoriatot = "SELECT SUM(valor) as total FROM registros WHERE estimulos_id_estimulo = ".$orderby." AND fase = ".$fase;
		//echo $consultasumatoriatot."<br>";
		$resultadosumatoriatot = mysqli_query( $conexion, $consultasumatoriatot ) or die ( "Algo ha ido mal en la consulta a la base de datos 3");
		$rows3 = $resultadosumatoriatot->fetch_assoc();
		$sumatoriatot = $rows3['total'];
			
		$consultamenciones = "SELECT Count(palabras_id_palabra) as menciones from registros WHERE estimulos_id_estimulo = ".$orderby." AND fase = ".$fase;
		//echo $consultamenciones;
		$resultadomenciones = mysqli_query( $conexion, $consultamenciones ) or die ( "Algo ha ido mal en la consulta a la base de datos 4");
		$rows2 = $resultadomenciones->fetch_assoc();
		$mencion = $rows2['menciones'];
			
		$consultaestimulo = "SELECT pal_estimulo from estimulos where id_estimulo =".$orderby."";
		$resultadoconsultapal = mysqli_query( $conexion, $consultaestimulo ) or die ( "Algo ha ido mal en la consulta a la base de datos 0");
		while ($row1 = mysqli_fetch_array( $resultadoconsultapal )){
				$mostrando = $row1['pal_estimulo'];
		};
			
		$consultatodaspalabras = "SELECT DISTINCT palabras_id_palabra FROM registros WHERE estimulos_id_estimulo = ".$orderby." AND fase = ".$fase;
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
				
			$consultamenciones = "SELECT Count(palabras_id_palabra) as menciones from registros WHERE palabras_id_palabra =".$idpal." AND estimulos_id_estimulo = ".$orderby." AND fase = ".$fase;
			//echo $consultamenciones;
			$resultadomenciones = mysqli_query( $conexion, $consultamenciones ) or die ( "Algo ha ido mal en la consulta a la base de datos 3");
			$rows2 = $resultadomenciones->fetch_assoc();
			$mencion = $rows2['menciones'];
			//echo $mencion;
				
			$consultasumatoria = "SELECT SUM(valor) as total FROM registros WHERE palabras_id_palabra = ".$idpal." AND estimulos_id_estimulo = ".$orderby." AND fase = ".$fase;
			$resultadosumatoria = mysqli_query( $conexion, $consultasumatoria ) or die ( "Algo ha ido mal en la consulta a la base de datos 3");
			$rows2 = $resultadosumatoria->fetch_assoc();
			$sumatoria = $rows2['total'];
			//echo $sumatoria;
				
			//$tabla = $tabla.'<tr><th scope="row">'.$idpal.'</th><td>'.$pal.'</td><td>'.$mencion.'</td><td>'.$sumatoria.'</td></tr>';

			$tupla = ["id" => $idpal, "palabra" => $pal, "menciones" => $mencion, "suma" => $sumatoria];
			array_push ( $relacion_palabrasumatoria , $tupla );
		};
		return $relacion_palabrasumatoria;
	}
	function semejanza ($Pals, $jsonR){
		//echo json_encode($Pals);
		$acosoResulPerf = [];
		
		for ($i = 0; $i < count($Pals); $i++){
			//echo ($i+1)." palabra: ".$Pals[$i]." esta en ".isInPerifery($jsonR, $Pals[$i])." y tiene ".$acosoResulPerf[$i] = periferyPoints(isInPerifery($jsonR, $Pals[$i]))." puntos<br>";
			$acosoResulPerf[$i] = periferyPoints(isInPerifery($jsonR, $Pals[$i]));
		}
		
		//echo "Suma total de puntos periferias: ". $sumperf = array_sum($acosoResulPerf)."<br>";
		$sumperf = array_sum($acosoResulPerf);
		//echo print_r($acosoResulPerf);
		
		$acosoResulPot = [];
		for ($i = 0; $i < count($Pals); $i++){
			//echo "puntos posicion: ".$acosoResulPot[$i]=potitionPoints($jsonR, $Pals[$i],$i)."<br>";
			$acosoResulPot[$i]=potitionPoints($jsonR, $Pals[$i],$i);
		}
		//echo "Suma total de puntos por posicion: ". $sumpot = array_sum($acosoResulPot)."<br>";
		$sumpot = array_sum($acosoResulPot);
		
		$suma = (int)$sumperf+(int)$sumpot;
		echo "Suma total de puntos: ".$suma."<br>";
		
		return "Tu resultado es: ".resultadotest($suma);
	}
	
	function busquedapal ($con, $pal){
	
		$consultapalabra = "SELECT * FROM palabras WHERE palabra = '".$pal."'";
		//echo $consultapalabra;
		$resultadopal = mysqli_query( $con, $consultapalabra ) or die ( "Algo ha ido mal en la consulta a la base de datos busquedapal1");
		$r = $resultadopal->fetch_assoc();
		//$r = $r['id_palabra'];
		if ($r == null){
			return 0;
		}
		else{
			return $r;
		}	
	}
	
	function busquedagenero ($con, $gen){
	
		$consultapalabra = "SELECT id_genero FROM generos WHERE genero = '".$gen."'";
		//echo $consultapalabra;
		$resultadopal = mysqli_query( $con, $consultapalabra ) or die ( "Algo ha ido mal en la consulta a la base de datos busquedagenero1");
		$r = $resultadopal->fetch_assoc();
		$r = $r['id_genero'];
		if ($r == null){
			return 0;
		}
		else{
			return $r;
		}	
	}
?>


<html lang="es">
<head>
	<title>Resultados</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
	
	
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
	
	<link rel="stylesheet" type="text/css" href="css/imgzoom.css" />
	<script type="text/javascript" src="js/jquery.imgzoom.pack.js"></script>
	<script src="js/jquery.zoomooz.min.js"></script> 
	<script src="js/jquery.panzoom.js"></script>
    <script src="js/jquery.mousewheel.js"></script>
	
	<!-- Dependencias maggicsuggest -->
	<link href="Maggic/magicsuggest-min.css" rel="stylesheet">
	<script src="Maggic/magicsuggest-min.js"></script>
	
	<!-- Paralax -->
	<link rel="stylesheet" type="text/css" href="Paralax/jquery.parallaxer.css">
	<script type="text/javascript" src="Paralax/jquery.parallaxer.js"></script>
	<script type="text/javascript">
		(function ($) {
			"use strict";

			$(function () {
				$(".parallaxer").parallaxer();
			});
		}(jQuery));
	</script>
	<script LANGUAGE="JavaScript">
		var pagina="https://rpsocialesuamc.000webhostapp.com/#page-top"
			function redireccionar() 
			{
				location.href=pagina
			} 
			setTimeout ("redireccionar()", 1000*300);
		</script>
	<!-- Dependencias D3-->
	<script type="text/javascript" src="js/d3.js"></script>
	<!-- Fuente de grafica-->
	<link rel="stylesheet" type="text/css" href="styleFont.css"/>
	<link href="https://fonts.googleapis.com/css?family=Abel|Arsenal" rel="stylesheet">
	
	<style type="text/css">
            body {
            			margin: 0;
            			background-color: #A81127;
            			font-family: Abel;
            			background-image: url("images/textura2.png");
						color:#fff;
            		}
            
            		.content1 {
            			color:#fff;
            			margin: 70pt 50pt;
            			text-align: justify;
            			min-height: 500px
            		}
            		
            		.content2 {
            			color:#fff;
            			display: block;
            			margin-top: 100px;
            			margin-bottom: 100px;
            			margin-left: auto;
            			margin-right: auto;
            			width: 50%;
            		}
					
					.content3 {
            			color:#fff;
            			display: block;
            			margin-top: 10px;
            			margin-bottom: 10px;
            			margin-left: auto;
            			margin-right: auto;
            			width: 50%;
            		}
					
					.card-body{
						background-color: #A81127;
						color:#fff;
						//border: 100px solid red;
						border-radius: 25px;
					}
            		
            		h1 {
            			//background-color: #ffffff;
            			color:#A81127;
            			font-family: Myriad Pro Condensed;
            			font-size: 300%;
            		}
            		
            		b{
            			background-color: #ffffff;
            			color:#A81127;
            		}
					
					.resp-iframe {
						position: absolute;
						top: 0;
						left: 0;
						width: 100%;
						height: 800px;
						border: 0;
					}
					
					.resp-container {
						position: relative;
						overflow: hidden;
						padding-top: 56.25%;
					}
					.zooming {
						transition: transform .5s; /* Animation */
						transform-origin: center;
						margin: 0 auto;
					}

					.zooming:hover {
						transform: scale(1.5); /* (300% zoom - Note: if the zoom is too large, it will go outside of the viewport) */ 
						background-color: #fff;
						border-radius: 15px;
						position: relative;
						z-index: 1;
					}
			</style>
					 
</head>
<body>
			<?php 
			
				//busquedapal ($conexion, "Mal");//busca si una palabra existe, si no regresa 0
				
				//$acosoPalspueba = array("Mal", "AAAAAAAAAAAAAA", "Sufrir", "Zoofilia", "ZZZZZZZZZZ");
				$idGenero = busquedagenero($conexion, "Femenino");
				
				$idAlumnoconsulta = "INSERT INTO alumnos (fecha, generos_id_genero, programas_id_programa) 
					VALUES ('".$date."', '".$idGenero."', '13')"; // establecer en 13 un programa sin nada.
				//echo $idAlumnoconsulta;
				//echo "<br>";
				$resultado5 = mysqli_query( $conexion, $idAlumnoconsulta ) or die ( "Algo ha ido mal en la consulta a la base de datos5");
				$idalumno=mysqli_insert_id($conexion); //id del alumno recien creado
				//echo $idalumno;
				//echo "<br>";
				
				//Ciclo para palabras dichas por alumno de estimulo Acoso Sexual
				$palUsrNoRegistAS = [];
				$j = 5;
				foreach ($acosoPals as &$pal) {
					$rb = busquedapal ($conexion, $pal);
					//echo "<br>";
					if ($rb == 0 && $pal != false){
						//echo $rb;
						$tupla = ["id" => 0, "palabra" => $pal, "menciones" => 1, "suma" => $j, "usr" => true];
						array_push ($palUsrNoRegistAS , $tupla );
					}
					else if ($pal != false){
						$rb = $rb["id_palabra"];
						//echo $rb;
						$insertRegistro = "INSERT INTO registros (valor, estimulos_id_estimulo, alumnos_id_alumno, palabras_id_palabra, fase) VALUES ('".$j."', '5', '".$idalumno."', '".$rb."', '1')"; //Acoso Sexual id=5
						//echo $insertRegistro;
						$resultRegistro = mysqli_query( $conexion, $insertRegistro ) or die ( "Algo ha ido mal en la consulta a la base de datos registro Acpso");
					}
					$j= $j-1;
				}
				
				//Ciclo para palabras dichas por alumno de estimulo Hostigamiento Sexual
				$palUsrNoRegistHs = [];
				$j = 5;
				foreach ($hostpals as &$pal) {
					$rb = busquedapal ($conexion, $pal);
					//echo "<br>";
					if ($rb == 0 && $pal != false){
						//echo $rb;
						$tupla = ["id" => 0, "palabra" => $pal, "menciones" => 1, "suma" => $j, "usr" => true];
						array_push ($palUsrNoRegistHs , $tupla );
					}
					else if ($pal != false){
						$rb = $rb["id_palabra"];
						//echo $rb;
						$insertRegistro = "INSERT INTO registros (valor, estimulos_id_estimulo, alumnos_id_alumno, palabras_id_palabra, fase) VALUES ('".$j."', '6', '".$idalumno."', '".$rb."', '1')"; //Acoso Sexual id=6
						//echo $insertRegistro;
						$resultRegistro = mysqli_query( $conexion, $insertRegistro ) or die ( "Algo ha ido mal en la consulta a la base de datos");
					}
					$j= $j-1;
				}
				
				//echo json_encode($palUsrNoRegistAS);
				//echo $tabla;
				//ksort($relacion_palabrasumatoria);
				//var_dump($relacion_palabrasumatoria);
				//print_r($relacion_palabrasumatoria);
				$periferias_a_graficar = 4;
				
				//Se extaen los resulytados de AcosoSexual que en base es "5"
				$rpsAcoso = busquedaBase($conexion,5,0);
				//Se agregan las palabras que no estan en la base pero que el usuario ingreso
				$rpsAcoso = array_merge($rpsAcoso,$palUsrNoRegistAS);
				//var_dump($palUsrNoRegistAS);
				
				
				//Se extaen los resulytados de HostigamientoSexual que en base es "6"
				$rpsHost = busquedaBase($conexion,6,0);
				//Se agregan las palabras que no estan en la base pero que el usuario ingreso
				$rpsHost = array_merge($rpsHost,$palUsrNoRegistHs);
				
				//Parametros para graficaar Acoso
				usort($rpsAcoso, 'sort_by_suma');
				$reversed = array_reverse($rpsAcoso);
				$reversed = separa_periferias($reversed, $periferias_a_graficar);
				$json_val = json_encode($reversed, JSON_UNESCAPED_UNICODE);
				usort($reversed, 'sort_by_palabra');
				$json_alfabetico = json_encode($reversed, JSON_UNESCAPED_UNICODE);
				//var_dump($json_val);
				
				//Parametros para graficar Hostigamiento
				usort($rpsHost, 'sort_by_suma');
				$reversedH = array_reverse($rpsHost);
				$reversedH = separa_periferias($reversedH, $periferias_a_graficar);
				$json_valH = json_encode($reversedH, JSON_UNESCAPED_UNICODE);
				usort($reversedH, 'sort_by_palabra');
				$json_alfabeticoH = json_encode($reversedH, JSON_UNESCAPED_UNICODE);
				
				
				//$tabla = NULL;
				//$tabla = hacer_tabla($reversed);
				//echo $tabla;
				//print_r($reversed);
				//usort($reversed, 'sort_by_palabra');
				//$json_alfabetico = json_encode($reversed, JSON_UNESCAPED_UNICODE);
				//echo $json_val;
				
			?>
	<div class="alert alert-danger content3" role="alert"><h1>No olvides llenar la encuesta de satisfacción de la exposición pulsando este botón</h1></div>
		<!-- Button trigger modal -->
	<button type="button" class="btn btn-danger btn-lg content3" data-toggle="modal" data-target="#exampleModal">
	  Encuesta de satisfacción
	</button>
	<div class="card" style="display: block; position: relative; max-width: 700px; min-width: 10px; width: 100%; height: auto; margin-left: auto; margin-right: auto; width: 70%;">
	<h1 class="card-title">Acoso Sexual</h1>
		<section id="focal" class="zooming">
		  <div class="parent">
			<div class="panzoom">
				<div id="grafik">
				</div>
			</div>
		  </div>
		  <div class="buttons">
		  </div>
		  <script>
			(function() {
			  var $section = $('#focal');
			  var $panzoom = $section.find('.panzoom').panzoom();
			  $panzoom.parent().on('mousewheel.focal', function( e ) {
				e.preventDefault();
				var delta = e.delta || e.originalEvent.wheelDelta;
				var zoomOut = delta ? delta < 0 : e.originalEvent.deltaY > 0;
				$panzoom.panzoom('zoom', zoomOut, {
				  animate: false,
				  focal: e
				});
			  });
			})();
		  </script>
		</section>
	  <div class="card-body">
		<p><?php echo semejanza($acosoPals, $reversedH)."<br>";?></p>
	  </div>
	</div>
	<br>

	<div class="card" style="display: block; position: relative; max-width: 700px; min-width: 10px; width: 100%; height: auto; margin-left: auto; margin-right: auto; width: 70%;">
	<h1 class="card-title">Hostigamiento Sexual</h1><br>
		<section id="focal1" class="zooming">
		  <div class="parent">
			<div class="panzoom">
				<div id="grafik2">
				</div>
			</div>
		  </div>
		  <div class="buttons">
		  </div>
		  <script>
			(function() {
			  var $section = $('#focal1');
			  var $panzoom = $section.find('.panzoom').panzoom();
			  $panzoom.parent().on('mousewheel.focal', function( e ) {
				e.preventDefault();
				var delta = e.delta || e.originalEvent.wheelDelta;
				var zoomOut = delta ? delta < 0 : e.originalEvent.deltaY > 0;
				$panzoom.panzoom('zoom', zoomOut, {
				  animate: false,
				  focal: e
				});
			  });
			})();
		  </script>
		</section>
	  <div class="card-body">
		<p><?php echo semejanza($hostpals, $reversedH)."<br>";?></p>
	  </div>
	</div>
	
	<!--<a href="puppy.jpg"><img class="thumbnail" src="puppy_small.jpg" alt="Puppy" /></a>-->
	
	

	<!-- Modal -->
	<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	  <div class="modal-dialog" role="document">
		<div class="modal-content">
		  <div class="modal-body">
			<iframe src="https://docs.google.com/forms/d/e/1FAIpQLSdRxrNzSLTHt1KQVy3sgIoJf6iG3bqwpKkbpgb0fFKo88FBAA/viewform?embedded=true" width="450" height="739" frameborder="0" marginheight="0" marginwidth="0">Cargando...</iframe>
		  </div>
		  <div class="modal-footer">
			<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
		  </div>
		</div>
	  </div>
	</div>

	
</body>
</html>

<script>
	
	//Funcion para pausar codigo javascript solo funciona con asyncfunction
	function sleep(ms) {
	  return new Promise(resolve => setTimeout(resolve, ms));
	};
	
	//Funcion para graficar las representaciones
	function RSgrafik(contenedor, data1, data_valores1, width1, height1, periferias_a_graficar1, real, pals) {
		
		var parche = "Abuso";
		var font = "Myriad Pro Light"; // "Abel" // "Oswald"
		var data = data1; //<?php echo $json_alfabetico; ?>;
		var data_valores = data_valores1;//<?php echo $json_val; ?>;
		var width = width1;
		var height = height1;
		var circulo_base_separacion = 50;
		var tamano_ciculobase = (height/2)-circulo_base_separacion*2;

		var palabras_para_graficar = Object.keys(data).length;
		var grados_para_aumentar = 360/palabras_para_graficar;
		var angulo_inicio = -90; //Este angulo se asigna para empezar en la pocicion sumperior del circulo
		var g = 0;
		var periferias_a_graficar = periferias_a_graficar1; //<?php echo $periferias_a_graficar; ?>;
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
		
		/*		
		function dragstarted(d) {
		  d3.select(this).raise().classed("active", true);
		}

		function dragged(d) {
		  d3.select(this).attr("cx", d.x = d3.event.x).attr("cy", d.y = d3.event.y);
		}

		function dragended(d) {
		  d3.select(this).classed("active", false);
		}
		*/
		function dragstarted(d) {
		  d3.select(this).raise().classed("active", true);
		}


		function dragged(d) {
		  d3.select(this).select("text.small")
			.attr("x", d.x = d3.event.x)
			.attr("y", d.y = d3.event.y);
		  d3.select(this).select("circles")
			.attr("cx", d.x = d3.event.x)
			.attr("cy", d.y = d3.event.y);
		}

		function dragended(d) {
		  d3.select(this).classed("active", false);
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
		if(real == 1){
			tamano_ciculobase = suma_mayores; //Si se aciva esta opcion se activa el tamaño real de la grafica
		}


		//Se crea el contenedor SVG y se asigna al DIV correspondiente
		var svgcontainer = d3.select("#"+contenedor).append("svg")
								.attr("width", width)
								.attr("height", height)
								.call(responsivefy) //Se llama a responsivefy despues de width y height
								.attr("id", "visualization")
								.attr("xmlns", "http://www.w3.org/2000/svg");
								
		//Marco para saber donde empieza y acaba el dibijo SVG
		var marco = svgcontainer.append("rect")
								.attr("width", width)
								.attr("height", height)
								//.attr("stroke", "black")
								.attr("fill","white")
								.attr("opacity", "0.0")//Tranparencia de fondo
								.attr("stroke-width","6");

		//Circulo base, dentro ira todo lo necesario
		var circulo_base = svgcontainer.append("circle")
								.attr("cx", width/2)
								.attr("cy", height/2)
								.attr("r", tamano_ciculobase)
								.attr("stroke-width",2)
								.attr("stroke","black")
								.attr("opacity", "0.0")
								.attr("fill","black")
								.attr("stroke-dasharray","10 5");

		//Marca de ciculo central solo referencia
		var circulo_centro = svgcontainer.append("circle")
								.attr("cx", width/2)
								.attr("cy", height/2)
								.attr("r", 0)
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
												return arregloDeSubCadenas;//[0];
												//return texto;
											});
            g = .1;		
        	var polygon = polygons
        					.attr("points", function(d) {
        										grados = angulo_inicio + g;
												if(periferias_a_graficar == 5 || periferias_a_graficar == 4){
													var div = 2;
												}
												else if(periferias_a_graficar == 3 || periferias_a_graficar == 2){
													var div = 3;
												}
												else if(periferias_a_graficar == 1 || periferias_a_graficar == 0){
													var div = 4;
												}
												else{
													var div = 3;
												}
        										var grados_referencia_mas = grados+(grados_para_aumentar/div);
        										var grados_referencia_menos = grados-(grados_para_aumentar/div);
        										var cadena = "";

        										for (i=grados_referencia_menos;i<=grados_referencia_mas;i++){
        												x1 = Coordenadas_circunferenciaX(width/2, height/2, i, tamano_ciculobase);
        												y1 = Coordenadas_circunferenciaY(width/2, height/2, i, tamano_ciculobase);
        											cadena = cadena + " "+x1+","+y1+"";
												}
        										g = g + grados_para_aumentar;
												return width/2+","+height/2+cadena;
											})
        					.attr("opacity", "0.1")
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
							.attr("fill", function(d) {
	   													p = d.periferia;
														texto = d.palabra;
														//console.log("De colores son los calzoncillos de: "+texto);
														var palUsr = pals;

	   													if (palUsr.includes(texto)){
															return "#da0000"
														}
														else{	
	   														return "black"
	   													}
	   												})
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
								.attr("fill-opacity",function(d) {
															if(k == 0 || k==1 || k==2){
																return 0;
															}
															else{
																return 0;
															}
														})
								.attr("fill", "black")
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
								.attr("r", c)
								.attr("stroke-width",1)
								//.attr("stroke","red")
								.attr("opacity", 1)
								.attr("fill-opacity",0)
								.attr("stroke-dasharray","3 3");
   			};
   			g = 0;
			gn = 0;
			var circleGroup = svgcontainer.append("g");
										
			
			var circles = circleGroup.selectAll("circle.small")
	             					.data(data)
	             					.enter()
	             					.append("circle");

	        	var circle = circles.attr("cx",function(d, i, x) {
	        											p = d.periferia;
														texto = d.palabra;

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
													if(texto=="Abuso/Abusador/Abusar/Abusivo"){ //parche solo para que no aparescan conpceptos encimados primera esfera
														x = 130 + Coordenadas_circunferenciaX(width/2, height/2, grados,rad);
													}
													else{
														x = Coordenadas_circunferenciaX(width/2, height/2, grados,rad);
													}
        											g = g + grados_para_aumentar;
													return x;
													})
	        					.attr("cy",function(d, i, y) {
	        										p = d.periferia;
													texto = d.palabra;

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
													if(texto=="Abuso/Abusador/Abusar/Abusivo"){ //parche solo para que no aparescan conpceptos encimados primera esfera
														y = 150 +Coordenadas_circunferenciaY(width/2, height/2, grados, rad);
													}
													else{
														y = Coordenadas_circunferenciaY(width/2, height/2, grados, rad);
													}
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
														texto = d.palabra;
														//console.log("De colores son los calzoncillos de: "+texto);
														var palUsr = pals;

	   													//if (palUsr.includes(texto)){
														//	return "none"
														//}
														//else 
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
	   							.attr("opacity", function(d) {
															p = d.periferia;
															texto = d.palabra;
															//console.log("De colores son los calzoncillos de: "+texto);
															var palUsr = pals;

															if (palUsr.includes(texto)){
																return "none"
															}
															else {
																return "0.4"
															}
														})
								.attr("stroke",function(d) {
															p = d.periferia;
															texto = d.palabra;
															//console.log("De colores son los calzoncillos de: "+texto);
															var palUsr = pals;

															if (palUsr.includes(texto)){
																return "black"
															}
															else {
																return "none"
															}
														})
	   							.attr("id", function(d) {return d.palabra;})
								.attr("stroke-width",5)
								g = 0;
			
	   			var texts = circleGroup.selectAll("text.small")
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
														texto = d.palabra;

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
        											if(texto=="Abuso/Abusador/Abusar/Abusivo"){ //parche solo para que no aparescan conpceptos encimados primera esfera
														x = 130 + Coordenadas_circunferenciaX(width/2, height/2, grados,rad);
													}
													else{
														x = Coordenadas_circunferenciaX(width/2, height/2, grados,rad);
													}
        											g = g + grados_para_aumentar;
													return x;
													})
        					.attr("y",function(d, i, y) {
	        										p = d.periferia;
													texto = d.palabra;

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
        											if(texto=="Abuso/Abusador/Abusar/Abusivo"){ //parche solo para que no aparescan conpceptos encimados primera esfera
														y = 150 +Coordenadas_circunferenciaY(width/2, height/2, grados, rad);
													}
													else{
														y = Coordenadas_circunferenciaY(width/2, height/2, grados, rad);
													}
        											g = g + grados_para_aumentar;
													
													texto = d.palabra;
														//console.log("De colores son los calzoncillos de: "+texto);
														var palUsr = pals;

	   													if (palUsr.includes(texto)){
															y = y+10;
														}
													return (y);
													})
   							.attr("fill", "black")
   							.attr("text-anchor","middle")
   							.attr("font-family", font)
   							.attr("dominant-baseline","middle")
   							.attr("font-size",function(d, i, x,y) {
														p = d.periferia;
														texto = d.palabra;
														//console.log("De colores son los calzoncillos de: "+texto);
														var palUsr = pals;

	   													if (palUsr.includes(texto) && p == "Nucleo"){
															f = 30;
														}
														else if (palUsr.includes(texto) && p == "Primera"){
															f = 30;
														}
														else if (palUsr.includes(texto) && p == "Segunda"){
															f = 30;
														}
	   													else if(p == "Nucleo"){	
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
													
				var images = circleGroup.selectAll("pointer.small")
	             					.data(data)
	             					.enter()
	             					.append("image");

					
					var pointer = images.attr("x",function(d, i, x) {
	        											p = d.periferia;
														texto = d.palabra;

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
        											if(texto=="Abuso/Abusador/Abusar/Abusivo"){ //parche solo para que no aparescan conpceptos encimados primera esfera
														x = 130 + Coordenadas_circunferenciaX(width/2, height/2, grados,rad);
													}
													else{
														x = Coordenadas_circunferenciaX(width/2, height/2, grados,rad);
													}
        											g = g + grados_para_aumentar;
													return x;
													})
	        					.attr("y",function(d, i, y) {
	        										p = d.periferia;
													texto = d.palabra;

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
        											if(texto=="Abuso/Abusador/Abusar/Abusivo"){ //parche solo para que no aparescan conpceptos encimados primera esfera
														y = 150 +Coordenadas_circunferenciaY(width/2, height/2, grados, rad);
													}
													else{
														y = Coordenadas_circunferenciaY(width/2, height/2, grados, rad);
													}
        											g = g + grados_para_aumentar;
													return y;
													})
								.attr('xlink:href', function(d) {
															u = d.usr;
															p = d.palabra;
															console.log("Cambiando marcador?: "+u+p)

															if (u == 1){
																return "images/mark.svg"
															}
															else {
																return 'images/mark2.svg'
															}
														})//Cambio de imagen para marcador
								.attr('width', 50)
								.attr('height', 50)
								.attr('transform', "translate(-25 -50)")
								.attr("opacity",function(d, i, x,y) {
														p = d.periferia;
														texto = d.palabra;
														//console.log("De colores son los calzoncillos de: "+texto);
														var palUsr = pals;

	   													if (palUsr.includes(texto)){
															f = 1.0;
														}
	   													else{	
	   														f = 0;
	   													}
													return f;
													});
								g = 0;
				//var circlesfuera = circleGroup.selectAll("ciclef.small")
	             					//.data(data)
	             					//.enter()
	             					//.append("circle");
									
					//var xy = ["100", "150", "200", "250", "300"];
					//var circlef1 = circlesfuera.attr("cx", function(d){return xy[0]})
	        					//.attr("cy",function(d){return xy[0]})
	   							//.attr("r","1")
	   							//.attr("fill", "#8D8788")
	   							//.attr("opacity", "0.5")
								//.attr("stroke","black")
	   							//.attr("id", function(d) {return d.palabra;})
								//.attr("stroke-width",5)
	}
	
	//funcion responsiva para D3
	function responsivefy(svg) {
      // get container + svg aspect ratio
      var container = d3.select(svg.node().parentNode),
          width = parseInt(svg.style("width")),
          height = parseInt(svg.style("height")),
          aspect = width / height;
      // add viewBox and preserveAspectRatio properties,
      // and call resize so that svg resizes on inital page load
      svg.attr("viewBox", "0 0 " + width + " " + height)
          .attr("preserveAspectRatio", "xMinYMid")
          .call(resize);
      // to register multiple listeners for same event type,
      // you need to add namespace, i.e., 'click.foo'
      // necessary if you call invoke this function for multiple svgs
      // api docs: https://github.com/mbostock/d3/wiki/Selections#on
      d3.select(window).on("resize." + container.attr("id"), resize);
      // get width of container and resize svg to fit it
      function resize() {
          var targetWidth = parseInt(container.style("width"));
          svg.attr("width", targetWidth);
          svg.attr("height", Math.round(targetWidth / aspect));
      }

    }												
														
</script>
<script type="text/javascript">
	var json_a =  <?php echo $json_alfabetico; ?>;
	var json = <?php echo $json_val; ?>;
	var perif = <?php echo $periferias_a_graficar; ?>;
	var acosoPals = <?php echo json_encode($acosoPals); ?>;
	
	RSgrafik("grafik", json_a, json, 1300, 1300, perif, 0, acosoPals, "ligth");
	
	var json_ah =  <?php echo $json_alfabeticoH; ?>;
	var jsonh = <?php echo $json_valH; ?>;
	var perif = <?php echo $periferias_a_graficar; ?>;
	var hostpalsPals = <?php echo json_encode($hostpals); ?>;
	
	RSgrafik("grafik2", json_ah, jsonh, 1300, 1300, perif, 0, hostpalsPals);
	
	  $(document).ready(function () {
		$('img.thumbnail').imgZoom();
	  });
</script>
	
	
</script>
 