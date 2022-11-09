
let imgInput = document.getElementById('imageInput');

imgInput.addEventListener('change', function (e) {
	if (e.target.files) {
		let imageFile = e.target.files[0]; //here we get the image file
		let reader = new FileReader();
		reader.readAsDataURL(imageFile);
		reader.onloadend = function (e) {
			let myImage = new Image(); // Creates image object
			myImage.src = e.target.result; // Assigns converted image to image object
			myImage.onload = function (ev) {
				let mySticker = mySticker_function();
				let myCanvas = document.getElementById("myCanvas"); // Creates a canvas object
				let myContext = myCanvas.getContext("2d"); // Creates a
				// context object
				myCanvas.width = myImage.width; // Assigns image's width to canvas
				myCanvas.height = myImage.height; // Assigns image's height to canvas
				myContext.drawImage(myImage, 0, 0); // Draws the image on canvas
				myContext.drawImage(document.getElementById(mySticker), 20, 50, 128, 128);
			}
		}
	}
});


// Webcam Stickers
function mySticker_function() {
	let x = document.getElementById("mySelect").value;
	return x;
}


// //Save Image
const saveImage = document.getElementById("save");

saveImage.addEventListener("click", () => {
	let data = myCanvas.toDataURL();
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

