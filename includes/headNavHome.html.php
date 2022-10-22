<?php

if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true) {
	include_once '../includes/headNavIn.html.php';
} else {
	include_once '../includes/headNavOut.html.php';
}