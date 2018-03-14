<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<title>Bienvenido a Blogitage</title>
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
	</head>
	<body>
		<div class="container">
			<div class="row">
				<div class="col-md-12">
					<h1>Blogitage</h1><br><br>
				</div>
			</div>
			<div class="row">
				<div class="col-md-8">

					<?php foreach($blogPosts as $blogPost):?>
						<div class="blog-post">
							<h2><?= $blogPost['title'] ?></h2>
							<p>March 15, 2018 by <a href="">Alex Campos</a></p>
						</div>
						<div class="blog-post-image">
							<img src="images/fotito.jpg" alt="" style="height: 300px;width: 400px;">
						</div>
						<div class="blog-post-content">
							<p><?= $blogPost['content'] ?></p>
						</div>
					 <?php endforeach; ?>

				</div>
				<div class="col-md-4">
					<h2>Más entradas del blog</h2>
					<p>Ut euismod ante ac mi tempus posuere. Nam et sem eu eros vehicula pulvinar auctor sit amet orci.</p>
				</div>
			</div>
			<div class="row">
				<div class="col-md-12">
					<br>
					<footer>&copy; Blogitage 2018. All rights reserved. <a href="">Admin Panel</a></footer>
				</div>
			</div>
		</div>
	</body>
</html>
