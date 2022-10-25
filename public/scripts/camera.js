

'use strict';

// card toggle for logo // stickers // initialize other page elements
document.addEventListener('DOMContentLoaded', function () {
	let cardToggles = document.getElementsByClassName('card-toggle');
	for (const element of cardToggles) {
		element.addEventListener('click', e => {
			e.currentTarget.parentElement.parentElement.childNodes[3].classList.toggle('is-hidden');
		});
	}
});


const video = document.getElementById('video');
const canvas = document.getElementById('canvas');
const snap = document.getElementById('snap');
const errorMsgElement = document.getElementById('spanErrorMsg');
let photo = null;
const constraints = {
	audio: false,
	video: true
};


/*

// Load init
init();
//Access webcam
async function init() {
	try {
		const stream = await navigator.mediaDevices.getUserMedia(constraints);
		handleSuccess(stream);
	} catch (e) {
		errorMsgElement.innerHTML = 'navigator.getUserMedia.error:${e.toString()}';
	}
}
*/


// EVENT LISTENERS
window.addEventListener('load', async () => {
	try {
		await start_video();
	} catch (e) {
		alert("In order to take photos we need your permission to use the webcam");
	}
});

const start_video = async() => {
	let stream = await navigator.mediaDevices.getUserMedia({ video: true, audio: false });
	video.srcObject = stream;
}

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

	let mySticker = mySticker_function();
	// let mySticker2 = mySticker_function2();
	// let mySticker3 = mySticker_function3();

	canvas.width = video.videoWidth;
	canvas.height = video.videoHeight;

	context.drawImage(video, 0, 0);
	context.drawImage(document.getElementById(mySticker), 20, 50, 128, 128);
	// context.drawImage(document.getElementById(mySticker2), 490, 50, 128, 128);
	// context.drawImage(document.getElementById(mySticker3), 240, 320, 128, 128);
});

//Reset Image
document.getElementById('clear').addEventListener('click', function () {

	video.classList.remove('is-hidden');
	canvas.classList.add('is-hidden');

	context.clearRect(0, 0, canvas.width, canvas.height);
}, false);


/*
// UPLOAD
let uploadedImage = null;
uploadedImage = document.querySelector('#uploadImage');

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
 */


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


function mySticker_function() {
	let x = document.getElementById("mySelect").value;
	return x;
}

/*
function mySticker_function2() {
	var x = document.getElementById("mySelect2").value;
	return x;
}

function mySticker_function3() {
	var x = document.getElementById("mySelect3").value;
	return x;
}
 */
