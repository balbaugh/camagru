<?php

session_start();

include_once '../config/dbconnect.php';

date_default_timezone_set('Europe/Helsinki');

// controller for user logout and session destroy that redirects to login page

session_unset();
session_destroy();

header("Location: ../sources/login.html.php?logout_success=You are logged out!");
exit();