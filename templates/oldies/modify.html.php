<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title>Camagru</title>
		<link rel="stylesheet" href="/styles/bulma.css">
	</head>
	<body>
	<section class="hero">
		<div class="hero-body">
			<div class="container">
				<h1 class="title">
					Camagru
				</h1>
				<p class="subtitle">
					Share your pictures with <strong>Camagru</strong>!
				</p>
			</div>
		</div>
	</section>

	<section class="section">
		<div class="container">
			<div class="columns is-mobile is-centered">
				<div class="column is-half">
				<form class="box">
					<figure class="level is-mobile">
						<div class="level-item has-text-centered">
							<p class="image is-128x128">
								<img src="/images/camera.png" alt="">
							</p>
						</div>
					</figure>
					<div class="field">
						<label class="label">Username</label>
						<div class="control">
							<input class="input" type="Username" placeholder="Username" required>
						</div>
					</div>
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
						<label class="label">Confirm New Password</label>
						<div class="control">
							<input class="input" type="password" placeholder="********" required>
						</div>
					</div>
					<button class="button is-primary">Submit</button>
				</form>
				</div>
			</div>
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
