<?php

session_start();

include_once '../config/dbConnect.php';
include_once '../controllers/security.php';

date_default_timezone_set('Europe/Helsinki');


if (isset($_POST['newEmail'])) {
	newEmail($_POST['newEmail']);
}

if (isset($_POST['newUsername'])) {
	newUsername($_POST['newUsername']);
}

if (isset($_POST['newPassword'])) {
	newPassword($_POST['newPassword']);
}

if (isset($_POST['deleteAccount'])) {
	deleteAccount();
}

function newEmail($newEmail)
{
	if (filter_var($newEmail, FILTER_VALIDATE_EMAIL)) {
		try {
			$conn = dbConnect();
			$stmt = $conn->prepare("UPDATE users SET email = :email WHERE id_user = :id_user");
			$stmt->bindParam(':email', $newEmail);
			$stmt->bindParam(':id_user', $_SESSION['id_user']);
			$stmt->execute();
			$_SESSION['email'] = $newEmail;
			header('Location: ../sources/settings.html.php?success=Email changed successfully');
		} catch (PDOException $e) {
			echo $e->getMessage() . " in " . $e->getFile() . ":" . $e->getLine();
			exit();
		}
	} else {
		header('Location: ../views/settings.html.php?error=invalid email');
	}
}

function newUsername($newUsername)
{
	if (preg_match('/^[a-zA-Z0-9]+$/', $newUsername)) {
		try {
			$newUsername = validateData($newUsername);
			$conn = dbConnect();
			$checkUsername = $conn->prepare("SELECT * FROM users WHERE username = $newUsername");
			$checkUsername->execute();
			if ($checkUsername->rowCount() > 0) {
				header('Location: ../views/settings.html.php?error=username already taken');
			} else {
				$_POST = array();

				$stmtUsername = $conn->prepare("UPDATE users SET username = $newUsername WHERE id_user = :id_user");
				$stmtUsername->bindParam(':id_user', $_SESSION['id_user']);
				$stmtUsername->execute();

				$stmtImages = $conn->prepare("UPDATE images SET username = $newUsername WHERE id_user = :id_user");
				$stmtImages->bindParam(':id_user', $_SESSION['id_user']);
				$stmtImages->execute();

				$stmtComments = $conn->prepare("UPDATE comments SET username = $newUsername WHERE id_user = :id_user");
				$stmtComments->bindParam(':id_user', $_SESSION['id_user']);
				$stmtComments->execute();

				$_SESSION['username'] = $newUsername;
				header('Location: ../sources/settings.html.php?success=username changed successfully');
			}
		} catch (PDOException $e) {
			echo $e->getMessage() . " in " . $e->getFile() . ":" . $e->getLine();
			exit();
		}
	} else {
		header('Location: ../views/settings.html.php?error=invalid username');
	}
}



/*
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
 */