<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<title>Blogitage | Write</title>
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
	</head>
	<body>
		<div class="container">
			<div class="row">
				<div class="col-md-12">
					<a href=<?= BASE_URL ?>><h1>Blogitage</h1></a><br><br>
					<h2>Escribe un nuevo post</h2>
				</div>
			</div>
			<div class="row">
				<div class="col-md-8">
					<a class="btn btn-secondary" href="<?= BASE_URL.'/admin/posts' ?>">Regresar</a><br><br>
					<?php 
						if (isset($result) && $result){
							//ejecutamos mensaje de alerta si hay éxito en el query
							echo '<div class="alert alert-success">Has pubicado con éxito!</div>';
						}
			 		?>	
					<form action="" method="POST">
						<div class="form-group">
							<label for="inputTitle">Título</label>
							<input class="form-control" type="text" name="title" id="inputTitle" size="80" maxlength="80">
						</div>
						<textarea class="form-control" name="content" id="inputContent" cols="90" rows="20"></textarea>
						<br>
						<input class="btn btn-primary" type="submit" value="Publicar" name="">
					</form>
				</div>
				<div class="col-md-4">
					<h2>Más entradas del blog</h2>
					<p>Ut euismod ante ac mi tempus posuere. Nam et sem eu eros vehicula pulvinar auctor sit amet orci.</p>
				</div>
			</div>
			<div class="row">
				<div class="col-md-12">
					<br>
					<footer>&copy; Blogitage 2018. All rights reserved. <a href="<?= BASE_URL ?>">Inicio</a></footer>
				</div>
			</div>
		</div>
	</body>
</html>
