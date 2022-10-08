<!DOCTYPE html>
<html>

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="./public/styles/bulma.css">
	<script defer src="https://use.fontawesome.com/releases/v5.0.6/js/all.js"></script>
	<title>camagru</title>
</head>

<body>
	<nav class="navbar has-shadow">
		<div class="container">
			<div class="navbar-brand">
				<a class="navbar-item">
					<img src="./public/images/camagruText.png" alt="">
				</a>
			</div>

			<div class="navbar-menu" id="navMenu">
				<div class="navbar-end">
					<div class="navbar-item">
						<div class="field is-grouped">
							<a class="navbar-item">
								<div class="level-item">
									<span class="icon is-medium">
										<img src="./public/icons/MaterialIconsGray/icons8-home-50.png" alt="Home"
											title="Home">
									</span>
									</br>
								</div>
							</a>
							<a class="navbar-item">
								<div class="level-item">
									<span class="icon is-medium">
										<img src="./public/icons/MaterialIconsGray/icons8-user-50.png" alt="Profile"
											title="Profile">
									</span>
									</br>
								</div>
							</a>
							<a class="navbar-item">
								<div class="level-item">
									<span class="icon is-medium">
										<img src="./public/icons/MaterialIconsGray/icons8-add-50.png" alt="Post"
											title="Post">
									</span>
									</br>
								</div>
							</a>
							<?php if ($loggedIn) : ?>
							<a href="/login/logout" class="navbar-item">
								<div class="level-item">
									<span class="icon is-medium">
										<img src="./public/icons/MaterialIconsGray/icons8-logout-50.png" alt="Log out"
											title="Log out">
									</span>
									</br>
								</div>
							</a>
							<?php else : ?>
							<a href="/login/login" class="navbar-item">
								<div class="level-item">
									<span class="icon is-medium">
										<img src="./public/icons/MaterialIconsGray/icons8-login-50.png" alt="Log in"
											title="Log in">
									</span>
									</br>
								</div>
							</a>
							<?php endif; ?>
						</div>
					</div>
					<div class="navbar-item has-dropdown is-hoverable">
						<a class="navbar-link">
							Menu
						</a>

						<div class="navbar-dropdown">
							<a class="navbar-item">
								Home
							</a>
							<a class="navbar-item">
								Profile
							</a>
							<a class="navbar-item">
								Post
							</a>
							<hr class="navbar-divider">
							<?php if ($loggedIn) : ?>
							<a class="navbar-item">
								Log out
							</a>
							<?php else : ?>
							<a class="navbar-item">
								Log in
							</a>
							<?php endif; ?>
						</div>
					</div>
				</div>
			</div>
		</div>
	</nav>
	<section class="is-relative section py-20 has-background-light">
		<div class="is-relative container">
			<div class="columns is-vcentered">
				<div class="column is-6 mb-8 mb-0-desktop">
					<!-- prints registration form errors -->
					<?php
					if (!empty($errors)) : ?>
					<div class="notification is-danger">
						<p>Your account could not be created. Please check the following:</p>
						<ul>
							<?php foreach ($errors as $error) : ?>
							<li><?= $error ?></li>
							<?php endforeach; ?>
						</ul>
					</div>
					<?php endif; ?>
					<h2 class="mb-10 title is-2">We steal your face right off of your head!</h2>
					<p class="is-size-5 has-text-grey-dark">Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>
				</div>
				<div class="column is-5">
					<div class="container p-6 px-10-desktop py-12-desktop">
						<form class="box" id="registration_form" action="" method="post">
							<figure class="image level is-mobile is-square">
								<img id="stealie" src="./public/images/camagruStealie.png" alt="">
							</figure>
							<div class="field">
								<label for="email" class="label">Email</label>
								<div class="control">
									<input class="input" type="email" name="user[email]" id="email"
										placeholder="e.g. alex@example.com" required>
								</div>
							</div>
							<div class=" field">
								<label for="username" class="label">Username</label>
								<div class="control">
									<input class="input" type="text" name="user[username]" id="username"
										placeholder="Username" required>
								</div>
							</div>
							<div class=" field">
								<label for="password" class="label">Password</label>
								<div class="control">
									<input class="input" type="password" name="user[password]" id="password"
										placeholder="********" required>
								</div>
								<p id=" error_message"></p>
							</div>

							<!-- INSERT TERMS OF SERVICE TOS CHECKBOX -->

							<input type="submit" name="submit" id="signup_btn" value="Sign Up"
								class="button is-primary is-fullwidth">
						</form>
						<div class="box has-text-centered">
							Already have an account? <a href="../index.php">Log in</a>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>
	<?php include './templates/includes/footer.html.php'; ?>
	</section>

</body>

</html>