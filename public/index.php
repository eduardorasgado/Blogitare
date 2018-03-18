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

	//renderizado de página
	function render($fileName, $params = []){
			//con esto queremos esperar hasta abajo para imprimir con echo response
			ob_start(); //turn on output buffering, while this is active, no output
						//is send from the script, instead the output is internal bufered
			extract($params); //toma un arreglo, convierte todo a variables y las hace publicas
			include $fileName;
			return ob_get_clean(); //will silently discard the buffer contends
		}	


	//comienzo de uso de librería PHRoute
	use Phroute\Phroute\RouteCollector;

	//inicializamos una instancia para guardar rutas
	$router = new RouteCollector();


	$router->get('/admin', function (){
		return render('../views/admin/index.php');
	});


	$router->get('/admin/posts', function () use ($PDO){
		$sql = "SELECT * FROM  blog_posts ORDER BY blog_id DESC";
		$query = $PDO->prepare($sql);
		$query->execute();

		$blogPosts = $query->fetchAll(PDO::FETCH_ASSOC);

		return render('../views/admin/posts.php',['blogPosts' => $blogPosts]);
	});


	$router->get('/admin/posts/create', function (){
		return render('../views/admin/insert-post.php');
	});


	$router->post('/admin/posts/create', function () use ($PDO){
		$result = false;
		if(!empty($_POST)){
			$sql = "INSERT INTO blog_posts (title, content) VALUES (:title, :content)";
			$query = $PDO->prepare($sql);
			$result = $query->execute([
				'title' => $_POST['title'],
				'content' => $_POST['content']
			]);
			$result=true;
		}

		return render('../views/admin/insert-post.php',['result' => $result]);

	});


	$router->get('/', function() use($PDO){
		$sql = "SELECT * FROM  blog_posts ORDER BY blog_id DESC";
		$query = $PDO->prepare($sql);
		$query->execute();

		$blogPosts = $query->fetchAll(PDO::FETCH_ASSOC);
		
		//include '../views/index.php';

		return render('../views/index.php',['blogPosts' => $blogPosts]);

	});

	$dispatcher = new Phroute\Phroute\Dispatcher($router->getData());
	$response = $dispatcher->dispatch($_SERVER['REQUEST_METHOD'], $route);

	//solo un echo para mostrar nuestras views renderizadas
	echo $response;
