

'use strict';

photo = document.getElementById('uploadedPhoto');
let uploadCard = null;
let uploadButton = null;
let uploadedDiv = null;
pic = new Image();

// card toggle for logo // stickers // initialize other page elements
document.addEventListener('DOMContentLoaded', function () {
	let cardToggles = document.getElementsByClassName('card-toggle');
	for (let i = 0; i < cardToggles.length; i++) {
		cardToggles[i].addEventListener('click', e => {
			e.currentTarget.parentElement.parentElement.childNodes[3].classList.toggle('is-hidden');
		});
	}
});


const canvas2 = document.getElementById('canvas2');
const snap2 = document.getElementById('snap2');
var photo = null;

// Load init
init();

//Draw Image
var context = canvas2.getContext('2d');
snap2.addEventListener("click", function () {
	video.classList.add('is-hidden');
	canvas2.classList.remove('is-hidden');

	var mySticker = mySticker_function();
	// var mySticker2 = mySticker_function2();
	// var mySticker3 = mySticker_function3();

	canvas.width = video.videoWidth;
	canvas.height = video.videoHeight;

	context.drawImage(video, 0, 0);
	context.drawImage(document.getElementById(mySticker), 20, 50, 128, 128);
	// context.drawImage(document.getElementById(mySticker2), 490, 50, 128, 128);
	// context.drawImage(document.getElementById(mySticker3), 240, 320, 128, 128);
});

//Reset Image
//var context = canvas.getContext('2d');
document.getElementById('clear').addEventListener('click', function () {

	video.classList.remove('is-hidden');
	canvas.classList.add('is-hidden');

	context.clearRect(0, 0, canvas.width, canvas.height);
}, false);



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

// draw uploadedImage on canvas
pic.addEventListener('load', () => {
	// stopWebcam();
	// webcamCard.hidden = true;
	uploadButton.textContent = "Choose Again";
	context.drawImage(pic, 0, 0, canvas.width, canvas.height);
	let imageDataURL = canvas2.toDataURL('image/png');
	photo.setAttribute('src', imageDataURL);
});

// //Save Image
var saveImage = document.getElementById("save");

save.addEventListener("click", () => {
	var data = canvas2.toDataURL();
	data = data.replace("data:image/png;base64,", "");
	var request = new XMLHttpRequest();

	request.onload = () => {
		console.log(request.responseText, request);
	}
	request.open("POST", "http://localhost:8080/camagru/controllers/camera.php", false);
	request.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
	request.send("img=" + encodeURIComponent(data));
	window.location.reload();
});


function mySticker_function() {
	var x = document.getElementById("mySelect2").value;
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
