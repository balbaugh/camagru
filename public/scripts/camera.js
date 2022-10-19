// card toggle for logo // stickers // initialize other page elements
document.addEventListener('DOMContentLoaded', function () {
	let cardToggles = document.getElementsByClassName('card-toggle');
	for (let i = 0; i < cardToggles.length; i++) {
		cardToggles[i].addEventListener('click', e => {
			e.currentTarget.parentElement.parentElement.childNodes[3].classList.toggle('is-hidden');
		});
	}
});

// Helpers
function isImage(url) {
	return /^data:image\/(png|gif|jpeg|jpg|webp|avif|svg);base64,/.test(url);
}

function testImage(url) {
	const imgPromise = new Promise(function imgPromise(resolve, reject) {
		const imgElement = new Image();

		imgElement.addEventListener('load', function imgOnLoad() {
			resolve(this);
		});

		imgElement.addEventListener('error', function imgOnError() {
			reject(this);
		})

		imgElement.src = url;
	});

	return imgPromise;
}

// function to start the webcam
function startWebcam() {
	// start the webcam
	navigator.mediaDevices.getUserMedia({ video: true, audio: false })
		.then(function (stream) {
			video.srcObject = stream;
			video.play();
		})
		.catch(function (err) {
			console.log("An error occurred: " + err);
		});
}


// function to stop the webcam
function stopWebcam() {
	video.pause();
	tracks = video.srcObject.getTracks();
	tracks.forEach(function (track) {
		track.stop();
	});
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
	let videoStream = null;
	let canvas = null;
	let canvasSticker = null;
	let photo = null;
	let ctx = null;
	let ctxSticker = null;
	let captureButton = null;
	let saveButton = null;
	let uploadCard = null;
	let uploadButton = null;
	let uploadedImage = null;
	let uploadedDiv = null;

	let webcamCard = null;
	let commentForm = null;
	let stickerDisplayed = null;
	let stickerPanel = null;
	let lastFrame = null;
	let lastSticker = null;
	let selectedSticker = null;
	let sticker = null;


	function initializeCamera() {

		video = document.getElementById('video');
		canvas = document.getElementById('canvas');
		canvasSticker = document.getElementById('canvasSticker');
		photo = document.getElementById('uploadedPhoto');
		pic = new Image();
		startButton = document.getElementById('startButton');
		captureButton = document.getElementById('captureButton');
		saveButton = document.getElementById('saveButton');
		uploadCard = document.getElementById('uploadCard');
		uploadButton = document.getElementById('uploadButton');
		uploadedDiv = document.getElementById('uploadedDiv');

		uploadedImage = document.querySelector('#uploadImage');
		webcamCard = document.getElementById('webcamCard');
		commentForm = document.getElementById('commentForm');
		stickerPanel = document.getElementById('stickerPanel');
		sticker = document.querySelector('#sticker');
		videoStream = document.getElementById('videoStream');
		ctx = canvas.getContext('2d');
		ctxSticker = canvasSticker.getContext('2d');

		// run startWebcam function when the capture button is clicked
		startButton.addEventListener('click', function (e) {
			e.preventDefault();
			startWebcam();
			// hide start button
			startButton.classList.add('is-hidden');
			// show capture button
			captureButton.classList.remove('is-hidden');
		});


		/* 		// Get the video stream from the camera
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
					}); */


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
			uploadCard.hidden = true;

			if (video.paused) {
				video.play();
				captureButton.textContent = "Capture";
			} else {
				video.pause();
				ctx.drawImage(video, 0, 0, canvas.width, canvas.height);
				let imageDataURL = canvas.toDataURL('image/png');
				photo.setAttribute('src', imageDataURL);
				captureButton.textContent = "Retake";
			}
		});

		// UPLOAD
		uploadedImage.addEventListener('change', function () {
			const reader = new FileReader();
			if (this.files[0].size > 4 * 1024 * 1024) {
				alert("File is too big! Please upload a file smaller than 4MB.");
				this.value = "";
			} else {
				reader.addEventListener("load", () => {
					const uploadedImage = reader.result;

					if (isImage(uploadedImage)) {
						testImage(uploadedImage)
							.then(() => {
								pic.src = uploadedImage;
							})
							.catch(() => {
								alert("File is not an image! Please upload an image file.");
							});
					} else {
						alert("Wrong format! Please upload a jpeg or png.");
					}
				});
				reader.readAsDataURL(this.files[0]);
			}
		});

		// draw uploadedImage on canvas
		pic.addEventListener('load', () => {
			// stopWebcam();
			// webcamCard.hidden = true;
			uploadButton.textContent = "Choose Again";
			commentForm.hidden = false;
			ctx.drawImage(pic, 0, 0, canvas.width, canvas.height);
			let imageDataURL = canvas.toDataURL('image/png');
			photo.setAttribute('src', imageDataURL);
		});


	}

	window.addEventListener('load', initializeCamera, false);
})();
