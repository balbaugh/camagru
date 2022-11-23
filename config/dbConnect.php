<?php

function dbConnect()
{
	$DB_DSN = 'mysql:host=localhost;dbname=camagru;';
	$DB_USER = 'root';
	$DB_PASSWORD = 'pizzza';
	$conn = "";

	try {
		$conn = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD);
		$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	} catch (PDOException $e) {
		echo "Unable to connect to the database server: " . $e->getMessage() . " in " . $e->getFile() . ":" . $e->getLine();
	}
	return $conn;
}