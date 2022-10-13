<?php

session_start();

if (isset($_SESSION['user'])) {
    include_once '../includes/headNavIn.html.php';
} else {
    include_once '../includes/headNavOut.html.php';
}
