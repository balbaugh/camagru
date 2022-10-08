<!-- Test for Reusable Database Connector in database.php -->
<!-- open test.php in browser to test connection -->
<?php
require_once './dbconnect.php';

if ($conn = dbConnect()) {
	echo "Database connection test successful!";
} else {
	echo "Unable to connect to the database server: " . $e->getMessage() . " in " . $e->getFile() . ":" . $e->getLine();
}