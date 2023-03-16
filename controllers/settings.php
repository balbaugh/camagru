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
include_once '../controllers/email.php';

date_default_timezone_set('Europe/Helsinki');


if (isset($_POST['newEmail']) && !empty($_POST['newEmail'])) {
	newEmail($_POST['newEmail']);
} elseif (isset($_POST['newUsername']) && !empty($_POST['newUsername'])) {
	newUsername($_POST['newUsername']);
} elseif (isset($_POST['newPassword']) && !empty($_POST['newPassword'])) {
	newPassword($_POST['newPassword']);
} elseif (isset($_POST['newNotifications']) && ($_POST['newNotifications'] == '1' || $_POST['newNotifications'] == '0')) {
	newNotifications($_POST['newNotifications']);
} elseif (isset($_POST['deleteAccount'])) {
	deleteAccount();
} else {
	header('Location: ../sources/settings.html.php?error=invalid action!');
}


function newEmail($newEmail)
{
	$email = filter_var(trim($newEmail), FILTER_SANITIZE_EMAIL);
	$newToken = bin2hex(random_bytes(8));
	$newTokenHash = password_hash($newToken, PASSWORD_DEFAULT);

	if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
		try {
			$conn = dbConnect();
			$stmt = $conn->query("SELECT * FROM users WHERE email = '$email'");
			$stmt->fetch(PDO::FETCH_ASSOC);
			$count = $stmt->rowCount();
			if ($count > 0) {
				header('Location: ../sources/settings.html.php?error=email already in use!');
			} else {
				if (session_status() === PHP_SESSION_NONE) {
					session_start();
				}
				session_regenerate_id(true);

				$stmt = $conn->prepare("UPDATE users SET email = ?, verify_token = ?, verified = 0 WHERE id_user = ?");
				$stmt->bindParam(1, $newEmail, PDO::PARAM_STR);
				$stmt->bindParam(2, $newTokenHash, PDO::PARAM_STR);
				$stmt->bindParam(3, $_SESSION['id_user'], PDO::PARAM_INT);

				$stmt->execute();

				$url = "http://localhost:8080/sources/verification.html.php";
				$urlSettings = "http://localhost:8080/sources/settings.html.php";

				$to = $newEmail;
				$subject = "Camagru :: New Email Verification";
				$body = 'Hello ' . $_SESSION['username'] . ', <br><br>';
				$body .= '<p>You email address has been updated!</p>.</br>';
				$body .= '<p>Your verification code is: <b>' . $newToken . '</b></p>';
				$body .= "<a href='$url'>Click here to verify your account.</a>";
				$body .= '</br>';
				$body .= 'Best regards, <br>';
				$body .= 'Camagru Team </br>';
				$body .= '</br>';
				$body .= "Please <a href=$urlSettings>CLICK HERE</a> if you would like to change your notification preferences. </br>";


				$headers = 'From: camagru <balbaugh@outlook.com>' . "\r\n" .
					'Reply-To: balbaugh@outlook.com' . "\r\n" .
					'Date: ' . date("r") . "\r\n" .
					'MIME-Version: 1.0' . "\r\n" .
					'Content-type: text/html; charset=ISO-8859-1' . "\r\n" .
					'X-Mailer: PHP/' . phpversion();

				mail($to, $subject, $body, $headers);

				session_destroy();

				header('Location: ../sources/verification.html.php?success=Email changed successfully! Check your inbox to verify the new address.');
			}
		} catch (PDOException $e) {
			echo $e->getMessage() . " in " . $e->getFile() . ":" . $e->getLine();
			exit();
		}
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
				if (session_status() === PHP_SESSION_NONE) {
					session_start();
				}
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

				notifyUsername($newUsername);

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
				if (session_status() === PHP_SESSION_NONE) {
					session_start();
				}
				session_regenerate_id(true);

				$newPassword = password_hash($newPassword, PASSWORD_DEFAULT);
				$stmt = $conn->prepare("UPDATE users SET password = :newPassword WHERE id_user = :id_user");
				$stmt->bindParam(':newPassword', $newPassword, PDO::PARAM_STR);
				$stmt->bindParam(':id_user', $_SESSION['id_user'], PDO::PARAM_INT);
				$stmt->execute();

				notifyPassword($_SESSION['id_user']);

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
		$stmt->bindParam(':newNotifications', $newNotifications, PDO::PARAM_INT);
		$stmt->bindParam(':id_user', $_SESSION['id_user'], PDO::PARAM_INT);
		$stmt->execute();

		notifyNotifications($_SESSION['id_user']);

		header('Location: ../sources/settings.html.php?success=Notifications preference changed successfully!');
	} catch (PDOException $e) {
		echo $e->getMessage() . " in " . $e->getFile() . ":" . $e->getLine();
		exit();
	}
}


function deleteAccount()
{
	if (isset($_SESSION['logged'])) {
		deleteUploads($_SESSION['id_user']);
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

			notifyDelete($_SESSION['id_user']);

			destroySession();

			header('Location: ../sources/home.html.php?success=Account deleted successfully!');
		} catch (PDOException $e) {
			echo $e->getMessage() . " in " . $e->getFile() . ":" . $e->getLine();
			exit();
		}
	} else {
		header('Location: ../sources/settings.html.php?error=You are not logged in!');
	}
}


function deleteUploads($id_user)
{
	try {
		$conn = dbConnect();
		$stmt = $conn->prepare("SELECT image_name FROM images WHERE id_user = :id_user");
		$stmt->bindParam(':id_user', $id_user, PDO::PARAM_INT);
		$stmt->execute();
		$images = $stmt->fetchAll();
		foreach ($images as $image) {
			unlink("../public/uploads/" . $image['image_name']);
		}
	} catch (PDOException $e) {
		echo $e->getMessage() . " in " . $e->getFile() . ":" . $e->getLine();
		exit();
	}
}