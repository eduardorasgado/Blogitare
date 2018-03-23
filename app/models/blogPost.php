<?php 

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BlogPost extends Model {
	//Esta clase al ser creada, hereda de Model muchos metodos que podremos usar
	protected $table = 'blog_posts';

	//esto permite poder usar el metodo save para insertar un nuevo post en 
	//postController.php
	protected $fillable = ['title','content','img_url','author'];
	//recordar que con ORM debemos crear en la tabla, columnas: created_at y updated_at
	//debido a que estas dos piden
}