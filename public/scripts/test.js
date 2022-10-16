// card toggle for stickers // filters
document.addEventListener('DOMContentLoaded', function () {
	let cardToggles = document.getElementsByClassName('card-toggle');
	for (let i = 0; i < cardToggles.length; i++) {
		cardToggles[i].addEventListener('click', e => {
			e.currentTarget.parentElement.parentElement.childNodes[3].classList.toggle('is-hidden');
		});
	}
});

(() => {
	// The width and height of the captured photo. We will set the
	// width to the value defined here, but the height will be
	// calculated based on the aspect ratio of the input stream.

	const width = 720; // We will scale the photo width to this
	let height = 0; // This will be computed based on the input stream

	// |streaming| indicates whether or not we're currently streaming
	// video from the camera. Obviously, we start at false.

	let streaming = false;

	// The various HTML elements we need to configure or control. These
	// will be set by the startup() function.

	let video = null;
	let canvas = null;
	let photo = null;
	let startbutton = null;

	// FIGURE THIS OUT AND EXPAND UPON IT
	// imageBlob is the image data that will be sent to the server
	let imageBlob = null;

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


	function initializeCamera() {
		video = document.getElementById('video');
		canvas = document.getElementById('canvas');
		photo = document.getElementById('photo');
		startbutton = document.getElementById('captureButton');

		// Get the video stream from the camera
		navigator.mediaDevices.getUserMedia({
			video: true,
			facingMode: "user",
			audio: false
		})
			.then(function (stream) {
				video.srcObject = stream;
				video.play();
			})
			.catch(function (err) {
				console.log("An error occurred: " + err);
			});

		// When the video stream is ready, start the camera
		// // if (isNaN(height)) :: Firefox currently has a bug where the height
		// can't be read from the video, so we will make assumptions if this
		// happens.
		video.addEventListener('canplay', function (ev) {
			if (!streaming) {
				height = video.videoHeight / (video.videoWidth / width);
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

		// When the capture button is clicked, take a picture
		startbutton.addEventListener('click', function (ev) {
			takepicture();
			ev.preventDefault();
		}, false);

		// Clear the photo
		clearphoto();
	}

	// Fill the photo with an indication that none has been
	// captured.
	function clearphoto() {
		var context = canvas.getContext('2d');
		context.fillStyle = "#AAA";
		context.fillRect(0, 0, canvas.width, canvas.height);

		// The data is a URL representing the image of the photo
		var data = canvas.toDataURL('../public/photos/png');
		photo.setAttribute('src', data);
	}

	// Capture a photo by fetching the current contents of the video
	// and drawing it into a canvas, then converting that to a PNG
	// format data URL. By drawing it on an offscreen canvas and then
	// converting that to a PNG, we can change its size and/or apply
	// other changes before drawing it.

	function takepicture() {
		const context = canvas.getContext('2d');
		if (width && height) {
			canvas.width = width;
			canvas.height = height;
			context.drawImage(video, 0, 0, width, height);

			// The image is a PNG format data URL
			const data = canvas.toDataURL('../public/photos/png');
			photo.setAttribute('src', data);
		} else {
			clearphoto();
		}
	}

	window.addEventListener('load', initializeCamera, false);
})();
