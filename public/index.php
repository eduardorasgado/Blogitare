<?php 
	//IMPLEMENTACIÓN DE FRONT CONTROLLER

	ini_set('display-errors', 1);
	ini_set('display-startup-errors', 1);
	//regresar cualquier error que se encuentre en cualquier parte de la app(en desarrollo)
	error_reporting(E_ALL);

	//cargando desde composer, las librerías
	require_once '../vendor/autoload.php';
	//aqui adentro está el PDO
	include_once '../config.php';
	
	//Constante para URL dinámica

	$baseURL = '';
	//reemplazar index.php en la cadena del dir del server, y reescibir esta cadena
	$baseDir = str_replace(basename($_SERVER['SCRIPT_NAME']), '', $_SERVER['SCRIPT_NAME'] );

	$baseURL = 'http://'.$_SERVER['HTTP_HOST'].$baseDir;
	
	//var_dump($baseDir);
	//var_dump($baseURL);

	define("BASE_URL", $baseURL);
	

	//uso de la variable global GET
	$route = $_GET['route'] ?? '/';

	//comienzo de uso de librería PHRoute
	use Phroute\Phroute\RouteCollector;

	//inicializamos una instancia para guardar rutas
	$router = new RouteCollector();

	//definimos las rutas, usando controladores
	$router->controller('/admin', App\Controllers\Admin\indexController::class);

	//solo necesitamos una ruta para el mismo archivo cuando se agrupan metodos en 
	//postController.php
	$router->controller('/admin/posts', App\Controllers\Admin\postController::class);	

	$router->controller('/', App\Controllers\indexController::class);

	//dispatcher, preparando para mostrar las vistas
	$dispatcher = new Phroute\Phroute\Dispatcher($router->getData());
	$response = $dispatcher->dispatch($_SERVER['REQUEST_METHOD'], $route);

	//solo un echo para mostrar nuestras views renderizadas
	echo $response;
