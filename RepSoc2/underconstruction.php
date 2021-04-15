<?php
	session_start();
	if($_SESSION['alias'] == NULL){
		header("Location:index.html");
	}
?>
<html lang="es">
	<head>
	  <title>Sitio en construccion</title>
	  <meta charset="utf-8">
	  <meta name="viewport" content="width=device-width, initial-scale=1">
	  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
	  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
	  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
	  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
	  <link rel="stylesheet" type="text/css" href="css/ase.css">
	</head>
	<body>

		

	<div class="container">
	  <div>
		  <h1 class="display-4">Seccion en contruccion <?php echo $_SESSION['alias'] ?>  ten panciencia!</h1>
		  <hr class="my-4">
		  <p></p>
		  <p class="lead"><img src="img/cod<?php echo rand(1, 4);?>.png" alt="tired"></p>
		</div>
	</div>

	</body>
</html> 