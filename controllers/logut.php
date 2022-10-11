<?php

// controller for user logout and session destroy that redirects to login page

session_start();

session_unset();
session_destroy();

header("Location: ../sources/login.html.php?logout_success=You are logged out!");
exit();
