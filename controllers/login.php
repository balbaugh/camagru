<?php

session_start();

include_once '../config/dbConnect.php';
include_once '../controllers/security.php';

date_default_timezone_set('Europe/Helsinki');



if (isset($_POST['submit_login'])) {
	$email = $_POST['email'];
	$password = $_POST['password'];

	// server-side form validation

	$empty_email = trim($_POST['email']);
	$empty_password = trim($_POST['password']);

	if (empty($empty_email)) {
		header("Location: ../sources/login.html.php?error=Email is required!");
		exit();
	} elseif (empty($empty_password)) {
		header("Location: ../sources/login.html.php?error=Password is required!");
		exit();
	} elseif (!filter_var($empty_email, FILTER_VALIDATE_EMAIL)) {
		header("Location: ../sources/login.html.php?error=Invalid email format!");
		exit();
	} elseif (strlen($empty_password) < 8) {
		header("Location: ../sources/login.html.php?error=Password must be at least 8 characters long!");
		exit();
	} elseif (!preg_match("/^[_\.0-9a-zA-Z-]+@([0-9a-zA-Z][0-9a-zA-Z-]+\.)+[a-zA-Z]{2,6}$/i", $empty_email)) {
		header("Location: ../sources/login.html.php?error=Invalid email address!");
		exit();
	}

	try {
		$conn = dbConnect();
		$stmt = $conn->prepare("SELECT id_user, username, email, password, verified, notifications FROM users WHERE email = ?");
		$stmt->execute([$empty_email]);
		$result = $stmt->fetch(PDO::FETCH_ASSOC);
		if ($result) {
			if (password_verify($empty_password, $result['password'])) {
				if ($result['verified'] == 1) {
					session_start();
					$_SESSION['logged'] = true;
					$_SESSION['id_user'] = $result['id_user'];
					$_SESSION['username'] = $result['username'];
					$_SESSION['email'] = $result['email'];
					$_SESSION['verified'] = $result['verified'];
					$_SESSION['notifications'] = $result['notifications'];


					header("Location: ../sources/home.html.php?success=You have been logged in!");
					exit();
				} else {
					header("Location: ../sources/login.html.php?error=Your account is not verified!");
					exit();
				}
			} else {
				header("Location: ../sources/login.html.php?error=Invalid email or password!");
				exit();
			}
		} else {
			header("Location: ../sources/login.html.php?error=Invalid email or password!");
			exit();
		}
	} catch (PDOException $e) {
		echo "Error: " . $e->getMessage();
	}
} else {
	header("Location: ../sources/login.html.php?error=Invalid email or password!");
	exit();
}