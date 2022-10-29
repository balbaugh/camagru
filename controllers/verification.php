<?php

session_start();

include_once '../config/dbConnect.php';
include_once '../controllers/security.php';

date_default_timezone_set('Europe/Helsinki');

// controller for verifying user account with token sent to email and submitted by user
// in sources/verification.html.php. If token is correct, user verify_token is set to 1 and
// user is redirected to login page. If token is incorrect, user is redirected to
// verification page with error message.


if (isset($_POST['submit_verification'])) {
	$email = $_POST['email'];
	$verify_token = $_POST['verify_token'];
	if (check_token($email, $verify_token)) {
		header("Location: ../sources/login.html.php?success=Your account has been verified! Please log in.");
	} else {
		header("Location: ../sources/verification.html.php?error=Invalid verification token!");
	}
} else {
	header("Location: ../sources/verification.html.php?error=Invalid verification token!");
}
exit();

function check_token($email, $verify_token)
{
	if (numberCheck($verify_token) == 1) {
		try {
			$conn = dbConnect();
			$stmt = $conn->prepare("SELECT * FROM users WHERE email = :email AND verify_token = :verify_token");
			$stmt->bindParam(':email', $email);
			$stmt->bindParam(':verify_token', $verify_token);
			$stmt->execute();
			$user = $stmt->fetch();
			if ($user) {
				$stmt = $conn->prepare("UPDATE users SET verified = 1 WHERE email = :email AND verify_token = :verify_token");
				$stmt->bindParam(':email', $email);
				$stmt->bindParam(':verify_token', $verify_token);
				$stmt->execute();
				return (1);
			} else {
				return (0);
			}
		} catch (PDOException $e) {
			echo "Unable to connect to the database server: " . $e->getMessage()
				. " in " . $e->getFile() . ":" . $e->getLine();
		}
	} else {
		return (0);
	}
}