<!DOCTYPE html>

<?php
	
	include 'acceso.php';
	
	$consulta = "SELECT * FROM palabras";
	$resultado = mysqli_query( $conexion, $consulta ) or die ( "Algo ha ido mal en la consulta a la base de datos 1");
	
	$consulta3 = "SELECT * FROM programas" ;
	$resultado3 = mysqli_query( $conexion, $consulta3 ) or die ( "Algo ha ido mal en la consulta a la base de datos 2");
	
	$consulta4 = "SELECT * FROM generos" ;
	$resultado4 = mysqli_query( $conexion, $consulta4 ) or die ( "Algo ha ido mal en la consulta a la base de datos 3");

?>

<html lang="es">
    <head>
        <title>acosoSexualEs</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
		<!--bootstrap-->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
        <!--<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>-->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>

		<!--Fuentes-->
        <link rel="stylesheet" type="text/css" href="styleFont.css" />
        <link href="https://fonts.googleapis.com/css?family=Oswald|Roboto" rel="stylesheet"> 
		
		<!-- Rotate-->
		<script src="js/jQueryRotate.js"></script>
		
		<!--cicle css-->
		<link href="css/progress-circle.css" rel="stylesheet">


        <!-- Dependencias maggicsuggest -->
        <link href="Maggic/magicsuggest-min.css" rel="stylesheet">
        <script src="Maggic/magicsuggest-min.js"></script>

        <!-- Dependencias scroller - Dispara los eventos de animate al hacer scroll-->
        <script src="js/scrolla.jquery.min.js"></script>

        <!-- Animate css https://daneden.github.io/animate.css/ -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.5.2/animate.min.css">


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
		<script type="text/javascript">
		$(document).ready(function() {
			$("form").keypress(function(e) {
				if (e.which == 13) {
					return false;
				}
			});
		});
		
		$('.modal-content').resizable({
			//alsoResize: ".modal-dialog",
			minHeight: 300,
			minWidth: 300
		});
		$('.modal-dialog').draggable();

		$('#exampleModal').on('show.bs.modal', function () {
			$(this).find('.modal-body').css({
				'max-height':'100%'
			});
		});
		</script>
        <style type="text/css">
				body {
					margin: 0;
					background-color: #000;
					font-family: 'Myriad Pro Light', 'Oswald', sans-serif;
					//background-image: url("images/textura2.png");
					padding-top: 50px;
					font-size: 14px;
					text-align: left;
					color: #fff;
				}
				button{
					text-decoration: none;
					padding: 5px;
					font-weight: 16px;
					font-size: 16px;
					color: #000;
					background-color: #D1D2D3;
					border-radius: 6px;
					border: 2px solid #8D8788;
				}
				button:hover{
					color: #000;
					background-color: #8D8788;
				}
				.btnrojo{
					background-color: #A81127;
					border: 2px solid #A81127;
					color: #fff;
				}
				.btnrojo:hover{
					color: #fff;
					background-color: #691943;
					border: 2px solid #691943;
				}
				.navbar {
					//background-color: rgba(141,135,136,0.0);
					background-color: #000;
				}
				.navbar .navbar-brand {
					color: #a81127;
				}

				.nav-link{
					display:block;
					padding:.5rem 1rem;
					color:#fff;
					font-family: 'Oswald', 'Roboto', sans-serif;
					
				}
				.nav-link.active {
					//color: #fff !important;
					//background-color: #A81127 !important;
					background-color: rgba(141,135,136,0.0) !important;
					color: #A81127 !important;
				}
				.nav-link:focus
				{
					color:#6c757d
				}
				.nav-link:hover{
					text-decoration:none;
					color:#A81127
				}
				.nav-link.disabled{
					color:#6c757d
				}
				.contentone {
					color:#fff;
					margin: 50pt 50pt;
					//text-align: justify;
					min-height: 300px;
					padding-top: 60px;
					margin-left: auto;
					margin-right: auto;
					width: 70%;
				}

				.contenttwo {
					padding-top: 50px;
					color:#fff;
					display: block;
					margin-top: 40px;
					margin-bottom: 40px;
					margin-left: auto;
					margin-right: auto;
					width: 40%;
					text-align: left;
				}
				
				.divrojo {
					background-color: #da0000;
					text-align: left;
					padding-top: 20px;
					padding-bottom: 20px;
				}
				.divnegro {
					background-color: #000;
					text-align: left;
				}
				.divnegro2 {
					background-color: #000;
					margin-left: auto;
					margin-right: auto;
					width: 60%;
				}
				
				.footer {
					color:#fff;
					text-align: left;
					//padding-top: 10px;
					margin-left: auto;
					margin-right: auto;
					width: 70%;
					font-family: 'Oswald', 'Roboto', sans-serif;
					margin-bottom: 30px;
				}

				.repsoc {
					text-align: left;
					font-size: 16px;
				}
				
				h1 {
					font-family: 'Oswald', 'Roboto', sans-serif;
					text-align: left;
					font-size: 24px;
					color: #fff;
				}
				
				h2 {
					font-family: 'Oswald', 'Roboto', sans-serif;
					text-align: left;
					font-size: 40px;
				}
				
				h3 {
					font-family: 'Oswald', 'Roboto', sans-serif;
					text-align: left;
					font-size: 50px;
					color: #A81127
				}
				
				.oswald{
					font-family: Oswald Light;
				}

				.bouncy{
					animation:bouncy 10s infinite linear;
					position:relative;
				}
				@keyframes bouncy {
					0%{top:0em}
					40%{top:0em}
					43%{top:-0.9em}
					46%{top:0em}
					48%{top:-0.4em}
					50%{top:0em}
					100%{top:0em;}
				} 
				.nav-link{
					text-align: center;
					font-size: 14px;
				}

				 .black-background {background-color: Transparent;}
				 .white {color:#ffffff;}
				 
				
				.modal-body{
					  overflow-y: auto;
				}
				 
				@media only screen and ( max-width: 1100px ) {
				  .navbar{
					//display: none;
				  }
 
				}
				@media only screen and ( max-width: 1100px ) {
				  .nav-link{
					//display: none;
					font-size: 12px;
				  }
 
				}
				@media only screen and ( max-width: 900px ) {
				  .nav-link{
					//display: none;
					font-size: 7px;
				  }
 
				}
				
				@media only screen and ( max-width: 900px ) {
				  .navbar-brand{
					//display: none;
					max-width: 30px;
				  }
 
				}
				@media only screen and ( max-width: 800px ) {
				  body{
					font-size: 14px;
				  }
 
				}
				@media only screen and ( max-width: 600px ) {
				  body{
					font-size: 10px;
				  }
 
				}
				
				@media only screen and ( max-width: 1100px ) {
				  .parallaxer {
						height:   200px;
						width:    100%;
					}
 
				}

        </style>
    </head>

    <body id="page-top" data-spy="scroll" data-target="#navbar-example2" >
	<nav id="navbar-example2" class="navbar fixed-top">
		<a class="navbar-brand" href="#page-top"><img src="images/acoso.png" style="display: block; position: relative; max-width: 60px; min-width: 20px; width: 100%; height: auto;"></a>
			<ul class="nav nav-pills" id="myNavbar">
				<li class="nav-item">
					<a class="nav-link" href="#que">¿Qué es el acoso sexual?</a>
				</li>
				<li class="nav-item">
					<a class="nav-link" href="#has">HAS en la UAM-C</a>
				</li>
				<li class="nav-item">
					<a class="nav-link" href="#rs">Representaciones sociales</a>
				</li>
				<li class="nav-item">
					<a class="nav-link" href="#achas">Acciones contra el HAS en la UAM-C</a>
				</li>
				<li class="nav-item">
					<a class="nav-link" href="#cd">Cómo denunciar</a>
				</li>
				<li class="nav-item">
					<a class="nav-link" href="#ase">#AcosoSexualEs</a>
				</li>
			</ul>
	</nav>
        <!-- Navigation -->
		<p id="que"></p>
            <div class="contentone">
				<div class="container">
				  <div class="row">
					<div class="col-sm">
						<img src="images/mano.png" style="display: block; position: relative; margin-left: auto; margin-right: auto; max-width: 1500px; min-width: 200px; width: 100%; height: auto;" >
					</div>
					<div class="col-sm">
						<img src="images/acoso.png" class="animate" data-animate="zoomInUp" style="display: block; position: relative; margin-left: auto; margin-right: auto; max-width: 300px; min-width: 200px; width: 120%; height: auto; margin-bottom: 60px;">
						<h1>
						¿Qué es el acoso sexual?</h1><br>
						<div>
						Son aquellas conductas consistentes en mensajes verbales
						o escritos, pellizcos, manoseos, exhibicionismo o actos
						de carácter sexual indeseados por quienes los reciben,
						ejercidos por compañeros o desconocidos.<br><br>

						El hostigamiento sexual es acoso sexual ejercido por profesores, trabajadores o personal administrativo cuya relación implica una subordinación jerárquica de la víctima, ocurre en ámbitos académicos y laborales.<br><br>

						Algunos especialistas nombran al hostigamiento y acoso sexual
						por su acrónimo: HAS.<br>
						</div>
					</div>
				  </div>
				</div>	
            </div>
			<p id="has"></p>
            <div class="contenttwo">
                <h1>
                    HAS en la UAM-C
                </h1><br>
                <div>
                    Ante la falta de denuncias por HAS en la UAM-C, se recurrió a un sondeo exploratorio aplicado a la comunidad para conocer de manera preliminar la incidencia del delito
                </div><br>
				<div class="container">
				  <div class="row">
					<div class="col-md-auto">
						<img src="images/f.png" style="max-width: 50px; min-width: 10px; width: 100%; height: auto;" ><br>
						<h2>61%</h2><p class="oswald">participantes</p>
					</div>
					<div class="col">
					  <div class="container">
						  <div class="row">
							<div class="col-md-auto">
							  <img src="images/1m.png" style="max-width: 110px; min-width: 10px; width: 100%; height: auto;" >
							</div>
							<div class="col" style="text-align: center;">
							  <h3>30%</h3>
							  Se ha sentido acosada sexualmente por alguna persona en la UAM-C
							</div>
						  </div>
						  <div class="row">
						  <p style ="padding-top: 10px;">Entre los presuntos agresores reconocen a:</p>
						  </div>
						  <div class="row">	
							<div class="col">
								<img src="images/2m.png" style="max-width: 80px; min-width: 10px; width: 100%; height: auto;"><br>
								Un alumno<br>
								<h3 style="font-size: 16px;">37%</h3>
							</div>
							<div class="col">
								<img src="images/3m.png" style="max-width: 80px; min-width: 10px; width: 100%; height: auto;" ><br>
								Un profesor
								<h3 style="font-size: 16px;">25%</h3>
							</div>
							<div class="col">
								<img src="images/4m.png" style="max-width: 80px; min-width: 10px; width: 100%; height: auto;" ><br>
								Más de un agresor
								<h3 style="font-size: 16px;">19%</h3>
							</div>
						  </div>
						</div>
					</div>
				  </div>
				</div>
				<p style ="padding-top: 50px;"></p>
				<!--Contendor hombres-->
				<div class="container">
				  <div class="row">
					<div class="col-md-auto">
						<img src="images/m.png" style="max-width: 50px; min-width: 10px; width: 100%; height: auto;" ><br>
						<h2>39%</h2><p class="oswald">participantes</p>
					</div>
					<div class="col">
					  <div class="container">
						  <div class="row">
							<div class="col-md-auto">
							  <img src="images/6h.png" style="max-width: 110px; min-width: 10px; width: 100%; height: auto;" >
							</div>
							<div class="col" style="text-align: center;">
							  <h3>12%</h3>
							  Se ha sentido acosado sexualmente por alguna persona en la UAM-C
							</div>
						  </div>
						  <div class="row">
						  <p style ="padding-top: 10px;">Entre los presuntos agresores reconocen a:</p>
						  </div>
						  <div class="row">	
							<div class="col">
								<img src="images/7h.png" style="max-width: 80px; min-width: 10px; width: 100%; height: auto;"><br>
								Un alumno<br>
								<h3 style="font-size: 16px;">100%</h3>
							</div>
							<div class="col">
							</div>
							<div class="col">
							</div>
						  </div>
						</div>
					</div>
				  </div>
				</div>
				<p style ="padding-top: 50px;"></p>
				<div class="container">
				  <div class="row">
					<div class="col-md-auto"><br>
						<h2 style="font-size: 65px;">100%</h2><div class="oswald" style="font-size: 35px;">no denunció</div>
					</div>
					<div class="col" >
					Entre los motivos que llevaron a las víctimas a no denunciar, se encuentran:
					<ul>
					  <li>los sentimientos de incomodidad, inseguridad y vulnerabilidad que imperan al ser agredido</li>
					  <li>no tener la certeza de ser víctima de HAS</li>
					  <li>no saber con quién acudir</li>
					</ul> 
					</div>
				  </div>
				</div>
            </div>
			<p id="rs" style ="padding-top: 50px;"></p>
            <div class="divrojo" id="rs">
				<div>
					<div class="container">
					  <div class="row">
						<div class="col">
							<img src="images/brain.png" style="max-width: 500px; min-width: 100px; width: 100%; height: auto;" >
						</div>
						<div class="col">
						<h1>Representaciones sociales</h1><br>
							Para descubrir la semejanza que existe entre tu postura acerca del HAS
							con respecto a la de tus compañeros, recurrimos a las representaciones
							sociales, las cuales consisten en el pensamiento colectivo, producto del
							conocimiento que adquirimos a partir de la observación del entorno
							y de la información de nuestros núcleos más cercanos como la familia
							y los amigos, además de nuestros propios consumos culturales.<br><br>
							Realiza el ejercicio y conoce que tan parecido piensas a la comunidad. <br><br>
							<button type="button" data-toggle="modal" data-target="#explic">Comenzar el ejercicio</button>
						</div>
					  </div>
					</div>
				</div> 
            </div>
			<p id="achas" style ="padding-top: 50px;"></p>
            <div class="divnegro">
				<div>
					<div class="container">
					  <div class="row">
						<div class="col">
							<h1>Acciones contra el HAS en la UAM-C</h1><br>
							Recientemente la UAM-C aprobó la Unidad Especializada en Igualdad y Equidad de Género, conformada por dos módulos: el Módulo de Transversalización de la Perspectiva de Género y el Módulo de Atención y Prevención de la Violencia de Género. Este último, encargado de recibir quejas, brindar acompañamiento, proporcionar asistencia jurídica y psicológica, y monitoreo de casos.<br><br>
							<button onclick="window.location.href='http://www.cua.uam.mx/igualdad-de-genero'">Conoce el acuerdo</button>
						</div>
						<div class="col">
							<img src="images/chicas.png" style="max-width: 500px; min-width: 100px; width: 100%; height: auto;" >
						</div>
					  </div>
					</div>
				</div>   
            </div>
			<p id="cd" style ="padding-top: 50px;"></p>
            <div class="divrojo">
				<div>
					<div class="container">
					  <div class="row">
						<div class="col">
							<img src="images/meet.png" style="max-width: 500px; min-width: 100px; width: 100%; height: auto;" >
						</div>
						<div class="col">
						<h1>Cómo denunciar el HAS en la UAM-C</h1><br>
							El protocolo inmediato de atención a la violencia de género determina el proceso a seguir ante posibles quejas de violencia de género como lo es el HAS. En él se indica la ruta del procedimiento ante quejas.<br><br>
							<button onclick="window.location.href='media/DI16_DenunciaHASenUAM.pdf'">¿Como Denunciar?</button>
							<button onclick="window.location.href='http://cua.uam.mx/pdfs/igualdad-genero/acuerdo-01-18-unidad-especializada-de-genero-anexo-ii.pdf'">Conoce el protocolo</button>
						</div>
					  </div>
					</div>
				</div>   
            </div>
			<p id="ase" style ="padding-top: 50px;"></p>
			<div class="divnegro2">
                <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
				  <ol class="carousel-indicators">
					<li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
					<li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
					<li data-target="#carouselExampleIndicators" data-slide-to="2"></li>
				  </ol>
				  <div class="carousel-inner">
					<div class="carousel-item active">
					  <img class="d-block w-100" src="images/earth.jpg" alt="First slide">
					  <div class="carousel-caption d-none d-md-block">
						<h1 style="text-align: center;">Proyecto #acosoSexualEs</h1><br>
							<p style="text-align: justify;">Surge ante la preocupación del creciente problema de violencia de género que azota a nuestro
	país. Las universidades, instituciones ligadas al desarrollo de la sociedad, no están exentas de sufrir dicho problema por lo que actualmente, centros de estudios públicos y privados, se encuentran implementando acciones al respecto. <br><br>La UAM-C también se ha sumado a la atención del problema, por lo que, bajo la convicción de que tanto autoridades como alumnado debemos sumar esfuerzos para hacer frente a la violencia de género, proponemos desde la perspectiva interdisciplinaria de MADIC, una estrategia integral de comunicación.</p>
	<button>Ir a la ICR</button>
					  </div>
					</div>
					<div class="carousel-item">
					  <img class="d-block w-100" src="images/earth.jpg" alt="Second slide">
					  <div class="carousel-caption d-none d-md-block">
						<h1 style="text-align: center;">Proyecto #acosoSexualEs</h1><br>
						<p style="text-align: justify;">El plan que integra esta estrategia está desarrollado con base a los resultados obtenidos
de una serie de actividades realizadas como parte de la metodología Investigación Acción
Participativa, el análisis de la información obtenida en un ejercicio de representaciones sociales
y de 22 historias de hostigamiento y acoso sexual recabadas a través de la red social Facebook.<br><br>
De este modo, se desarrollaron las acciones, mensajes y canales que se utilizan como mejor elemento de información y sensibilización sobre el HAS en la universidad, con el fin de incidir en la reflexión de los estudiantes, reconfigurar sus representaciones sociales e integrar una actitud crítica en pro de la igualdad de género, así como en un espacio libre de violencia.</p>
<button>Ir a la ICR</button>
					  </div>
					</div>
					<div class="carousel-item">
					  <img class="d-block w-100" src="images/earth.jpg" alt="Third slide"><div class="carousel-caption d-none d-md-block">
						<h1 style="text-align: center;">Proyecto #acosoSexualEs</h1><br>
						<p style="text-align: justify;">La estrategia de comunicación consta de tres fases prospectivas:<br><br>
Fase 1: Acercamiento a los conceptos básicos sobre acoso y hostigamiento sexual.<br>
Fase 2: Cultura y equidad en el espacio universitario<br>
Fase 3: Hostigamiento y acoso sexual en espacios digitales. <br></p>
<button>Ir a la ICR</button>
					  </div>
					</div>
				  </div>
				  <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
					<span class="carousel-control-prev-icon" aria-hidden="true"></span>
					<span class="sr-only">Previous</span>
				  </a>
				  <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
					<span class="carousel-control-next-icon" aria-hidden="true"></span>
					<span class="sr-only">Next</span>
				  </a>
				</div>
            </div>
			<p style ="padding-top: 50px;"></p>
			<div class="footer">
				<div class="container">
                <h1>Proyecto terminal de MADIC: Acoso y hostigamiento sexual en la UAM Cuajimalpa</h1>
				<hr style="background-color: #fff;">
				  <div class="row">
					<div class="col-md-auto">
					  Alumnos:
					</div>
					<div class="col-md-auto">
						Dulce Carolina Córdova Cruz<br>
						Vanessa Nuñez Alarcón<br>
						Karina Rubid Pichardo Martínez<br>
						Gerardo Real Flores<br><br>
					</div>
				  </div>
				  <div class="row">
					<div class="col-md-auto">
					  Asesoras:
					</div>
					<div class="col-md-auto">
						Dra. Rocío Abascal Mena<br>
						Dra. Caridad García Hernández<br>
						Dra. Angélica Martínez de la Peña
					</div>
				  </div>
				</div>
				<img src="images/footer.png" align="right" style="max-width: 500px; min-width: 100px; width: 100%; height: auto;" >
            </div>
			
			
			
			
			
			
			

	
        <!-- Bottones que activan los modales, estan ocultos se autoactivan despues del primero -->
				
        <button type="button" data-toggle="modal" data-target="#exampleModal1" id="launch" data-backdrop="static" data-keyboard="false" onclick="paseTar<br><br>jeta()" style="display: block; position: relative; margin-left: auto; margin-right: auto; display:none">MOdal 1</button>

        <button type="button" data-toggle="modal" data-target="#exampleModal2" data-backdrop="static" data-keyboard="false" style="display: block; position: relative; margin-left: auto; margin-right: auto; display:none" id="nextbutton1">
						MOdal 2
					</button>

        <button type="button" data-toggle="modal" data-target="#exampleModal3" data-backdrop="static" data-keyboard="false" style="display: block; position: relative; margin-left: auto; margin-right: auto; display:none" id="waitbutton">
						MOdal 3
					</button>
        </div>
		<!--Modal 0-->
		<div class="modal fade" id="explic" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
		  <div class="modal-dialog modal-dialog-centered" role="document">
			<div class="modal-content">
			  <div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				  <span aria-hidden="true">&times;</span>
				</button>
			  </div>
			  <div class="modal-body" style="color: #000;">
				<h1 class="modal-title" id="exampleModalLabel" style="color: #000;">Representaciones sociales.</h1><br>
				<p class="repsoc">Algunas indicaciones antes de empezar..<br><br>
				<b>Te daremos un par de palabras para que apartir de ellas, escribas en cada campo lo que más rápido venga a tu mente. </b><br><br>
				Llena todos los campos y permite que se genere tu resultado.<br><br>
				<img src="images/ejempl.png" style="max-width: 400px; min-width: 100px; width: 100%; height: auto;" ><br><br>
				¡Estarás contra reloj, así que no pienses mucho tus respuestas!.<br><br>
				Una vez iniciado el ejercicio no podrás detenerlo.<br><br></p>
			  </div>
			  <div class="modal-footer">
				<button type="button" class="btnrojo" data-dismiss="modal" data-toggle="modal" data-target="#exampleModal">Comenzar ejercicio!</button>
			  </div>
			</div>
		  </div>
		</div>
        <!-- Modal -->
        <form action="resultado.php" method="post" id="form1">
            <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" >
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
								<span aria-hidden="true">&times;</span>
							</button>
                        </div>
                        <div class="modal-body" style="overflow-y:auto; color: #000;">
                            <p class="repsoc">Para fines estadisticos, debemos conocer tu género.</p>
                            <br><br>
                            <div class="row">
                                <div class="col">
                                    <label for="exampleFormControlTextarea1">Género</label>
                                    <select class="form-control" id="gender" name="gender">
									<?php
										while ($columna = mysqli_fetch_array( $resultado4 )){
											echo "<option>" . $columna['genero'] . "</option>";
										}
									?>
									</select>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" data-dismiss="modal" id="cancel" ;>Cancelar </button>
                            <button type="button" class="btnrojo" data-toggle="modal" data-target="#exampleModal1" id="launch" data-backdrop="static" data-keyboard="false" onclick="paseTarjeta()">
								Empezar
							</button>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Modal 1 -->
            <div class="modal fade" id="exampleModal1" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" style="overflow-y:auto">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h2 class="modal-title" id="exampleModalLabel" style="color: #000;">Acoso Sexual</h2>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="display:none">
								<span aria-hidden="true">&times;</span>
							</button>
							<div id="progcircle1" class="progress-circle progress-100"><span id="spancircle1" style="display:none">0</span></div>
                        </div>

                        <div class="modal-body" style="overflow-y:auto" color: #000;>

                            <input class="form-control" type="text" placeholder="Palabra 1" id="acs1" name="a1" /><br>
                            <input class="form-control" type="text" placeholder="Palabra 2" id="acs2" name="a2" /><br>
                            <input class="form-control" type="text" placeholder="Palabra 3" id="acs3" name="a3" /><br>
                            <input class="form-control" type="text" placeholder="Palabra 4" id="acs4" name="a4" /><br>
                            <input class="form-control" type="text" placeholder="Palabra 5" id="acs5" name="a5" /><br>

                            <!--<h5>Siguiente palabra estimulo en:</h5>-->
                            <div class="progress" style="display:none">
                                <div id="bar" class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" style="width: 50%" aria-valuenow="100" aria-valuemin="0" aria-valuemax="20"></div>
                            </div>
                        </div>


                        <button type="button" class="btn btn-secondary" data-dismiss="modal" id="cancelId1" style="display:none">Cancel</button>

                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal2" id="nextbutton2" style="display:none">Next</button>

                    </div>
                </div>
            </div>

            <!-- Modal 2 -->
            <div class="modal fade" id="exampleModal2" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" style="overflow-y:auto">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h2 class="modal-title" id="exampleModalLabel" style="color: #000;">Hostigamiento Sexual</h2>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="display:none">
								<span aria-hidden="true">&times;</span>
							</button>
						  <div id="progcircle2" class="progress-circle progress-100"><span id="spancircle2" style="display:none">0</span></div>
                        </div>
                        <div class="modal-body" style="overflow-y:auto">

                            <input class="form-control" type="text" placeholder="Palabra 1" id="hts1" name="h1" /><br>
                            <input class="form-control" type="text" placeholder="Palabra 2" id="hts2" name="h2" /><br>
                            <input class="form-control" type="text" placeholder="Palabra 3" id="hts3" name="h3" /><br>
                            <input class="form-control" type="text" placeholder="Palabra 4" id="hts4" name="h4" /><br>
                            <input class="form-control" type="text" placeholder="Palabra 5" id="hts5" name="h5" /><br>

                            <!--<h5>Fin del ejercicio en:</h5>-->
                            <div class="progress" style="display:none">
                                <div id="bar2" class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" style="width: 50%" aria-valuenow="100" aria-valuemin="0" aria-valuemax="20"></div>
                            </div>
                        </div>

                            <button type="button" class="btn btn-secondary" data-dismiss="modal" id="cancelId2" style="display:none">Cancel</button>
                            <button type="submit" class="btn btn-primary" id="nextbutton3" style="display:none">Save</button>
                    </div>
                </div>
            </div>
        </form>
        <!-- Modal -->
        <div class="modal fade" id="exampleModal3" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-body" style="vertical-align: middle;">
						<h1 class="modal-title" id="generando" style="color: #000;">Generando tu resultado...</h1>
						<img src="images/flechacirc.png" id="exa3" style="display: block; position: relative; max-width: 60px; min-width: 20px; width: 100%; height: auto;">
                    </div>
                </div>
            </div>
        </div>
        <!-- Fin Modal-->
    </body>
</html>

    <script>
        //Funcion para pausar codigo javascript solo funciona con asyncfunction
        	function sleep(ms) {
        	  return new Promise(resolve => setTimeout(resolve, ms));
        	}
        	
        	function formReset() {
        		document.getElementById("form1").reset();
        	}
        	
        	//Funcion para el pase de tarjetas
        	async function paseTarjeta() {
        		var i;
        		var t = 50;
        		
        		document.getElementById("cancel").click();
        		
        		//await sleep(1000);
        		for (i = t; i >= 0; i--) {
        			document.getElementById("nextbutton1").innerHTML="Next word in "+i;
        			var time = i*100/t;
        			document.getElementById("bar").style="width:"+time+"%";
					
					document.getElementById("progcircle1").className = "progress-circle progress-"+time;
					document.getElementById("spancircle1").innerHTML = i;
					
        			if(time<50){
        				document.getElementById("bar").className="progress-bar progress-bar-striped progress-bar-animated bg-warning";
        			}
        			if(time<20){
        				document.getElementById("bar").className="progress-bar progress-bar-striped progress-bar-animated bg-danger";
        			}
        			document.getElementById("bar").innerHTML=i;
        			await sleep(1000);
        		}
        		document.getElementById("cancelId1").click();
        		document.getElementById("nextbutton1").click();
        		
        		
        		for (i = t; i >= 0; i--) {
        			document.getElementById("nextbutton2").innerHTML="Next Screen in "+i;
        			var time = i*100/t;
        			document.getElementById("bar2").style="width:"+time+"%";
					
					document.getElementById("progcircle2").className = "progress-circle progress-"+time;
					document.getElementById("spancircle2").innerHTML = i;
					
        			if(time<50){
        				document.getElementById("bar2").className="progress-bar progress-bar-striped progress-bar-animated bg-warning";
        			}
        			if(time<20){
        				document.getElementById("bar2").className="progress-bar progress-bar-striped progress-bar-animated bg-danger";
        			}
        			document.getElementById("bar2").innerHTML=i;
        			await sleep(1000);
        		}
        		document.getElementById("nextbutton3").click();
				document.getElementById("cancelId2").click();
				document.getElementById("waitbutton").click();
				
				for (i = 100; i >= 0; i--) {
					document.getElementById("generando").innerHTML="Generando tu resultado";
					await sleep(1000);
        			document.getElementById("generando").innerHTML="Generando tu resultado.";
					await sleep(1000);
					document.getElementById("generando").innerHTML="Generando tu resultado..";
					await sleep(1000);
					document.getElementById("generando").innerHTML="Generando tu resultado...";
					await sleep(1000);
				}
        		
        	}
        	
        
        	//funciones para magicsuggest
        	
        	var pal = [<?php 
        		while ($columna = mysqli_fetch_array( $resultado ))
        		echo "'".$columna['palabra']."',";?> ]
        	
        	var minch = 3;
			var maxsug = 0;
			var strict = false;
			
        	$(function() {
                var ms1 = $('#acs1').magicSuggest({ allowFreeEntries: true, maxSuggestions: maxsug, maxSelection: 1, valueField: 'name', minChars: minch, noSuggestionText: 'Ningu resultado para {{query}}', data: pal, name: 'a1', useZebraStyle: true, strictSuggest: strict, autoSelect: true, useTabKey: true
                });
              });
			
			$(function() {
                var ms2 = $('#acs2').magicSuggest({ allowFreeEntries: true, maxSuggestions: maxsug,maxSelection: 1, valueField: 'name', minChars: minch, noSuggestionText: 'Ningu resultado para {{query}}', data: pal, name: 'a1', strictSuggest: strict, autoSelect: true, useTabKey: true
                });
              });
			  
			$(function() {
                var ms3 = $('#acs3').magicSuggest({ allowFreeEntries: true, maxSuggestions: maxsug, maxSelection: 1, valueField: 'name', minChars: minch, noSuggestionText: 'Ningu resultado para {{query}}', data: pal, name: 'a1', strictSuggest: strict, autoSelect: true, useTabKey: true
                });
              });
			
			$(function() {
                var ms4 = $('#acs4').magicSuggest({ allowFreeEntries: true, maxSuggestions: maxsug, maxSelection: 1, valueField: 'name', minChars: minch, noSuggestionText: 'Ningu resultado para {{query}}', data: pal, name: 'a1', strictSuggest: strict, autoSelect: true, useTabKey: true
                });
              });
			
			$(function() {
                var ms5 = $('#acs5').magicSuggest({ allowFreeEntries: true, maxSuggestions: maxsug, maxSelection: 1, valueField: 'name', minChars: minch, noSuggestionText: 'Ningu resultado para {{query}}', data: pal, name: 'a1', strictSuggest: strict, autoSelect: true, useTabKey: true
                });
              });
			
        	$(function() {
                var ms6 = $('#hts1').magicSuggest({ allowFreeEntries: true, maxSuggestions: maxsug, maxSelection: 1, valueField: 'name', minChars: minch, noSuggestionText: 'Ningu resultado para {{query}}', data: pal, name: 'h1',strictSuggest: strict, autoSelect: true, useTabKey: true
                });
              });
			
			$(function() {
                var ms7 = $('#hts2').magicSuggest({ allowFreeEntries: true, maxSuggestions: maxsug, maxSelection: 1, valueField: 'name', minChars: minch, noSuggestionText: 'Ningu resultado para {{query}}', data: pal, name: 'h1',strictSuggest: strict, autoSelect: true, useTabKey: true
                });
              });
			$(function() {
                var ms8 = $('#hts3').magicSuggest({ allowFreeEntries: true, maxSuggestions: maxsug, maxSelection: 1, valueField: 'name', minChars: minch, noSuggestionText: 'Ningu resultado para {{query}}', data: pal, name: 'h1',strictSuggest: strict, autoSelect: true, useTabKey: true
                });
              });
			  
			$(function() {
                var ms9 = $('#hts4').magicSuggest({ allowFreeEntries: true, maxSuggestions: maxsug, maxSelection: 1, valueField: 'name', minChars: minch, noSuggestionText: 'Ningu resultado para {{query}}', data: pal, name: 'h1',strictSuggest: strict, autoSelect: true, useTabKey: true
                });
              });
			$(function() {
                var ms10 = $('#hts5').magicSuggest({ allowFreeEntries: true, maxSuggestions: maxsug, maxSelection: 1, valueField: 'name', minChars: minch, noSuggestionText: 'Ningu resultado para {{query}}', data: pal, name: 'h1',strictSuggest: strict, autoSelect: true, useTabKey: true
                });
              });
    </script>
    <script>
        $('.animate').scrolla({
        	mobile: false,
        	once: false
        });
		
		function redireccionar() {
			setTimeout("location.href='index.php#page-top'");
		}
		
    </script>
	<script>
	$(document).ready(function(){
	  // Add scrollspy to <body>
	  $('body').scrollspy({target: ".navbar", offset: 50});   

	  // Add smooth scrolling on all links inside the navbar
	  $("#myNavbar a").on('click', function(event) {
		// Make sure this.hash has a value before overriding default behavior
		if (this.hash !== "") {
		  // Prevent default anchor click behavior
		  event.preventDefault();

		  // Store hash
		  var hash = this.hash;

		  // Using jQuery's animate() method to add smooth page scroll
		  // The optional number (800) specifies the number of milliseconds it takes to scroll to the specified area
		  $('html, body').animate({
			scrollTop: $(hash).offset().top
		  }, 800, function(){
	   
			// Add hash (#) to URL when done scrolling (default click behavior)
			window.location.hash = hash;
		  });
		}  // End if
	  });
	});
	</script>
	 <script type="text/javascript">
      $(document).ready(function(){
		var angle = 0;
		setInterval(function(){
			  angle+=10;
				$("#exa3").rotate(angle);
		},50);
    });
    </script>
