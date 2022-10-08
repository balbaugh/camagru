<!-- Database Connection Config AND Reusable Database Connector -->
<?php

$DB_NAME = 'camagru_db';
$DB_HOST = 'mysql:host=localhost';
$DB_DSN = 'mysql:host=localhost;dbname=camagru_db';
$DB_USER = 'root';
$DB_PASSWORD = 'pizzza';
$conn = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD);