<?php

// connect to database and start session then check if user is logged in.
// if logged in, display the gallery page with all user images from database
// images will be listed chronologically.
// if user not logged in, redirect to home page for gallery with less features.

// connect to database
include_once '../config/dbconnect.php';

// start session
session_start();

// check if user is logged in and get images from database
if (isset($_SESSION['user'])) {
    $stmt = $conn->prepare("SELECT * FROM images ORDER BY id_image DESC");
    $stmt->execute();
}

function getImages()
{
    $stmt = $conn->prepare("SELECT * FROM images ORDER BY id_image DESC");
    $stmt->execute();
    $images = $stmt->fetchAll();
    return $images;
}

function getLikes()
{
    $stmt = $conn->prepare("SELECT * FROM likes WHERE id_image = :id_image");
    $stmt->execute();
    $likes = $stmt->fetchAll();
    return $likes;
}

function getComments()
{
    $stmt = $conn->prepare("SELECT * FROM comments WHERE id_image = :id_image");
    $stmt->execute();
    $comments = $stmt->fetchAll();
    return $comments;
}
