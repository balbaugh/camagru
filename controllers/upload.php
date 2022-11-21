<?php

session_start();



include_once '../config/dbConnect.php';

date_default_timezone_set('Europe/Helsinki');

$time_zone = date_default_timezone_set('Europe/Helsinki');
$date = date('Y-m-d H:i:s');
$image_name = $_SESSION['username'] . $date . '.png';
$id_user = $_SESSION['id_user'];
$username = $_SESSION['username'];
$date_added = $date;
$img = base64_decode($_POST["img"]);
$img = imagecreatefromstring($img);
$img = imagescale($img, $width = 427, $height = 320, $mode = IMG_BICUBIC_FIXED);
imagepng($img, "../public/uploads/" . $image_name);

// PHP code to insert image from camera.html.php into database

if (isset($_SESSION['check']) && !empty($_SESSION['check'])) {
	if (($_SESSION['check']) != hash('ripemd128', $_SERVER['REMOTE_ADDR'] . $_SERVER['HTTP_USER_AGENT'])) {
		session_destroy();
		header('Location: ../sources/login.html.php?error=Session expired!');
	} else {
		$_SESSION['check'] = hash('ripemd128', $_SERVER['REMOTE_ADDR'] . $_SERVER['HTTP_USER_AGENT']);
		try {
			$conn = dbConnect();
			$stmt = $conn->prepare("INSERT into images (`id_user`, `username`, `image_name`, `date_added`) VALUES (?, ?, ?, ?)");
			$stmt->bindParam(1, $id_user, PDO::PARAM_INT);
			$stmt->bindParam(2, $username, PDO::PARAM_STR);
			$stmt->bindParam(3, $image_name, PDO::PARAM_STR);
			$stmt->bindParam(4, $date_added, PDO::PARAM_STR);

			$stmt->execute();
		} catch (PDOException $e) {
			echo "Unable to connect to the database server: " . $e->getMessage() . " in " . $e->getFile() . ":" . $e->getLine();
			exit();
		}
	}
}