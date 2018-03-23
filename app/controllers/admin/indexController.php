<?php 
namespace App\Controllers\Admin;

use App\Controllers\baseController;
use App\Models\user;

class IndexController extends baseController {
	
	public function getIndex() {

		if (isset($_SESSION['userId'])){
			$userId = $_SESSION['userId'];
			//cuando id está como 'id' en la tabla
			//$userLogged = User::find($userId);
			
			//cuando id está con otro nombre en la tabla
			//users_id es el nombre de la columna
			$userLogged = User::query()->where('users_id','=',$userId)->first();

			if ($userLogged){
				return $this->render('admin/index.twig',[
					'user' => $userLogged
				]);
			}
		}
	
		header('Location:'.BASE_URL.'auth/login');
	}
}