<?php 
namespace App\Controllers\Admin;

use App\Controllers\baseController;

class IndexController extends baseController {
	
	public function getIndex() {
		return $this->render('admin/index.twig');
	}
}