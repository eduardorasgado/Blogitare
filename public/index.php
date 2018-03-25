<?php 
	//Se usa Composer(packagist.org),TWIG,PHP7,phroute,psr-4,illuminate
	//siriusphp, monolog

	//IMPLEMENTACIÓN DE FRONT CONTROLLER

	ini_set('display-errors', 1);
	ini_set('display-startup-errors', 1);
	//regresar cualquier error que se encuentre en cualquier parte de la app(en desarrollo)
	error_reporting(E_ALL);

	//cargando desde composer, las librerías
	require_once '../vendor/autoload.php';

	//Inicio de sesion, al tener el front controller ya no es necesario
	//iniciar la sesion en otras partes de la aplicacion
	session_start();

	//Constante para URL dinámica

	$baseURL = '';
	//reemplazar index.php en la cadena del dir del server, y reescibir esta cadena
	$baseDir = str_replace(basename($_SERVER['SCRIPT_NAME']), '', $_SERVER['SCRIPT_NAME'] );

	$baseURL = 'http://'.$_SERVER['HTTP_HOST'].$baseDir;

	//Definiendo constante global
	define("BASE_URL", $baseURL);


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

	//uso de la variable global GET
	$route = $_GET['route'] ?? '/';

	//comienzo de uso de librería PHRoute
	use Phroute\Phroute\RouteCollector;

	//inicializamos una instancia para guardar rutas
	$router = new RouteCollector();

	//filtro(middleware)
	$router->filter('auth',function(){

		if (!isset($_SESSION['userId'])){
			header('Location:'.BASE_URL.'auth/login');
			return false;
		}
	});

	//definimos las rutas, usando controladores
	$router->controller('/auth', App\Controllers\authController::class);

	//Agrupación de routers por filtro pre carga
	//Si hay usuario logueado, acceso permitido
	$router->group(['before' => 'auth'],function($router){
		$router->controller('/admin', App\Controllers\Admin\indexController::class);

		//solo necesitamos una ruta para el mismo archivo cuando se agrupan metodos en 
		//postController.php
		$router->controller('/admin/posts', App\Controllers\Admin\postController::class);

		$router->controller('/admin/posts', App\Controllers\Admin\editController::class);

		$router->controller('/admin/users', App\Controllers\Admin\userController::class);
	});

	$router->controller('/', App\Controllers\indexController::class);

	$router->controller('/detail', App\Controllers\detailController::class);

	//dispatcher, preparando para mostrar las vistas
	$dispatcher = new Phroute\Phroute\Dispatcher($router->getData());
	$response = $dispatcher->dispatch($_SERVER['REQUEST_METHOD'], $route);

	//solo un echo para mostrar nuestras views renderizadas
	echo $response;
