<?php

session_start();

include_once '../includes/headNav.html.php';
include_once '../controllers/gallery.php';

?>

<section class="section">
	<div class="notification is-info is-light pb-3">
		<button class="delete"></button>
		<div class="content">
			<h2>Webcam Guide</h2>
			<ul>
				<li class="is-size-4"><strong>1.</strong> Choose Sticker <strong>2.</strong> Take Picture
					<strong>3.</strong> Save Your Creation
				</li>
			</ul>
		</div>
	</div>
	<div class="card  pb-6 is-shadowless">
		<div class="container is-max-widescreen">
			<div class="columns is-centered py-5">
				<div class="column is-6 is-6-desktop is-6-widescreen">
					<div class="block">
						<!-- Nav tabs -->

						<input type="radio" id="camera" name="nav-tab">
						<input type="radio" id="upload" name="nav-tab">

						<div class="tabs is-centered">
							<ul>
								<li><label class="button is-same2 is-focused mb-2 mr-1"
										for="camera"><a><strong>Camera</strong></a></label>
								</li>

								<!--
								<li><label class="button is-same2 is-focused mb-2 ml-1"
										for="upload"><a><strong>Upload</strong></a></label>
								</li>
								 -->

							</ul>
						</div>

						<!-- Tab panes -->

						<div class="tab-content">
							<div class="tab-pane content-camera ">
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
												id="start">
												Start Camera
											</button>
										</p>
									</div>

									<div class="field is-grouped is-grouped-centered">
										<p class="control">
											<button
												class="button is-normal is-rounded is-different is-focused is-primary is-light is-responsive mt-2 is-inline-block is-hidden"
												id="snap">
												Capture
											</button>
										</p>
									</div>

									<div class="field is-grouped is-grouped-centered">
										<p class="control">
											<button
												class="button is-normal is-rounded is-same is-focused is-warning is-light is-responsive mt-2 is-inline-block is-hidden"
												id="clear">
												Clear
											</button>
										</p>
										<p class="control">
											<button
												class="button is-normal is-rounded is-same is-focused is-link is-light is-responsive mt-2 is-inline-block is-hidden"
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
								<form method="POST" action="" enctype="multipart/form-data">
									<div class="content" id="uploadForm">
										<div class="card-image p-3 is-hidden" id="uploadedDiv">
											<figure class="image is-4by3">
												<img id="uploadImage" alt="" src="" />
											</figure>
											<div id="canvasDiv2">
												<canvas class="is-hidden" id="uploadCanvas"></canvas>
											</div>

										</div>

										<div class="block">
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
												<p class="control">
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
																<option selected="selected" value="img1">Bolt
																</option>
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
														<input class="file-input" type="file" name="uploadImage"
															id="uploadImage" accept="image/png, image/jpg, image/jpeg">

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
								</form>
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
								<li><label class="button is-same2 is-focused mb-2 mr-1" for="library"><a><strong>Photo
												Library</strong></a></label>
								</li>
								<li><label class="button is-same2 is-focused mb-2 ml-1"
										for="stickers"><a><strong>Sticker
												Preview</strong></a></label>
								</li>
							</ul>
						</div>

						<!-- Tab panes -->
						<div class="tab-content">

							<div class="tab-pane content-library">
								<div class="content">
									<div class="card-content is-scrollable2">
										<figure class="postedImage">
											<?php
											$images = getImages();
											foreach ($images as $image) : ?>
											<?php
												if ($_SESSION['id_user'] == $image['id_user']) : {
														$imageName = $image['image_name']; ?>
											<img class="image is-128x128 mx-3 is-clickable postedImageImg"
												src=" ../public/uploads/<?php echo $imageName; ?>"
												id="<?php echo $imageName; ?>" alt="<?php echo $imageName; ?>">

											<?php } ?>
											<?php endif; ?>
											<?php endforeach; ?>
										</figure>
									</div>
								</div>

							</div>

							<div class="tab-pane content-stickers">
								<div class="content">
									<figure>
										<img src="../public/stickers/bolt.png" class="sticker frame is-white p-5"
											id="img1" alt="bolt">
										<img src="../public/stickers/stealie.png" class="sticker frame is-white p-5"
											id="img2" alt="stealie">
										<img src="../public/stickers/stealieBlank.png"
											class="sticker frame is-white p-5" id="img3" alt="stealieBlank">
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
	</div>
</section>


<script src="../public/scripts/camera.js"></script>

<script src="../public/scripts/gallery.js"></script>




<script>
// code to make checkboxes behave like radio buttons
function onlyOne(checkbox) {
	let checkboxes = document.getElementsByName('nav-tab1')
	checkboxes.forEach((item) => {
		if (item !== checkbox) item.checked = false
	})
}
</script>

<div id="myModal" class="modal">
	<div class="modal-background"></div>
	<div class="columns is-mobile is-centered">
		<div class="column is-half pt-6 mt-6">
			<p class="image">
				<img class="modal-content" id="myModalImage" alt="">
			</p>
		</div>
	</div>
	<button class="modal-close is-large" aria-label="close"></button>
</div>


<?php include_once '../includes/footer.html.php'; ?>