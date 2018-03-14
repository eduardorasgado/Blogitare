<?php 
	$database = 'mysql';
	$dbhost = 'localhost';
	$dbname = 'cursophp';
	$dbuser = 'root';
	$dbpass = '';

	try {
		$PDO = new PDO("$database::host=$dbhost;dbname=$dbname",$dbuser,$dbpass); //basedatos,nombredeusuario,
																	//passwordpara conectarnos
								//CUIDADO con dejar root y cuentas inseguras en producción
		$PDO->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	} catch(Exception $e){
		$errorCode = $e->getMessage();
		echo "<p style='color: red'>Error: $errorCode</p>";
	}
 