<?php

session_start();

require_once '../config/dbconnect.php';
include_once '../controllers/gallery.php';

include_once '../includes/headNav.html.php';



$images = getImages();


$conn = dbConnect();

if (isset($_GET['page']) && $_GET['page'] != "") {
	$page = $_GET['page'];
} else {
	$page = 1;
}

$pageMax = 5;
$pictures = ($page - 1) * $pageMax;
$next_page = $page + 1;
$prev_page = $page - 1;
$stmt = $conn->query("SELECT COUNT(*) FROM images");
$total_images = $stmt->fetchColumn();
$total_pages = ceil($total_images / $pageMax);

?>


<section class="section">
	<div class="columns body-columns">
		<div class="column is-half is-offset-one-quarter">

			<h1 class="title is-1">Gallery</h1>

			<?php





			$start = ($page - 1) * $pageMax;

			try {
				$conn = dbConnect();
				$stmt = $conn->prepare("SELECT * FROM images ORDER BY id_image DESC LIMIT $start, $pageMax");
				$stmt->execute();
				$numberResults = $stmt->rowCount();
				$numberPages = ceil($numberResults / $pageMax);
				if ($stmt->execute() && $stmt->rowCount() > 0) {
					while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
						$id_image = $row['id_image'];
						$id_user = $row['id_user'];
						$username = $row['username'];
						$date_added = $row['date_added'];
						$original_date = $date_added;
						$new_date = date("d-m-Y", strtotime($original_date));
						$image_count = $stmt->rowCount();



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
								<h1 class="title is-6 has-text-right"><?php echo $new_date; ?></h1>
							</div>
						</div>
					</div>

					<div class="content">
						<p>
							<strong>@balbaugh</strong>
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
			<div class="pagination">
				<a class="arrows" <?php if ($page > 1) {
										echo "href='?page_no=$prev_page'";
									} ?>> ⬅ </a>&nbsp&nbsp&nbsp&nbsp&nbsp
				<?php echo $page; ?>&nbsp&nbsp&nbsp&nbsp&nbsp
				<a class="arrows" <?php if ($page < $total_pages) {
										echo "href='?page_no=$next_page'";
									} ?>> ➡ </a>
			</div>
		</div>
	</div>
</section>


<?php include_once '../includes/footer.html.php'; ?>