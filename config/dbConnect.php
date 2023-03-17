<?php


function dbConnect()
{
    $DB_NAME = 'camagru';
//	$DB_DSN = 'mysql:host=localhost;dbname=camagru;';
    $DB_DSN = 'mysql:host=mysql-server;dbname='.$DB_NAME.';charset=utf8mb4';
	$DB_USER = 'root';
	$DB_PASSWORD = 'password';
	$conn = "";

	try {
		$conn = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD);
		$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	} catch (PDOException $e) {
		echo "Unable to connect to the database server: " . $e->getMessage() . " in " . $e->getFile() . ":" . $e->getLine();
	}
	return ($conn);
}
