<?php
	session_start();
	if($_SESSION['alias'] == NULL){
		header("Location:index.html");
	}
	include 'acceso.php';
	
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
	
	<style> 
	#rcorners1 {
		border-radius: 25px;
		background: rgba(130, 130, 130, 0.5);
		margin:20px 50px
	}
	</style>
	<link rel="stylesheet" type="text/css" href="css/ase.css">
</head

<body>
	<form action="Formulario_resultado.php" method="post" name="f1" id="f1">
		<div class="form-group" id="rcorners1">
		<h1>Capturador representaciones sociales de <?php echo $_SESSION['alias'] ?></h1>
		<div class="row">
				<div class="col"> 
					<input class="form-control" type="date" name="date" placeholder="Fecha" id="date">
				</div>
				<div class="col">
					<select class="form-control" id="gender" name="gender">
					<?php
						while ($columna = mysqli_fetch_array( $resultado4 )){
							echo "<option>" . $columna['genero'] . "</option>";
						}
					?>
					</select>
				</div>
				<div class="col">
					<input class="form-control" type="number" placeholder="Edad" name="age" id="age" min="17" max="99">
				</div>
				<div class="col">
					<select class="form-control" name="prog" id="prog">
					<?php
						while ($columna = mysqli_fetch_array( $resultado3 )){
							echo "<option>" . $columna['programa'] . "</option>";
						}
					?>
					</select>
				</div>
				<div class="col">
					<select class="form-control" name="fase" id="fase">
						<option>Sin Fase</option>
						<option>Fase Investigación</option>
						<option>Fase 1</option>
						<option>Fase 2</option>
						<option>Fase 3</option>
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
					for ($j = 5; $j >= 1; $j--) {
						echo '<div class="input-group mb-3">';
						echo '<div class="input-group-prepend">';
						echo '<span class="input-group-text" id="basic-addon1">'.$j.'</span>';
						echo '</div>';
						echo '<input type="text" id="palabra'.$inputcount.'" name="palabra'.$inputcount.'" class="form-control" placeholder="" aria-label="Username" aria-describedby="basic-addon1" style="width:250px">';
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
		<button type="button" class="btn btn-outline-primary btn-lg btn-block" data-toggle="modal" data-target="#exampleModalCenter" onclick="recibir();">Revisar</button>
		<a href="bienvenida.php" class="btn btn-primary btn-lg active" role="button" aria-pressed="true">Salir</a>
		</div>
		<!-- Modal -->
		<div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
		  <div class="modal-dialog modal-dialog-centered" role="document">
			<div class="modal-content">
			  <div class="modal-header">
				<h5 class="modal-title" id="exampleModalLongTitle" style="color:black";>Se va capturar un alumno con los siguientes datos:</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				  <span aria-hidden="true">&times;</span>
				</button>
			  </div>
			  <div class="modal-body" style="color:black";>
				Fecha:
				<div class="alert alert-dark" role="alert" id="datediv">
				No se ha seleccionado fecha
				</div>
				Género:
				<div class="alert alert-dark" role="alert" id="genderdiv">
				</div>
				Edad:
				<div class="alert alert-dark" role="alert" id="agediv">
				No se ha seleccionado edad
				</div>
				Programa de estudios:
				<div class="alert alert-dark" role="alert" id="progdiv">
				</div>
				Fase:
				<div class="alert alert-dark" role="alert" id="fasediv">
				</div>

			</div>
				<div class="modal-footer" style="display:none;" id="buttons" align="right">
				<input class="btn btn-danger" role="button" type="submit" value="Mandar a base de datos" id="submit">
				</div>
			</div>
		  </div>
		</div>
	</form>
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
    document.getElementById('submit').disabled=true;
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
			document.getElementById('submit').disabled=true;
		}
		
		var valor5 = document.getElementById("fase").value;
        document.getElementById("fasediv").innerHTML=valor5;
		if (valor5 == "") {
			document.getElementById("facediv").className = "alert alert-danger";
		}
		
		if(valor1 != "" || valor14 != ""){
			var div1 = document.getElementById('buttons');
			div1.style.display = 'block';
			document.getElementById('submit').disabled=false;
		}
		
		if(valor1 == "" || valor14 == ""){
			document.getElementById('submit').disabled=true;
		}
    }        
</script> 
</html>

