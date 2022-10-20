<!DOCTYPE html>
<html>

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Camagru</title>
	<meta http-equiv="X-UA-Compatible" content="ie=edge" />
	<link rel="preconnect" href="https://fonts.gstatic.com">
	<link href="https://fonts.googleapis.com/css2?family=Oswald&display=swap" rel="stylesheet">
	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link href="https://fonts.googleapis.com/css2?family=Averia+Serif+Libre:ital,wght@1,700&display=swap"
		rel="stylesheet">
	<style>
	html {
		background: rgb(249, 249, 249);
		overflow-x: hidden;
	}

	.form {
		font-family: 'Roboto', sans-serif;
		font-size: 0.8rem;
	}

	.image {
		display: flex;
		align-items: center;
		justify-content: center;
		margin-bottom: 10px;
	}

	#video {
		display: block;
		margin-top: 150px;
		margin-left: auto;
		margin-right: auto;
	}

	#start-camera {
		display: block;
		margin-top: 10px;
		margin-left: auto;
		margin-right: auto;
		border-style: none;
		background: white;
		padding: 10px;
		border-radius: 50px;
		box-shadow: 1px 2px 2px hsl(0deg 0% 0% / 0.44);
		margin-bottom: 20px;
	}

	#click-photo {
		display: block;
		margin-top: 10px;
		margin-left: auto;
		margin-right: auto;
		border-style: none;
		background: white;
		padding: 7px;
		border-radius: 10px;
		box-shadow: 1px 2px 2px hsl(0deg 0% 0% / 0.44);
	}

	#canvas {
		display: block;
		margin-top: 10px;
		margin-left: auto;
		margin-right: auto;
	}

	#web_add {
		display: block;
		margin-top: 10px;
		margin-left: auto;
		margin-right: auto;
	}

	.stamps {
		display: flex;
		align-items: center;
		justify-content: center;
	}

	.img_add {
		display: flex;
		align-items: center;
		justify-content: center;
		margin-top: 10px;
	}

	#hrNavbar {
		width: 2600px;
		height: 0px;
		background: black;
		position: fixed;
		top: 60px;
		right: -1px;
	}

	.navPanel {
		width: 2580px;
		height: 80px;
		background: white;
		position: fixed;
		top: -10px;
		right: 0px;
	}

	#profile {
		position: fixed;
		top: 0.7%;
		left: 15%;
	}

	#gallery {
		position: fixed;
		top: 0.7%;
		left: 47.8%;
	}

	#logout {
		position: fixed;
		top: 0.7%;
		left: 80%;
	}

	@media screen and (min-width: 300px) and (max-width: 45x0px) {
		#profile {
			position: fixed;
			top: 0.7%;
			left: 11%;
		}

		#gallery {
			position: fixed;
			top: 0.7%;
			left: 42%;
		}

		#logout {
			position: fixed;
			top: 0.7%;
			left: 73%;
		}
	}

	@media screen and (min-width: 1500px) and (max-width: 2800px) {
		#profile {
			position: fixed;
			top: 0.7%;
			left: 12%;
		}

		#gallery {
			position: fixed;
			top: 0.7%;
			left: 48.8%;
		}

		#logout {
			position: fixed;
			top: 0.7%;
			left: 80%;
		}
	}

	#web_add {
		background: white;
		border-style: solid;
		border-color: white;
		padding: 10px;
		border-radius: 50px;
		box-shadow: 1px 2px 2px hsl(0deg 0% 0% / 0.44);
		margin-bottom: 20px;
	}

	.img_size {
		width: 150px;
	}

	#inputTag {
		display: none;
	}

	.footer {
		display: flex;
		align-items: center;
		justify-content: center;
		font-family: 'Averia Serif Libre', cursive;
		font-size: 1rem;
	}

	.slide-container {
		width: 150px;
		overflow: auto;
	}

	#image-container {
		display: flex;
		align-items: center;
		min-width: 150px;

	}
	</style>
</head>

<body>

	<video id="video" width="340" height="240" autoplay></video>
	<button id="start-camera">Start Camera</button><button id="click-photo">
		<p>Capture</p><img src="../images/capture.png" width="50">
	</button>
	<canvas id="canvas" width="375" height="280" value="canvas"></canvas>
	<form class="form" action="add_webcam.php" method="POST" enctype="multipart/form-data">
		<button id="web_add" type="submit" name="add" value="">Submit</button>
		<input type="hidden" id="web_photo" name="new_pic" value="">
		<input type="hidden" id="stamp" name="stamp" value="">
	</form>
	<br>
	<br>
	<div class="stamps">
		<button><img id="first" onclick="stampPath1()" src="../public/stickers/bolt.png" width='50'
				height='50'></button>
		<button><img id="second" onclick="stampPath2()" src="../public/stickers/camagruStealie.png" width='50'
				height='50'></button>
		<button><img id="third" onclick="stampPath3()" src="../public/stickers/StealYourFaceEmpty.png" width='50'
				height='50'></button>

	</div>
	<div class="img_add">
		<form class="form" action="add_foto.php" method="POST" enctype="multipart/form-data">
			<label for="inputTag">
				<input id="inputTag" type="file" name="photo">ADD PHOTO FROM DEVICE
			</label>
			<button id="web_add" type="submit" value="Add">Add</button>
			<input type="hidden" id="stamp1" name="stamp" value="">
		</form>
	</div>
	<br>
	<hr id="hrNavbar">
	<hr>
	<div class="footer">
		<p>CAMAGRU</p>
	</div>
</body>

</html>
<script>
let camera_button = document.querySelector("#start-camera"),
	video = document.querySelector("#video"),
	click_button = document.querySelector("#click-photo"),
	canvas = document.querySelector("#canvas"),
	new_pic = document.querySelector("#web_photo"),
	final_stamp_web = document.querySelector("#stamp"),
	final_stamp_add = document.querySelector("#stamp1"),
	first = document.querySelector("#first"),
	second = document.querySelector("#second"),
	third = document.querySelector("#third"),
	fourth = document.querySelector("#fourth");

let stamp_auth = 0;

function stampPath1() {
	final_stamp_web.value = first.src;
	final_stamp_add.value = first.src;
	stamp_auth = 1;
}

function stampPath2() {
	final_stamp_web.value = second.src;
	final_stamp_add.value = second.src;
	stamp_auth = 1;
}

function stampPath3() {
	final_stamp_web.value = third.src;
	final_stamp_add.value = third.src;
	stamp_auth = 1;
}

function stampPath4() {
	final_stamp_web.value = fourth.src;
	final_stamp_add.value = fourth.src;
	stamp_auth = 1;
}

camera_button.addEventListener('click', async function() {
	let stream = await navigator.mediaDevices.getUserMedia({
		video: true,
		audio: false
	});
	video.srcObject = stream;
});

click_button.addEventListener('click', function() {
	if (stamp_auth == 1) {
		canvas.getContext('2d').drawImage(video, 0, 0, canvas.width, canvas.height);
		let image_data_url = canvas.toDataURL('image/jpeg');
		new_pic.value = image_data_url;
	}
});
</script>