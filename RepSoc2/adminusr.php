<?php
	session_start();
	if($_SESSION['alias'] == NULL){
		header("Location:index.html");
	}
	include 'acceso.php';
	$consultaadmin = "SELECT usr FROM capturadores WHERE alias = '".$_SESSION['alias']."'"; 
						//echo $consultaadmin;
						$adminresultado = mysqli_query( $conexion, $consultaadmin ) or die ( "Algo ha ido mal en la consulta a la base de datos45");
						$a = mysqli_fetch_assoc($adminresultado);
						$a = $a['usr'];
	if ($a == "i"){
		header("Location:underconstruction.php");
	}
	
	function hacer_tablausr($arreglo){
		$tabla = NULL;

		foreach( $arreglo as $key => $tupla ){
			//echo '<ul>';
			$no = NULL;
    		$alias = NULL;
    		$pass =  NULL;
    		$tipo = NULL;
    		$accion = NULL;
			
			foreach( $tupla as $attribute => $value ){
				//echo '<li>' . $attribute . ': ' . $value . '</li>';
				if($attribute == "id"){
            		$no = $value; 
            	}
            	if($attribute == "alias"){
            		$alias = $value; 
            	}
            	if($attribute == "pass"){
            		$pass = $value;
            	}
            	if($attribute == "usr"){
            		$tipo = $value; 
            	}
			}
			//echo '</ul>';
			$tabla = $tabla.'<tr>
								<th scope="row">'.$no.'</th>
								<td>'.$alias.'</td>
								<td>'.$pass.'</td>
								<td>'.$tipo.'</td>
								<td>
									<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modificarModal'.$no.'">
									<img src="img/lapiz.png" width="20">
									</button>
								</td>
								<td>
									<button type="button" class="btn btn-danger" data-toggle="modal" data-target="#eliminarModal'.$no.'">
									<img src="img/basura.png" width="20">
									</button>
								</td>
							</tr>
							
							<!-- Modal eliminar -->
							<div class="modal fade" id="eliminarModal'.$no.'" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
							  <div class="modal-dialog modal-dialog-centered" role="document">
								<div class="modal-content">
								  <div class="modal-header">
									<h4 class="modal-title" id="exampleModalLabel">Advertencia esta accion no se puede deshacer</h4>
									<button type="button" class="close" data-dismiss="modal" aria-label="Close">
									  <span aria-hidden="true">&times;</span>
									</button>
								  </div>
								  <div class="modal-body" style="color:#000";>
									¿Desea eliminar a '.$alias.' con no. de usuario '.$no.'?.<br>Sin embargo la informacion capturada por el usuario aun estara disponible, lo que podria causar inconsistencias en la base de datos
								  </div>
								  <div class="modal-footer">
									<button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
									<a href="deleteusr.php?id='.$no.'" class="btn btn-danger active" role="button" aria-pressed="true">Aceptar</a>
								  </div>
								</div>
							  </div>
							</div>
							
							<!-- Modal Modificar -->
							<div class="modal fade" id="modificarModal'.$no.'" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
							  <div class="modal-dialog modal-dialog-centered" role="document">
								<div class="modal-content">
								  <div class="modal-header">
									<h1 class="modal-title" id="exampleModalLabel" style="color:#000";>Modificar</h1>
									<button type="button" class="close" data-dismiss="modal" aria-label="Close">
									  <span aria-hidden="true">&times;</span>
									</button>
								  </div>
								  <div class="modal-body" style="color:#000";>
									<form action="modifusr.php" method="POST">
									  <div class="form-group">
										<label for="exampleInputEmail1">Nombre de usuario</label>
										<input type="text" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Nombre" name="usr" value="'.$alias.'">
								
									  </div>
									  <div class="form-group">
										<label for="exampleInputPassword1">Password</label>
										<input type="text" class="form-control" id="exampleInputPassword1" placeholder="Password" name="pass" value="'.$pass.'">
									  </div>
									   <div class="form-group">
										<label for="exampleFormControlSelect1">Tipo de usuario</label>
										<select class="form-control" id="exampleFormControlSelect1" name="tipo">
											<option  value="a">Administrador</option>
											<option  value="i" selected="selected">Investigador</option>
										</select>
										<input type="text" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="id" name="id" value="'.$no.'" style="visibility: hidden">
								  </div>
								  <div class="modal-footer">
									<button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
									<button type="submit" class="btn btn-primary">Aceptar</button>
									</form>
								  </div>
								</div>
							  </div>
							</div>'
							;
		}

		return $tabla;
	}
	$relacionusr = [];
	$consultausr= "SELECT * FROM capturadores";
	//echo $consultausr."<br>";
	$resultadousr = mysqli_query( $conexion, $consultausr ) or die ( "Algo ha ido mal en la consulta a la base de datos 1");
	while ($row = mysqli_fetch_array( $resultadousr )){
			$no	= $row['id_capturador'];
			$alias = $row['alias'];
			$pass = $row['pass'];
			$tipo = $row['usr'];
			//echo $pass;
			$tupla = ["id" => $no, "alias" => $alias, "pass" => $pass, "usr" => $tipo];
			array_push ( $relacionusr , $tupla );
	}
		
	
?>
<html lang="es">
	<head>
		<title>Administraciòn de usuario</title>
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
		</style>
		<link rel="stylesheet" type="text/css" href="css/ase.css">
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
		<div class="container">
			<div>
			<h1 class="display-4"><?php echo $_SESSION['alias'] ?>, en esta sección puedes administrar los usuarios de la plataforma</h1>
			<br>
				<div class="container">
				  <div class="row">
					<div class="col-sm">
						<button type="button" class="btn btn-outline-primary btn-lg" data-toggle="modal" data-target="#nuevoModal">Registrar nuevo usuario</button>
					</div>

					<div class="col-sm">
					
					</div>
				  </div>
				</div>
				<hr class="my-4">
				
					<table class="table table-striped" id="myTable">
					  <thead>
						<tr>
						  <th scope="col">No. de Usuario</th>
						  <th scope="col">Alias</th>
						  <th scope="col">Password</th>
						  <th scope="col">Tipo de usuario</th>
						  <th scope="col">Acciones</th>
						  <th scope="col"></th>
						</tr>
					  </thead>
					  <tbody>
						<?php
							$tabla = hacer_tablausr($relacionusr);
							echo $tabla;
						?>
					  </tbody>
					</table>
				<br>
				<a href="bienvenida.php" class="btn btn-primary btn-lg active" role="button" aria-pressed="true">Salir</a>
			</div>
		</div>
	</body>

	<!-- Modal -->
	<div class="modal fade" id="nuevoModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	  <div class="modal-dialog modal-dialog-centered" role="document">
		<div class="modal-content">
		  <div class="modal-header">
			<h1 class="modal-title" id="exampleModalLabel" style="color:#000">Registro de nuevo usuario</h1>
			<button type="button" class="close" data-dismiss="modal" aria-label="Close">
			  <span aria-hidden="true">&times;</span>
			</button>
		  </div>
		  <div class="modal-body" style="color:#000">
			<form action="registrousr.php" method="POST">
			  <div class="form-group">
				<label for="usr">Nombre de usuario</label>
				<input type="text" class="form-control" id="usr" name="usr" aria-describedby="emailHelp" placeholder="Nombre">
			  </div>
			  <div class="form-group">
				<label for="Password1">Password</label>
				<input type="text" class="form-control" id="Password1" name="Password1" placeholder="Password">
			  </div>
			   <div class="form-group">
				<label for="Selectusr">Tipo de usuario</label>
				<select class="form-control" id="Selectusr" name="tipo">
					<option  value="a">Administrador</option>
					<option  value="i" selected="selected">Investigador</option>
				</select>
			
		  </div>
		  <div class="modal-footer">
			<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
			<button type="submit" class="btn btn-primary">Aceptar</button>
			</form>
		  </div>
		</div>
	  </div>
	</div>
	
	
</html> 