let video = document.getElementById('video');
let canvas = document.getElementById('canvas');
let context = canvas.getContext('2d');
let snap = document.getElementById('snap');
let start = document.getElementById('start');
let saveImage = document.getElementById('save');
let clear = document.getElementById('clear');
let stickersDiv = document.getElementById('stickers');






// EVENT LISTENERS

start.addEventListener('click', async function () {
	let constraints = {
		audio: false,
		video: {
			facingMode: "user"
		}
	};

	let stream = await navigator.mediaDevices.getUserMedia(constraints).catch(function () { alert("You must allow access to your webcam to use this feature! Please reload the page and try again..."); });

	if (stream) {
		stickersDiv.classList.remove("is-hidden");
		video.classList.remove("is-hidden");
		video.srcObject = stream;
		start.classList.add("is-hidden");
		snap.classList.remove("is-hidden");
	}


});


//Draw Image
snap.addEventListener("click", function () {
	video.classList.add('is-hidden');
	canvas.classList.remove('is-hidden');
	saveImage.classList.remove("is-hidden");
	clear.classList.remove("is-hidden");
	snap.classList.add("is-hidden");


	canvas.width = video.videoWidth;
	canvas.height = video.videoHeight;

	context.drawImage(video, 0, 0);
});


// Webcam Stickers
function mySticker_function1() {
	return document.getElementById("mySelect1").value;
}

function mySticker_function2() {
	return document.getElementById("mySelect2").value;
}


// // Server Side Process and Save Image
saveImage.addEventListener("click", function () {
	let data = canvas.toDataURL();
	data = data.replace("data:image/png;base64,", "");
	let request = new XMLHttpRequest();

	let mySticker1 = mySticker_function1();
	let sticker1src = document.getElementById(mySticker1).getAttribute("src");
	let mySticker2 = mySticker_function2();
	let sticker2src = document.getElementById(mySticker2).getAttribute("src");

	request.onload = function () {
		window.location.reload();
	}

	request.open("POST", "/camagru/controllers/camera.php", true);
	request.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

	request.send("img=" + encodeURIComponent(data) + "&sticker1=" + sticker1src + "&sticker2=" + sticker2src);


});


//Clear Webcam Image
document.getElementById('clear').addEventListener('click', function () {
	video.classList.remove('is-hidden');
	canvas.classList.add('is-hidden');
	saveImage.classList.add("is-hidden");
	clear.classList.add("is-hidden");
	snap.classList.remove("is-hidden");

	context.clearRect(0, 0, canvas.width, canvas.height);
}, false);
