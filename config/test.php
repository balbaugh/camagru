<!-- Test for Reusable Database Connector in database.php -->
<!-- open test.php in browser to test connection -->
<?php
require_once 'database.php';

if ($conn = dbConnect('pdo')) {
	echo "Database connection test successful!";
} else {
	echo "Unable to connect to the database server: " . $e->getMessage() . " in " . $e->getFile() . ":" . $e->getLine();
}