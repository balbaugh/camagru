<?php

function dbConnect(): PDO
{
    $DB_DSN = 'mysql:host=localhost;dbname=camagru;charset=utf8mb4';
    $DB_USER = 'root';
    $DB_PASSWORD = 'pizzza';
    $conn = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD);

    try {
        $conn = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        echo "Database connection successful!";
    } catch (PDOException $e) {
        echo "Unable to connect to the database server: " . $e->getMessage() . " in " . $e->getFile() . ":" . $e->getLine();
    }
    return ($conn);
}