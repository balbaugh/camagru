<?php

if (session_status() === PHP_SESSION_NONE) {
	session_start();
}

if (isset($_SESSION['check']) && !empty($_SESSION['check'])) {
	if (($_SESSION['check']) != hash('ripemd128', $_SERVER['REMOTE_ADDR'] . $_SERVER['HTTP_USER_AGENT'])) {
		session_destroy();
		header('Location: ../sources/login.html.php?error=Session expired!');
	} else {
		$_SESSION['check'] = hash('ripemd128', $_SERVER['REMOTE_ADDR'] . $_SERVER['HTTP_USER_AGENT']);
	}
}

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
	$newEmail = trim($newEmail);
	if (filter_var($newEmail, FILTER_VALIDATE_EMAIL)) {
		try {
			$conn = dbConnect();
			$checkEmail = $conn->query("SELECT * FROM users WHERE email = '$newEmail'");
			$checkEmail->fetch();
			if ($checkEmail->rowCount() > 0) {
				header('Location: ../sources/settings.html.php?error=email already in use!');
			} else {
				session_start();
				session_regenerate_id(true);

				$newToken = random_int(100000, 999999);
				$stmt = $conn->prepare("UPDATE users SET email = :newEmail, verify_token = :newToken, verified = 0 WHERE id_user = :id_user");
				$stmt->bindParam(':newEmail', $newEmail, PDO::PARAM_STR);
				$stmt->bindParam(':newToken', $newToken, PDO::PARAM_INT);
				$stmt->bindParam(':id_user', $_SESSION['id_user'], PDO::PARAM_INT);
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
	$newUsername = sanitize($newUsername);
	if (preg_match('/^[a-zA-Z0-9]+$/', $newUsername)) {
		try {
			$conn = dbConnect();
			$checkUsername = $conn->query("SELECT * FROM users WHERE username = '$newUsername'");
			$checkUsername->fetch();
			if ($checkUsername->rowCount() > 0) {
				header('Location: ../sources/settings.html.php?error=username already taken');
			} else {
				session_start();
				session_regenerate_id(true);

				$stmtUsername = $conn->prepare("UPDATE users SET username = '$newUsername' WHERE id_user = :id_user");
				$stmtUsername->bindParam(':id_user', $_SESSION['id_user'], PDO::PARAM_INT);
				$stmtUsername->execute();

				$stmtImages = $conn->prepare("UPDATE images SET username = '$newUsername' WHERE id_user = :id_user");
				$stmtImages->bindParam(':id_user', $_SESSION['id_user'], PDO::PARAM_INT);
				$stmtImages->execute();

				$stmtComments = $conn->prepare("UPDATE comments SET username = '$newUsername' WHERE id_user = :id_user");
				$stmtComments->bindParam(':id_user', $_SESSION['id_user'], PDO::PARAM_INT);
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
	if (validatePassword($newPassword)) {
		try {
			$conn = dbConnect();
			$comparePassword = $conn->query("SELECT * FROM users WHERE id_user = '$_SESSION[id_user]'");
			$comparePassword = $comparePassword->fetch();
			if (password_verify($newPassword, $comparePassword['password'])) {
				header('Location: ../sources/settings.html.php?error=New password cannot be the same as the old one!');
			} else {
				session_start();
				session_regenerate_id(true);

				$newPassword = password_hash($newPassword, PASSWORD_DEFAULT);
				$stmt = $conn->prepare("UPDATE users SET password = :newPassword WHERE id_user = :id_user");
				$stmt->bindParam(':newPassword', $newPassword, PDO::PARAM_STR);
				$stmt->bindParam(':id_user', $_SESSION['id_user'], PDO::PARAM_INT);
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
		session_start();
		session_regenerate_id(true);

		$conn = dbConnect();
		$stmt = $conn->prepare("UPDATE users SET notifications = :newNotifications WHERE id_user = :id_user");
		$stmt->bindParam(':newNotifications', $newNotifications, PDO::PARAM_INT);
		$stmt->bindParam(':id_user', $_SESSION['id_user'], PDO::PARAM_INT);
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
			$stmtLikes->bindParam(':id_user', $_SESSION['id_user'], PDO::PARAM_INT);
			$stmtLikes->execute();

			$stmtComments = $conn->prepare("DELETE FROM comments WHERE id_user = :id_user");
			$stmtComments->bindParam(':id_user', $_SESSION['id_user'], PDO::PARAM_INT);
			$stmtComments->execute();

			$stmtImages = $conn->prepare("DELETE FROM images WHERE id_user = :id_user");
			$stmtImages->bindParam(':id_user', $_SESSION['id_user'], PDO::PARAM_INT);
			$stmtImages->execute();

			$stmtUser = $conn->prepare("DELETE FROM users WHERE id_user = :id_user");
			$stmtUser->bindParam(':id_user', $_SESSION['id_user'], PDO::PARAM_INT);
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