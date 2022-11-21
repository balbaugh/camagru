<?php

session_start();

include_once '../config/dbConnect.php';

date_default_timezone_set('Europe/Helsinki');


// renders malicious html input harmless
function sanitize($input)
{
	$input = trim($input);
	$input = stripslashes($input);
	$input = strip_tags($input);
	$input = htmlentities($input, ENT_QUOTES, 'UTF-8');
	return $input;
}


// double validation for user entries
function validateData($data)
{
	$data = trim($data);
	$data = stripslashes($data);
	$data = strip_tags($data);
	$data = htmlspecialchars($data);
	return $data;
}


// password validation
// password must contain at least 8 characters, 1 uppercase letter, 1 lowercase letter and 1 number
function validatePassword($password)
{
	$pattern = '/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[a-zA-Z\d]{8,20}$/';
	if (
		preg_match($pattern, $password)
	) {
		return 1;
	} else {
		return 0;
	}
}



// checks the input of user activation code to check if it is numeric or not
function numberCheck($str)
{
	$i = 0;
	while ($str[$i]) {
		if (is_numeric($str[$i]) == 1) {
			return 1;
		}
		$i++;
	}
	return 0;
}


function destroySession()
{
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
}