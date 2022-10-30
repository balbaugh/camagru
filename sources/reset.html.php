<?php

session_start();

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
					<form class="box" id="resetForm" action="../controllers/reset.php" method="post">
						<figure class="image level is-mobile is-square">
							<img src="../public/logo/camagruStealie.png" alt="StealieLogo">
						</figure>
						<p class="is-size-6 has-text-info p-3">Enter your email, verification code and a new password to
							reset.</p>
						<div class="field pt-2">
							<label for="email" class="label">Email</label>
							<div class="control">
								<input class="input" type="email" name="email" id="email"
									placeholder="e.g. alex@example.com" required>
							</div>
						</div>
						<div class=" field">
							<label for="verify_token" class="label">Verification
								Token</label>
							<div class="control">
								<input class="input" type="text" name="verify_token" id="verify_token"
									placeholder="********" required>
							</div>
						</div>
						<div class=" field">
							<label for="password" class="label">Password</label>
							<div class="control">
								<input class="input" type="password" name="password" id="password"
									placeholder="********" required onChange="onChange();">
							</div>

							<strong>
								<h2 id="errorMessage" class="is-size-5 has-text-danger pt-2"></h2>
							</strong>
						</div>

						<div class=" field">
							<label for="confirmPassword" class="label">Confirm Password</label>
							<div class="control">
								<input class="input" type="password" name="confirmPassword" id="confirmPassword"
									placeholder="********" required onChange="onChange();">
							</div>
						</div>
						<div class="field pt-2">
							<div class="control">
								<button class="button is-primary is-fullwidth" type="submit" name="submitReset"
									id="submitReset">Reset Password
								</button>
							</div>
						</div>
					</form>
					<div class="box has-text-centered">
						Need an account? <a href="register.html.php">Register</a>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>

<script>
function onChange() {
	const password = document.querySelector('input[name=password]');
	const confirmPassword = document.querySelector('input[name=confirmPassword]');

	if (confirmPassword.value === password.value) {
		confirmPassword.setCustomValidity('');
	} else {
		confirmPassword.setCustomValidity('Passwords do not match');
	}
}
</script>

<?php include_once '../includes/footer.html.php'; ?>