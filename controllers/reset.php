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

if (!empty($_SESSION['logged'])) {
	header("Location: ../controllers/logout.php");
	exit();
}

if (isset($_POST['submitForgot']) && !empty($_POST['email'])) {
	resetEmail($_POST['email']);
} elseif (isset($_POST['submitReset']) && !empty($_POST['email']) && !empty($_POST['verify_token']) && !empty($_POST['password'])) {
	resetPassword($_POST['email'], $_POST['verify_token'], $_POST['password']);
} else {
	header('Location: ../sources/reset.html.php?error=invalid action!');
}



function resetEmail($emailPost)
{

	$email = trim($_POST['email']);
	$email = filter_var($email, FILTER_SANITIZE_EMAIL);
	$token = bin2hex(random_bytes(8));
	$newToken = password_hash($token, PASSWORD_DEFAULT);

	if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
		try {
			$conn = dbConnect();
			$checkEmail = $conn->query("SELECT * FROM users WHERE email = '$email'");
			$checkEmail->fetch(PDO::FETCH_ASSOC);
			$count = $checkEmail->rowCount();
			if ($count > 0) {
				$stmt = $conn->prepare("UPDATE users SET verify_token = ? WHERE email = ?");
				$stmt->bindParam(1, $newToken, PDO::PARAM_STR);
				$stmt->bindParam(2, $email, PDO::PARAM_STR);

				$stmt->execute();

				notifyReset($email, $token);

				session_destroy();

				header('Location: ../sources/reset.html.php?success=Password reset triggered! Check your inbox for a token to verify the change.');

				exit();
			} else {
				header('Location: ../sources/forgot.html.php?error=Email not found!');
				exit();
			}
		} catch (PDOException $e) {
			echo $e->getMessage() . " in " . $e->getFile() . ":" . $e->getLine();
			exit();
		}
	} else {
		header('Location: ../sources/forgot.html.php?error=Invalid email!');
		exit();
	}
}

function
resetPassword($emailPost, $tokenPost, $passwordPost)
{
	$email = trim($_POST['email']);
	$email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
	$token = sanitize($_POST['verify_token']);
	$password = sanitize($_POST['password']);

	if (filter_var($email, FILTER_VALIDATE_EMAIL) && validatePassword($password) == 1) {
		try {
			$conn = dbConnect();
			$stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
			$stmt->bindParam(1, $email, PDO::PARAM_STR);
			$stmt->execute();
			$stmt->fetch(PDO::FETCH_ASSOC);
			$count = $stmt->rowCount();
			if ($count > 0) {
				$stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
				$stmt->bindParam(1, $email, PDO::PARAM_STR);
				$stmt->execute();
				$checkToken = $stmt->fetch(PDO::FETCH_ASSOC);
				if (password_verify($password, $checkToken['password'])) {
					header('Location: ../sources/reset.html.php?error=New password cannot be the same as the old one!');
					exit();
				}
				if (password_verify($token, $checkToken['verify_token'])) {
					$hashedPassword = password_hash($password, PASSWORD_DEFAULT);
					$stmt = $conn->prepare("UPDATE users SET password = ? WHERE email = ?");
					$stmt->bindParam(1, $hashedPassword, PDO::PARAM_STR);
					$stmt->bindParam(2, $email, PDO::PARAM_STR);
					$stmt->execute();
				} else {
					header('Location: ../sources/reset.html.php?error=Invalid token!');
					exit();
				}
			} else {
				header('Location: ../sources/reset.html.php?error=Email not found!');
				exit();
			}
		} catch (PDOException $e) {
			echo $e->getMessage() . " in " . $e->getFile() . ":" . $e->getLine();
			exit();
		}

		session_destroy();

		header('Location: ../sources/login.html.php?success=Password reset successful!');

		exit();
	} else {
		header('Location: ../sources/reset.html.php?error=Invalid email!');
		exit();
	}
}