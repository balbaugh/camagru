<?php

if (session_status() === PHP_SESSION_NONE) {
	session_start();
}


include_once '../config/dbConnect.php';

date_default_timezone_set('Europe/Helsinki');

// controller for user logout and session destroy that redirects to login page
/*
1. We start by checking if the user is logged in. If that is not the case, we redirect the user to the login page and display an error message.
2. Next, we start a new session and regenerate the session ID to prevent session fixation attacks. The session ID is regenerated with the same session data. This is important to prevent the session data from being lost.
3. We then destroy all of the session data and unset the session cookie to log the user out.
4. Finally, we redirect the user to the login page and display a success message.
*/

if (!isset($_SESSION['logged'])) {
	header('Location: ../sources/login.html.php?error=You are not logged in!');
} else {
	if (session_status() === PHP_SESSION_NONE) {
		session_start();
	}
	session_regenerate_id(true);

	$_SESSION = array();
	if (isset($_COOKIE[session_name()])) :
		setcookie(session_name(), '', time() - 86400, '/');
	endif;
	session_destroy();
	header('Location: ../sources/login.html.php?success=You have been logged out!');
}

exit();