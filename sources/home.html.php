<?php

session_start();

require_once '../config/dbConnect.php';

// include_once '../controllers/comments.php'

include_once '../controllers/likes.php';

include_once '../controllers/gallery.php';

include_once '../includes/headNav.html.php';




$next = 0;
$prev = 0;
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;

$pageMax = 6;

$imageTotal = count(getImages());
$totalPages = ceil($imageTotal / $pageMax);
$offset = ($page - 1) * $pageMax;
$start = ($page > 1) ? ($page * $pageMax) - $pageMax : 0;
$next = ($page < $totalPages) ? $page + 1 : 0;
$prev = ($page > 1) ? $page - 1 : 0;


if (!isset($_GET['page'])) {
	$page = 1;
}
if (!(int)$_GET['page']) {
	$page = 1;
}
if ($_GET['page'] < 1) {
	$page = 1;
}
if ($_GET['page'] > $totalPages) {
	$page = $totalPages;
}


?>


<section class="section">
	<?php if (empty($_SESSION['logged'])) : ?>
	<div class="notification is-warning">
		<p class="title is-4">WELCOME TO CAMAGRU</p>
		<p class="subtitle is-6">You are not logged in.</p>
		<p class="subtitle is-6">You can still view the gallery,
			but you will not be able to like or comment or post.</p>
		<p><a href="register.html.php">Register</a> to start sharing.</p>
	</div>
	<?php endif; ?>
	<div class="columns body-columns">
		<div class="column is-half is-offset-one-quarter">
			<h1 class="title is-1">Gallery</h1>

			<?php


			try {
				$conn = dbConnect();
				$stmt = $conn->query("SELECT * FROM images ORDER BY id_image DESC LIMIT $offset, $pageMax");
				$stmt->execute();
				$imageTotal = count(getImages());
				$totalPages = ceil($imageTotal / $pageMax);

				if ($stmt->execute() && $stmt->rowCount() > 0) {
					while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {

						$id_image = $row['id_image'];
						$id_user = $row['id_user'];
						$username = $row['username'];
						$date_added = $row['date_added'];
						$original_date = $date_added;
						$post_date = date("d-m-Y", strtotime($original_date));

						$imageURL = '../public/uploads/' . $row["image_name"];
			?>

			<div class="card mt-6">
				<div class="header">
					<div class="card-header-title">
						<h1 class="title is-4"><?php echo "@" . $username; ?></h1>
					</div>
				</div>
				<div class="card-image">
					<figure class="image is-4by3">
						<img src="<?php echo $imageURL; ?>" alt="" height="320" width="" />
					</figure>
				</div>
				<div class="card-content">
					<div class="level is-mobile">
						<div class="level-left">
							<?php if ($_SESSION['verified'] == "1") : ?>
							<div class="level-item has-text-centered">
								<div class="heart">
									<form id="<?php echo $id_image ?>" action="../controllers/likes.php" method="post">
										<?php if (checkLikes($id_image, $id_user)) : ?>
										<figure class="image is-32x32 is-clickable" title="Liked"
											id="<?php echo $id_image; ?>">
											<img data="<?php echo $id_image ?>"
												src="../public/icons/MaterialIcons/icons8-liked-50.png"
												id="like_post" />
											<input class="like_input" type="hidden" name="unlike"
												value="<?php echo $id_image ?>">
										</figure>
										<?php else : ?>
										<figure class="image is-32x32
												is-clickable" title="notLiked" id="<?php echo $id_image; ?>">
											<img data="<?php echo $id_image ?>"
												src="../public/icons/MaterialIcons/icons8-like-50.png" id="like_post" />
											<input class="like_input" type="hidden" name="like"
												value="<?php echo $id_image ?>">
										</figure>
										<?php endif; ?>
									</form>
								</div>
							</div>
							<?php endif; ?>
							<div class="level-item has-text-centered">
								<h1 class="title is-6 pl-1">
									<?php
												if (countLikes($id_image) < 1) {
													echo "";
												} elseif (countLikes($id_image) == 1) {
													echo countLikes($id_image) . " Like";
												} else {
													echo countLikes($id_image) . " Likes";
												}
												?>
								</h1>
							</div>
							<!--<div class="level-item has-text-centered">
								<div>
									<figure class="image is-32x32">
										<img src="../public/icons/MaterialIcons/icons8-comments-50.png" alt="Comment"
											title="Comment">
									</figure>
								</div>
							</div>-->
							<?php if ($row['id_user'] === $_SESSION['id_user']) : ?>
							<div id="deleteForm" class="level-item">
								<form action="../controllers/gallery.php" method="post">
									<button class="button is-ghost" type="submit" name="deleteButton" value="Delete"
										onClick="return confirmDelete()">
										<img class="image is-32x32"
											src="../public/icons/MaterialIcons/icons8-delete-50.png" width="25">
									</button>
									<input type="hidden" name="id_image" value=<?php echo $id_image; ?>>
								</form>
							</div>
							<?php endif; ?>
						</div>
						<div class="level-right">
							<div class="level-item has-text-centered">
								<h1 class="title is-6 has-text-right"><?php echo "Created: " . $post_date; ?></h1>
							</div>
						</div>
					</div>

					<div class="card-content is-scrollable">
						<div class="card-content">
							<?php
										$comments = getComments($id_image);
										foreach ($comments as $comment) {
										?>
							<div class="block">
								<p class="comment_username">
									<strong><?php echo $comment['username']; ?></strong>
								</p>
								<p class="comment_text">
									<?php echo $comment['comment']; ?>
								</p>
								<br>
							</div>
							<?php } ?>
						</div>
					</div>

				</div>
				<div class="card-content">
					<?php if (isset($_SESSION['logged'])) : ?>
					<form id="comment_<?php echo $id_image; ?>" class="field has-addons"
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
					</form>
					<?php endif; ?>
				</div>
			</div>
			<?php }
				} else { ?>
			<section class="block">
				<br>
				<p>No image(s) found...</p>
			</section>
			<?php }
			} catch (PDOException $e) {
				echo "Unable to connect to the database server: " . $e->getMessage() . " in " . $e->getFile() . ":" . $e->getLine();
				exit();
			}
			?>
		</div>
	</div>
</section>

<!-- pagination -->
<nav class="pagination level is-rounded mt-5" role="navigation">
	<div class="level-item has-text-centered">
		<?php
		if ($page < $totalPages && $page > 1) {
			echo '<a class="pagination-previous" href="home.html.php?page=' . $prev . '">' . 'Previous' . '</a>';

			echo '<a class="pagination-next" href="home.html.php?page=' . $next . '">' . 'Next' . '</a>';
		} elseif ($page > 1  && $page == $totalPages) {
			echo '<a class="pagination-previous" href="home.html.php?page=' . $prev . '">' . 'Previous' . '</a>';
		}
		if ($page === 1 && $totalPages > 1) {
			$next = $page + 1;
			echo '<a class="pagination-next" href="home.html.php?page=' . $next . '">' . 'Next' . '</a>';
		}
		?>
	</div>
</nav>


<script src="../public/scripts/gallery.js"></script>

<?php include_once '../includes/footer.html.php'; ?>