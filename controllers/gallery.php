<?php

session_start();

include_once '../config/dbConnect.php';

date_default_timezone_set('Europe/Helsinki');

// connect to database and start session then check if user is logged in.
// if logged in, display the gallery page with all user images from database
// images will be listed chronologically.
// if user not logged in, redirect to home page for gallery with less features.

// check if user is logged in and get images from database


function getImages()
{
	try {
		$conn = dbConnect();
		$stmt = $conn->prepare("SELECT * FROM images ORDER BY id_image DESC");
		$stmt->execute();
		$images = $stmt->fetchAll();
		return $images;
	} catch (PDOException $e) {
		echo $e->getMessage() . " in " . $e->getFile() . ":" . $e->getLine();
		exit();
	}
}

function getGallery(int $offset, int $pageMax)
{
	try {
		$conn = dbConnect();
		$stmt = $conn->prepare("SELECT * FROM images ORDER BY id_image DESC LIMIT $offset, $pageMax");
		$stmt->execute();
		$images = $stmt->fetchAll();
		return $images;
	} catch (PDOException $e) {
		echo $e->getMessage() . " in " . $e->getFile() . ":" . $e->getLine();
		exit();
	}
}

function getLikes()
{
	try {
		$conn = dbConnect();
		$stmt = $conn->prepare("SELECT * FROM likes WHERE id_image = :id_image");
		$stmt->execute();
		$likes = $stmt->fetchAll();
		return $likes;
	} catch (PDOException $e) {
		echo $e->getMessage() . " in " . $e->getFile() . ":" . $e->getLine();
		exit();
	}
}

function getComments()
{
	try {
		$conn = dbConnect();
		$stmt = $conn->prepare("SELECT * FROM comments WHERE id_image = :id_image");
		$stmt->execute();
		$comments = $stmt->fetchAll();
		return $comments;
	} catch (PDOException $e) {
		echo $e->getMessage() . " in " . $e->getFile() . ":" . $e->getLine();
		exit();
	}
}