<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="../public/styles/bulma.css">
	<title>camagru</title>
</head>

<body>
	<nav class="navbar has-shadow">

		<div class="navbar-brand">
			<a href="" class="navbar-item">
				<img src="../public/images/camagruText.png" alt="">
			</a>
			<div class="navbar-start">
				<div class="navbar-item">

				</div>
			</div>
		</div>

		<div id="navMenu" class="navbar-menu">
			<div class="navbar-end">
				<div class="navbar-item">
					<div class="field is-grouped">
						<a href="../index.php" class="navbar-item">
							<div class="level-item">
								<span class="icon is-medium">
									<img src="../public/icons/MaterialIconsGray/icons8-home-50.png" alt="Home"
										title="Home">
								</span>
								</br>
							</div>
						</a>
						<a href="profile.html.php" class="navbar-item">
							<div class="level-item">
								<span class="icon is-medium">
									<img src="../public/icons/MaterialIconsGray/icons8-user-50.png" alt="Profile"
										title="Profile">
								</span>
								</br>
							</div>
						</a>
						<a href="camera.html.php" class="navbar-item">
							<div class="level-item">
								<span class="icon is-medium">
									<img src="../public/icons/MaterialIconsGray/icons8-add-50.png" alt="Post"
										title="Post">
								</span>
								</br>
							</div>
						</a>
						<?php if ($loggedIn) : ?>
						<a href="logout.html.php" class="navbar-item">
							<div class="level-item">
								<span class="icon is-medium">
									<img src="../public/icons/MaterialIconsGray/icons8-logout-50.png" alt="Log out"
										title="Log out">
								</span>
								</br>
							</div>
						</a>
						<?php else : ?>
						<a href="login.html.php" class="navbar-item">
							<div class="level-item">
								<span class="icon is-medium">
									<img src="../public/icons/MaterialIconsGray/icons8-login-50.png" alt="Log in"
										title="Log in">
								</span>
								</br>
							</div>
						</a>
						<?php endif; ?>
					</div>
                    <div class="navbar-item has-dropdown is-hoverable">
                        <a class="navbar-link">
                            Menu
                        </a>

                        <div class="navbar-dropdown">
                            <a class="navbar-item" href="../index.php">
                                Home
                            </a>
                            <a class="navbar-item" href="profile.html.php">
                                Profile
                            </a>
                            <a class="navbar-item" href="camera.html.php">
                                Post
                            </a>
                            <hr class="navbar-divider">
                            <?php if ($loggedIn) : ?>
                                <a class="navbar-item" href="logout.html.php">
                                    Log out
                                </a>
                            <?php else : ?>
                                <a class="navbar-item" href="login.html.php">
                                    Log in
                                </a>
                            <?php endif; ?>
                        </div>
                    </div>
				</div>
			</div>
		</div>
	</nav>