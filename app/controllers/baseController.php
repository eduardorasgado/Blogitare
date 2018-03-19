<?php 

namespace App\Controllers;
//Twig puede evitar un XSS atack desde métodos post
//Incorporación del motor de templates twig instalado con Composer
//composer require twig/twig:~2.0
use Twig_Loader_Filesystem;
use Twig_Environment;
use Twig_SimpleFilter;

class BaseController {

	protected $templateEngine;

	public function __construct(){
		//recibe donde están las vistas
		$loader = new Twig_Loader_Filesystem('../views');
		$this->templateEngine = new Twig_Environment($loader, [
				'debug' => true,
				'cache' => false
		]);

		//Este es un helper que va a permitirnos el manejo de URLs en links
		$this->templateEngine->addFilter( new Twig_SimpleFilter('url', function($path){
			return BASE_URL.$path;
		}));
	}

	public function render($fileName, $data = []){
			return $this->templateEngine->render($fileName,$data);
	}
}