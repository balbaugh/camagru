<?php

session_start();

include_once '../config/dbconnect.php';

date_default_timezone_set('Europe/Helsinki');

// checks the characters in the string for special characters that could be used to hack the database
// also in functions.php
function characterCheck($user)
{
	if (preg_match(pattern: '/[\'^£$%&*()}{@#~?!><>\s+,\/|=+¬-]/', subject: $user)) {
		return 1;
	} else {
		return 0;
	}
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
function validatePassword($password)
{
	if (
		strlen($password) > 6 &&
		preg_match('/[a-z]/', $password) &&
		preg_match('/[A-Z]/', $password) &&
		preg_match('/[0-9]/', $password)
	) {
		return 1;
	} else {
		return 0;
	}
}