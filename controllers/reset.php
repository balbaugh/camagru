<?php

session_start();

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

if (!empty($_SESSION['logged'])) {
	header("Location: ../controllers/logout.php");
	exit();
}

if (isset($_POST['submitForgot']) && !empty($_POST['email'])) {
	resetEmail($_POST['email']);
} elseif (isset($_POST['submitReset']) && !empty($_POST['email']) && !empty($_POST['verify_token']) && !empty($_POST['password'])) {
	resetPassword($_POST['submitReset']);
}


function resetEmail($email)
{
	if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
		try {
			$conn = dbConnect();
			$checkEmail = $conn->query("SELECT * FROM users WHERE email = '$email'");
			$checkEmail->fetch();
			if ($checkEmail->rowCount() > 0) {
				$newToken = random_int(100000, 999999);
				$stmt = $conn->prepare("UPDATE users SET verify_token = :newToken WHERE email = :email");
				$stmt->bindParam(':newToken', $newToken, PDO::PARAM_INT);
				$stmt->bindParam(':email', $email, PDO::PARAM_STR);
				$stmt->execute();
			} else {
				header('Location: ../sources/forgot.html.php?error=Email not found!');
				exit();
			}
		} catch (PDOException $e) {
			echo $e->getMessage() . " in " . $e->getFile() . ":" . $e->getLine();
			exit();
		}

		$url = "http://localhost:8080/camaguru/sources/reset.html.php";
		$to = $email;
		$subject = "Password Reset";
		$message = '<p>You have requested a password reset.</p>.</br>';
		$message .= '<p>Your reset code is: <b>' . $newToken . '</b></p>';
		$message .= "<a href='$url'>Click here to reset your password.</a>";

		$headers = "From: balbaugh <info@hive.fi>\r\n";
		$headers .= "Reply-To: info@hive.fi\r\n";
		$headers .= "Content-type: text/html\r\n";

		mail($to, $subject, $message, $headers);


		$email_log = "Reset password was triggered and verification token email has been sent to $email.";

		session_destroy();

		header('Location: ../sources/reset.html.php?success=Password reset triggered! Check your inbox for a token to verify the change.');

		exit();
	} else {
		header('Location: ../sources/forgot.html.php?error=Invalid email!');
		exit();
	}
}

function resetPassword($resetPassword)
{
	$resetParams = array();
	$resetParams['email'] = $_POST['email'];
	$resetParams['verify_token'] = $_POST['verify_token'];
	$resetParams['password'] = $_POST['password'];

	if (filter_var($resetParams['email'], FILTER_VALIDATE_EMAIL) && validatePassword($resetParams['password']) == 1 && numberCheck($resetParams['verify_token']) == 1) {
		try {
			$conn = dbConnect();
			$checkEmail = $conn->query("SELECT * FROM users WHERE email = '$resetParams[email]'");
			$checkEmail->fetch();
			if ($checkEmail->rowCount() > 0) {
				$stmt = $conn->prepare("SELECT * FROM users WHERE email = :email AND verify_token = :verify_token");
				$stmt->bindParam(':email', $resetParams['email'], PDO::PARAM_STR);
				$stmt->bindParam(':verify_token', $resetParams['verify_token'], PDO::PARAM_INT);
				$stmt->execute();
				$checkToken = $stmt->fetch();
				if (password_verify($resetParams['password'], $checkToken['password'])) {
					header('Location: ../sources/reset.html.php?error=New password cannot be the same as the old one!');
					exit();
				}
                if ($checkToken['verify_token'] == $resetParams['verify_token']) {
					$hashedPassword = password_hash($resetParams['password'], PASSWORD_DEFAULT);
					$stmt = $conn->prepare("UPDATE users SET password = :password WHERE email = :email");
					$stmt->bindParam(':password', $hashedPassword, PDO::PARAM_STR);
					$stmt->bindParam(':email', $resetParams['email'], PDO::PARAM_STR);
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

		$email_log = "Password reset was triggered and password has been changed for $resetParams[email].";

		session_destroy();

		header('Location: ../sources/login.html.php?success=Password reset successful!');

		exit();
	} else {
		header('Location: ../sources/reset.html.php?error=Invalid email!');
		exit();
	}
}