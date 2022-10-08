<?php include 'includes/headandnav.html.php'; ?>

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
							<img id="stealie" src="../public/images/camagruStealie.png" alt="StealieLogo">
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
<?php include 'includes/footer.html.php'; ?>
