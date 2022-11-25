<?php

if (session_status() === PHP_SESSION_NONE) {
	session_start();
}

if (isset($_SESSION["logged"]) && $_SESSION["logged"] === true) {
	include_once '../includes/headNavIn.html.php';
} else {
	header('Location: ../sources/login.html.php?error=Please log in');
}