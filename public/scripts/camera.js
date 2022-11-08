'use strict';

const video = document.getElementById('video');
const canvas = document.getElementById('canvas');
const snap = document.getElementById('snap');
const start = document.getElementById('start');
const save = document.getElementById('save');
const clear = document.getElementById('clear');
const errorMsgElement = document.getElementById('spanErrorMsg');

let photo = null;

const constraints = {
	audio: false,
	video: true
};


// EVENT LISTENERS

start.addEventListener('click', async function () {
	event.preventDefault();
	let stream = await navigator.mediaDevices.getUserMedia({ video: true, audio: false });
	video.classList.remove("is-hidden");
	snap.classList.remove("is-hidden");
	start.classList.add("is-hidden");
	video.srcObject = stream;
});


// Success
function handleSuccess(stream) {
	window.stream = stream;
	video.srcObject = stream;
}


//Draw Image
let context = canvas.getContext('2d');
snap.addEventListener("click", function () {
	video.classList.add('is-hidden');
	canvas.classList.remove('is-hidden');
	save.classList.remove("is-hidden");
	clear.classList.remove("is-hidden");
	snap.classList.add("is-hidden");

	let mySticker = mySticker_function();


	canvas.width = video.videoWidth;
	canvas.height = video.videoHeight;

	context.drawImage(video, 0, 0);
	context.drawImage(document.getElementById(mySticker), 20, 50, 128, 128);

});


// Webcam Stickers
function mySticker_function() {
	let x = document.getElementById("mySelect").value;
	return x;
}


//Reset Webcam Image
document.getElementById('clear').addEventListener('click', function () {

	video.classList.remove('is-hidden');
	canvas.classList.add('is-hidden');
	save.classList.add("is-hidden");
	clear.classList.add("is-hidden");
	snap.classList.remove("is-hidden");

	context.clearRect(0, 0, canvas.width, canvas.height);
}, false);



// //Save Image
const saveImage = document.getElementById("save");

saveImage.addEventListener("click", () => {
	let data = canvas.toDataURL();
	data = data.replace("data:image/png;base64,", "");
	let request = new XMLHttpRequest();

	request.onload = () => {
		console.log(request.responseText, request);
	}
	request.open("POST", "/camagru/controllers/camera.php", false);
	request.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
	request.send("img=" + encodeURIComponent(data));
	window.location.reload();
});


