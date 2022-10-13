<?php

session_start();

include_once '../config/dbconnect.php';

// controller for verifying user account with token sent to email and submitted by user
// in sources/verification.html.php. If token is correct, user verify_token is set to 1 and
// user is redirected to login page. If token is incorrect, user is redirected to
// verification page with error message.

function check_token($email, $verify_token)
{
	try {
		$conn = dbconnect();
		$stmt = $conn->prepare("SELECT * FROM users WHERE email = :email AND verify_token = :verify_token");
		$stmt->bindParam(':email', $email);
		$stmt->bindParam(':verify_token', $verify_token);
		$stmt->execute();
		$user = $stmt->fetch();
		if ($user) {
			$stmt = $conn->prepare("UPDATE users SET verify_token = 1 WHERE email = :email AND verify_token = :verify_token");
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
}

if (isset($_POST['submit_verification'])) {
	$email = $_POST['email'];
	$verify_token = $_POST['verify_token'];
	if (check_token($email, $verify_token)) {
		header("Location: ../sources/login.html.php?token_success=Your account has been verified!");
	} else {
		header("Location: ../sources/verification.html.php?token_error=Invalid verification token!");
	}
} else {
	header("Location: ../sources/verification.html.php?token_error=Invalid verification token!");
}
exit();