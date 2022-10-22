<?php

session_start();

require_once '../config/dbconnect.php';


/* if (!isset($_SESSION['id_user'])) {
	header('location:login.html.php');
} else {
	// save the user_id into a variable
	$id_user = $_SESSION['id_user'];
	$logged_user = $_SESSION['username'];
}
 */

/*
$username = $_SESSION['username'];
$stmt = $conn->prepare("SELECT * FROM images ORDER BY id_image DESC");
$stmt->execute();
 */
?>

<?php include_once '../includes/headNavHome.html.php'; ?>

<body>

	<div class="columns body-columns">
		<div class="column is-half is-offset-one-quarter">
			<div class="card">
				<div class="header">
					<div class="media">
						<div class="media-left">
							<figure class="image is-48x48">
								<img src="https://source.unsplash.com/random/96x96" alt="Placeholder image">
							</figure>
						</div>
						<div class="media-content">
							<p class="title is-4">John Smith</p>
							<p class="subtitle is-6">@johnsmith</p>
						</div>
					</div>
				</div>
				<div class="card-image">
					<figure class="image is-4by3">
						<img src="https://source.unsplash.com/random/1280x960" alt="Placeholder image">
					</figure>
				</div>
				<div class="card-content">
					<div class="level is-mobile">
						<div class="level-left">
							<?php if ($liked) : ?>
							<div class="level-item has-text-centered">
								<div>
									<a href="">
										<img src="../public/icons/MaterialIcons/icons8-heart-50.png" alt="Liked"
											title="Liked">
									</a>
								</div>
							</div>
							<?php else : ?>
							<div class="level-item has-text-centered">
								<div>
									<a href="">
										<img src="../public/icons/MaterialIconsGray/icons8-heart-50.png" alt="Like"
											title="Like">
									</a>
								</div>
							</div>
							<?php endif; ?>
							<div class="level-item has-text-centered">
								<div>
									<a href="">
										<img src="../public/icons/MaterialIconsGray/icons8-chat-bubble-50.png"
											alt="Like" title="Like">
									</a>
								</div>
							</div>
						</div>
					</div>

					<div class="content">
						<p>
							<strong>32 Likes</strong>
						</p>
						Lorem ipsum dolor sit amet, consectetur adipiscing elit. Phasellus nec iaculis mauris.
						<a>@bulmaio</a>.
						<a href="#">#css</a>
						<a href="#">#responsive</a>
						<br>
						<time datetime="2018-1-1">11:09 PM - 1 Jan 2018</time>
					</div>
				</div>
				<div class="card-footer">
					<div class="columns is-mobile">
						<div class="column is-11">
							<div class="field">
								<div class="control">
									<input class="input is-medium" type="text" placeholder="Add a comment . . .">
								</div>
							</div>
						</div>
						<div class="level-item has-text-centered">
							<div>
								<a href="">
									<img src="../public/icons/MaterialIconsGray/icons8-email-send-50.png" alt="Comment"
										title="Comment">
								</a>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<?php include_once '../includes/footer.html.php'; ?>