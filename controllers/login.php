<?php

if (session_status() === PHP_SESSION_NONE) {
	session_start();
}


include_once '../config/dbConnect.php';
include_once '../controllers/security.php';

date_default_timezone_set('Europe/Helsinki');


/*
1. The session_status() function checks if the session is started or not.
2. The PHP_SESSION_NONE is a constant which is declared in the PHP core files.
3. The session_start() function starts the session.
4. The session_regenerate_id() function regenerates the session ID. This will prevent session hijacking.
5. The true parameter is used to indicate that the existing session should be destroyed.
*/

if (isset($_POST['submit_login'])) {
	$email = trim($_POST['email']);
	$email = filter_var($email, FILTER_SANITIZE_EMAIL);
	$password = trim($_POST['password']);

	if (empty($email)) {
		header("Location: ../sources/login.html.php?error=Email is required!");
		exit();
	}
	if (empty($password)) {
		header("Location: ../sources/login.html.php?error=Password is required!");
		exit();
	}
	if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
		header("Location: ../sources/login.html.php?error=Invalid email format!");
		exit();
	}
	if (!validatePassword($password)) {
		header("Location: ../sources/login.html.php?error=Incorrect password format!");
		exit();
	}

	try {
		$conn = dbConnect();
		$stmt = $conn->prepare("SELECT id_user, username, email, password, verified, notifications FROM users WHERE email = ?");
		$stmt->bindParam(1, $email, PDO::PARAM_STR);
		$stmt->execute();
		$result = $stmt->fetch(PDO::FETCH_ASSOC);
		if ($result) {
			if (password_verify($password, $result['password'])) {
				if ($result['verified'] == 1) {

					if (session_status() === PHP_SESSION_NONE) {
						session_start();
					}
					session_regenerate_id(true);

					$_SESSION['logged'] = true;
					$_SESSION['id_user'] = $result['id_user'];
					$_SESSION['username'] = $result['username'];
					$_SESSION['email'] = $result['email'];
					$_SESSION['verified'] = $result['verified'];
					$_SESSION['notifications'] = $result['notifications'];

					$_SESSION['check'] = hash('ripemd128', $_SERVER['REMOTE_ADDR'] . $_SERVER['HTTP_USER_AGENT']);
					$token = $_SESSION['check'];


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