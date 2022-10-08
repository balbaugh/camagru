<?php
	require_once 'security.php';
?>

<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title>Camagru</title>
		<link rel="stylesheet" href="../styles/bulma.min.css">
	</head>

	<body>
	<nav class="navbar has-shadow">

		<div class="navbar-brand">
			<a class="navbar-item">
				<img src="../images/StealYourFace.png" alt="">
			</a>
			<div class="navbar-start">
				<div class="navbar-item">
				<small>Share your pictures with <strong>Camagru</strong>!</small>
				</div>
			</div>
			<div class="navbar-burger burger" data-target="navMenu">
				<span></span>
				<span></span>
				<span></span>
			</div>
		<!-- Logo, tagline, and navbar-burger -->
		</div>

		<div id="navMenu" class="navbar-menu">
		<!-- User name, dropdown menu -->
		</div>
		<div id="navMenu" class="navbar-menu">
		<div class="navbar-end">
			<div class="navbar-item has-dropdown is-hoverable">
				<div class="navbar-link">
					<small><strong>Menu</strong></small>
				</div>
				<div class="navbar-dropdown">
					<a class="navbar-item">
						<div class="level-item">
							<span class="icon is-small">
								<img src="../images/home.png">
							</span>
						</br>Home
						</div>
					</a>
					<a class="navbar-item">
						<div class="level-item">
							<span class="icon is-small">
							<img src="../images/user.png">
						</span>
						</br>Profile
						</div>
					</a>
					<a class="navbar-item">
						<div class="level-item">
							<span class="icon is-small">
								<img src="../images/logout.png">
							</span>
							</br>Logout
							</div>
						</a>
				</div>
			</div>
		</div>
		</div>
	</nav>
	<section class="hero">
		<div class="hero-body">
			<div class="container">
				pizza
			</div>
		</div>
	</section>

	<section class="section">
		<div class="container">
			<div class="columns is-mobile is-centered">

				<div class="column is-half">
					pizza
				</div>
			</div>
		</div>
	</section>
	<section class="footer">
		<div class="content has-text-centered">
			<p>
			<strong>Camagru</strong> by <a href=" ">balbaugh</a>.
			</p>
		</div>
	</section>
	</body>
</html>
