<?php

if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true) {
	include_once '../includes/headNavIn.html.php';
} else {
	header('Location: ../sources/login.html.php?login_error=Please log in');
}