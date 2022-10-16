<!-- Database Connection Config AND Reusable Database Connector -->
<?php

$DB_NAME = 'camaguru';
$DB_HOST = 'mysql:host=localhost';
$DB_DSN = 'mysql:host=localhost;dbname=camaguru';
$DB_USER = 'root';
$DB_PASSWORD = 'pizzza';
$conn = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD);