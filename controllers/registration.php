<?php

session_start();

include_once '../config/dbConnect.php';

include_once '../controllers/security.php';

date_default_timezone_set('Europe/Helsinki');

if (isset($_POST['submit_registration'])) {
	$email = trim($_POST['email']);
	$email = filter_var($email, FILTER_SANITIZE_EMAIL);
	$username = sanitize($_POST['username']);
	$password = trim($_POST['password']);
	$verify_token = random_int($min = 100000, $max = 999999);


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

		if ($result['email']) {
			header("Location: ../sources/register.html.php?error=Account associated with that email already exists!");
			exit();
		} else if ($result['username'] == $username) {
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
			$subject = "Camagru Verification Code";
			$body = '<p>Thank you for registering with camagru!</p>.</br>';
			$body .= '<p>Your verification code is: <b>' . $verify_token . '</b></p>';
			$body .= "<a href='$url'>Click here to verify your account.</a>";

			$headers = 'MIME-Version: 1.0' . "\r\n" .
				'Content-type: text/html; charset=utf-8' . "\r\n" .
				'From: balbaugh <info@camagru.fi>' . "\r\n" .
				'Reply-To: info@camagru.fi' . "\r\n" .
				'X-Mailer: PHP/' . phpversion();

			mail($to, $subject, $body, $headers);

			header("Location: ../sources/verification.html.php?success=Registration successful! Please check your email for verification code.");

			/* if (mail($to, $subject, $body, $headers)) {
				header("Location: ../sources/verification.html.php?success=Registration successful! Please check your email for verification code.");
				exit();
			} else {
				header("Location: ../sources/register.html.php?error=Something went wrong! Please try again!");
				exit();
			} */
		}
	} catch (PDOException $e) {
		echo "Unable to connect to the database server: " . $e->getMessage() . " in " . $e->getFile() . ":" . $e->getLine();
		exit();
	}
}