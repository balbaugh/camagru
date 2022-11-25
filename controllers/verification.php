<?php

if (session_status() === PHP_SESSION_NONE) {
	session_start();
}

include_once '../config/dbConnect.php';
include_once '../controllers/security.php';

date_default_timezone_set('Europe/Helsinki');

// controller for verifying user account with token sent to email and submitted by user
// in sources/verification.html.php. If token is correct, user verify_token is set to 1 and
// user is redirected to login page. If token is incorrect, user is redirected to
// verification page with error message.


if (($_SERVER['REQUEST_METHOD'] == 'POST') && (isset($_POST['submit_verification'])) && (!empty($_POST['email'])) && (isset($_POST['email']))) {
	$email = filter_var($_POST['email'], FILTER_VALIDATE_EMAIL);
	$email = filter_var($email, FILTER_SANITIZE_EMAIL);
	$verify_token = $_POST['verify_token'];
	$verify_token = htmlentities($verify_token, ENT_QUOTES, 'UTF-8');

	if (check_token($email, $verify_token)) {
		header("Location: ../sources/login.html.php?success=Your account has been verified! Please log in.");
	} else {
		header("Location: ../sources/verification.html.php?error=Invalid verification token!");
	}
} else {
	header("Location: ../sources/verification.html.php?error=Please try again!");
}


function check_token($email, $verify_token)
{
	try {
		$conn = dbConnect();
		$stmt = $conn->prepare("SELECT * FROM users WHERE email = ? AND verified = 0");
		$stmt->bindParam(1, $email, PDO::PARAM_STR);
		$stmt->execute();
		$result = $stmt->fetch(PDO::FETCH_ASSOC);
		if ($result) {
			if (password_verify($verify_token, $result['verify_token'])) {
				$stmt = $conn->prepare("UPDATE users SET verified = 1 WHERE email = ?");
				$stmt->bindParam(1, $email, PDO::PARAM_STR);
				$stmt->execute();
				return true;
			} else {
				return false;
			}
		}
	} catch (PDOException $e) {
		echo "Error: " . $e->getMessage();
	}
}


/*
if (($_SERVER['REQUEST_METHOD'] == 'GET') && (!empty($_GET['verify_token'])) && (isset($_GET['verify_token'])) && (!empty($_GET['email'])) && (isset($_GET['email']))) {
	$email = filter_var($_GET['email'], FILTER_VALIDATE_EMAIL);
	$email = filter_var($email, FILTER_SANITIZE_EMAIL);
	$verify_token = $_GET['verify_token'];
	$verify_token = htmlentities($verify_token, ENT_QUOTES, 'UTF-8');

	if (check_token($email, $verify_token)) {
		header("Location: ../sources/login.html.php?success=Your account has been verified! Please log in.");
	} else {
		header("Location: ../sources/verification.html.php?error=Invalid verification token!");
	}
} else {
	header("Location: ../sources/verification.html.php?error=Please try again!");
}
*/