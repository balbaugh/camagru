<?php

session_start();

include_once '../config/dbconnect.php';

date_default_timezone_set('Europe/Helsinki');


// check if user is logged in and update user information based on form input
if (isset($_SESSION['user'] && $_POST['submit_settings'])) {
	$username = htmlspecialchars($_POST['username']);
	$email = $_POST['email'];
	$password = $_POST['password'];
	$verify_token = rand(100000, 999999);

	//server-side form validation

	$empty_email = trim($_POST['email']);
	$empty_username = trim($_POST['username']);
	$empty_password = trim($_POST['password']);

	if (empty($empty_email)) {
		header("Location: ../sources/settings.html.php?email_error=Email is required!");
		exit();
	} else if (empty($empty_username)) {
		header("Location: ../sources/settings.html.php?username_error=Username is required!");
		exit();
	} else if (empty($empty_password)) {
		header("Location: ../sources/settings.html.php?password_error=Password is required!");
		exit();
	} else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
		header("Location: ../sources/settings.html.php?email_error=Invalid email format!");
		exit();
	} else if (!preg_match("/^[a-zA-Z0-9]*$/", $username)) {
		header("Location: ../sources/settings.html.php?username_error=Invalid username!");
		exit();
	} else if (strlen($password) < 8) {
		header("Location: ../sources/settings.html.php?password_error=Password must be at least 8 characters long!");
		exit();
	} else if (!preg_match("/^[_\.0-9a-zA-Z-]+@([0-9a-zA-Z][0-9a-zA-Z-]+\.)+[a-zA-Z]{2,6}$/i", $empty_email)) {
		header("Location: ../sources/settings.html.php?email_error=Invalid email address!");
		exit();
	} else if (preg_match("/[<>=\{\}\/]/", $empty_username)) {
		header("Location: ../sources/settings.html.php?username_error=Username cannot contain special characters!");
		exit();
	}

	try {
		$conn = dbConnect();
		$stmt = $conn->prepare("SELECT id_user FROM users WHERE email = ? OR username = ?");

		$stmt->bindParam(1, $email);
		$stmt->bindParam(2, $username);
		$stmt->execute();
		$result = $stmt->fetch(PDO::FETCH_ASSOC);
	} catch (PDOException $e) {
		echo "Unable to
		connect to database: " . $e->getMessage();
	}









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

	header("Location: ../sources/verification.html.php?success_message=Registration successful, please check email for verification code!");
	exit();
}