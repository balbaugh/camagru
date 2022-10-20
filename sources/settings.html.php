<?php include_once '../includes/headNav.html.php'; ?>

<section class="is-relative section py-20 has-background-light">
	<div class="is-relative container">
		<div class="columns is-vcentered">
			<div class="column is-6 mb-8 mb-0-desktop">
				<h2 class="mb-10 title is-2">We steal your face right off of
					your head!</h2>
				<p class="is-size-5 has-text-grey-dark">Lorem ipsum dolor sit
					amet, consectetur adipiscing elit.</p>
			</div>
			<div class="column is-5">
				<div class="container p-6 px-10-desktop py-12-desktop">
					<form class="box" id="settings_form" action="../controllers/settings.php" method="post">
						<figure class="image level is-mobile is-square">
							<img src="../public/logo/camagruStealie.png" alt="StealieLogo">
						</figure>
						<div class="field">
							<label for="email" class="label">Change Email</label>
							<div class="control">
								<input class="input" type="email" name="email" id="email"
									placeholder="e.g. alex@example.com" required>
							</div>
							<?php if (isset($_GET['email_error'])) { ?>
							<p class="help is-danger"><?php echo $_GET['email_error']; ?> </p>
							<?php } ?>
						</div>

						<div class="field">
							<label for="username" class="label">Change Username</label>
							<div class="control">
								<input class="input" type="text" name="username" id="username" placeholder="Username"
									required>
							</div>
							<?php if (isset($_GET['username_error'])) { ?>
							<p class="help is-danger"><?php echo $_GET['username_error']; ?> </p>
							<?php } ?>
						</div>

						<div class="field">
							<label for="password" class="label">Change Password</label>
							<div class="control">
								<input class="input" type="password" name="password" id="password"
									placeholder="********" required>
							</div>
							<?php if (isset($_GET['password_error'])) { ?>
							<p class="help is-danger"><?php echo $_GET['password_error']; ?> </p>
							<?php } ?>
						</div>

						<div class="field">
							<label for="notifications" class="label">Notifications</label>
							<div class="control">
								<label class="checkbox">
									<input type="checkbox" name="notifications" id="notifications" checked>
									Receive Notification Emails
								</label>
							</div>
						</div>

						<div class="field">
							<div class="control">
								<button class="button is-primary is-fullwidth" type="submit" name="submit_registration"
									id="submit_registration">Submit
								</button>
							</div>
						</div>
					</form>
					<div class="box has-text-centered">
						<div class="field">
							<div class="control">
								<button class="button is-danger is-fullwidth" type="submit" name="submit_settings"
									id="submit_settings">Delete Account
								</button>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>
<?php include_once '../includes/footer.html.php'; ?>