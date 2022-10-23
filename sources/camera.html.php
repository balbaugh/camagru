<?php

session_start();

include_once '../includes/headNav.html.php';

?>

<section class="section">
	<div class="columns is-centered">
		<div class="column is-two-thirds">
			<div class="container is-fluid">

				<div class="block">
					<h2 class="has-text-centered">1. Choose A Sticker</h2>
					<h2 class="has-text-centered">2. Take a Picture</h2>
					<h2 class="has-text-centered">- OR -</h2>
					<h2 class="has-text-centered">2. Upload a Picture</h2>
					<h2 class="has-text-centered">3. Add a Description</h2>
					<h2 class="has-text-centered">4. Submit</h2>
				</div>

				<div id="stickerPanel" class="card mt-3">
					<header class="card-header">
						<h2 class="card-header-title">Sticker Examples</h2>
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
											id="img1" alt="bolt">
									</figure>
								</div>
							</div>
							<div class="tile is-parent">
								<div class="tile is-child is-1">
									<figure class="image is-128x128">
										<img src="../public/stickers/stealie.png" class="button sticker frame is-white"
											id="img2" alt="stealie">
									</figure>
								</div>
							</div>
						</div>
						<div class="tile is-ancestor">
							<div class="tile is-parent">
								<div class="tile is-child is-1">
									<figure class="image is-128x128">
										<img src="../public/stickers/stealieBlank.png"
											class="button sticker frame is-white" id="img3" alt="stealieBlank">
									</figure>
								</div>
							</div>
							<div class="tile is-parent">
								<div class="tile is-child is-1">
									<figure class="image is-128x128">
										<img src="../public/stickers/silent.png" class="button sticker frame is-white"
											id="img4" alt="stealie">
									</figure>
								</div>
							</div>
						</div>
					</div>
				</div>


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
								<div class="video-wrap">
									<video id="video" playsinline autoplay muted></video>
								</div>
								<div>
									<canvas class="" id="canvas"></canvas>
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

							<div class="field-group">
								<div class="field is-inline-block mt-2">
									<label class="label">Sticker Select</label>
									<div class="control">
										<div class="select is-primary is-small is-rounded m-2">
											<select id="mySelect">
												<option selected="selected" value="img0">None</option>
												<option value="img1">Bolt</option>
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

				<div id="uploadCard" class="card mt-3">
					<header class="card-header">
						<h2 class="card-header-title">Upload</h2>
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
							<div>
								<canvas class="" id="canvas2"></canvas>
							</div>
						</div>

						<!-- upload file to uploadedPhoto figure, then when capture is clicked, it will be saved to
						canvasUpload with the selected sticker and then saved to the database when save is clicked.
						?? include upload.js // upload.php ?? -->








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

						<div class="level">
							<div class="level-item">
								<div class="field is-inline-block mt-2">
									<label class="label">Sticker Select</label>
									<div class="control">
										<div class="select is-primary is-small is-rounded">
											<select id="mySelect2">
												<option selected="selected" value="img0">None</option>
												<option value="img1">Bolt</option>
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
										<img src="../public/stickers/stealie.png" class="button frame is-white"
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
<!-- <script src="../public/scripts/upload.js"></script> -->
<!-- <script src="../public/scripts/cameraOld.js"></script> -->