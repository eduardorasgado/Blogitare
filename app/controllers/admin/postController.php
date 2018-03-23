<?php 

namespace App\Controllers\Admin;

use App\Controllers\baseController;
use App\Models\BlogPost;
use Sirius\Validation\Validator;
use App\Models\user;

class PostController extends baseController {

	public function getIndex(){
		
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

		//query de user que sube post 
		$userId = $_SESSION['userId'];
		$userLogged = User::query()->where('users_id','=',$userId)->first();
		$userLogged = $userLogged['name'];

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
				'content' => $_POST['content'],
				'author' => $userLogged
			]);

			//imagen no obligatoria, pero si existe guardar
			if($_POST['img']){
				$blogPost->img_url = $_POST['img'];
			}

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

