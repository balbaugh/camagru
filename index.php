<?php

require_once 'config/setup.php';

session_start();



if (isset($_SESSION['user'])) {
	header('Location: ./sources/home.html.php');
} else {
	header('Location: ./sources/login.html.php');
}