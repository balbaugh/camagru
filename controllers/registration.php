<?php

session_start();

include_once '../config/dbConnect.php';

include_once '../controllers/security.php';

date_default_timezone_set('Europe/Helsinki');

if (isset($_POST['submit_registration'])) {
	$email = trim($_POST['email']);
	$email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
	$username = sanitize($_POST['username']);
	$password = trim($_POST['password']);
	$verify_token = random_int($min = 100000, $max = 999999);


	if (empty($email)) {
		header("Location: ../sources/register.html.php?error=Email is required!");
		exit();
	} elseif (empty($username)) {
		header("Location: ../sources/register.html.php?error=Username is required!");
		exit();
	} elseif (empty($password)) {
		header("Location: ../sources/register.html.php?error=Password is required!");
		exit();
	} elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
		header("Location: ../sources/register.html.php?error=Invalid email format!");
		exit();
	} elseif (!preg_match("/^[a-zA-Z0-9]*$/", $username)) {
		header("Location: ../sources/register.html.php?error=Username must be alphanumberic!");
		exit();
	} elseif (!validatePassword($password)) {
		header("Location: ../sources/register.html.php?error=Password must contain at least 8 characters, 1 uppercase letter, 1 lowercase letter and 1 number!");
		exit();
	}

	try {
		$conn = dbConnect();
		$stmt = $conn->prepare("SELECT id_user FROM users WHERE email = ? OR username = ?");

		$stmt->bindParam(1, $email, PDO::PARAM_STR);
		$stmt->bindParam(2, $username, PDO::PARAM_STR);
		$stmt->execute();
		$result = $stmt->fetch(PDO::FETCH_ASSOC);
	} catch (PDOException $e) {
		echo "Unable to connect to the database server: " . $e->getMessage() . " in " . $e->getFile() . ":" . $e->getLine();
		exit();
	}
	if ($result == $email) {
		header("Location: ../sources/register.html.php?error=Email already exists!");
		exit();
	}
	if ($result == $username) {
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
			$stmt->bindParam(4, $verify_token, PDO::PARAM_INT);
			$stmt->execute();
		} catch (PDOException $e) {
			echo "Unable to connect to the database server: " . $e->getMessage() . " in " . $e->getFile() . ":" . $e->getLine();
			exit();
		}

		$url = "http://localhost:8080/camaguru/sources/verification.html.php";
		$to = $email;
		$subject = "Email Verification";
		$message = '<p>Thank you for registering with camagru!</p>.</br>';
		$message .= '<p>Your verification code is: <b>' . $verify_token . '</b></p>';
		$message .= "<a href='$url'>Click here to verify your account.</a>";

		$headers = 'MIME-Version: 1.0' . "\r\n";
		$headers .= 'Content-type: text/html; charset=utf-8' . "\r\n";
		$headers .= 'From: balbaugh <info@hive.fi>' . "\r\n";
		$headers .= 'Reply-To: info@hive.fi' . "\r\n";
		//$headers .= 'From: balbaugh <balbaugh@balbaughs-iMac.localdomain>' . "\r\n";
		//$headers .= 'Reply-To: balbaugh@balbaughs-iMac.localdomain' . "\r\n";
		$headers .= 'X-Mailer: PHP/' . phpversion();

		mail($to, $subject, $message, $headers);

		$email_log = "Registration was successful and verification email has been sent to $email.";

		header("Location: ../sources/verification.html.php?success=Registration successful, please check email for verification code!");

		exit();
	}
} else {
	header('Location: ../sources/register.html.php?error=An error has occurred. Please try again.');
	exit();
}