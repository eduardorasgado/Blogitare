<?php 

namespace App\Controllers\Admin;

use App\Controllers\baseController;

class PostController extends baseController {

	public function getIndex(){
		//admin/posts o podemos acceder con admin/posts/index.php

		//para sustituir use($PDO) en index.php public
		global $PDO;

		$sql = "SELECT * FROM  blog_posts ORDER BY blog_id DESC";
		$query = $PDO->prepare($sql);
		$query->execute();

		// con \ le decimos a php q PDO está en el namespace global
		$blogPosts = $query->fetchAll(\PDO::FETCH_ASSOC);

		return $this->render('admin/posts.twig',['blogPosts' => $blogPosts]);
	}

	public function getCreate(){
		//admin/posts/create
		return $this->render('admin/insert-post.twig');
	}

	public function postCreate(){
		//admin/posts/create  submit

		global $PDO;

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

		return $this->render('admin/insert-post.twig',['result' => $result]);
	}
}

