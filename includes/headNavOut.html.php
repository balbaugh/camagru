<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="../public/styles/bulma.css">
	<title>camagru</title>
	<link rel="shortcut icon" type="image/jpg" href="../public/images/whiteFavicon.png" />
</head>

<body class="main">
	<nav class="navbar has-shadow">

		<div class="navbar-brand">
			<a href="" class="navbar-item">
				<img src="../public/logo/camagruText.png" alt="">
			</a>
			<div class="navbar-burger burger" data-target="navMenu">
				<span></span>
				<span></span>
				<span></span>
			</div>
		</div>

		<div id="navMenu" class="navbar-menu">
			<div class="navbar-end">
				<div class="navbar-item">
					<div class="field is-grouped">
						<a href="../" class="navbar-item">
							<div class="level-item">
								<span class="icon is-medium">
									<img src="../public/icons/MaterialIcons/icons8-home-50.png" alt="Home" title="Home">
								</span>
								</br>
							</div>
						</a>
						<a href="../sources/login.html.php" class="navbar-item">
							<div class="level-item">
								<span class="icon is-medium">
									<img src="../public/icons/MaterialIcons/icons8-login-50.png" alt="Log in"
										title="Log in">
								</span>
								</br>
							</div>
						</a>
						<a class="navbar-item" href="../controllers/logout.php">
							<div class="level-item">
								<span class="icon is-medium">
									<img src="../public/icons/MaterialIcons/icons8-logout-50.png" alt="Log out"
										title="Log out">
								</span>
								</br>
							</div>
						</a>
					</div>
				</div>
			</div>
		</div>
	</nav>

	<?php if (isset($_GET['success'])) { ?>
	<div class="notification is-success is-light">
		<button class="delete"></button>
		<h2 class="is-size-3"><?php echo $_GET['success']; ?></h2>
	</div>
	<?php } ?>

	<?php if (isset($_GET['error'])) { ?>
	<div class="notification is-danger is-light">
		<button class="delete"></button>
		<h2 class="is-size-3"><?php echo $_GET['error']; ?></h2>
	</div>
	<?php } ?>