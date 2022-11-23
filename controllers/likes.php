<?php

session_start();


include_once '../config/dbConnect.php';

date_default_timezone_set('Europe/Helsinki');

if (isset($_POST['like']) && !empty($_POST['like'])) {
	$id_image = $_POST['like'];
	postLikes($id_image, $_SESSION['id_user']);
	// notifyUser($id_image, 2);
} else if (isset($_POST['unlike']) && !empty($_POST['unlike'])) {
	deleteLikes($_POST['unlike'], $_SESSION['id_user']);
}


function checkLikes($id_image, $id_user)
{
	try {
		$conn = dbConnect();
		$stmt = $conn->prepare("SELECT * FROM likes WHERE id_image = :id_image AND id_user = :id_user");
		$stmt->bindParam(':id_image', $id_image, PDO::PARAM_INT);
		$stmt->bindParam(':id_user', $_SESSION['id_user'], PDO::PARAM_INT);
		$stmt->execute();
		return $stmt->fetchAll();
	} catch (PDOException $e) {
		echo $e->getMessage() . " in " . $e->getFile() . ":" . $e->getLine();
		exit();
	}
}


function postLikes($id_image, $id_user)
{
	if (isset($_SESSION['check']) && !empty($_SESSION['check'])) {
		if (($_SESSION['check']) != hash('ripemd128', $_SERVER['REMOTE_ADDR'] . $_SERVER['HTTP_USER_AGENT'])) {
			session_destroy();
			header('Location: ../sources/login.html.php?error=Session expired!');
		} else {
			$_SESSION['check'] = hash('ripemd128', $_SERVER['REMOTE_ADDR'] . $_SERVER['HTTP_USER_AGENT']);
			try {
				$conn = dbConnect();
				$stmt = $conn->prepare("INSERT INTO likes (id_image, id_user, liked) VALUES (:id_image, :id_user, 1)");
				$stmt->bindParam(':id_image', $id_image, PDO::PARAM_INT);
				$stmt->bindParam(':id_user', $_SESSION['id_user'], PDO::PARAM_INT);
				$stmt->execute();
				header("Location: ../sources/home.html.php");
				exit();
			} catch (PDOException $e) {
				echo $e->getMessage() . " in " . $e->getFile() . ":" . $e->getLine();
				exit();
			}
		}
	}
}


function countLikes($id_image)
{
	try {
		$conn = dbConnect();
		$stmt = $conn->prepare("SELECT COUNT(*) FROM likes WHERE id_image = :id_image");
		$stmt->bindParam(':id_image', $id_image, PDO::PARAM_INT);
		$stmt->execute();
        return $stmt->fetchColumn();
	} catch (PDOException $e) {
		echo $e->getMessage() . " in " . $e->getFile() . ":" . $e->getLine();
		exit();
	}
}


function deleteLikes($id_image, $id_user)
{
	if (isset($_SESSION['check']) && !empty($_SESSION['check'])) {
		if (($_SESSION['check']) != hash('ripemd128', $_SERVER['REMOTE_ADDR'] . $_SERVER['HTTP_USER_AGENT'])) {
			session_destroy();
			header('Location: ../sources/login.html.php?error=Session expired!');
		} else {
			$_SESSION['check'] = hash('ripemd128', $_SERVER['REMOTE_ADDR'] . $_SERVER['HTTP_USER_AGENT']);
			try {
				$conn = dbConnect();
				$stmt = $conn->prepare("DELETE FROM likes WHERE id_image = :id_image AND id_user = :id_user");
				$stmt->bindParam(':id_image', $id_image, PDO::PARAM_INT);
				$stmt->bindParam(':id_user', $_SESSION['id_user'], PDO::PARAM_INT);
				$stmt->execute();
				header("Location: ../sources/home.html.php");
				exit();
			} catch (PDOException $e) {
				echo $e->getMessage() . " in " . $e->getFile() . ":" . $e->getLine();
				exit();
			}
		}
	}
}




/*
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
*/