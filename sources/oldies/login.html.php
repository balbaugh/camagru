<?php include '../includes/headandnav.html.php'; ?>

<section class="is-relative section py-20 has-background-light">
	<div class="is-relative container">
		<div class="columns is-vcentered">
			<div class="column is-6 mb-8 mb-0-desktop">
				<h2 class="mb-10 title is-2">We steal your face right off of your head!</h2>
				<p class="is-size-5 has-text-grey-dark">Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>
			</div>
			<div class="column is-5">
				<div class="container p-6 px-10-desktop py-12-desktop">
					<form action="" method="post" class="box">
						<figure class="image level is-mobile is-square">
							<img id="stealie" src="../../public/stickers/camagruStealie.png" alt="">
						</figure>
						<div class="field">
							<label class="label" for="email">Email</label>
							<div class="control">
								<input class="input" name="email" type="email" id="email"
									placeholder="e.g. name@example.com" required>
							</div>
						</div>
						<div class="field">
							<label class="label" for="password">Password</label>
							<div class="control">
								<input class="input" name="password" type="password" id="password"
									placeholder="********" required>
							</div>
						</div>
						<input type="submit" name="login" id="login_btn" value="Log in"
							class="button is-primary is-fullwidth">
					</form>
					<div class="box has-text-centered">
						Don't have an account? <a href="../templates/register.html.php">Sign up</a>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>
<section class="footer">
	<div class="content has-text-centered">
		<p>
			&#169 2022 <strong>camagru</strong> from <a href="https://balbaugh.com">balbaugh</a>
		</p>
	</div>
</section>
</body>

</html>