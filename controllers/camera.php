<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

//Session starts to obtain user
session_start();

//Include the database files for connection
include_once '../config/dbconnect.php';




// PHP code to insert image from camera.html.php into database



$statusMsg = '';
$date = date("Y-m-d H:i:s");
$image_name = $_SESSION['username'] . $date . '.png';
$img = base64_decode($_POST["img"]);
$img = imagecreatefromstring($img);
imagepng($img, "images/" . $image_name);

try {
	$sql = "INSERT IGNORE into images (`id_user`, `username`, `image_name`, `date_added`)
		VALUES ('" . $_SESSION['id_user'] . "', '" . $_SESSION['username'] . "', '" . $image_name . "', '" . $date . "')";
	$stmt = $conn->prepare($sql);
	if ($stmt->execute()) {
		$statusMsg = "The file " . $image_name . " has been uploaded successfully by " . ($_SESSION["username"]) . ".";
	}
} catch (PDOException $e) {
	$statusMsg = "File upload failed, please try again.";
	echo $e->getMessage();
}
echo $statusMsg;