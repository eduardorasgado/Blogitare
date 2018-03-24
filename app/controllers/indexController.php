<?php
//esto fue facilmente aplicado gracias a psr-4 en composer.json luego de instalar de nuevo 
//composer install, para actualizar autoload
namespace App\Controllers;

use App\Models\blogPost;

class IndexController extends baseController {

	public function getIndex($number = 1){
		//paginacion del blog
		$count = BlogPost::count();
		$next = null;
		$prev = null;

		if($number > 1){
			$prev = $number -1;
		}
		if($number < $count){
			$next = $number +1;
		}
		$links = [
			'next' => $next,
			'prev' => $prev,
		];

		//la clase creada en blogPost.php de illuminate
		//SELECT * FROM blog_posts  --->
		#$blogPosts = BlogPost::query()->orderBy('blog_id', 'desc')->get();

		//Nueva query para paginacion
		$blogPosts = BlogPost::query()->
				orderBy('blog_id', 'desc')->
					skip(2*($number-1))->
							take(2)->get();

		//la ruta ya no es completa puesto que ya la definimos dentro del constructor de la clase base
		return $this->render('index.twig',[
			'blogPosts' => $blogPosts,
			'links' => $links
		]);
	}
}