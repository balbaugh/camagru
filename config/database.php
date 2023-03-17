<!-- Database Connection Config AND Reusable Database Connector -->
<?php
//require_once 'config/setup.php';
$DB_NAME = 'camagru';
//$DB_HOST = 'mysql:host=localhost';
$DB_HOST = "mysql:host=mysql-server";
//$DB_DSN = 'mysql:host=localhost;dbname=camagru';
$DB_DSN = 'mysql:host=mysql-server;dbname='.$DB_NAME.';charset=utf8mb4';
$DB_USER = 'root';
$DB_PASSWORD = 'password';

$conn = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD);
