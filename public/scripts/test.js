// card toggle for stickers // filters // initialize other page elements
document.addEventListener('DOMContentLoaded', function () {
	const videoStream = document.getElementById('videoStream');
	const video = document.getElementById('video');
	const canvas = document.getElementById('canvas');
	const photo = document.getElementById('photo');
	const comment = document.getElementById('commentForm');
	const sticker = document.getElementById('stickerPanel');
	const filter = document.getElementById('filterPanel');
	const captureButton = document.getElementById('captureButton');
	const saveButton = document.getElementById('saveButton');




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
	let captureButton = null;

	// FIGURE THIS OUT AND EXPAND UPON IT
	// imageBlob is the image data that will be sent to the server
	let imageBlob = null;

	function initializeCamera() {
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
		video.addEventListener('canplay', () => {
			if (!streaming) {
				let videoWidth = videoStream.offsetWidth;
				let videoHeight = videoStream.offsetHeight;
				/* if (isNaN(height)) {
					height = width / (4 / 3);
				} */
				video.setAttribute('width', width);
				video.setAttribute('height', height);
				canvas.setAttribute('width', width);
				canvas.setAttribute('height', height);
				streaming = true;
			}
		}, false
		)

		// When the capture button is clicked, take a picture
		captureButton.addEventListener('click', function () {
			commentForm.hidden = false;
			stickerPanel.hidden = false;
			filterPanel.hidden = false;
			if (video.paused) {
				video.play();
				// captureButton.textContent = "Capture";
			} else {
				video.pause();
				drawImage(video, 0, 0, canvas.width, canvas.height);
			}
			)
	});


	// Clear the photo
	/* 		clearphoto();
		} */

	// Fill the photo with an indication that none has been
	// captured.
	/* 		function clearphoto() {
				var context = canvas.getContext('2d');
				context.fillStyle = "#AAA";
				context.fillRect(0, 0, canvas.width, canvas.height);
	
				// The data is a URL representing the image of the photo
				var data = canvas.toDataURL('../public/photos/png');
				photo.setAttribute('src', data);
			} */

	// Capture a photo by fetching the current contents of the video
	// and drawing it into a canvas, then converting that to a PNG
	// format data URL. By drawing it on an offscreen canvas and then
	// converting that to a PNG, we can change its size and/or apply
	// other changes before drawing it.

	/* 		function takepicture() {
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
	 */
	window.addEventListener('load', initializeCamera, false);
})();
