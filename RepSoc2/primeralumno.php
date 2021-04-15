<?php
	session_start();
	if($_SESSION['alias'] == NULL){
		header("Location:index.html");
	}
	// Ejemplo de conexión a base de datos MySQL con PHP.
	//
	
	// Datos de la base de datos
	$usuario = "root";
	$password = "";
	$servidor = "localhost";
	$basededatos = "repsocdb";
	
	// creación de la conexión a la base de datos con mysql_connect()
	$conexion = mysqli_connect( $servidor, $usuario, "" ) or die ("No se ha podido conectar al servidor de Base de datos");
	$conexion->set_charset("utf8"); //Muy importante, sin esta liena no se mostraran las tildes por que la coneccion se hara en otra codificacion
	
	// Selección del a base de datos a utilizar
	$db = mysqli_select_db( $conexion, $basededatos ) or die ( "Upps! Pues va a ser que no se ha podido conectar a la base de datos" );
	// establecer y realizar consulta. guardamos en variable.
	
	$consulta = "SELECT id_alumno, edad, fecha, genero, programa, alias FROM alumnos 
					JOIN generos ON generos_id_genero = id_genero 
					JOIN programas ON programas_id_programa = id_programa 
					JOIN capturadores ON capturadores_id_capturador = id_capturador";
					//WHERE id_alumno = 19";
	$resultado = mysqli_query( $conexion, $consulta ) or die ( "Algo ha ido mal en la consulta a la base de datos");
	
	$consulta2 = "SELECT * FROM estimulos" ;
	$resultado2 = mysqli_query( $conexion, $consulta2 ) or die ( "Algo ha ido mal en la consulta a la base de datos");
	
	$consulta3 = "SELECT * FROM programas" ;
	$resultado3 = mysqli_query( $conexion, $consulta3 ) or die ( "Algo ha ido mal en la consulta a la base de datos");
	
	$consulta4 = "SELECT * FROM generos" ;
	$resultado4 = mysqli_query( $conexion, $consulta4 ) or die ( "Algo ha ido mal en la consulta a la base de datos");
	
	$inputcount = 1; //da un id unico a cada input
	$numencuestasxfila = 4; //Encuestas que debe de tener cada fila
	
	while ($columna = mysqli_fetch_array( $resultado )){
		$id_alumno = $columna['id_alumno'];
		$edad = $columna['edad'];
		$fecha = $columna['fecha'];
		$genero = $columna['genero'];
		$alias = $columna['alias'];
		$programa = $columna['programa'];
		break;
		}
?>