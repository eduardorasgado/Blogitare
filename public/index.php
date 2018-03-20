<?php 
	//Se usa Composer(packagist.org),TWIG,PHP7,phroute,psr-4,illuminate
	//siriusphp

	//IMPLEMENTACIÓN DE FRONT CONTROLLER

	ini_set('display-errors', 1);
	ini_set('display-startup-errors', 1);
	//regresar cualquier error que se encuentre en cualquier parte de la app(en desarrollo)
	error_reporting(E_ALL);

	//cargando desde composer, las librerías
	require_once '../vendor/autoload.php';
	//aqui adentro está el PDO
	//include_once '../config.php';
	

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

	//Variables de entorno con Dotenv
	//instalado con: composer require vlucas/phpdotenv
	$dotenv = new \Dotenv\Dotenv(__DIR__.'/..');
	$dotenv->load();

	//Uso de ORM con illuminate, instalado via composer require illuminate/database
	use Illuminate\Database\Capsule\Manager as Capsule;

	$capsule = new Capsule;

	//Editar según servidor
	//
	$capsule->addConnection([
	    'driver'    => 'mysql',
	    'host'      => getenv('DB_HOST'),
	    'database'  => getenv('DB_NAME'),
	    'username'  => getenv('DB_USER'),
	    'password'  => getenv('DB_PASS'),
	    'charset'   => 'utf8',
	    'collation' => 'utf8_unicode_ci',
	    'prefix'    => '',
	]);
	//Para uso como demostracion
	// Make this Capsule instance available globally via static methods... (optional)
	$capsule->setAsGlobal();

	// Setup the Eloquent ORM... (optional; unless you've used setEventDispatcher())
	$capsule->bootEloquent();


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
