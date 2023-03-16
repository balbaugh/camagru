let canvas = document.getElementById('canvas');
let context = canvas.getContext('2d');
let imgInput = document.getElementById('imageInput');
let saveImage = document.getElementById('save');



imgInput.addEventListener('change', function () {
	if (this.files && this.files[0]) {
		if (this.files[0].size > 2097152) {
			alert("Image size is too big! Please upload an image less than 2MB.");
			this.value = "";
		}
		if (this.value != "") {
			saveImage.classList.remove("is-hidden");
			let myImage = new Image();

			myImage.src = URL.createObjectURL(this.files[0]);
			myImage.onload = function () {
				canvas.width = myImage.width;
				canvas.height = myImage.height;

				context.drawImage(myImage, 0, 0);
				this.value = "";
			}
		}
	}
});


// Webcam Stickers
function mySticker_function1() {
	return document.getElementById("mySelect1").value;
}

function mySticker_function2() {
	return document.getElementById("mySelect2").value;
}


// //Save Image
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

	request.open("POST", "/controllers/upload.php");
	request.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

	request.send("img=" + encodeURIComponent(data) + "&sticker1=" + sticker1src + "&sticker2=" + sticker2src);
});
