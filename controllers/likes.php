<?php

session_start();

include_once '../config/dbConnect.php';

date_default_timezone_set('Europe/Helsinki');


function likedBy(int $id_image, int $id_user): bool {
    try {
        $conn = dbConnect();
        $stmt = $conn->prepare("SELECT * FROM likes WHERE id_image = :id_image AND id_user = :id_user");
        $stmt->bindParam(':id_image', $id_image);
        $stmt->bindParam(':id_user', $id_user);
        $stmt->execute();

        return $stmt->rowCount() != 0 ? true : false;
    } catch (PDOException $e) {
        echo $e->getMessage() . " in " . $e->getFile() . ":" . $e->getLine();
        exit();
    }
}

function likeCount(int $id_image) {
    try {
        $conn = dbConnect();
        $stmt = $conn->prepare("SELECT * FROM likes WHERE id_image = :id_image");
        $stmt->bindParam(':id_image', $id_image);
        $stmt->execute();
        if ($stmt->rowCount() > 0) {
            return $stmt->rowCount();
        } else {
            return 0;
        }
    } catch (PDOException $e) {
        echo $e->getMessage() . " in " . $e->getFile() . ":" . $e->getLine();
        exit();
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
