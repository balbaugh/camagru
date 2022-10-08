<?php
require_once 'security.php';
require_once '../config/database.php';

$conn = dbConnect();
$images_directory = '../photos';
$sql = 'SELECT image_path FROM user_images';
$result = $conn->query($sql);
$numRows = $result->rowCount();
?>

<?php
foreach ($conn->query as $row) { ?>
<div><?= safe($row['filename']) ?></div>
<?php }
?>

<!DOCTYPE html>
<html>

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>camagru</title>
	<link rel="stylesheet" href="../styles/bulma.min.css">
</head>

<body>
	<nav class="navbar has-shadow">

		<div class="navbar-brand">
			<a class="navbar-item">
				<img src="../images/StealYourFace.png" alt="">
			</a>
			<div class="navbar-start">
				<div class="navbar-item">
					<small>Steal your face with <strong>Camagru</strong>!</small>
				</div>
			</div>
			<div class="navbar-burger burger" data-target="navMenu">
				<span></span>
				<span></span>
				<span></span>
			</div>
		</div>

		<div id="navMenu" class="navbar-menu">
			<div class="navbar-end">
				<div class="navbar-item has-dropdown is-hoverable">
					<div class="navbar-link">
						<small><strong>Menu</strong></small>
					</div>
					<div class="navbar-dropdown">
						<a class="navbar-item">
							<div class="level-item">
								<span class="icon is-small">
									<img src="../images/home.svg">
								</span>
								</br>Home
							</div>
						</a>
						<a class="navbar-item">
							<div class="level-item">
								<span class="icon is-small">
									<img src="../images/user.svg">
								</span>
								</br>Profile
							</div>
						</a>
						<a class="navbar-item">
							<div class="level-item">
								<span class="icon is-small">
									<img src="../images/logout.svg">
								</span>
								</br>Logout
							</div>
						</a>
					</div>
				</div>
			</div>
		</div>
	</nav>


	<section class="section has-background-light">
		<div class="container">
			<h2 class="title mb-16 mb-24-tablet">Gallery</h2>
			<div class="has-mw-4xl mx-auto">
				<div class="mb-14 columns is-multiline -mx-6 -mt-6">
					<div class="column is-6-tablet">
						<div class="m-6-tablet has-background-white is-relative">
							<span class="is-absolute is-top-0 is-left-0 ml-4 mt-4 tag is-info has-text-weight-bold"
								style="z-index: 10;">NEW</span>
							<div class="card-image">
								<a href="#">
									<img class="image mx-auto" style="height: 296px;" src="../photos/boat.png" alt="">
								</a>
							</div>
							<div class="card-content pt-8 px-6 pb-6">
								<div class="content" href="">
									<a class="mb-2 px-6 is-block" href="#">
										<h5 class="mb-2">Compac 16</h5>
									</a>
								</div>
								<article class="media">
									<div class="media-content">
										<div class="field">
											<p class="control">
												<textarea class="textarea"
													placeholder="What are you thinking....post here"></textarea>
											</p>
										</div>
										<div class="field">
											<p class="control has-text-right">
												<button class="button is-small is-info">Add Comment</button>
											</p>
										</div>
									</div>
								</article>
								<br>
								</article>
							</div>
						</div>
					</div>
					<div class="column is-6-tablet">
						<div class="m-6-tablet has-background-white is-relative">
							<span class="is-absolute is-top-0 is-left-0 ml-4 mt-4 tag is-danger has-text-weight-bold"
								style="z-index: 10;">NEW</span>
							<div class="card-image">
								<a href="#">
									<img class="image mx-auto" style="height: 296px;" src="../photos/meSauna.png"
										alt="">
								</a>
							</div>
							<div class="card-content pt-8 px-6 pb-6">
								<div class="content" href="">
									<a class="mb-2 px-6 is-block" href="#">
										<h5 class="mb-2">Sauna Time</h5>
									</a>
								</div>
								<article class="media">
									<div class="media-content">
										<div class="field">
											<p class="control">
												<textarea class="textarea"
													placeholder="What are you thinking....post here"></textarea>
											</p>
										</div>
										<div class="field">
											<p class="control has-text-right">
												<button class="button is-small is-info">Add Comment</button>
											</p>
										</div>
									</div>
								</article>
								<br>
								</article>
							</div>
						</div>
					</div>
					<div class="column is-6-tablet">
						<div class="m-6-tablet has-background-white is-relative">
							<span class="is-absolute is-top-0 is-left-0 ml-4 mt-4 tag is-danger has-text-weight-bold"
								style="z-index: 10;">NEW</span>
							<div class="card-image">
								<a href="#">
									<img class="image mx-auto" style="height: 296px;" src="../photos/stealalbum.png"
										alt="">
								</a>
							</div>
							<div class="card-content pt-8 px-6 pb-6">
								<div class="content" href="">
									<a class="mb-2 px-6 is-block" href="#">
										<h5 class="mb-2">Steal your face!</h5>
									</a>
								</div>
								<article class="media">
									<div class="media-content">
										<div class="field">
											<p class="control">
												<textarea class="textarea"
													placeholder="What are you thinking....post here"></textarea>
											</p>
										</div>
										<div class="field">
											<p class="control has-text-right">
												<button class="button is-small is-info">Add Comment</button>
											</p>
										</div>
									</div>
								</article>
								<br>
								</article>
							</div>
						</div>
					</div>
					<div class="column is-6-tablet">
						<div class="m-6-tablet has-background-white is-relative">
							<span class="is-absolute is-top-0 is-left-0 ml-4 mt-4 tag is-danger has-text-weight-bold"
								style="z-index: 10;">NEW</span>
							<div class="card-image">
								<a href="#">
									<img class="image mx-auto" style="height: 296px;" src="../photos/can.png" alt="">
								</a>
							</div>
							<div class="card-content pt-8 px-6 pb-6">
								<div class="content" href="">
									<a class="mb-2 px-6 is-block" href="#">
										<h5 class="mb-2">Holger</h5>
									</a>
								</div>
								<article class="media">
									<div class="media-content">
										<div class="field">
											<p class="control">
												<textarea class="textarea"
													placeholder="What are you thinking....post here"></textarea>
											</p>
										</div>
										<div class="field">
											<p class="control has-text-right">
												<button class="button is-small is-info">Add Comment</button>
											</p>
										</div>
									</div>
								</article>
								<br>
								</article>
							</div>
						</div>
					</div>
				</div>
				<div class="has-text-centered"><a class="button is-info" href="#">Show More</a></div>
			</div>
		</div>
	</section>


	<section class="footer">
		<div class="content has-text-centered">
			<p>
				<strong>Camagru</strong> by <a href=" ">balbaugh</a>.
			</p>
		</div>
	</section>
</body>

</html>





<!--
// Template header; feel free to customize it, but do not indent the PHP code or it will throw an error
function template_header($title) {
echo <<<EOT
<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<title>$title</title>
		<link href="style.css" rel="stylesheet" type="text/css">
		<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css">
	</head>
	<body>
    <nav class="navtop">
    	<div>
    		<h1>Gallery System</h1>
            <a href="index.php"><i class="fas fa-image"></i>Gallery</a>
    	</div>
    </nav>
EOT;
}



// Template footer
function template_footer() {
echo <<<EOT
    </body>
</html>
EOT;
}
?>


<?= template_header('Gallery') ?>

<div class="content home">
	<h2>Gallery</h2>
	<p>Welcome to the gallery page! You can view the list of uploaded images below.</p>
	<a href="upload.php" class="upload-image">Upload Image</a>
	<div class="images">
		<?php foreach ($images as $image) : ?>
		<?php if (file_exists($image['filepath'])) : ?>
		<a href="#">
			<img src="<?= $image['filepath'] ?>" alt="<?= $image['description'] ?>" data-id="<?= $image['id'] ?>" data-title="<?= $image['title'] ?>" width="300" height="200">
			<span><?= $image['description'] ?></span>
		</a>
		<?php endif; ?>
		<?php endforeach; ?>
	</div>
</div>
<div class="image-popup"></div>
<script>
// Container we'll use to output the image
let image_popup = document.querySelector('.image-popup');
// Iterate the images and apply the onclick event to each individual image
document.querySelectorAll('.images a').forEach(img_link => {
	img_link.onclick = e => {
		e.preventDefault();
		let img_meta = img_link.querySelector('img');
		let img = new Image();
		img.onload = () => {
			// Create the pop out image
			image_popup.innerHTML = `
				<div class="con">
					<h3>${img_meta.dataset.title}</h3>
					<p>${img_meta.alt}</p>
					<img src="${img.src}" width="${img.width}" height="${img.height}">
					<a href="delete.php?id=${img_meta.dataset.id}" class="trash" title="Delete Image"><i class="fas fa-trash fa-xs"></i></a>
				</div>
			`;
			image_popup.style.display = 'flex';
		};
		img.src = img_meta.src;
	};
});
// Hide the image popup container, but only if the user clicks outside the image
image_popup.onclick = e => {
	if (e.target.className == 'image-popup') {
		image_popup.style.display = "none";
	}
};
</script>
<?= template_footer() ?> -->