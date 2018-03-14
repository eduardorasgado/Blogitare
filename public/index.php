<?php 
	//IMPLEMENTACIÓN DE FRONT CONTROLLER

	ini_set('display-errors', 1);
	ini_set('display-startup-errors', 1);
	//regresar cualquier error que se encuentre en cualquier parte de la app(en desarrollo)
	error_reporting(E_ALL);

	//cargando desde composer, las librerías
	require_once '../vendor/autoload.php';
	include_once '../config.php';
	
	//uso de la variable global GET
	$route = $_GET['route'] ?? '/';

	//comienzo de uso de librería PHRoute
	use Phroute\Phroute\RouteCollector;

	$router = new RouteCollector();

	$router->get('/', function() use($PDO){
		$sql = "SELECT * FROM  blog_posts ORDER BY blog_id DESC";
		$query = $PDO->prepare($sql);
		$query->execute();

		$blogPosts = $query->fetchAll(PDO::FETCH_ASSOC);

		include '../views/index.php';
	});

	$dispatcher = new Phroute\Phroute\Dispatcher($router->getData());
	$response = $dispatcher->dispatch($_SERVER['REQUEST_METHOD'], $route);

	echo $response;


	//para traer las páginas que necesitan el front controller
	//$route = $_GET['route'] ?? '/';

	//switch($route){
	//	case '/':
	//		require '../index.php';
	//		break;
	//	case '/admin':
	//		require '../admin/index.php';
	//		break;
	//	case '/admin/posts':
	//		require '../admin/posts.php';
	//		break;
	//	case '/admin/insert-post':
	//		require '../admin/insert-post.php';
	//		break;
	//}
 ?>