<?php

session_start();

include_once '../config/dbConnect.php';
include_once '../controllers/security.php';

date_default_timezone_set('Europe/Helsinki');


if (isset($_POST['newEmail']) && $_POST['newEmail'] != '') {
	newEmail($_POST['newEmail']);
} elseif (isset($_POST['newUsername']) && $_POST['newUsername'] != '') {
	newUsername($_POST['newUsername']);
} elseif (isset($_POST['newPassword'])) {
	newPassword($_POST['newPassword']);
} elseif (isset($_POST['newNotifications'])) {
	newNotifications($_POST['newNotifications']);
} elseif (isset($_POST['deleteAccount'])) {
	deleteAccount();
} else {
	header('Location: ../sources/settings.html.php?error=invalid action!');
}


function newEmail($newEmail)
{
	if (filter_var($newEmail, FILTER_VALIDATE_EMAIL)) {
		try {
			$conn = dbConnect();
			$checkEmail = $conn->query("SELECT * FROM users WHERE email = '$newEmail'");
			$checkEmail->fetch();
			if ($checkEmail->rowCount() > 0) {
				header('Location: ../sources/settings.html.php?error=email already in use!');
			} else {
				$newToken = random_int(100000, 999999);
				$stmt = $conn->prepare("UPDATE users SET email = :newEmail, verify_token = :newToken, verified = 0 WHERE id_user = :id_user");
				$stmt->bindParam(':newEmail', $newEmail);
				$stmt->bindParam(':newToken', $newToken);
				$stmt->bindParam(':id_user', $_SESSION['id_user']);
				$stmt->execute();
			}
		} catch (PDOException $e) {
			echo $e->getMessage() . " in " . $e->getFile() . ":" . $e->getLine();
			exit();
		}

		$url = "http://localhost:8080/camaguru/sources/verification.html.php";
		$to = $newEmail;
		$subject = "Email Verification";
		$message = '<p>You email address has been updated!</p>.</br>';
		$message .= '<p>Your verification code is: <b>' . $newToken . '</b></p>';
		$message .= "<a href='$url'>Click here to verify your account.</a>";

		$headers = "From: balbaugh <info@hive.fi>\r\n";
		$headers .= "Reply-To: info@hive.fi\r\n";
		$headers .= "Content-type: text/html\r\n";

		mail($to, $subject, $message, $headers);


		$email_log = "Registration was successful and verification email has been sent to $newEmail.";

		session_destroy();

		header('Location: ../sources/verification.html.php?success=Email changed successfully! Check your inbox to verify the new address.');

		exit();
	} else {
		header('Location: ../sources/settings.html.php?error=Invalid email!');
	}
}


function newUsername($newUsername)
{
	if (preg_match('/^[a-zA-Z0-9]+$/', $newUsername)) {
		try {
			$newUsername = validateData($newUsername);
			$conn = dbConnect();
			$checkUsername = $conn->query("SELECT * FROM users WHERE username = '$newUsername'");
			$checkUsername->fetch();
			if ($checkUsername->rowCount() > 0) {
				header('Location: ../sources/settings.html.php?error=username already taken');
			} else {
				$_POST = array();

				$stmtUsername = $conn->prepare("UPDATE users SET username = '$newUsername' WHERE id_user = :id_user");
				$stmtUsername->bindParam(':id_user', $_SESSION['id_user']);
				$stmtUsername->execute();

				$stmtImages = $conn->prepare("UPDATE images SET username = '$newUsername' WHERE id_user = :id_user");
				$stmtImages->bindParam(':id_user', $_SESSION['id_user']);
				$stmtImages->execute();

				$stmtComments = $conn->prepare("UPDATE comments SET username = '$newUsername' WHERE id_user = :id_user");
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
		header('Location: ../sources/settings.html.php?error=invalid username');
	}
}


function newPassword($newPassword)
{
	if (validatePassword($newPassword) == true) {
		try {
			$conn = dbConnect();
			$comparePassword = $conn->query("SELECT * FROM users WHERE id_user = '$_SESSION[id_user]'");
			$comparePassword = $comparePassword->fetch();
			if (password_verify($newPassword, $comparePassword['password'])) {
				header('Location: ../sources/settings.html.php?error=New password cannot be the same as the old one!');
			} else {
				$newPassword = password_hash($newPassword, PASSWORD_DEFAULT);
				$stmt = $conn->prepare("UPDATE users SET password = :newPassword WHERE id_user = :id_user");
				$stmt->bindParam(':newPassword', $newPassword);
				$stmt->bindParam(':id_user', $_SESSION['id_user']);
				$stmt->execute();
				session_destroy();
				header('Location: ../sources/login.html.php?success=Password change successful! Please login.');
			}
		} catch (PDOException $e) {
			echo $e->getMessage() . " in " . $e->getFile() . ":" . $e->getLine();
			exit();
		}
	} else {
		header('Location: ../sources/settings.html.php?error=Invalid password!');
	}
}


function newNotifications($newNotifications)
{
	try {
		$conn = dbConnect();
		$stmt = $conn->prepare("UPDATE users SET notifications = :newNotifications WHERE id_user = :id_user");
		$stmt->bindParam(':newNotifications', $newNotifications);
		$stmt->bindParam(':id_user', $_SESSION['id_user']);
		$stmt->execute();
		header('Location: ../sources/settings.html.php?success=Notifications preference changed successfully!');
	} catch (PDOException $e) {
		echo $e->getMessage() . " in " . $e->getFile() . ":" . $e->getLine();
		exit();
	}
}


function deleteAccount()
{
	if (isset($_SESSION['logged'])) {
		try {
			$conn = dbConnect();

			$stmtLikes = $conn->prepare("DELETE FROM likes WHERE id_user = :id_user");
			$stmtLikes->bindParam(':id_user', $_SESSION['id_user']);
			$stmtLikes->execute();

			$stmtComments = $conn->prepare("DELETE FROM comments WHERE id_user = :id_user");
			$stmtComments->bindParam(':id_user', $_SESSION['id_user']);
			$stmtComments->execute();

			$stmtImages = $conn->prepare("DELETE FROM images WHERE id_user = :id_user");
			$stmtImages->bindParam(':id_user', $_SESSION['id_user']);
			$stmtImages->execute();

			$stmtUser = $conn->prepare("DELETE FROM users WHERE id_user = :id_user");
			$stmtUser->bindParam(':id_user', $_SESSION['id_user']);
			$stmtUser->execute();

			destroySession();
			header('Location: ../sources/index.html.php?success=Account deleted successfully!');
		} catch (PDOException $e) {
			echo $e->getMessage() . " in " . $e->getFile() . ":" . $e->getLine();
			exit();
		}
	} else {
		header('Location: ../sources/settings.html.php?error=You are not logged in!');
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
header("Location: ../sources/settings.html.php?error=Email is required!");
exit();
} else if (empty($empty_username)) {
header("Location: ../sources/settings.html.php?error=Username is required!");
exit();
} else if (empty($empty_password)) {
header("Location: ../sources/settings.html.php?error=Password is required!");
exit();
} else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
header("Location: ../sources/settings.html.php?error=Invalid email format!");
exit();
} else if (!preg_match("/^[a-zA-Z0-9]*$/", $username)) {
header("Location: ../sources/settings.html.php?error=Invalid username!");
exit();
} else if (strlen($password) < 8) { header("Location: ../sources/settings.html.php?error=Password must be at
	least 8 characters long!"); exit(); } else if
	(!preg_match("/^[_\.0-9a-zA-Z-]+@([0-9a-zA-Z][0-9a-zA-Z-]+\.)+[a-zA-Z]{2,6}$/i", $empty_email)) { header("Location:
	../sources/settings.html.php?error=Invalid email address!"); exit(); } else if (preg_match("/[<>=\{\}\/]/",
	$empty_username)) {
	header("Location: ../sources/settings.html.php?error=Username cannot contain special characters!");
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