<?php
//esto fue facilmente aplicado gracias a psr-4 en composer.json luego de instalar de nuevo 
//composer install, para actualizar autoload
namespace App\Controllers;

use App\Models\BlogPost;

class IndexController extends baseController {

	public function getIndex(){

		//la clase creada en blogPost.php de illuminate
		//SELECT * FROM blog_posts  --->
		$blogPosts = BlogPost::query()->orderBy('blog_id', 'desc')->get();

		//la ruta ya no es completa puesto que ya la definimos dentro del constructor de la clase base
		return $this->render('index.twig',['blogPosts' => $blogPosts]);
	}
}