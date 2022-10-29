<?php

session_start();

include_once '../config/dbConnect.php';

date_default_timezone_set('Europe/Helsinki');

// controller for user logout and session destroy that redirects to login page

if (!isset($_SESSION['logged'])) {
	header('Location: ../sources/login.html.php?error=You are not logged in!');
} else {
	$_SESSION = array();
	if (isset($_COOKIE[session_name()])) :
		setcookie(session_name(), '', time() - 86400, '/');
	endif;
	session_destroy();
	header('Location: ../sources/login.html.php?success=You have been logged out!');
}

exit();