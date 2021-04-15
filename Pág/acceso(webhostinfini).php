<?php
	// Ejemplo de conexión a base de datos MySQL con PHP.
	//
	// Datos de la base de datos
	$usuario = "epiz_22582790";
	$password = "lGEmu0iWBKG";
	$servidor = "sql302.epizy.com";
	//$basededatos = "repsocdb";
    $basededatos = "epiz_22582790_repsoctrue";
	// creación de la conexión a la base de datos con mysql_connect()
	$conexion = mysqli_connect( $servidor, $usuario, $password ) or die ("No se ha podido conectar al servidor de Base de datos");
	$conexion->set_charset("utf8"); //Muy importante, sin esta liena no se mostraran las tildes por que la coneccion se hara en otra codificacion
	// Selección del a base de datos a utilizar
	$db = mysqli_select_db( $conexion, $basededatos ) or die ( "Upps! Pues va a ser que no se ha podido conectar a la base de datos" );
	// establecer y realizar consulta. guardamos en variable.
?>