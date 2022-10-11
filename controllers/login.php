<?php

// controller to process user login from login.html.php

session_start();

include("../config/dbconnect.php");

if (isset($_POST['submit_login'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // server-side form validation

    $empty_email = trim($_POST['email']);
    $empty_password = trim($_POST['password']);

    if (empty($empty_email)) {
        header("Location: ../sources/login.html.php?email_error=Email is required!");
        exit();
    } else if (empty($empty_password)) {
        header("Location: ../sources/login.html.php?password_error=Password is required!");
        exit();
    } else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        header("Location: ../sources/login.html.php?email_error=Invalid email format!");
        exit();
    } else if (strlen($password) < 8) {
        header("Location: ../sources/login.html.php?password_error=Password must be at least 8 characters long!");
        exit();
    } else if (!preg_match("/^[_\.0-9a-zA-Z-]+@([0-9a-zA-Z][0-9a-zA-Z-]+\.)+[a-zA-Z]{2,6}$/i", $empty_email)) {
        header("Location: ../sources/login.html.php?email_error=Invalid email address!");
        exit();
    }

    try {
        $conn = dbConnect();
        $stmt = $conn->prepare("SELECT id_user, username, email, password, verified FROM users WHERE email = ?");
        $stmt->execute([$email]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($result) {
            if (password_verify($password, $result['password'])) {
                if ($result['verified'] == 1) {
                    $_SESSION['id_user'] = $result['id_user'];
                    $_SESSION['username'] = $result['username'];
                    $_SESSION['email'] = $result['email'];
                    header("Location: ../sources/gallery.html.php?login_success=You are logged in!");
                    exit();
                } else {
                    header("Location: ../sources/login.html.php?login_error=Your account is not verified!");
                    exit();
                }
            } else {
                header("Location: ../sources/login.html.php?login_error=Invalid email or password!");
                exit();
            }
        } else {
            header("Location: ../sources/login.html.php?login_error=Invalid email or password!");
            exit();
        }
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
} else {
    header("Location: ../sources/login.html.php?login_error=Invalid email or password!");
    exit();
}
