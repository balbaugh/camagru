<?php

if (session_status() === PHP_SESSION_NONE) {
	session_start();
}


include_once '../config/dbConnect.php';

date_default_timezone_set('Europe/Helsinki');


function notifyComment($id_image, $id_user, $comment)
{
	try {
		$conn = dbConnect();
		$stmt = $conn->prepare("SELECT * FROM images WHERE id_image = :id_image");
		$stmt->bindParam(':id_image', $id_image, PDO::PARAM_INT);
		$stmt->execute();
		$resultPoster = $stmt->fetch(PDO::FETCH_ASSOC);
		if ($resultPoster) {
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
				$body .= $resultPoster . ' commented: "' . $comment . '" <br><br>';
				$body .= '</br>';
				$body .= "<a href=$urlLogin>CLICK HERE</a> to log in and view the post..</br>";
				$body .= '<p>Camagru Team</p> </br>';
				$body .= '</br>';
				$body .= "<p>Please <a href=$urlSettings>CLICK HERE</a> if you would like to change your notification preferences.</p>.</br>";

				$headers = 'From: camagru <balbaugh@outlook.com>' . "\r\n" .
					'Date: ' . date("r") . "\r\n" .
					'MIME-Version: 1.0' . "\r\n" .
					'Content-type: text/html; charset=ISO-8859-1' . "\r\n" .
					'Reply-To: balbaugh@outlook.com' . "\r\n" .
					'X-Mailer: PHP/' . phpversion();

				mail($to, $subject, $body, $headers);
			}
		}
	} catch (PDOException $e) {
		echo "Error: " . $e->getMessage();
	}
}


function notifyLike ($id_image, $id_user)
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
				$body = '$i on one of your images! <br><br>';
				$body .= $result['username'] . ' commented: "' . $comment . '" <br><br>';
				$body .= '</br>';
				$body .= "<a href=$urlLogin>CLICK HERE</a> to log in and view the post..</br>";
				$body .= '<p>Camagru Team</p> </br>';
				$body .= '</br>';
				$body .= "<p>Please <a href=$urlSettings>CLICK HERE</a> if you would like to change your notification preferences.</p>.</br>";

				$headers = 'From: camagru <balbaugh@outlook.com>' . "\r\n" .
					'Date: ' . date("r") . "\r\n" .
					'MIME-Version: 1.0' . "\r\n" .
					'Content-type: text/html; charset=ISO-8859-1' . "\r\n" .
					'Reply-To: balbaugh@outlook.com' . "\r\n" .
					'X-Mailer: PHP/' . phpversion();

				mail($to, $subject, $body, $headers);
			}