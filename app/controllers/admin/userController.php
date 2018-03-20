<?php 

namespace App\Controllers\Admin;

use App\Controllers\baseController;
use App\Models\user;


class UserController extends baseController {

	public function getIndex(){
		$users = User::all();
		return $this->render('admin/users.twig',[
			'users' => $users
		]);
	}
}