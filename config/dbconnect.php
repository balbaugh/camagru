<?php

/*// The ob_start() method keeps an eye on output buffering and allow us to use Header.
ob_start();

// The $_SESSION allow us to save data that we can use in our PHP application,
// sessions are alive as long as the browser window is open.
if(!isset($_SESSION)) {
    session_start();
}*/

function dbConnect(): PDO
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
	return ($conn);
}