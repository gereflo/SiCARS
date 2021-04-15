<?php
	session_start();
	if($_SESSION['alias'] == NULL){
		header("Location:index.html");
	}
	include 'acceso.php';
	
	$id_alumnoget= $_GET["id_alumn"];//tomar la variable que viene del get en la direccion
	
	$consulta = "SELECT id_alumno, edad, fecha, genero, programa, alias, fase FROM alumnos 
					JOIN generos ON generos_id_genero = id_genero 
					JOIN programas ON programas_id_programa = id_programa 
					JOIN capturadores ON capturadores_id_capturador = id_capturador
					WHERE id_alumno =".$id_alumnoget;
	$resultado = mysqli_query( $conexion, $consulta ) or die ( "Algo ha ido mal en la consulta a la base de datos");
	$row_cnt = $resultado->num_rows;
	
	if($row_cnt == 0){
		//header("Location:underconstruction.php");
		$consulta = "SELECT id_alumno, fecha, genero, programa, fase FROM alumnos 
					JOIN generos ON generos_id_genero = id_genero 
					JOIN programas ON programas_id_programa = id_programa 
					WHERE id_alumno =".$id_alumnoget;
		$resultado = mysqli_query( $conexion, $consulta ) or die ( "Algo ha ido mal en la consulta a la base de datos");
		$row_cnt = $resultado->num_rows;
		
		while ($columna = mysqli_fetch_array( $resultado )){
			$id_alumno = $columna['id_alumno'];
			//$edad = $columna['edad'];
			$fecha = $columna['fecha'];
			$genero = $columna['genero'];
			//$alias = $columna['alias'];
			$programa = $columna['programa'];
			$fase = $columna['fase'];
		}
	}
	else{
		
		while ($columna = mysqli_fetch_array( $resultado )){
		$id_alumno = $columna['id_alumno'];
		$edad = $columna['edad'];
		$fecha = $columna['fecha'];
		$genero = $columna['genero'];
		$alias = $columna['alias'];
		$programa = $columna['programa'];
		$fase = $columna['fase'];
		}
	}
	
	

	
	//$consulta3 = "SELECT * FROM programas" ;
	//$resultado3 = mysqli_query( $conexion, $consulta3 ) or die ( "Algo ha ido mal en la consulta a la base de datos");
	
	//$consulta4 = "SELECT * FROM generos" ;
	//$resultado4 = mysqli_query( $conexion, $consulta4 ) or die ( "Algo ha ido mal en la consulta a la base de datos");
	
	$inputcount = 1; //da un id unico a cada input
	$numencuestasxfila = 4; //Encuestas que debe de tener cada fila

	if (empty($alias)) {
		$alias = "Usuario Anónimo";
	}
	if (empty($edad)) {
		$edad = "Sin edad registrada";
	}

?>
<html lang="es">
<head>
	<title>Captura el encuestra de representaciones socuales <?php echo $_SESSION['alias'] ?></title>
	<meta http-equiv="Content-type" content="text/html; charset=utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1">
	
	<!-- Bootstrap -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">  
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
  
	<!-- Autocomplete -->
	<script src="./demo/jquery.js" type="text/javascript"></script>
	<script src="./demo/prettify.js" type="text/javascript"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
	<link rel="stylesheet" href="./css/jquery.autocomplete.css">
	<script src="./js/jquery.autocomplete.js" type="text/javascript"></script>
	<link rel="stylesheet" type="text/css" href="css/ase.css">
	
	<style> 
	#rcorners1 {
		border-radius: 25px;
		background: rgba(130, 130, 130, 0.5);
		margin:20px 50px
	}
	</style>
</head>

<body>
	<form action="Formulario_resultado.php" method="post">
		<div class="form-group" id="rcorners1">
		<h1>Alumno <?php echo $id_alumno ?> capturado por <?php echo $alias ?></h1>
			<div class="row">
				<div class="col"> 
					<input class="form-control" type="text" placeholder="<?php echo $fecha?>" readonly>
				</div>
				<div class="col">
					<input class="form-control" id="exampleFormControlSelect1" placeholder="<?php echo $genero ?>" readonly>
				</div>
				<div class="col">
					<input class="form-control" type="number" placeholder="<?php echo $edad?>" readonly>
				</div>
				<div class="col">
					<input class="form-control" id="exampleFormControlSelect2" placeholder="<?php echo $programa?>" readonly> 
				</div>
				<div class="col">
					<input class="form-control" id="text" placeholder="<?php echo $fase?>" readonly> 
				</div>
			</div>
			<br>
			<?php
				$count = 1;
					
				$consulta2 = "SELECT * FROM estimulos";
				$resultado2 = mysqli_query( $conexion, $consulta2 ) or die ( "Algo ha ido mal en la consulta a la base de datos");
						
				while ($columna = mysqli_fetch_array( $resultado2 )){
					if($count == 1){
					echo "<div class='row'>";
					}
					echo "<div class='col'>";
					echo "<label for='exampleFormControlInput1'>".$columna['pal_estimulo']."</label>";
					echo "<br>";
					for ($j = 5; $j >= 1; $j--) {
						$consulta_palabras = "SELECT id_registro, palabra FROM registros
												JOIN palabras ON palabras_id_palabra = id_palabra 
												JOIN estimulos ON estimulos_id_estimulo = id_estimulo 
													WHERE alumnos_id_alumno =".$id_alumnoget." 
													AND pal_estimulo = '".$columna['pal_estimulo']."' 
													AND valor =".$j;
						
						$resultado_palabra = mysqli_query( $conexion, $consulta_palabras) or die ( "Algo ha ido mal en la consulta a la base de datos");
						//echo $consulta_palabras;
						$r = mysqli_fetch_assoc($resultado_palabra);
						echo '<div class="input-group mb-3">';
						echo '<div class="input-group-prepend">';
						echo '<span class="input-group-text" id="basic-addon1">'.$j.'</span>';
						echo '</div>';
						echo '<input type="text" id="palabra'.$inputcount.'" name="palabra'.$inputcount.'" class="form-control" placeholder="'.$r['palabra'].'" aria-label="Username" aria-describedby="basic-addon1" readonly>';
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
			<!--<nav aria-label="Page navigation example">
				<ul class="pagination">
					<li class="page-item"><a class="page-link" href="Ver_formulario.php?id_alumn=<?php echo $id_alumno-1;?>">Anterior</a></li>
					<li class="page-item">
					<form action="Ver_formulario.php" method="get">
					</form>
					<form action="Ver_formulario.php" method="get">
						<input type="text" name="id_alumn" id="id_alumn" class="form-control">
						<input type="submit" value="Submit" class="btn btn-info btn-sm" >
					</form> 
					</li>
			<li class="page-item"><a class="page-link" href="Ver_formulario.php?id_alumn=<?php echo $id_alumno+1;?>">Siguiente</a></li>
		  </ul>
			</nav>-->
			<a href="Ver_todo.php?orderby=0" class="btn btn-primary btn-lg active" role="button" aria-pressed="true">Salir</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			<button type="button" class="btn btn-danger btn-lg" data-toggle="modal" data-target="#exampleModalCenter2" onclick="recibir();">Eliminar registro</button>
		<div class="modal fade" id="exampleModalCenter2" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
		  <div class="modal-dialog modal-dialog-centered" role="document">
			<div class="modal-content">
			  <div class="modal-header">
				<h5 class="modal-title" id="exampleModalLongTitle" style="color:black";>Se va a eliminar el registro del alumno <?php echo $id_alumno ?> :</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				  <span aria-hidden="true">&times;</span>
				</button>
			  </div>
			  <div class="modal-body" style="color:black";>
					<!--establecer aqui permisos-->
					<?php
						$consultaadmin = "SELECT usr FROM capturadores WHERE alias = '".$_SESSION['alias']."'"; 
						//echo $consultaadmin;
						$adminresultado = mysqli_query( $conexion, $consultaadmin ) or die ( "Algo ha ido mal en la consulta a la base de datos45");
						$a = mysqli_fetch_assoc($adminresultado);
						$a = $a['usr'];
					?>
					Esta accion no se puede deshacer
			</div>
				<div class="modal-footer" id="buttons1" align="right">
				<?php
					if ($a == "a"){
						echo '<a href="deletealumno.php?id_alumn='.$id_alumnoget.'" class="btn btn-danger btn-lg" role="button" aria-disabled="true">Seguro</a>';
					}
					else{
						echo '<div class="alert alert-warning" role="alert">No tiene permisos para esta acción, llame al administrador</div>';
					}
				?>
			  </div>
			</div>
		  </div>
		</form>
		
		</div>
		<!--<form action="Ver_formulario.php" method="get">
			<input type="text" size="5" name="id_alumn" id="id_alumn" class="form-control">
			<input type="submit" value="Submit" class="btn btn-info btn-sm" >
		</form>-->
	</div>
	<script>
		document.getElementById("id_alumn").value = <?php echo $id_alumno?>.
	</script>
</body>
<script>
/********************************** local start ************************************************/
var pal = [
<?php
while ($columna = mysqli_fetch_array( $resultado ))
	echo "'".$columna['palabra']."',";
?>
];

<?php
for ($j = 1; $j <= $inputcount; $j++) {
	echo "$('#palabra".$j."').autocomplete({source:[pal]});";
}
?>

/*********************************** local end *****************************************************/
</script>
<script language="javascript">     
    function recibir()
    {
        var valor1 = document.getElementById("date").value;
		//var elemento = document.getElementById("capa-variable");
		if (valor1 == "") {
			document.getElementById("datediv").className = "alert alert-danger";
		}
		else{
			document.getElementById("datediv").innerHTML=valor1;
			document.getElementById("datediv").className = "alert alert-dark";
		}
		
		var valor2 = document.getElementById("prog").value;
        document.getElementById("progdiv").innerHTML=valor2;
		if (valor2 == "") {
			document.getElementById("progdiv").className = "alert alert-danger";
		}
		
		var valor3 = document.getElementById("gender").value;
        document.getElementById("genderdiv").innerHTML=valor3;
		if (valor3 == "") {
			document.getElementById("genderdiv").className = "alert alert-danger";
		}
		
		var valor4 = document.getElementById("age").value;
		if (valor4 == "") {
			document.getElementById("agediv").className = "alert alert-danger";
		}
		else{
			document.getElementById("agediv").innerHTML=valor4;
			document.getElementById("agediv").className = "alert alert-dark"
		}
		
		if(valor1 != "" || valor14 != ""){
			var div1 = document.getElementById('buttons');
			div1.style.display = 'block';
		}
    }        
</script> 
</html>

