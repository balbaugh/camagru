<?php

if (session_status() === PHP_SESSION_NONE) {
	session_start();
}

include_once '../includes/headNavHome.html.php';

?>

<section class="is-relative section py-20">
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
					<form class="box box-settings is-shadowless" id="forgotForm" action="../controllers/reset.php"
						method="post">
						<figure class="image level is-mobile is-square">
							<img src="../public/logo/camagruStealie.png" alt="StealieLogo">
						</figure>
						<p class="is-size-6 has-text-info p-3">Enter your
							email so that we can send you a verification
							code to reset your password.</p>
						<div class="field pt-2">
							<label for="email" class="label">Email</label>
							<div class="control">
								<input class="input" type="email" name="email" id="email" autocomplete="email"
									placeholder="e.g. alex@example.com" required>
							</div>
						</div>
						<div class="field pt-2">
							<div class="control">
								<button class="button is-primary is-fullwidth" type="submit" name="submitForgot"
									id="submitForgot">Reset Password
								</button>
							</div>
						</div>
					</form>
					<div class="box box-settings is-shadowless has-text-centered">
						Need an account? <a href="register.html.php">Register</a>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>
<?php include_once '../includes/footer.html.php'; ?>