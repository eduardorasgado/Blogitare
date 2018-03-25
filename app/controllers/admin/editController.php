<?php 

namespace App\Controllers\Admin;

use App\Controllers\baseController;
use App\Models\blogPost;
use App\Controllers\Admin\postController;

class EditController extends baseController {
	public function getEdit() {
		return $this->render('admin/posts.twig');
	}

	public function postEdit() {
		return $this->render('admin/posts.twig');
	}

	public function getDelete($id){
		//consulta del blog(guardado en un array) se elimina el blog con id
		$blogPosts = BlogPost::where('blog_id',$id)->delete();

		//Se hace de nuevo un refresh de la consulta y se renderiza
		$blogPosts = BlogPost::query()->orderBy('blog_id', 'desc')->get();

		return $this->render('admin/posts.twig',['blogPosts' => $blogPosts]);
	}

}