<?php
require_once 'security.php';

// $conn = dbConnect('pdo');
?>

<!DOCTYPE html>
<html>

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Camagru</title>
	<link rel="stylesheet" href="../../public/styles/bulma.css">
</head>

<body>
	<nav class="navbar has-shadow">

		<div class="navbar-brand">
			<a class="navbar-item">
				<img src="../public/images/camagruText.png" alt="">
			</a>
			<div class="navbar-start">
				<div class="navbar-item">

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
				<div class="navbar-item">
					<div class="field is-grouped">
						<a class="navbar-item">
							<div class="level-item">
								<span class="icon is-medium">
									<img src="../public/images/MaterialIconsGray/icons8-home-50.png" alt="Home">
								</span>
								</br>
							</div>
						</a>
						<a class="navbar-item">
							<div class="level-item">
								<span class="icon is-medium">
									<img src="../public/images/MaterialIconsGray/icons8-user-50.png" alt="Profile">
								</span>
								</br>
							</div>
						</a>
						<a class="navbar-item">
							<div class="level-item">
								<span class="icon is-medium">
									<img src="../public/images/MaterialIcons/icons8-add-50.png" alt="Post">
								</span>
								</br>
							</div>
						</a>
						<a class="navbar-item">
							<div class="level-item">
								<span class="icon is-medium">
									<img src="../public/images/MaterialIconsGray/icons8-logout-50.png" alt="Logout">
								</span>
								</br>
							</div>
						</a>
					</div>
				</div>
			</div>
		</div>
	</nav>

	<section class="section">
		<div class="container">
			<div class="columns">
				<div class="column is-3">
					<label class="label has-text-centered">Controls</label>
					<button class="button is-fullwidth">Filters</button>
					</br>
					<button class="button is-fullwidth">Stickers</button>
					</br>
					<button class="button is-fullwidth">Save</button>
					</br>
					<button class="button is-fullwidth">Upload</button>
					</br>
					<button class="button is-fullwidth">Download</button>
					</br>
					<button class="button is-fullwidth">Delete</button>
				</div>
				<div class="column is-5">
					<div class="box">
						<label class="label has-text-centered">Camera</label>
						<div class="camera">
							<video id="video">Video stream not available.</video>
						</div>
						<div class="controls">
							<button class="button is-fullwidth" id="startbutton">Capture</button>
						</div>
					</div>
					<div class="box">
						<canvas id="canvas">
							<div class="output">
								<img id="photo" alt="The screen capture will appear in this box.">
							</div>
						</canvas>
					</div>
				</div>
				<div class="column is-3">
					<label class="label has-text-centered">Photos</label>
					<img src="../public/images/bolt.png">
				</div>
			</div>
		</div>
	</section>
	<section class="footer">
		<div class="content has-text-centered">
			<p>
				&#169 2022 <strong>camagru</strong> from <a href="https://balbaugh.com">balbaugh</a>
			</p>
		</div>
	</section>
</body>
<script>
(function() {
	// The width and height of the captured photo. We will set the
	// width to the value defined here, but the height will be
	// calculated based on the aspect ratio of the input stream.

	var width = 420; // We will scale the photo width to this
	var height = 0; // This will be computed based on the input stream

	// |streaming| indicates whether or not we're currently streaming
	// video from the camera. Obviously, we start at false.

	var streaming = false;

	// The various HTML elements we need to configure or control. These
	// will be set by the startup() function.

	var video = null;
	var canvas = null;
	var photo = null;
	var startbutton = null;

	function showViewLiveResultButton() {
		if (window.self !== window.top) {
			// Ensure that if our document is in a frame, we get the user
			// to first open it in its own tab or window. Otherwise, it
			// won't be able to request permission for camera access.
			document.querySelector(".contentarea").remove();
			const button = document.createElement("button");
			button.textContent = "View live result of the example code above";
			document.body.append(button);
			button.addEventListener('click', () => window.open(location.href));
			return true;
		}
		return false;
	}

	function startup() {
		if (showViewLiveResultButton()) {
			return;
		}
		video = document.getElementById('video');
		canvas = document.getElementById('canvas');
		photo = document.getElementById('photo');
		startbutton = document.getElementById('startbutton');

		navigator.mediaDevices.getUserMedia({
				video: true,
				audio: false
			})
			.then(function(stream) {
				video.srcObject = stream;
				video.play();
			})
			.catch(function(err) {
				console.log("An error occurred: " + err);
			});

		video.addEventListener('canplay', function(ev) {
			if (!streaming) {
				height = video.videoHeight / (video.videoWidth / width);

				// Firefox currently has a bug where the height can't be read from
				// the video, so we will make assumptions if this happens.

				if (isNaN(height)) {
					height = width / (4 / 3);
				}

				video.setAttribute('width', width);
				video.setAttribute('height', height);
				canvas.setAttribute('width', width);
				canvas.setAttribute('height', height);
				streaming = true;
			}
		}, false);

		startbutton.addEventListener('click', function(ev) {
			takepicture();
			ev.preventDefault();
		}, false);

		clearphoto();
	}

	// Fill the photo with an indication that none has been
	// captured.

	function clearphoto() {
		var context = canvas.getContext('2d');
		context.fillStyle = "#AAA";
		context.fillRect(0, 0, canvas.width, canvas.height);

		var data = canvas.toDataURL('image/png');
		photo.setAttribute('src', data);
	}

	// Capture a photo by fetching the current contents of the video
	// and drawing it into a canvas, then converting that to a PNG
	// format data URL. By drawing it on an offscreen canvas and then
	// drawing that to the screen, we can change its size and/or apply
	// other changes before drawing it.

	function takepicture() {
		var context = canvas.getContext('2d');
		if (width && height) {
			canvas.width = width;
			canvas.height = height;
			context.drawImage(video, 0, 0, width, height);

			var data = canvas.toDataURL('image/png');
			photo.setAttribute('src', data);
		} else {
			clearphoto();
		}
	}

	// Set up our event listener to run the startup process
	// once loading is complete.
	window.addEventListener('load', startup, false);
})();
</script>

</html>