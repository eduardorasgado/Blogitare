<?php 

namespace App\Controllers;

use App\Models\blogPost;

class DetailController extends baseController {
	public function getIndex($id){
		//consiguiendo id de posts
		$blogPosts = BlogPost::where('blog_id', $id)->get();

		return $this->render('detail.twig',[
			'blogPosts' => $blogPosts
		]);
	}
}