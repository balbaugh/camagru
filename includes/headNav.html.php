<?php

session_start();

if (isset($_SESSION['user'])) {
    include_once '../includes/headNavIn.html.php';
} else {
    header('Location: ../sources/login.html.php?login_error=Please log in');
}
