<?php

session_start();

require_once './config/setup.php';

if (isset($_SESSION['user'])) {
	header('Location: ./sources/home.html.php');
} else {
	header('Location: ./sources/login.html.php');
}