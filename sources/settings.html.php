<?php

session_start();

include_once '../includes/headNav.html.php';

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
					<div class="box">
						<figure class="image level is-mobile is-square">
							<img src="../public/logo/camagruStealie.png" alt="StealieLogo">
						</figure>
						<form class="block" id="settingsForm" action="../controllers/settings.php" method="post">
							<label for="email" class="label">Change Email</label>
							<div class="field has-addons">
								<div class="control is-expanded">
									<input class="input" type="email" name="newEmail" id="newEmail"
										placeholder="e.g. alex@example.com">
								</div>
								<p class="control">
									<button class="button is-info" type="submit" name="changeEmail">
										Submit
									</button>
								</p>
							</div>
						</form>
						<form class="block" id="settingsForm" action="../controllers/settings.php" method="post">
							<label for="username" class="label">Change Username</label>
							<div class="field has-addons">
								<div class="control is-expanded">
									<input class="input" type="text" name="newUsername" id="newUsername"
										placeholder="Username">
								</div>
								<p class="control">
									<button class="button is-info" type="submit" name="changeUsername">
										Submit
									</button>
								</p>
							</div>
						</form>

						<form class="block" id="settingsForm" action="../controllers/settings.php" method="post">
							<label for="password" class="label">Change Password</label>
							<div class="control is-expanded">
								<input class="input" type="password" name="newPassword" id="newPassword"
									placeholder="New Password" onChange="onChange();">
							</div>
							<div class="field has-addons pt-2">
								<div class="control is-expanded">
									<input class="input" type="password" name="confirmPassword" id="confirmPassword"
										placeholder="Confirm New Password" onChange="onChange();">
								</div>
								<p class="control">
									<button class="button is-info" type="submit" name="changePassword">
										Submit
									</button>
								</p>
							</div>
						</form>
						<form class="block" id="settingsForm" action="../controllers/settings.php" method="post">
							<label for="notifications" class="label">Email Notifications</label>
							<div class="field has-addons">
								<div class="select is-fullwidth">
									<select name="newNotifications" id="newNotifications">
										<option value="1">Yes</option>
										<option value="0">No</option>
									</select>
								</div>
								<p class="control">
									<button class="button is-info" type="submit" name="changeNotifications">
										Submit
									</button>
								</p>
							</div>
						</form>
					</div>
					<div class="box has-text-centered">
						<form class="block" id="settingsForm" action="../controllers/settings.php" method="post">
							<div class="field">
								<div class="control">
									<button class="button is-danger is-fullwidth" type="submit" name="deleteAccount"
										id="deleteAccount" onClick="return confirmDelete()">Delete Account
									</button>
								</div>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>

<script>
// Delete Account Confirmation
function confirmDelete() {
	let confirm = window.confirm(" Are you sure you want to delete your account?");
	if (confirm) {
		return true;
	} else {
		return false;
	}
}

// Password Validation
function onChange() {
	const newPassword = document.querySelector('input[name=newPassword]');
	const confirmPassword = document.querySelector('input[name=confirmPassword]');

	if (confirmPassword.value === newPassword.value) {
		confirmPassword.setCustomValidity('');
	} else {
		confirmPassword.setCustomValidity('Passwords do not match');
	}
}
</script>

<?php include_once '../includes/footer.html.php'; ?>