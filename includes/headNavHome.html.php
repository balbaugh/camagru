<?php

if (isset($_SESSION["logged"]) && $_SESSION["logged"] === true) {
	include_once '../includes/headNavIn.html.php';
} else {
	include_once '../includes/headNavOut.html.php';
}