<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<script src="../public/scripts/navbar.js"></script>
	<script src="../public/scripts/notifications.js"></script>
	<link rel="stylesheet" href="../public/styles/bulma.css">
	<link rel="shortcut icon" type="image/jpg" href="../public/images/whiteFavicon.png" />
	<title>camagru</title>
</head>

<body class="main">
	<nav class="navbar has-shadow">

		<div class="navbar-brand">
			<a href="" class="navbar-item">
				<img src="../public/logo/camagruText.png" alt="">
			</a>
			<a role="button" class="navbar-burger burger" id="burger" data-target="navMenu" aria-label="menu"
				aria-expanded="false" onClick="toggleNavbar()">
				<span aria-hidden="true"></span>
				<span aria-hidden="true"></span>
				<span aria-hidden="true"></span>
			</a>
		</div>

		<div id="navMenu" class="navbar-menu">
			<div class="navbar-end">
				<div class="navbar-item">
					<div class="field is-grouped">
						<a class="navbar-item" href="../">
							<div class="level-item">
								<span class="icon is-medium">
									<img src="../public/icons/home-50.png" alt="Home" title="Home">
								</span>
								</br>
							</div>
						</a>
						<a class="navbar-item" href="../sources/camera.html.php">
							<div class="level-item">
								<span class="icon is-medium">
									<img src="../public/icons/camera-50.png" alt="Camera" title="Camera">
								</span>
								</br>
							</div>
						</a>
						<a class="navbar-item" href="../sources/upload.html.php">
							<div class="level-item">
								<span class="icon is-medium">
									<img src="../public/icons/upload-50.png" alt="Upload" title="Upload">
								</span>
								</br>
							</div>
						</a>
						<a class="navbar-item" href="../sources/settings.html.php">
							<div class="level-item">
								<span class="icon is-medium">
									<img src="../public/icons/settings-50.png" alt="Settings" title="Settings">
								</span>
								</br>
							</div>
						</a>
						<a class="navbar-item" href="../controllers/logout.php">
							<div class="level-item">
								<span class="icon is-medium">
									<img src="../public/icons/logout-50.png" alt="Log out" title="Log out">
								</span>
								</br>
							</div>
						</a>
					</div>
				</div>
			</div>
	</nav>

	<?php if (isset($_GET['success'])) { ?>
	<div class="notification is-success is-light">
		<button class="delete"></button>
		<h2 class="is-size-3"><?php echo htmlentities($_GET['success'], ENT_QUOTES, 'UTF-8'); ?></h2>
	</div>
	<?php } ?>

	<?php if (isset($_GET['error'])) { ?>
	<div class="notification is-danger is-light">
		<button class="delete"></button>
		<h2 class="is-size-3"><?php echo htmlentities($_GET['error'], ENT_QUOTES, 'UTF-8'); ?></h2>
	</div>
	<?php } ?>