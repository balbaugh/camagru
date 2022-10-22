<?php

session_start();

include_once '../config/dbconnect.php';

date_default_timezone_set('Europe/Helsinki');

$time_zone = date_default_timezone_set('Europe/Helsinki');
$date = date('Y-m-d H:i:s');
$image_name = $_SESSION['username'] . $date . '.png';
$img = base64_decode($_POST["img"]);
$img = imagecreatefromstring($img);
imagepng($img, "../public/uploads/" . $image_name);