<?php 

namespace App\Controllers\Admin;

use App\Controllers\baseController;
use App\Models\blogPost;
use App\Controllers\Admin\postController;
use App\Models\user;
use Sirius\Validation\Validator;

class EditController extends baseController {
	public function getEdit($id) {
		//consulta del blog(guardado en un array) con un id
		$blogPost_item = BlogPost::where('blog_id',$id)->get()->first();
		return $this->render('admin/update-post.twig',[
			'blogPost' => $blogPost_item
		]);
	}

	public function postEdit($id) {
		//query de user que sube post 
		$userId = $_SESSION['userId'];
		$userLogged = User::query()->where('users_id','=',$userId)->first();
		$userLogged = $userLogged['name'];

		$result = false;

		//Uso de Sirius validator
		$errors = [];
		$edit_validator = new Validator();
		$edit_validator->add('title','required');
		$edit_validator->add('title', 'maxlength', 'max=100');
		$edit_validator->add('title', 'minlength', 'min=10');
		$edit_validator->add('content','required');
		$edit_validator->add('content','minlength','min=200');
		
		if ($edit_validator->validate($_POST)){	

			//limpiandoel titulo para no terminar con _
			$rawTitle = $_POST['title'];
			$new_title = '';
			//uno menos que la logitud del string
			//para hacerlo indice de arrays
			$title_length = strlen($rawTitle) - 1;

			//averiguamos hasta que indice dejan de haber espacios
			//en el titulo 
			while($title_length > 0){
				if ($rawTitle[$title_length] == ' '){
					$title_length--;
				}
				elseif ($rawTitle[$title_length] != ' ') {
					break;
				}
				
			}
			//seteamos new_title como el rawtitle hasta el punto que
			//terminan las letras, excluyedo los espacios finales
			foreach (range(0,$title_length) as $i) {
						$new_title = $new_title.$rawTitle[$i];
					}
			
			//Meter nuevos datos en la db
			$postTitle = $new_title;
			$postImage = $_POST['img'];
			$postContent = $_POST['content'];

			$blogPost = BlogPost::where('blog_id',$id)->
				update([
					'title' => $postTitle,
					'img_url' => $postImage,
					'content' => $postContent
				]);

			$result = true;

			$blogPosts_item = BlogPost::query()->orderBy('blog_id', 'desc')->get();

			//Regresar a lista de post y presentar mensaje de exito
			return $this->render('admin/posts.twig',[
				'result' => $result,
				'blogPosts' => $blogPosts_item
			]);
		}

		else{
			$errors = $validator->getMessages();
		}

		//En caso de no tener exito permanece en la pagina actual
		return $this->render('admin/update-post.twig',[
			'errors' => $errors
		]);

	}

	public function getDelete($id){
		//consulta del blog(guardado en un array) se elimina el blog con id
		$blogPosts = BlogPost::where('blog_id',$id)->delete();

		//Se hace de nuevo un refresh de la consulta y se renderiza
		$blogPosts = BlogPost::query()->orderBy('blog_id', 'desc')->get();

		return $this->render('admin/posts.twig',['blogPosts' => $blogPosts]);
	}

}