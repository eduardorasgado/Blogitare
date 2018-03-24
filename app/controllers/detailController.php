<?php 

namespace App\Controllers;

use App\Models\blogPost;

class DetailController extends baseController {
	public function getIndex($id){

		//filtro para limpiar el $id
		//ya que entra asi: 10_nombre_de_articulo
		//Encontrando el comienzo de los _
		$lenght = strlen($id);
		$limit = 0;
		for ($i=0;$i<$lenght;$i++){
			if ($id[$i] == '_'){
				$limit = $i-1	;
				break;
			}
		}
		//aislando $id desde el inicio hasta el limit
		$new_id = '';
		foreach(range(0,$limit) as $i){
			$new_id = $new_id.$id[$i];
		}
		
		//consiguiendo id de posts
		$blogPosts = BlogPost::where('blog_id', $new_id)->get();

		return $this->render('detail.twig',[
			'blogPosts' => $blogPosts
		]);
	}
}