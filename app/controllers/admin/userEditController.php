<?php 

namespace App\Controllers\Admin;

use App\Controllers\baseController;
use App\Models\user;
use Sirius\Validation\Validator;

class UserEditController extends baseController {
	//Estas funciones estan predefinidas y bajo un estadar
	//get o post + la funcion dada: index, delete, edit, create

	public function getEdit($userId){
		//query para obtener el user con la id
		$user = User::query()->where('users_id','=',$userId)->get()->first();

		return $this->render('admin/update-user.twig',[
			'user' => $user
		]);
	}

	public function postEdit($userId){
		
		$result = false;

		//Uso de Sirius validator
		$errors = [];
		$validator = new Validator();
		$validator->add('name','required');
		$validator->add('email','required');
		$validator->add('email','email');
		$validator->add('password','required');
		
		//Si hay contraseña nueva sera requerida en ambos campos
		//de comprobacion
		if ($_POST['newPassword'] != '') {
			$validator->add('newRepeatedPassword','required');
		}

		//validando y agregando nuevos datos
		if ($validator->validate($_POST)){
			//query para obtener el user con la id
			//$user = User::query()->where('users_id','=',$userId)->get();
			$user = User::where('users_id',$userId)->first();

			//En caso de haber usuario
			if($user){

				//Si la contraseña dada es la correcta
				if (password_verify($_POST['password'], $user->password)){
					$newName= $_POST['name'];
					$newEmail = $_POST['email'];
					$newPass = '';
					$oldPassword = $user->password;

					//Si las contraseñas nuevas requeridas por duplicidad son 
					//identicas se haran los cambios
					$Npass = $_POST['newPassword'];
					$Npass2 = $_POST['newRepeatedPassword'];
					if (($Npass == $Npass2) && ($Npass != '')) {
						$newPass = password_hash($Npass, PASSWORD_DEFAULT);
						$user = User::where('users_id','=',$userId)->update(['name' => $newName, 'email' => $newEmail, 'password' => $newPass]);
						$result=true;

						//consulta y render hacia users.twig
						$users = User::all();

						return $this->render('admin/users.twig',[
							'result' => $result,
							'users' => $users
						]);
					}
					//En caso de no haber nueva contraseña
					//Se guardan solo datos name e email y se guarda
					//la vieja password
					elseif($Npass == ''){
						$user = User::where('users_id','=',$userId)->update(['name' => $newName, 'email' => $newEmail, 'password' => $oldPassword]);

						$result=true;

						//consulta y render hacia users.twig
						$users = User::all();

						return $this->render('admin/users.twig',[
							'result' => $result,
							'users' => $users
						]);
					}
					else{
						//En caso de errar en nueva contraseña repetida
						$errors =['Nueva contraseña' => array('La contraseña nueva no coincide en ambos campos :(')];
					}

				}
			}	
			
		}
		else{
			$errors = $validator->getMessages();
		}
		

		return $this->render('admin/update-user.twig',[
			'errors' => $errors
		]);
	}

	public function getDelete($userId) {
		//query para obtener el user con la id
		$user = User::query()->where('users_id','=',$userId)->delete();

		$users = User::all();
		return $this->render('admin/users.twig',[
			'users' => $users
		]);
	}
}