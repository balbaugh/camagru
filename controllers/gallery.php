<?php

session_start();

include_once '../config/dbConnect.php';

date_default_timezone_set('Europe/Helsinki');

// connect to database and start session then check if user is logged in.
// if logged in, display the gallery page with all user images from database
// images will be listed chronologically.
// if user not logged in, redirect to home page for gallery with less features.

// check if user is logged in and get images from database


function getImages()
{
	try {
		$conn = dbConnect();
		$stmt = $conn->prepare("SELECT * FROM images ORDER BY id_image DESC");
		$stmt->execute();
		$images = $stmt->fetchAll();
		return $images;
	} catch (PDOException $e) {
		echo $e->getMessage() . " in " . $e->getFile() . ":" . $e->getLine();
		exit();
	}
}

function getComments($id_image)
{
	try {
		$conn = dbConnect();
		$stmt = $conn->prepare("SELECT * FROM comments WHERE id_image = :id_image ORDER BY id_comment ASC");
		$stmt->bindParam(':id_image', $id_image);
		$stmt->execute();
		return $stmt->fetchAll();
	} catch (PDOException $e) {
		echo $e->getMessage() . " in " . $e->getFile() . ":" . $e->getLine();
		exit();
	}
}


/*
function getGallery(int $offset, int $pageMax)
{
	try {
		$conn = dbConnect();
		$stmt = $conn->prepare("SELECT * FROM images ORDER BY id_image DESC LIMIT $offset, $pageMax");
		$stmt->execute();
		$images = $stmt->fetchAll();
		return $images;
	} catch (PDOException $e) {
		echo $e->getMessage() . " in " . $e->getFile() . ":" . $e->getLine();
		exit();
	}
}*/

// delete user image from database and from server
/*if (isset($_POST['delete_picture']) && !empty($_POST['delete_picture'])) {
	$img_id = $_POST['delete_picture'];

	if (img_by_user($img_id, $_SESSION['user_id'])) {
		unlink("../public/uploads/" . get_img_path_by_id($img_id));
	}

	try {
		$conn = connect();
		$stmt = $conn->prepare("DELETE FROM user_images WHERE id = :img_id AND uploader_id = :user_id");
		$stmt->bindParam(':img_id', $img_id);
		$stmt->bindParam(':user_id', $_SESSION['user_id']);
		$stmt->execute();
	} catch (PDOException $e) {
		echo "Error: " . $e->getMessage();
	}
}
if (isset($_SERVER['HTTP_REFERER']))
	header("location: " . $_SERVER['HTTP_REFERER']);
else
	header('location: home.html.php'); */