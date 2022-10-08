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
				<small>Steal your face with <strong>Camagru</strong>!</small>
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
								<img src="../images/home.svg">
							</span>
						</br>Home
						</div>
					</a>
					<a class="navbar-item">
						<div class="level-item">
							<span class="icon is-small">
							<img src="../images/user.svg">
						</span>
						</br>Profile
						</div>
					</a>
					<a class="navbar-item">
						<div class="level-item">
							<span class="icon is-small">
								<img src="../images/logout.svg">
							</span>
							</br>Logout
							</div>
						</a>
				</div>
			</div>
		</div>
		</div>
	</nav>

	<section class="is-relative section py-20 has-background-light">
		<div class="is-relative container">
			<div class="columns is-vcentered">
			<div class="column is-6 mb-8 mb-0-desktop">
				<h2 class="mb-10 title is-2">Lorem ipsum dolor sit amet consectutar domor at elis</h2>
				<p class="is-size-5 has-text-grey-dark">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Pellentesque massa nibh, pulvinar vitae aliquet nec, accumsan aliquet orci.</p>
			</div>
			<div class="column is-5">
				<div class="box p-6 px-10-desktop py-12-desktop has-background-white">
				<form method="POST" action="" class="box">
						<figure class="level is-mobile">
							<div class="level-item has-text-centered">
								<p class="image is-128x128">
									<img src="../images/StealYourFace.png" alt="">
								</p>
							</div>
						</figure>
						<div class="field">
							<label class="label">Current Password</label>
							<div class="control">
								<input class="input" type="email" placeholder="********" required>
							</div>
						</div>
						<div class="field">
							<label class="label">New Password</label>
							<div class="control">
								<input class="input" type="password" placeholder="********" required>
							</div>
						</div>
						<div class="field">
							<label class="label">Confirm Password</label>
							<div class="control">
								<input class="input" type="password" placeholder="********" required>
							</div>
						</div>
						<button class="button is-primary">Submit</button>
				</form>
				</div>
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


<!-- <!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>42Chat</title>
</head>
<body>
	<form action="modif.php" method="POST">
		Username: <input type="text" name="login" value="" />
		<br />
		Old password: <input type="password" name="oldpw" value="" />
		<br />
		New password: <input type="password" name="newpw" value="" />
		<br />
		<input type="submit" name="submit" value="OK"/>
	</form>
	<a href="index.html">Back to the login page</a>
</body>
</html>
 -->


<?php
/*	require_once('security.php');
	
	if ($_POST['login'] && $_POST['oldpw'] && $_POST['newpw'] && $_POST['submit'] && $_POST['submit'] === "OK")
	{
		if (!file_exists('../private'))
		{
			mkdir("../private");
		}
		if (!file_exists('../private/passwd'))
		{
			file_put_contents('../private/passwd', null);
		}
		$account = unserialize(file_get_contents('../private/passwd'));
		if ($account)
		{
			$exist = 0;
			foreach ($account as $key => $value)
			{
				if ($value['login'] === $_POST['login'] && $value['passwd'] === hash('whirlpool', $_POST['oldpw']))
				{
					$exist = 1;
					$account[$key]['passwd'] =  hash('whirlpool', $_POST['newpw']);
				}
			}
			if ($exist)
			{
				file_put_contents('../private/passwd', serialize($account));
				header('Location: index.html');
				echo "OK\n";
				exit();
			}
			else
			{
				echo "ERROR\n";
			}
		}
		else
		{
			echo "ERROR\n";
		}
	}
	else
	{
		echo "ERROR\n";
	}*/
?>
