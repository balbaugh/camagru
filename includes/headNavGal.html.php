<?php

session_start();

if(isset($_SESSION['user'])){
    include '../includes/headNavIn.html.php';
} else {
    include '../includes/headNavOut.html.php';
}

?>