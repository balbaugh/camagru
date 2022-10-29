<?php

session_start();

include_once '../config/dbConnect.php';

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
		strlen($password) > 8 &&
		preg_match('/[a-z]/', $password) &&
		preg_match('/[A-Z]/', $password) &&
		preg_match('/[0-9]/', $password)
	) {
		return 1;
	} else {
		return 0;
	}
}


function sanitizeString($var)
{
	global $connection;
	$var = strip_tags($var);
	$var = htmlentities($var);
	if (get_magic_quotes_gpc())
		$var = stripslashes($var);
	return $connection->real_escape_string($var);
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


//checks that the login and password match and also if the user account is activated
function auth($login, $password)
{
	$res = 0;
	try {
		$conn = dbConnect();
		$sql = "SELECT username, password, verify_token FROM users ";
		$qry = $conn->query($sql);
		$result = $qry->fetchAll(PDO::FETCH_ASSOC);
		if ($result) {
			foreach ($result as $key) {
				$userPwd = hash('whirlpool', $password);
				if ($key['username'] == $login && $key['pwd'] == $userPwd) {
					$res += 1;
				}
				if ($key['verify_token'] == 1 && $res == 1) {
					$conn = null;
					return ($res += 1);
				}
			}
		}
	} catch (PDOException $e) {
		echo $qry . "<br>" . $e->getMessage();
	}
	$conn = null;
	return $res;
}