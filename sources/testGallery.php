<?php

session_start();

require_once '../config/dbconnect.php';

include_once '../includes/headNav.html.php';

/* if (!isset($_SESSION['id_user'])) {
	header('location:login.html.php');
} else {
	// save the user_id into a variable
	$id_user = $_SESSION['id_user'];
	$logged_user = $_SESSION['username'];
}
 */

/*
$username = $_SESSION['username'];
$stmt = $conn->prepare("SELECT * FROM images ORDER BY id_image DESC");
$stmt->execute();
 */

if (!isset($_SESSION['id_user'])) {
	header('location:login.php');
}

?>

<?php
try {
	$conn = dbConnect();
	$stmt = $conn->prepare("SELECT * FROM images ORDER BY date_added DESC");
	$stmt->execute();
	if ($stmt->execute() && $stmt->rowCount() > 0) {
		while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
			$imageURL = '../public/uploads/' . $row["image_name"];

?>
<section class="block">
	<br>
	<img src="<?php echo $imageURL; ?>" alt="" height="160" width="" />
</section>
<?php }
	} else { ?>
<section class="block">
	<br>
	<p>No image(s) found...</p>
</section>
<?php }
} catch (PDOException $e) {
	echo "Unable to connect to the database server: " . $e->getMessage() . " in " . $e->getFile() . ":" . $e->getLine();
	exit();
}
?>

<?php include_once '../includes/footer.html.php'; ?>