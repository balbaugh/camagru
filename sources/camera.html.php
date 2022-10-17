<?php include_once '../includes/headNav.html.php'; ?>

<section class="section">
	<div class="columns is-centered">
		<div class="column is-two-thirds">
			<div class="container is-fluid">

				<div id="webcamCard" class="card mt-2">
					<div class="block has-text-centered" id="captureImage">
						<header class="card-header">
							<h2 class="card-header-title">Camera</h2>
							<button class="card-header-icon card-toggle">
								<span class="icon">
									<img src="../public/icons/MaterialIcons/icons8-expand-arrow-48.png" alt="Open"
										title="Camera View">
								</span>
							</button>
						</header>
						<div class="card-content is-hidden" id="cameraView">
							<div id="videoStream" class="block">
								<video id="video" autoplay muted></video>
								<canvas id="canvas" hidden></canvas>
								<canvas id="canvasSticker" hidden></canvas>
								<div id="stickerOverlay" src="" hidden></div>
							</div>

							<div class="control">
								<button class="button is-normal is-fullwidth is-focused is-link is-light is-responsive"
									id="captureButton" type="submit">
									Start Camera
								</button>
							</div>

						</div>
					</div>
				</div>

				<div id="uploadCard" class="card mt-3">
					<header class="card-header">
						<h2 class="card-header-title">Upload Image</h2>
						<button class="card-header-icon card-toggle">
							<span class="icon">
								<img src="../public/icons/MaterialIcons/icons8-expand-arrow-48.png" alt="Options"
									title="More Options">
							</span>
						</button>
					</header>

					<div class="card-content is-hidden" id="uploadForm">
						<div class="card-image p-3" id="uploadedDiv">
							<figure class="image is-4by3">
								<img id="uploadedPhoto" alt="" src="" />
							</figure>
						</div>
						<div class="file is-normal is-boxed is-centered is-info" id="uploadButtonDiv">
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

				<div id="commentForm" class="card mt-2" hidden>
					<div class="field">
						<div class="control pt-3 px-5">
							<textarea class="input" id="imageDescription" type="text" name="imageDescription"
								placeholder="Image Description"></textarea>
						</div>
						<?php if (isset($_GET['comment_error'])) { ?>
						<p class="help is-danger">
							<?php echo $_GET['comment_error']; ?>
						</p>
						<?php } ?>
						<div class="control py-3 px-5">
							<button class="button is-normal is-fullwidth is-focused is-success is-light is-responsive"
								id="saveButton" type="submit">
								Save
							</button>
						</div>
					</div>
				</div>

				<div id="stickerPanel" class="card mt-3">
					<header class="card-header">
						<h2 class="card-header-title">Choose A Sticker</h2>
						<button class="card-header-icon card-toggle">
							<span class="icon">
								<img src="../public/icons/MaterialIcons/icons8-expand-arrow-48.png" alt="Options"
									title="More Options">
							</span>
						</button>
					</header>

					<div class="card-content is-hidden" id="stickerList">
						<div class="tile is-ancestor">
							<div class="tile is-parent">
								<div class="tile is-child is-1">
									<figure class="image is-128x128">
										<img src="../public/stickers/bolt.png" class="button sticker frame is-white"
											id="boltSticker">
									</figure>
								</div>
							</div>
							<div class="tile is-parent">
								<div class="tile is-child is-1">
									<figure class="image is-128x128">
										<img src="../public/stickers/camagruStealie.png"
											class="button sticker frame is-white" id="camagruSticker">
									</figure>
								</div>
							</div>
						</div>
						<div class="tile is-ancestor">
							<div class="tile is-parent">
								<div class="tile is-child is-1">
									<figure class="image is-128x128">
										<img src="../public/stickers/StealYourFaceEmpty.png"
											class="button sticker frame is-white" id="emptySticker">
									</figure>
								</div>
							</div>
							<div class="tile is-parent">
								<div class="tile is-child is-1">
									<figure class="image is-128x128">
										<img src="../public/stickers/SilentEmoji.png"
											class="button sticker stickerBottomRight is-white" id="silentSticker">
									</figure>
								</div>
							</div>
						</div>
					</div>
				</div>

				<div id="libraryPanel" class="card mt-3">
					<header class="card-header">
						<h2 class="card-header-title">Photo Library</h2>
						<button class="card-header-icon card-toggle">
							<span class="icon">
								<img src="../public/icons/MaterialIcons/icons8-expand-arrow-48.png" alt="Options"
									title="More Options">
							</span>
						</button>
					</header>

					<div class="card-content is-hidden" id="libraryList">
						<div class="tile is-ancestor">
							<div class="tile is-parent">
								<div class="tile is-child is-1">
									<figure class="image is-128x128">
										<img src="../public/stickers/bolt.png" class="button frame is-white" id="bolt">
									</figure>
								</div>
							</div>
							<div class="tile is-parent">
								<div class="tile is-child is-1">
									<figure class="image is-128x128">
										<img src="../public/stickers/camagruStealie.png" class="button frame is-white"
											id="camagru">
									</figure>
								</div>
							</div>
						</div>
					</div>
				</div>


			</div>
		</div>
	</div>
</section>
<?php include_once '../includes/footer.html.php'; ?>

<script src="../public/scripts/camera.js"></script>