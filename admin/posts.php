<?php 
	include_once '../config.php';
	$sql = "SELECT * FROM  blog_posts ORDER BY blog_id DESC";
	$query = $PDO->prepare($sql);
	$query->execute();

	$blogPosts = $query->fetchAll(PDO::FETCH_ASSOC);

?>

<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<title>Blogitage | Post List</title>
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
	</head>
	<body>
		<div class="container">
			<div class="row">
				<div class="col-md-12">
					 <a href="../index.php"><h1>Blogitage</h1></a>
					<br><br>
				</div>
			</div>
			<div class="row">
				<div class="col-md-8">
					<h2>Post Manage System</h2>
					<a class="btn btn-primary" href="insert-post.php">New Post</a><br><br>
					<table class="table">
						<tr>
							<th>Title</th>
							<th>Content</th>
							<th>Edit</th>
							<th>Delete</th>
						</tr	>
						<?php foreach($blogPosts as $blogPost):?>
						<tr>
							<td><?= $blogPost['title']?></td>
							<?php
								$contenido2 = ''; 
								foreach(range(0,80) as $letter){
									$contenido2[$letter] = $blogPost['content'][$letter];
								}
							?>
							<td><?= $contenido2 ?>...</td>
							<td><a href="">Edit</a></td>
							<td><a href="">Delete</a></td>
						</tr> 
					 	<?php endforeach; ?>
					</table>

				</div>
				<div class="col-md-4">
					<h2>Más entradas del blog</h2>
					<p>Ut euismod ante ac mi tempus posuere. Nam et sem eu eros vehicula pulvinar auctor sit amet orci.</p>
				</div>
			</div>
			<div class="row">
				<div class="col-md-12">
					<br>
					<footer>&copy; Blogitage 2018. All rights reserved. <a href="../index.php">Inicio</a></footer>
				</div>
			</div>
		</div>
	</body>
</html>
