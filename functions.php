<?php

include 'dbconnect.php';

//checks that the login and password match and also if the account was activated
function auth ($login, $passwd)
{
    $res = 0;
    try {
        $conn = connection();
        $sql = "SELECT u_name, pwd, activ_status FROM user_info";
        $qry = $conn->query($sql);
        $result = $qry->fetchAll(PDO::FETCH_ASSOC);
        if ($result) {
            foreach ($result as $key) {
                $user_pwd = hash('whirlpool', $passwd);
                if ($key['u_name'] == $login && $key['pwd'] == $user_pwd)
                    $res += 1;
                if ($key['activ_status'] == 1 && $res == 1) {
                    $conn = null;
                    return ($res += 1);
                }
            }
        }
    } catch (PDOException $e) {
        echo $qry . "<br>" . $e->getMessage();
    }
    $conn = null;
    return $res;
}

// checks the input to make sure it is numeric or not
function number_check ($str)
{
    $i = 0;
    while ($str[$i]) {
        if (is_numeric($str[$i]) == 1)
            return 1;
        $i++;
    }
    return 0;
}

// checks the characters in the string for special characters that could be used to hack the database
function character_check($user)
{
    if (preg_match('/[\'^£$%&*()}{@#~?!><>\s+,\/|=+¬-]/', $user))
        return 1;
    return 0;
}

// password validation
function validate_password ($password)
{
    if (
        strlen($password) > 6   &&
        preg_match('/[a-z]/', $password) &&
        preg_match('/[A-Z]/', $password) &&
        preg_match('/[0-9]/', $password)
    ) {
        return 1;
    } else {
        return 0;
    }
}

// double validation for user entries
function validate_data ($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = strip_tags($data);
    $data = htmlspecialchars($data);
    return $data;
}