<?php

session_start();

include_once '../config/dbConnect.php';

include_once '../controllers/security.php';

date_default_timezone_set('Europe/Helsinki');

if (isset($_POST['submit_registration'])) {
	$email = $_POST['email'];
	$username = htmlentities($_POST['username']);
	$password = $_POST['password'];
	$verify_token = random_int($min = 100000, $max = 999999);

	//server-side form validation

	$empty_email = trim($_POST['email']);
	$empty_username = trim($_POST['username']);
	$empty_password = trim($_POST['password']);

	if (empty($empty_email)) {
		header("Location: ../sources/register.html.php?error=Email is required!");
		exit();
	} elseif (empty($empty_username)) {
		header("Location: ../sources/register.html.php?error=Username is required!");
		exit();
	} elseif (empty($empty_password)) {
		header("Location: ../sources/register.html.php?error=Password is required!");
		exit();
	} elseif (!filter_var($empty_email, FILTER_VALIDATE_EMAIL)) {
		header("Location: ../sources/register.html.php?error=Invalid email format!");
		exit();
	} elseif (!preg_match("/^[a-zA-Z0-9]*$/", $empty_username)) {
		header("Location: ../sources/register.html.php?error=Invalid username!");
		exit();
	} elseif (!validatePassword($empty_password)) {
		header("Location: ../sources/register.html.php?error=Password must contain at least 8 characters, 1 uppercase letter, 1 lowercase letter and 1 number!");
	} elseif (strlen($empty_password) < 8) {
		header("Location: ../sources/register.html.php?error=Password must be at least 8 characters long!");
		exit();
	} elseif (!preg_match("/^[_\.0-9a-zA-Z-]+@([0-9a-zA-Z][0-9a-zA-Z-]+\.)+[a-zA-Z]{2,6}$/i", $empty_email)) {
		header("Location: ../sources/register.html.php?error=Invalid email address!");
		exit();
	} elseif (preg_match("/[<>=\{\}\/]/", $empty_username)) {
		header("Location: ../sources/register.html.php?error=Username cannot contain special characters!");
		exit();
	}

	try {
		$conn = dbConnect();
		$stmt = $conn->prepare("SELECT id_user FROM users WHERE email = ? OR username = ?");

		$stmt->bindParam(1, $empty_email);
		$stmt->bindParam(2, $empty_username);
		$stmt->execute();
		$result = $stmt->fetch(PDO::FETCH_ASSOC);
	} catch (PDOException $e) {
		echo "Unable to connect to the database server: " . $e->getMessage() . " in " . $e->getFile() . ":" . $e->getLine();
		exit();
	}
	if ($result == $empty_email) {
		header("Location: ../sources/register.html.php?error=Email already exists!");
		exit();
	}
	if ($result == $empty_username) {
		header("Location: ../sources/register.html.php?error=Username already exists!");
		exit();
	} else {
		$hashedPassword = password_hash($empty_password, PASSWORD_DEFAULT);
		try {
			$conn = dbConnect();
			$stmt = $conn->prepare("INSERT INTO users (email, username, password, verify_token) VALUES (?, ?, ?, ?)");
			$stmt->bindParam(1, $empty_email);
			$stmt->bindParam(2, $empty_username);
			$stmt->bindParam(3, $hashedPassword);
			$stmt->bindParam(4, $verify_token);
			$stmt->execute();
		} catch (PDOException $e) {
			echo "Unable to connect to the database server: " . $e->getMessage() . " in " . $e->getFile() . ":" . $e->getLine();
			exit();
		}

		$url = "http://localhost:8080/camaguru/sources/verification.html.php";
		$to = $empty_email;
		$subject = "Email Verification";
		$message = '<p>Thank you for registering with camagru!</p>.</br>';
		$message .= '<p>Your verification code is: <b>' . $verify_token . '</b></p>';
		$message .= "<a href='$url'>Click here to verify your account.</a>";

		$headers = "From: balbaugh <info@hive.fi>\r\n";
		$headers .= "Reply-To: info@hive.fi\r\n";
		$headers .= "Content-type: text/html\r\n";

		mail($to, $subject, $message, $headers);

		$email_log = "Registration was successful and verification email has been sent to $empty_email.";

		header("Location: ../sources/verification.html.php?success=Registration successful, please check email for verification code!");
		exit();
	}
} else {
	header('Location: ../sources/register.html.php?error=An error has occurred. Please try again.');
	exit();
}