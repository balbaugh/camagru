<?php

session_start();

include_once '../config/dbconnect.php';

date_default_timezone_set('Europe/Helsinki');


/* if (isset($_POST['delete_picture']) && !empty($_POST['delete_picture'])) {
	$img_id = $_POST['delete_picture'];

	if (img_by_user($img_id, $_SESSION['user_id'])) {
		unlink("../img/uploads/" . get_img_path_by_id($img_id));
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
	header('location: home.php'); */