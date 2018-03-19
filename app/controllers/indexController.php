<?php
//esto fue facilmente aplicado gracias a psr-4 en composer.json luego de instalar de nuevo 
//composer install, para actualizar autoload
namespace App\Controllers;

class IndexController extends baseController {

	public function getIndex(){

		global $PDO;	

		$sql = "SELECT * FROM  blog_posts ORDER BY blog_id DESC";
		$query = $PDO->prepare($sql);
		$query->execute();

		//Al tener aqui la clase pdo debemos especificar el namespace global \
		$blogPosts = $query->fetchAll(\PDO::FETCH_ASSOC);

		//la ruta ya no es completa puesto que ya la definimos dentro del constructor de la clase base
		return $this->render('index.twig',['blogPosts' => $blogPosts]);
	}
}