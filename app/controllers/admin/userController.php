<?php 

namespace App\Controllers\Admin;

use App\Controllers\baseController;
use App\Models\user;
use Sirius\Validation\Validator;


class UserController extends baseController {

	public function getIndex(){
		$users = User::all();
		return $this->render('admin/users.twig',[
			'users' => $users
		]);
	}

	public function getCreate(){
		return $this->render('admin/insert-user.twig');
	}

	public function postCreate(){
		$result = false;

		//Uso de Sirius validator
		$errors = [];
		$validator = new Validator();
		$validator->add('name','required');
		$validator->add('email','required');
		$validator->add('email','email');
		$validator->add('password','required');

		if ($validator->validate($_POST)){
			//Insertar con ORM Illuminate
			$newUser = new user();
			$newUser->name = $_POST['name'];
			$newUser->email = $_POST['email'];
			$newUser->password = password_hash($_POST['password'], PASSWORD_DEFAULT);

			$newUser->save();
			$result=true;
		}
		else{
			$errors = $validator->getMessages();
		}
		

		return $this->render('admin/insert-user.twig',[
			'result' => $result,
			'errors' => $errors
		]);
	}
}	