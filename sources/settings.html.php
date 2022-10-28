<?php

session_start();

include_once '../includes/headNav.html.php';

?>

<?php if (isset($_GET['success'])) { ?>
<p class="help is-success"><?php echo $_GET['success']; ?> </p>
<?php } ?>

<?php if (isset($_GET['error'])) { ?>
<p class="help is-success"><?php echo $_GET['error']; ?> </p>
<?php } ?>

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
					<!-- <form id="comment_<?php echo $id_image; ?>" class="field has-addons"
						action="../controllers/comments.php" method="post">
						<div class="control is-expanded">
							<label for="comment">
								<input id="postComment" name="postComment" class="input" type="text"
									placeholder="Add a comment . . .">
								<input type="hidden" name="id_image" value="<?php echo $id_image; ?>">
							</label>
						</div>
						<p class="control">
							<button data="<?php echo $id_image; ?>" class="comment-icon button is-info" id="commentBtn"
								type="submit">
								Submit
							</button>
						</p>
					</form> -->
					<form class="box" id="settingsForm" action="../controllers/settings.php" method="post">
						<figure class="image level is-mobile is-square">
							<img src="../public/logo/camagruStealie.png" alt="StealieLogo">
						</figure>
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

						<label for="password" class="label">Change Password</label>
						<div class="field has-addons">
							<div class="control is-expanded">
								<input class="input" type="password" name="newPassword" id="newPassword"
									placeholder="********">
							</div>
							<p class="control">
								<button class="button is-info" type="submit" name="changePassword">
									Submit
								</button>
							</p>
						</div>

						<label for="notifications" class="label">Notifications Preference</label>
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
					<div class="box has-text-centered">
						<div class="field">
							<div class="control">
								<button class="button is-danger is-fullwidth" type="submit" name="deleteAccount"
									id="deleteAccount">Delete Account
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