<?php

session_start();

include_once '../config/dbConnect.php';

date_default_timezone_set('Europe/Helsinki');

//checks that the login and password match and also if the user account is activated
function auth($login, $password)
{
	$res = 0;
	try {
		$conn = dbConnect();
		$sql = "SELECT username, password, verify_token FROM users ";
		$qry = $conn->query($sql);
		$result = $qry->fetchAll(PDO::FETCH_ASSOC);
		if ($result) {
			foreach ($result as $key) {
				$userPwd = hash('whirlpool', $password);
				if ($key['username'] == $login && $key['pwd'] == $userPwd) {
					$res += 1;
				}
				if ($key['verify_token'] == 1 && $res == 1) {
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

// checks the input of user activation code to check if it is numeric or not
function numberCheck($str)
{
	$i = 0;
	while ($str[$i]) {
		if (is_numeric($str[$i]) == 1) {
			return 1;
		}
		$i++;
	}
	return 0;
}