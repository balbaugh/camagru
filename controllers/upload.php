<?php

if (session_status() === PHP_SESSION_NONE) {
	session_start();
}

include_once '../config/dbConnect.php';

date_default_timezone_set('Europe/Helsinki');


$time_zone = date_default_timezone_set('Europe/Helsinki');
$date = date('Y-m-d H:i:s');

$date_added = $date;

/*
1. I check if the session is set and not empty.
2. I check if the session hash is equal to the hash created from the ip address and the user agent of the client.
3. If the check is passed, I create a new session hash.
4. I create variables from the session variables.
5. Then I check if the image is set.
6. I decode the image.
7. I check if the first sticker is set.
8. I get the content of the first sticker.
9. I decode the content of the first sticker.
10. I use the imagecopy function to copy the first sticker on the image.
11. I do the same thing with the second sticker.
12. I save the image in the given directory.
13. I destroy the stickers and the image.
14. I call the insertImage function to insert the image in the database.
*/

if (isset($_SESSION['check']) && !empty($_SESSION['check'])) {
	if (($_SESSION['check']) != hash('ripemd128', $_SERVER['REMOTE_ADDR'] . $_SERVER['HTTP_USER_AGENT'])) {
		session_destroy();
		header('Location: ../sources/login.html.php?error=Session expired!');
	} else {
		$_SESSION['check'] = hash('ripemd128', $_SERVER['REMOTE_ADDR'] . $_SERVER['HTTP_USER_AGENT']);

		$id_user = $_SESSION['id_user'];
		$username = $_SESSION['username'];
		$image_name = $username . $date . '.png';

		if (isset($_POST['img'])) {
			$img = $_POST['img'];
			$img = base64_decode($img);
			$img = imagecreatefromstring($img);

			if (isset($_POST['sticker1'])) {
				$pathOne = $_POST['sticker1'];
				$sticker1 = file_get_contents($pathOne);
				$sticker1 = imagecreatefromstring($sticker1);
				imagecopy($img, $sticker1, 10, 30, 0, 0, 128, 128);
			}

			if (isset($_POST['sticker2'])) {
				$pathTwo = $_POST['sticker2'];
				$sticker2 = file_get_contents($pathTwo);
				$sticker2 = imagecreatefromstring($sticker2);
				imagecopy($img, $sticker2, 240, 320, 0, 0, 128, 128);
			}

			imagepng($img, "../public/uploads/" . $image_name);

			imagedestroy($sticker1);
			imagedestroy($sticker2);
			imagedestroy($img);

			insertImage($id_user, $username, $image_name, $date_added);
		}
	}
}

function insertImage($id_user, $username, $image_name, $date_added)
{
	try {
		$conn = dbConnect();
		$stmt = $conn->prepare("INSERT into images (`id_user`, `username`, `image_name`, `date_added`) VALUES (?, ?, ?, ?)");
		$stmt->bindParam(1, $id_user, PDO::PARAM_INT);
		$stmt->bindParam(2, $username, PDO::PARAM_STR);
		$stmt->bindParam(3, $image_name, PDO::PARAM_STR);
		$stmt->bindParam(4, $date_added, PDO::PARAM_STR);

		$stmt->execute();
	} catch (PDOException $e) {
		echo "Unable to connect to the database server: " . $e->getMessage() . " in " . $e->getFile() . ":" . $e->getLine();
		exit();
	}
}