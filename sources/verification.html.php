<?php

if (session_status() === PHP_SESSION_NONE) {
	session_start();
}

if (isset($_SESSION["logged"]) && $_SESSION["logged"] === true) {
	header('Location: ../index.php');
}

include_once '../includes/headNavOut.html.php';

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
					<form class="box box-settings is-shadowless" id="verification_form"
						action="../controllers/verification.php" method="post">
						<figure class="image level is-mobile is-square">
							<img src="../public/logo/camagruStealie.png" alt="StealieLogo">
						</figure>
						<div class="field">
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
								<input class="input" type="password" name="verify_token" id="verify_token"
									placeholder="********" required>
							</div>
						</div>
						<div class="field">
							<div class="control">
								<button class="button is-primary is-fullwidth" type="submit" name="submit_verification"
									id="submit_verification">Submit
								</button>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
</section>

<?php include_once '../includes/footer.html.php'; ?>