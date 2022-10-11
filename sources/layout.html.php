<!DOCTYPE html>
<html lang="en">

<!-- By prefixing a link in an HTML document, here the stylesheet, with a forward slash ( / ), it tells the browser to look for the file from the top level of the website. If we refresh the page, we’ll see the styles now display correctly. -->

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="../public/styles/bulma.css">
	<title><?= $title ?></title>
</head>

<body>
	<nav class="navbar has-shadow">

		<div class="navbar-brand">
			<a class="navbar-item">
				<img src="../public/stickers/camagruText.png" alt="">
			</a>
			<div class="navbar-start">
				<div class="navbar-item">

				</div>
			</div>
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
						<a href="/index.php" class="navbar-item">
							<div class="level-item">
								<span class="icon is-medium">
									<img src="../public/icons/MaterialIconsGray/icons8-home-50.png" alt="Home"
										title="Home">
								</span>
								</br>
							</div>
						</a>
						<a href="" class="navbar-item">
							<div class="level-item">
								<span class="icon is-medium">
									<img src="../public/icons/MaterialIconsGray/icons8-user-50.png" alt="Profile"
										title="Profile">
								</span>
								</br>
							</div>
						</a>
						<a href="" class="navbar-item">
							<div class="level-item">
								<span class="icon is-medium">
									<img src="../public/icons/MaterialIconsGray/icons8-add-50.png" alt="Post"
										title="Post">
								</span>
								</br>
							</div>
						</a>
						<?php if ($loggedIn) : ?>
						<a href="" class="navbar-item">
							<div class="level-item">
								<span class="icon is-medium">
									<img src="../public/icons/MaterialIconsGray/icons8-logout-50.png" alt="Log out"
										title="Log out">
								</span>
								</br>
							</div>
						</a>
						<?php else : ?>
						<a href="" class="navbar-item">
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
				</div>
			</div>
		</div>
	</nav>
    <div class="columns is-flex-direction-column is-fullheight-100vh">
        <section class="section">
            <?= $output ?>
        </section>
    </div>
	<footer class="footer is-white">
		<div class="content has-text-centered">
			<p>
				&#169 2022 <strong>camagru</strong> from <a href="https://balbaugh.com">balbaugh</a>
			</p>
		</div>
	</footer>
</body>

</html>