<?php

ob_start();

if (session_status() === PHP_SESSION_NONE) {
	session_start();
}

require_once 'config/setup.php';

date_default_timezone_set('Europe/Helsinki');

if (isset($_SESSION["logged"]) && $_SESSION["logged"] === true) {
	header('Location: ./sources/home.html.php');
	exit;
} else {
	header('Location: ./sources/register.html.php');
	exit;
}
