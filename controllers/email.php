<?php

if (session_status() === PHP_SESSION_NONE) {
	session_start();
}


include_once '../config/dbConnect.php';

date_default_timezone_set('Europe/Helsinki');


function notifyComment($id_image, $username, $comment)
{
	try {
		$conn = dbConnect();
		$stmt = $conn->prepare("SELECT * FROM images WHERE id_image = :id_image");
		$stmt->bindParam(':id_image', $id_image, PDO::PARAM_INT);
		$stmt->execute();
		$result = $stmt->fetch(PDO::FETCH_ASSOC);
		if ($result) {
			$stmt = $conn->prepare("SELECT * FROM users WHERE id_user = ?");
			$stmt->bindParam(1, $result['id_user'], PDO::PARAM_INT);
			$stmt->execute();
			$result = $stmt->fetch(PDO::FETCH_ASSOC);
			if ($result && $result['notifications'] == 1) {

				$urlLogin = "http://localhost:8080/camagru/sources/login.html.php";
				$urlSettings = "http://localhost:8080/camagru/sources/settings.html.php";

				$to = $result['email'];
				$subject = "Camagru - Comment Notification";
				$body = 'Hello ' . $result['username'] . ', <br><br>';
				$body = 'There is a new comment on one of your images! <br><br>';
				$body .= $username . ' commented: "' . $comment . '" <br><br>';
				$body .= '</br>';
				$body .= "<a href=$urlLogin>CLICK HERE</a> to log in and view the post.</br>";
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
			}
		}
	} catch (PDOException $e) {
		echo "Error: " . $e->getMessage();
	}
}


function notifyLike($id_image, $username)
{
	try {
		$conn = dbConnect();
		$stmt = $conn->prepare("SELECT * FROM images WHERE id_image = :id_image");
		$stmt->bindParam(':id_image', $id_image, PDO::PARAM_INT);
		$stmt->execute();
		$result = $stmt->fetch(PDO::FETCH_ASSOC);
		if ($result) {
			$stmt = $conn->prepare("SELECT * FROM users WHERE id_user = ?");
			$stmt->bindParam(1, $result['id_user'], PDO::PARAM_INT);
			$stmt->execute();
			$result = $stmt->fetch(PDO::FETCH_ASSOC);
			if ($result && $result['notifications'] == 1) {

				$urlLogin = "http://localhost:8080/camagru/sources/login.html.php";
				$urlSettings = "http://localhost:8080/camagru/sources/settings.html.php";

				$to = $result['email'];
				$subject = "Camagru - Like Notification";
				$body = 'Hello ' . $result['username'] . ', <br><br>';
				$body = $username . ' liked one of your images! <br><br>';
				$body .= '</br>';
				$body .= "<a href=$urlLogin>CLICK HERE</a> to log in and view the post.</br>";
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
			}
		}
	} catch (PDOException $e) {
		echo "Error: " . $e->getMessage();
	}
}


function notifyUsername($newUsername)
{
	try {
		$conn = dbConnect();
		$stmt = $conn->prepare("SELECT * FROM users WHERE username = ?");
		$stmt->bindParam(1, $newUsername, PDO::PARAM_STR);
		$stmt->execute();
		$result = $stmt->fetch(PDO::FETCH_ASSOC);
		if ($result && $result['notifications'] == 1) {
			$urlSettings = "http://localhost:8080/camagru/sources/settings.html.php";

			$to = $result['email'];
			$subject = "Camagru - New Username Notification";
			$body = 'Hello, <br><br>';
			$body .= 'Your username has successfully been changed! <br><br>';
			$body .= 'Your new username is: ' . $newUsername . ' <br><br>';
			$body .= '</br>';
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
		}
	} catch (PDOException $e) {
		echo "Error: " . $e->getMessage();
	}
}


function notifyNotifications($id_user)
{
	try {
		$conn = dbConnect();
		$stmt = $conn->prepare("SELECT * FROM users WHERE id_user = ?");
		$stmt->bindParam(1, $id_user, PDO::PARAM_INT);
		$stmt->execute();

		$result = $stmt->fetch(PDO::FETCH_ASSOC);
		if ($result) {
			$urlSettings = "http://localhost:8080/camagru/sources/settings.html.php";

			$to = $result['email'];
			$subject = "Camagru - Notification Preferences Notification";
			$body = 'Hello ' . $result['username'] . ', <br><br>';
			$body .= 'Your notification preferences have been updated successfully! <br><br>';
			$body .= '</br>';
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
		}
	} catch (PDOException $e) {
		echo "Error: " . $e->getMessage();
	}
}


function notifyPassword($id_user)
{
	try {
		$conn = dbConnect();
		$stmt = $conn->prepare("SELECT * FROM users WHERE id_user = ?");
		$stmt->bindParam(1, $id_user, PDO::PARAM_INT);
		$stmt->execute();

		$result = $stmt->fetch(PDO::FETCH_ASSOC);
		if ($result && $result['notifications'] == 1) {
			$urlLogin = "http://localhost:8080/camagru/sources/login.html.php";
			$urlSettings = "http://localhost:8080/camagru/sources/settings.html.php";

			$to = $result['email'];
			$subject = "Camagru - New Password Notification";
			$body = 'Hello ' . $result['username'] . ', <br><br>';
			$body .= 'Your password has been updated successfully! <br><br>';
			$body .= "<a href=$urlLogin>CLICK HERE</a> to log in to your account.</br>";
			$body .= '</br>';
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
		}
	} catch (PDOException $e) {
		echo "Error: " . $e->getMessage();
	}
}


function notifyDelete($id_user)
{
	try {
		$conn = dbConnect();
		$stmt = $conn->prepare("SELECT * FROM users WHERE id_user = ?");
		$stmt->bindParam(1, $id_user, PDO::PARAM_INT);
		$stmt->execute();

		$result = $stmt->fetch(PDO::FETCH_ASSOC);
		if ($result && $result['notifications'] == 1) {
			$urlRegister = "http://localhost:8080/camagru/sources/register.html.php";


			$to = $result['email'];
			$subject = "Camagru - Account Deletion Notification";
			$body = 'Hello ' . $result['username'] . ', <br><br>';
			$body .= 'Your account and user data have been deleted successfully! <br><br>';
			$body .= '</br>';
			$body .= 'Kind Regards, <br>';
			$body .= 'Camagru Team </br></br>';
			$body .= '</br>';
			$body .= "<a href=$urlRegister>CLICK HERE</a> to create a new account.</br>";

			$headers = 'From: camagru <balbaugh@outlook.com>' . "\r\n" .
				'Reply-To: balbaugh@outlook.com' . "\r\n" .
				'Date: ' . date("r") . "\r\n" .
				'MIME-Version: 1.0' . "\r\n" .
				'Content-type: text/html; charset=ISO-8859-1' . "\r\n" .
				'X-Mailer: PHP/' . phpversion();

			mail($to, $subject, $body, $headers);
		}
	} catch (PDOException $e) {
		echo "Error: " . $e->getMessage();
	}
}


function notifyReset($email, $token)
{

	try {
		$conn = dbConnect();
		$stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
		$stmt->bindParam(1, $email, PDO::PARAM_STR);
		$stmt->execute();
		$result = $stmt->fetch(PDO::FETCH_ASSOC);
		if ($result) {
			$urlReset = "http://localhost:8080/camagru/sources/reset.html.php";

			$to = $result['email'];
			$subject = "Camagru - Password Reset Notification";
			$body = 'Hello ' . $result['username'] . ', </br></br>';
			$body .= 'You have initiated a request to reset your password. </br></br>';
			$body .= '<p>Your reset verification token is: ' . $token . '</p>';
			$body .= '</br>';
			$body .= "<a href='$urlReset'>Click here to reset your password.</a> </br></br>";
			$body .= '</br>';
			$body .= 'If you did not initiate this request, please ignore this email. </br></br>';
			$body .= 'Kind Regards, </br>';
			$body .= 'Camagru Team </br></br>';

			$headers = 'From: camagru <balbaugh@outlook.com>' . "\r\n" .
				'Reply-To: balbaugh@outlook.com' . "\r\n" .
				'Date: ' . date("r") . "\r\n" .
				'MIME-Version: 1.0' . "\r\n" .
				'Content-type: text/html; charset=ISO-8859-1' . "\r\n" .
				'X-Mailer: PHP/' . phpversion();

			mail($to, $subject, $body, $headers);
		}
	} catch (PDOException $e) {
		echo "Error: " . $e->getMessage();
	}
}

/*
function notifyEmail()
{
}
 */