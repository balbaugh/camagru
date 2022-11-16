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
imagepng($img, "../public/uploads/" . $image_name);


// PHP code to insert image from camera.html.php into database

try {
	$conn = dbConnect();
	$stmt = $conn->prepare("INSERT into images (`id_user`, `username`, `image_name`, `date_added`) VALUES (?, ?, ?, ?)");
	$stmt->bindParam(1, $id_user);
	$stmt->bindParam(2, $username);
	$stmt->bindParam(3, $image_name);
	$stmt->bindParam(4, $date_added);

	$stmt->execute();
} catch (PDOException $e) {
	echo "Unable to connect to the database server: " . $e->getMessage() . " in " . $e->getFile() . ":" . $e->getLine();
	exit();
}