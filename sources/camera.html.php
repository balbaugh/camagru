<?php

session_start();

include_once '../includes/headNav.html.php';
include_once '../controllers/gallery.php';

?>

<section class="section">
	<div class="container is-max-widescreen">
		<div class="block is-centered">
			<h2 class="has-text-centered">1. Choose A Sticker</h2>
			<h2 class="has-text-centered">2. Take a Picture</h2>
			<h2 class="has-text-centered">- OR -</h2>
			<h2 class="has-text-centered">2. Upload a Picture</h2>
			<h2 class="has-text-centered">3. Add a Description</h2>
			<h2 class="has-text-centered">4. Submit</h2>
		</div>
		<div class="columns is-centered">
			<div class="column is-6 is-6-desktop is-6-widescreen">
				<div class="block">
					<!-- Nav tabs -->
					<input type="radio" id="camera" name="nav-tab">
					<input type="radio" id="upload" name="nav-tab">

					<div class="tabs is-centered">
						<ul>
							<li><label for="camera"><a>Camera</a></label></li>
							<li><label for="upload"><a>Upload</a></label></li>
						</ul>
					</div>

					<!-- Tab panes -->
					<div class="tab-content">
						<div class="tab-pane content-camera">
							<div class="content mt-2" id="cameraView">
								<div id="videoStream" class="block">
									<div class="video-wrap">
										<video id="video" playsinline autoplay muted></video>
									</div>
									<div id="canvasDiv">
										<canvas class="is-hidden" id="canvas"></canvas>
									</div>
								</div>

								<div class="field is-grouped is-grouped-centered">
									<p class="control">
										<button
											class="button is-normal is-rounded is-different is-focused is-primary is-light is-responsive mt-2 is-inline-block"
											id="snap">
											Capture
										</button>
									</p>
								</div>

								<div class="field is-grouped is-grouped-centered">
									<p class="control">
										<button
											class="button is-normal is-rounded is-same is-focused is-warning is-light is-responsive mt-2 is-inline-block"
											id="clear">
											Clear
										</button>
									</p>
									<p class="control" action="">
										<button
											class="button is-normal is-rounded is-same is-focused is-link is-light is-responsive mt-2 is-inline-block"
											id="save" type="submit">
											Save
										</button>
									</p>
								</div>

								<div class="level">
									<div class="level-item">
										<div class="field is-inline-block mt-2">
											<label class="label">Sticker Select</label>
											<div class="control">
												<div class="select is-primary is-small is-rounded">
													<select id="mySelect">
														<!-- <option selected="selected" value="img0">None</option> -->
														<option selected="selected" value="img1">Bolt</option>
														<option value="img2">Stealie</option>
														<option value="img3">Stealie Blank</option>
														<option value="img4">Silent Emoji</option>
													</select>
												</div>
											</div>
										</div>
									</div>
								</div>

							</div>
						</div>

						<div class="tab-pane content-upload">
							<div class="content" id="uploadForm">
								<div class="card-image p-3 is-hidden" id="uploadedDiv">
									<figure class="image is-4by3">
										<img id="uploadedPhoto" alt="" src="" />
									</figure>
									<div id="canvasDiv2">
										<canvas class="is-hidden" id="canvas2"></canvas>
									</div>
								</div>

								<div class="block is-hidden">
									<div class="field is-grouped is-grouped-centered">
										<p class="control">
											<button
												class="button is-normal is-rounded is-different is-focused is-primary is-light is-responsive mt-2 is-inline-block"
												id="snap2">
												Capture
											</button>
										</p>
									</div>

									<div class="field is-grouped is-grouped-centered">
										<p class="control">
											<button
												class="button is-normal is-rounded is-same is-focused is-warning is-light is-responsive mt-2 is-inline-block"
												id="clear2">
												Clear
											</button>
										</p>
										<p class="control" action="">
											<button
												class="button is-normal is-rounded is-same is-focused is-link is-light is-responsive mt-2 is-inline-block"
												id="save2" type="submit">
												Save
											</button>
										</p>
									</div>
								</div>

								<div class="level">
									<div class="level-item">
										<div class="field is-inline-block mt-2">
											<label class="label">Sticker Select</label>
											<div class="control">
												<div class="select is-primary is-small is-rounded">
													<select id="mySelect2">
														<option selected="selected" value="img1">Bolt</option>
														<option value="img2">Stealie</option>
														<option value="img3">Stealie Blank</option>
														<option value="img4">Silent Emoji</option>
													</select>
												</div>
											</div>
										</div>
									</div>
									<div class="level-item">
										<div class="file is-small is-boxed is-info mt-5" id="uploadButtonDiv">
											<label class="file-label">
												<input class="file-input" type="file" name="Upload" id="uploadImage"
													accept="image/png, image/jpg">
												<span class="file-cta">
													<span class="file-label" id="uploadButton">
														Choose File
													</span>
												</span>
											</label>
										</div>
									</div>
								</div>

							</div>
						</div>
					</div>
				</div>
			</div>

			<div class="column is-6 is-6-desktop is-6-widescreen">
				<div class="block">
					<!-- Nav tabs -->
					<input type="checkbox" id="library" name="nav-tab1" onclick="onlyOne(this)">
					<input type="checkbox" id="stickers" name="nav-tab1" onclick="onlyOne(this)">

					<div class="tabs is-centered">
						<ul>
							<li><label for="library"><a>Photo Library</a></label></li>
							<li><label for="stickers"><a>Sticker Preview</a></label></li>
						</ul>
					</div>

					<!-- Tab panes -->
					<div class="tab-content">

						<div class="tab-pane content-library">
							<div class="content">
								<figure>
									<?php
									$images = getImages();
									foreach ($images as $image) : ?>
									<?php
										if ($_SESSION['id_user'] == $image['id_user']) : ?>
									<img src="../public/uploads/<?php echo $image['image_name']; ?>"
										alt="<?php echo $image['image_name']; ?>"
										class="image is-128x128 p-4 js-modal-trigger" data-target="modal-js">
									<?php endif; ?>
									<?php endforeach; ?>
								</figure>
							</div>

						</div>

						<div class="tab-pane content-stickers">
							<div class="content">
								<figure>
									<img src="../public/stickers/bolt.png" class="sticker frame is-white p-5" id="img1"
										alt="bolt">
									<img src="../public/stickers/stealie.png" class="sticker frame is-white p-5"
										id="img2" alt="stealie">
									<img src="../public/stickers/stealieBlank.png" class="sticker frame is-white p-5"
										id="img3" alt="stealieBlank">
									<img src="../public/stickers/silent.png" class="sticker frame is-white p-5"
										id="img4" alt="stealie">
								</figure>
							</div>
						</div>
					</div>
				</div>
			</div>

		</div>
	</div>
</section>


<script src="../public/scripts/camera.js"></script>
<!-- <script src="../public/scripts/upload.js"></script> -->
<!-- <script src="../public/scripts/cameraOld.js"></script> -->

<script>
// code to make checkboxes behave like radio buttons
function onlyOne(checkbox) {
	var checkboxes = document.getElementsByName('nav-tab1')
	checkboxes.forEach((item) => {
		if (item !== checkbox) item.checked = false
	})
}
</script>

<div id="modal-js" class="modal">
	<div class="modal-background"></div>
	<img class="modal-content image is-1by1" id="img01">
	<button class="modal-close is-large" aria-label="close"></button>
</div>





<?php include_once '../includes/footer.html.php'; ?>


<!--
upload file to uploadedPhoto figure, then when capture is clicked, it will be saved to
canvasUpload with the selected sticker and then saved to the database when save is clicked.
?? include upload.js // upload.php ?? -->