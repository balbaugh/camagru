<?php








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