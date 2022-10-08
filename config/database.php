<!-- Database Connection Config AND Reusable Database Connector -->
<?php
$DB_DSN = 'mysql:host=localhost;dbname=camagru;charset=utf8mb4';
$DB_NAME = 'camagru';
$DB_USER = 'root';
$DB_PASSWORD = 'pizzza';
$DB_HOST = 'mysql:host=localhost';
$conn = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD);

function dbConnect($connectionType = 'pdo')
{
	$DB_DSN = 'mysql:host=localhost;dbname=camagru;charset=utf8mb4';
	$DB_USER = 'root';
	$DB_PASSWORD = 'pizzza';
	$DB_HOST = 'mysql:host=localhost';

	try {
		$conn = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD);
		$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$output = 'Database connection successful!';
	} catch (PDOException $e) {
		$output = 'Unable to connect to the database server: ' . $e->getMessage() . ' in ' . $e->getFile() . ':' . $e->getLine();
	}
	return ($conn);
}

include './templates/output.html.php';