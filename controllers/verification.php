<?php

session_start();

include("../config/dbconnect.php");

function check_token($email, $verify_token)
{
    try {
        $conn = dbConnect();
        $stmt = $conn->prepare("SELECT id_user FROM users WHERE email = ? AND verify_token = ?");
        $stmt->execute([$email, $verify_token]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($result) {
            $stmt = $conn->prepare("UPDATE users SET verified = 1 WHERE email = ? AND verify_token = ?");
            $stmt->execute([$email, $verify_token]);
            return (true);
        }
    } catch (PDOException $e) {
        echo "Unable to connect to the database server: " . $e->getMessage() . " in " . $e->getFile() . ":" . $e->getLine();
    }
    return (false);
}

if (isset($_POST['email']) && isset($_POST['verify_token'])) {
    $email = $_POST['email'];
    $verify_token = $_POST['verify_token'];
    if (check_token($email, $verify_token)) {
        header("Location: ../sources/login.html.php?token_success=Your account has been verified!");
        exit();
    } else {
        header("Location: ../sources/verification.html.php?token_error=Invalid verification token!");
        exit();
    }
} else {
    header("Location: ../sources/verification.html.php?token_error=Invalid verification token!");
    exit();
}




