<?php

session_start();

require_once '../config/dbconnect.php';

// include_once '../controllers/comments.php';

include_once '../controllers/gallery.php';

include_once '../includes/headNav.html.php';



$conn = dbConnect();

$next = 0;
$prev = 0;
$page = 1;
$pageMax = 5;

$imageTotal = count(getImages());
$totalPages = ceil($imageTotal / $pageMax);

if (isset($_GET['page'])) {
	$page = intval($_GET['page']);
	$next = $page + 1;
	$prev = $page - 1;

	if ($page > $totalPages && $next > $totalPages) {
		$page = $totalPages;
		$next = $page;
		$prev = $page - 1;
	} elseif ($page < 1) {
		$page = 1;
		$next = $page + 1;
	}
}

$offset = ($page - 1) * $pageMax;

$images = getGallery($offset, $pageMax);





?>


<section class="section">
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
							<?php if ($liked) : ?>
							<div class="level-item has-text-centered">
								<div>
									<a href="">
										<img src="../public/icons/MaterialIcons/icons8-liked-50.png" alt="Liked"
											title="Liked">
									</a>
								</div>
							</div>
							<?php else : ?>
							<div class="level-item has-text-centered">
								<div>
									<a href="">
										<img src="../public/icons/MaterialIcons/icons8-like-50.png" alt="Like"
											title="Like">
									</a>
								</div>
							</div>
							<?php endif; ?>
							<div class="level-item has-text-centered">
								<div>
									<a href="">
										<img src="../public/icons/MaterialIcons/icons8-comments-50.png" alt="Comment"
											title="Comment">
									</a>
								</div>
							</div>
						</div>
						<div class="level-right">
							<div class="level-item has-text-centered">
								<h1 class="title is-6 has-text-right"><?php echo $post_date; ?></h1>
							</div>
						</div>
					</div>
					<div class="card-content is-scrollable">
						<div class="card-content">
							<p>
								<strong>@balbaugh</strong>
							</p>
							Lorem ipsum dolor sit amet, consectetur adipiscing elit. Phasellus nec iaculis mauris.

							<br>
							<time datetime="2018-1-1">11:09 PM - 1 Jan 2018</time>
						</div>
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
								<button class="button is-primary" href="">
									Submit
								</button>
							</div>
						</div>
					</div>
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
<nav class="pagination level is-rounded mt-5" role="navigation">
	<div class="level-item has-text-centered">
		<?php
		if ($page < $totalPages && $page > 1) {
			echo '<a class="pagination-previous" href="home.html.php?page=' . $prev . '">' . 'Previous' . '</a>';

			echo '<a class="pagination-next" href="home.html.php?page=' . $next . '">' . 'Next' . '</a>';
		} elseif ($page == $totalPages && $page > 1) {
			echo '<a class="pagination-previous" href="home.html.php?page=' . $prev . '">' . 'Previous' . '</a>';
		}
		if ($page == 1 && $totalPages != 1) {
			$next = $page + 1;
			echo '<a class="pagination-next" href="home.html.php?page=' . $next . '">' . 'Next' . '</a>';
		}
		?>
	</div>
</nav>

<?php include_once '../includes/footer.html.php'; ?>