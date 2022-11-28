<?php

if (session_status() === PHP_SESSION_NONE) {
	session_start();
}


include_once '../config/dbConnect.php';
include_once '../controllers/email.php';

date_default_timezone_set('Europe/Helsinki');

if (isset($_SESSION['logged'])) {
	$id_user = $_SESSION['id_user'];
	$username = $_SESSION['username'];
}


if (isset($_POST['like']) && !empty($_POST['like'])) {
	$id_image = $_POST['like'];

	postLikes($id_image, $id_user);
} elseif (isset($_POST['unlike']) && !empty($_POST['unlike'])) {
	deleteLikes($_POST['unlike'], $_SESSION['id_user']);
}



function postLikes($id_image, $id_user)
{
	if (isset($_SESSION['check']) && !empty($_SESSION['check'])) {
		if (($_SESSION['check']) != hash('ripemd128', $_SERVER['REMOTE_ADDR'] . $_SERVER['HTTP_USER_AGENT'])) {
			session_destroy();
			header('Location: ../sources/login.html.php?error=Session expired!');
		} else {
			$_SESSION['check'] = hash('ripemd128', $_SERVER['REMOTE_ADDR'] . $_SERVER['HTTP_USER_AGENT']);
			try {
				$conn = dbConnect();
				$stmt = $conn->prepare("INSERT INTO likes (id_image, id_user, liked) VALUES (:id_image, :id_user, 1)");
				$stmt->bindParam(':id_image', $id_image, PDO::PARAM_INT);
				$stmt->bindParam(':id_user', $id_user, PDO::PARAM_INT);
				$stmt->execute();
				notifyLike($id_image, $_SESSION['username']);
				header("Location: ../sources/home.html.php");
				exit();
			} catch (PDOException $e) {
				echo $e->getMessage() . " in " . $e->getFile() . ":" . $e->getLine();
				exit();
			}
		}
	}
}


function deleteLikes($id_image, $id_user)
{
	if (isset($_SESSION['check']) && !empty($_SESSION['check'])) {
		if (($_SESSION['check']) != hash('ripemd128', $_SERVER['REMOTE_ADDR'] . $_SERVER['HTTP_USER_AGENT'])) {
			session_destroy();
			header('Location: ../sources/login.html.php?error=Session expired!');
		} else {
			$_SESSION['check'] = hash('ripemd128', $_SERVER['REMOTE_ADDR'] . $_SERVER['HTTP_USER_AGENT']);
			try {
				$conn = dbConnect();
				$stmt = $conn->prepare("DELETE FROM likes WHERE id_image = :id_image AND id_user = :id_user");
				$stmt->bindParam(':id_image', $id_image, PDO::PARAM_INT);
				$stmt->bindParam(':id_user', $id_user, PDO::PARAM_INT);
				$stmt->execute();
				header("Location: ../sources/home.html.php");
				exit();
			} catch (PDOException $e) {
				echo $e->getMessage() . " in " . $e->getFile() . ":" . $e->getLine();
				exit();
			}
		}
	}
}


function checkLikes($id_image, $id_user)
{
	try {
		$conn = dbConnect();
		$stmt = $conn->prepare("SELECT * FROM likes WHERE id_image = :id_image AND id_user = :id_user");
		$stmt->bindParam(':id_image', $id_image, PDO::PARAM_INT);
		$stmt->bindParam(':id_user', $_SESSION['id_user'], PDO::PARAM_INT);
		$stmt->execute();
		return $stmt->fetchAll();
	} catch (PDOException $e) {
		echo $e->getMessage() . " in " . $e->getFile() . ":" . $e->getLine();
		exit();
	}
}


function countLikes($id_image)
{
	try {
		$conn = dbConnect();
		$stmt = $conn->prepare("SELECT COUNT(*) FROM likes WHERE id_image = :id_image");
		$stmt->bindParam(':id_image', $id_image, PDO::PARAM_INT);
		$stmt->execute();
		return $stmt->fetchColumn();
	} catch (PDOException $e) {
		echo $e->getMessage() . " in " . $e->getFile() . ":" . $e->getLine();
		exit();
	}
}