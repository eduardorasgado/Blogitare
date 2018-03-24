<?php

namespace App\Controllers;

use App\Controllers\baseController;
use Sirius\Validation\Validator;
use App\Models\user;

class AuthController extends baseController {

	public function getLogin(){

		return $this->render('login.twig');
	}

	public function postLogin(){

		$authValidator = new Validator();
		$authValidator->add('email','required');
		$authValidator->add('email','email');
		$authValidator->add('password','required');

		if ($authValidator->validate($_POST)){
			$user = User::where('email',$_POST['email'])->first();
			if ($user){
				if (password_verify($_POST['password'], $user->password)){
					//Se considera que usuario OK
					
					//Session de variable superglobal, solo activa si
					//se ha iniciado session en el index.php de public

					$_SESSION['userId'] = $user->users_id;
					
					//enviar un encabezado en la respuesta
					//en este caso de redirección
					header('Location:'.BASE_URL.'admin');
					return null;

				}
			}
			//Se considera usuario not OK
			$authValidator->addMessage('email','Ops! El usuario y/o la contraseña no coinciden');
		}

		$errors = $authValidator->getMessages();

		return $this->render('login.twig',[
			'errors' => $errors
		]);
	}

	public function getLogout() {
		session_destroy($_SESSION['userId']);
		header('Location:'.BASE_URL.'auth/login');
	}

}