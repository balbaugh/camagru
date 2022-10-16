// card toggle for logo // stickers // initialize other page elements
document.addEventListener('DOMContentLoaded', function () {
	let cardToggles = document.getElementsByClassName('card-toggle');
	for (let i = 0; i < cardToggles.length; i++) {
		cardToggles[i].addEventListener('click', e => {
			e.currentTarget.parentElement.parentElement.childNodes[3].classList.toggle('is-hidden');
		});
	}
});

// STICKERS
function selectSticker(clickedSticker) {

	// getting the path of the sticker and save it in display screen
	stickerDisplayed.src = "../public/stickers/" + clickedSticker.id;

	// applying sticker location
	applySticker(clickedSticker.classList[1]);
}




// We start by wrapping the whole script in an anonymous function to avoid global variables, then setting up various variables we'll be using.

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
	let saveButton = null;
	let uploadCard = null;
	let uploadButton = null;
	let commentForm = null;
	let stickerDisplayed = null;
	let stickerPanel = null;
	let filterPanel = null;



	// FIGURE THIS OUT AND EXPAND UPON IT
	// imageBlob is the image data that will be sent to the server
	let imageBlob = null;


	function initializeCamera() {

		video = document.getElementById('video');
		canvas = document.getElementById('canvas');
		photo = document.getElementById('photo');
		captureButton = document.getElementById('captureButton');
		saveButton = document.getElementById('saveButton');
		uploadCard = document.getElementById('uploadCard');
		uploadButton = document.getElementById('uploadButton');
		commentForm = document.getElementById('commentForm');
		stickerPanel = document.getElementById('stickerPanel');
		videoStream = document.getElementById('videoStream');
		ctx = canvas.getContext('2d');

		// Get the video stream from the camera
		navigator.mediaDevices.getUserMedia({
			video: true,
			audio: false,
			facingMode: "user"
		})
			.then(function (stream) {
				video.srcObject = stream;
				video.play();
			})
			.catch(function (err) {
				console.log("An error occurred: ${err}");
			});

		// When the video stream is ready, start the camera
		// // if (isNaN(height)) :: Firefox currently has a bug where the height
		// can't be read from the video, so we will make assumptions if this
		// happens.
		video.addEventListener('canplay', () => {
			if (!streaming) {
				let videoWidth = videoStream.offsetWidth;
				let videoHeight = videoStream.offsetHeight;
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
		captureButton.addEventListener('click', function (ev) {
			commentForm.hidden = false;
			stickerPanel.hidden = false;
			uploadCard.hidden = true;

			if (video.paused) {
				video.play();
				captureButton.textContent = "Capture";
			} else {
				video.pause();
				ctx.drawImage(video, 0, 0, canvas.width, canvas.height);
				captureButton.textContent = "Retake";
			}
		});
	}

	window.addEventListener('load', initializeCamera, false);
})();
