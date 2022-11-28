<?php

if (session_status() === PHP_SESSION_NONE) {
	session_start();
}

include_once '../config/dbConnect.php';
include_once '../controllers/security.php';
include_once '../controllers/email.php';

date_default_timezone_set('Europe/Helsinki');


$id_user = $_SESSION['id_user'];
$username = $_SESSION['username'];

if (isset($_POST['postComment']) && isset($_POST['id_image']) && !empty($_POST['postComment']) && !empty($_POST['id_image'])) {
	if (strlen($_POST['postComment']) <= 255) {
		$comment = sanitize($_POST['postComment']);
		$id_image = $_POST['id_image'];

		postComment($id_image, $id_user, $comment);
	}
}



function postComment($id_image, $id_user, $comment)
{
	if (isset($_SESSION['check']) && !empty($_SESSION['check'])) {
		if (($_SESSION['check']) != hash('ripemd128', $_SERVER['REMOTE_ADDR'] . $_SERVER['HTTP_USER_AGENT'])) {
			session_destroy();
			header('Location: ../sources/login.html.php?error=Session expired!');
		} else {
			$_SESSION['check'] = hash('ripemd128', $_SERVER['REMOTE_ADDR'] . $_SERVER['HTTP_USER_AGENT']);
			try {
				$conn = dbConnect();
				$stmt = $conn->prepare("INSERT INTO comments (id_image, id_user, username, comment) VALUES (:id_image, :id_user, :username, :comment)");
				$stmt->bindParam(':id_image', $id_image, PDO::PARAM_INT);
				$stmt->bindParam(':id_user', $id_user, PDO::PARAM_INT);
				$stmt->bindParam(':username', $_SESSION['username'], PDO::PARAM_STR);
				$stmt->bindParam(':comment', $comment, PDO::PARAM_STR);
				$stmt->execute();
				notifyComment($id_image, $_SESSION['username'], $comment);
				header("Location: ../sources/home.html.php");
				exit();
			} catch (PDOException $e) {
				echo $e->getMessage() . " in " . $e->getFile() . ":" . $e->getLine();
				exit();
			}
		}
	}
}