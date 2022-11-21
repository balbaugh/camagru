<?php

session_start();

include_once '../config/dbConnect.php';
include_once '../controllers/security.php';

date_default_timezone_set('Europe/Helsinki');


if (!empty($_POST['postComment']) && !empty($_POST['id_image'])) {
	if (strlen($_POST['postComment']) <= 255) {
		$comment = sanitize($_POST['postComment']);
		$id_image = ($_POST['id_image']);
		$id_user = $_SESSION['id_user'];

		postComment($id_image, $id_user, $comment);
		// notifyUser($id_image, 1, $id_user, $comment);
	}
}
header('Location: ../sources/home.html.php');


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
			} catch (PDOException $e) {
				echo $e->getMessage() . " in " . $e->getFile() . ":" . $e->getLine();
				exit();
			}
		}
	}
}




/*
$url = "http://localhost:8080/camaguru/sources/verification.html.php";
$to = $email;
$subject = "Email Verification";
$message = '<p>Thank you for registering with camagru!</p>.</br>';
$message .= '<p>Your verification code is: <b>' . $verify_token . '</b></p>';
$message .= "<a href='$url'>Click here to verify your account.</a>";

$headers = "From: balbaugh <info@hive.fi>\r\n";
$headers .= "Reply-To: info@hive.fi\r\n";
$headers .= "Content-type: text/html\r\n";

mail($to, $subject, $message, $headers);

$email_log = "Registration was successful and verification email has been sent to $email.";

 */