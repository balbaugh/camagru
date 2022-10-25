<?php

session_start();

include_once '../config/dbConnect.php';

date_default_timezone_set('Europe/Helsinki');

$time_zone = date_default_timezone_set('Europe/Helsinki');
$date = date('Y-m-d H:i:s');
$image_name = $_SESSION['username'] . $date . '.png';
$img = base64_decode($_POST["img"]);
$img = imagecreatefromstring($img);
imagepng($img, "../public/uploads/" . $image_name);

// PHP code to insert image from camera.html.php into database

try {
	$conn = dbConnect();
	$stmt = $conn->prepare("INSERT into images (`id_user`, `username`, `image_name`, `date_added`)
			VALUES ('" . $_SESSION['id_user'] . "', '" . $_SESSION['username'] . "', '" . $image_name . "', '" . $date . "')");
	$stmt->execute();
} catch (PDOException $e) {
	echo "Unable to connect to the database server: " . $e->getMessage() . " in " . $e->getFile() . ":" . $e->getLine();
	exit();
}