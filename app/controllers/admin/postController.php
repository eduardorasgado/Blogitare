<?php 

namespace App\Controllers\Admin;

use App\Controllers\baseController;
use App\Models\BlogPost;
use Sirius\Validation\Validator;

class PostController extends baseController {

	public function getIndex(){
		//Old way
		//admin/posts o podemos acceder con admin/posts/index.php

		//para sustituir use($PDO) en index.php public
		//global $PDO;

		//$sql = "SELECT * FROM  blog_posts ORDER BY blog_id DESC";
		//$query = $PDO->prepare($sql);
		//$query->execute();

		// con \ le decimos a php q PDO está en el namespace global
		//$blogPosts = $query->fetchAll(\PDO::FETCH_ASSOC);
		
		//New way
		//Ejecutando consulta a sql desde illuminate
		//$blogPosts = BlogPost::all() //Para consultar sin ordenar
		$blogPosts = BlogPost::query()->orderBy('blog_id', 'desc')->get();

		return $this->render('admin/posts.twig',['blogPosts' => $blogPosts]);
	}

	public function getCreate(){
		//admin/posts/create
		return $this->render('admin/insert-post.twig');
	}

	public function postCreate(){
		//admin/posts/create  submit

		$result = false;

		//Uso de Sirius validator
		$errors = [];
		$validator = new Validator();
		$validator->add('title','required');
		$validator->add('title', 'maxlength', 'max=100');
		$validator->add('title', 'minlength', 'min=10');
		$validator->add('content','required');
		$validator->add('content','minlength','min=200');
		

		if ($validator->validate($_POST)){
			//Insertar con ORM Illuminate
			$blogPost = new BlogPost([
				'title' => $_POST['title'],
				'content' => $_POST['content']
			]);
			$blogPost->save();
			$result=true;
		}
		else{
			$errors = $validator->getMessages();
		}
		

		return $this->render('admin/insert-post.twig',[
			'result' => $result,
			'errors' => $errors
		]);
	}
}

