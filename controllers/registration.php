<?php

if (session_status() === PHP_SESSION_NONE) {
	session_start();
}

include_once '../config/dbConnect.php';

include_once '../controllers/security.php';

include_once '../controllers/email.php';

date_default_timezone_set('Europe/Helsinki');

if (isset($_POST['submit_registration'])) {
	$email = trim($_POST['email']);
	$email = filter_var($email, FILTER_SANITIZE_EMAIL);
	$username = sanitize($_POST['username']);
	$password = trim($_POST['password']);
	$verify_token = bin2hex(random_bytes(8));
	$hashedToken = password_hash($verify_token, PASSWORD_DEFAULT);

	if (empty($email)) {
		header("Location: ../sources/register.html.php?error=Email is required!");
		exit();
	}
	if (empty($username)) {
		header("Location: ../sources/register.html.php?error=Username is required!");
		exit();
	}
	if (empty($password)) {
		header("Location: ../sources/register.html.php?error=Password is required!");
		exit();
	}
	if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
		header("Location: ../sources/register.html.php?error=Invalid email format!");
		exit();
	}
	if (!preg_match("/^[a-zA-Z0-9]*$/", $username)) {
		header("Location: ../sources/register.html.php?error=Username must be alphanumberic!");
		exit();
	}
	if (!validatePassword($password)) {
		header("Location: ../sources/register.html.php?error=Password must contain at least 8 characters, 1 uppercase letter, 1 lowercase letter and 1 number!");
		exit();
	}

	try {
		$conn = dbConnect();
		$stmt = $conn->prepare("SELECT * FROM users WHERE email = ? OR username = ?");
		$stmt->bindParam(1, $email, PDO::PARAM_STR);
		$stmt->bindParam(2, $username, PDO::PARAM_STR);
		$stmt->execute();
		$result = $stmt->fetch(PDO::FETCH_ASSOC);


		if ($result && $result['email'] === $email) {
			header("Location: ../sources/register.html.php?error=Account associated with that email already exists!");
			exit();
		} else if ($result && $result['username'] === $username) {
			header("Location: ../sources/register.html.php?error=Username already exists!");
			exit();
		} else {
			$hashedPassword = password_hash($password, PASSWORD_DEFAULT);
			try {
				$conn = dbConnect();
				$stmt = $conn->prepare("INSERT INTO users (email, username, password, verify_token) VALUES (?, ?, ?, ?)");
				$stmt->bindParam(1, $email, PDO::PARAM_STR);
				$stmt->bindParam(2, $username, PDO::PARAM_STR);
				$stmt->bindParam(3, $hashedPassword, PDO::PARAM_STR);
				$stmt->bindParam(4, $hashedToken, PDO::PARAM_STR);
				$stmt->execute();
			} catch (PDOException $e) {
				echo "Unable to connect to the database server: " . $e->getMessage() . " in " . $e->getFile() . ":" . $e->getLine();
				exit();
			}

			$url = "http://localhost:8080/camagru/sources/verification.html.php";
			$verifyUrl = "http://localhost:8080/camagru/controllers/verification.php?email=" . $email . "&token=" . $verify_token;
			$to = $email;
			$subject = "Camagru Verification Code";
			$body = '<p>Thank you for registering with camagru!</p>.</br>';
			$body .= '<p>Your verification code is: <b>' . $verify_token . '</b></p>.</br>';
			$body .= '</br>';
			$body .= "<p>Please click <a href=$url>HERE</a>, and enter the code to verify your account.</p>.</br>";
			$body .= '</br>';
			$body .= '<p>Thank you!</p> </br>';
			$body .= '<p>Camagru Team</p>';

			$headers = 'From: camagru <balbaugh@outlook.com>' . "\r\n" .
				'Reply-To: balbaugh@outlook.com' . "\r\n" .
				'Date: ' . date("r") . "\r\n" .
				'MIME-Version: 1.0' . "\r\n" .
				'Content-type: text/html; charset=ISO-8859-1' . "\r\n" .
				'X-Mailer: PHP/' . phpversion();

			mail($to, $subject, $body, $headers);

			header("Location: ../sources/verification.html.php?success=Registration successful! Please check your email for verification code.");
		}
	} catch (PDOException $e) {
		echo "Unable to connect to the database server: " . $e->getMessage() . " in " . $e->getFile() . ":" . $e->getLine();
		exit();
	}
}