<!-- setup file for creating the database -->
<?php



$DB_HOST = 'mysql:host=localhost';
$DB_USER = 'root';
$DB_PASSWORD = 'pizzza';

$sql = "
		CREATE DATABASE IF NOT EXISTS `camagru`;
		CREATE TABLE IF NOT EXISTS camagru. `users` (
			`id_user`				INT(11) UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
			`username`				VARCHAR(255) NOT NULL,
			`email`					VARCHAR(255) NOT NULL,
			`password`				VARCHAR(255) NOT NULL,
			`verify_token`			VARCHAR(255) NOT NULL,
			`verified`				TINYINT(1) NOT NULL DEFAULT 0,
			`notifications`			TINYINT(1) NOT NULL DEFAULT 1,
			`modif_date`			TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
			`creation_date`			TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP
		);
		CREATE TABLE IF NOT EXISTS camagru. `images` (
			`id_image`				INT(11) UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
			`id_user`				INT(11) UNSIGNED NOT NULL,
			`username`				VARCHAR(255) NOT NULL,
			`image_name`			VARCHAR(255) COLLATE utf8_unicode_ci NOT NULL,
			`date_added`			TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
		);
		CREATE TABLE IF NOT EXISTS camagru. `likes` (
			`id_like`				INT(11) UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
			`id_image`				INT(11) UNSIGNED NOT NULL,
			`id_user`				INT(11) UNSIGNED NOT NULL,
			`liked`					INT DEFAULT 0 NOT NULL,
			`date_added`			TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
		);
		CREATE TABLE IF NOT EXISTS camagru. `comments` (
			`id_comment`			INT(11) UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
			`id_image`				INT(11) UNSIGNED NOT NULL,
			`id_user`				INT(11) UNSIGNED NOT NULL,
			`username`				VARCHAR(255) NOT NULL,
			`comment`				VARCHAR(1000) NOT NULL,
			`date_added`			TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
		);
	";

try {
	$conn = new PDO($DB_HOST, $DB_USER, $DB_PASSWORD);

	$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

	$conn->exec($sql);
	echo "Database created successfully!";
} catch (PDOException $e) {
	echo "ERROR: " . $sql . "<br>" . $e->getMessage() . " in " . $e->getFile() . ":" . $e->getLine();
}

$conn = null;



