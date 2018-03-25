<?php 

namespace App\Controllers\Admin;

use App\Controllers\baseController;
use App\Models\user;

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
		//query para obtener el user con la id
		$user = User::query()->where('users_id','=',$userId)->get();
		
		$result = true;

		$users = User::all();

		return $this->render('admin/users.twig',[
			'result' => $result,
			'users' => $users
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