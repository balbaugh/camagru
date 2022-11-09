<?php

session_start();

include_once '../config/dbConnect.php';

date_default_timezone_set('Europe/Helsinki');


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

// delete image from database and delete image file from server if image is owned by user logged in

if (!empty($_POST['deleteButton']) && isset($_POST['id_image'])) {
	deleteImage($_POST['id_image']);
}

function deleteImage($id_image)
{
	try {
		$conn = dbConnect();
		$stmt = $conn->prepare("SELECT * FROM images WHERE id_image = :id_image");
		$stmt->bindParam(':id_image', $id_image);
		$stmt->execute();
		$image = $stmt->fetch();
		if ($image['id_user'] == $_SESSION['id_user']) {
			$imagePath = $image['image_name'];
			unlink("../public/uploads/" . $imagePath);
			$stmt = $conn->prepare("DELETE FROM images WHERE id_image = :id_image");
			$stmt->bindParam(':id_image', $id_image);
			$stmt->execute();
			$stmt = $conn->prepare("DELETE FROM comments WHERE id_image = :id_image");
			$stmt->bindParam(':id_image', $id_image);
			$stmt->execute();
			$stmt = $conn->prepare("DELETE FROM likes WHERE id_image = :id_image");
			$stmt->bindParam(':id_image', $id_image);
			$stmt->execute();

			header('Location: ../sources/home.html.php?success=Image deleted!');
		}
	} catch (PDOException $e) {
		echo $e->getMessage() . " in " . $e->getFile() . ":" . $e->getLine();
		exit();
	}
}
