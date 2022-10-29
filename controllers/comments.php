<?php

session_start();

include_once '../config/dbConnect.php';
include_once '../controllers/security.php';

date_default_timezone_set('Europe/Helsinki');


if (!empty($_POST['postComment']) && !empty($_POST['id_image'])) {
	if (strlen($_POST['postComment']) <= 255) {
		$comment = htmlspecialchars($_POST['postComment']);
		$id_image = ($_POST['id_image']);
		$id_user = $_SESSION['id_user'];

		postComment($id_image, $id_user, $comment);
		// notifyUser($id_image, 1, $id_user, $comment);
	}
}
header('Location: ../sources/home.html.php');


function postComment($id_image, $id_user, $comment)
{
	try {
		$conn = dbConnect();
		$stmt = $conn->prepare("INSERT INTO comments (id_image, id_user, username, comment) VALUES (:id_image, :id_user, :username, :comment)");
		$stmt->bindParam(':id_image', $id_image);
		$stmt->bindParam(':id_user', $id_user);
		$stmt->bindParam(':username', $_SESSION['username']);
		$stmt->bindParam(':comment', $comment);
		$stmt->execute();
	} catch (PDOException $e) {
		echo $e->getMessage() . " in " . $e->getFile() . ":" . $e->getLine();
		exit();
	}
}



/* function getComments($id_image)
{
	try {
		$conn = dbConnect();
		$stmt = $conn->prepare("SELECT * FROM comments WHERE id_image = :id_image ORDER BY id_comment DESC");
		$stmt->bindParam(':id_image', $id_image);
		$stmt->execute();
		return $stmt->fetchAll();
	} catch (PDOException $e) {
		echo $e->getMessage() . " in " . $e->getFile() . ":" . $e->getLine();
		exit();
	}
} */


/*
function showComments($id_image)
{
    try {
        $conn = dbConnect();
        $stmt = $conn->prepare("SELECT * FROM comments WHERE id_image = :id_image");
        $stmt->execute(['id_image' => $id_image]);
        $comments = $stmt->fetchAll();
        return $comments;
        foreach ($comments as $comment) {
            echo $comment['comment'];
        }
    } catch (PDOException $e) {
        echo $e->getMessage() . " in " . $e->getFile() . ":" . $e->getLine();
        exit();
    }
}*/




/*
$url = "http://localhost:8080/camaguru/sources/verification.html.php";
$to = $email;
$subject = "Email Verification";
$message = '<p>Thank you for registering with camagru!</p>.</br>';
$message .= '<p>Your verification code is: <b>' . $verify_token . '</b></p>';
$message .= "<a href='$url'>Click here to verify your account.</a>";

$headers = "From: balbaugh <info@hive.fi>\r\n";
$headers .= "Reply-To: info@hive.fi\r\n";
$headers .= "Content-type: text/html\r\n";

mail($to, $subject, $message, $headers);

$email_log = "Registration was successful and verification email has been sent to $email.";

 */


/*

-- add_comment --
if (!empty($_POST['post_comment']) && !empty($_POST['image_id'])) {
	if (strlen($_POST['post_comment']) <= 255) {
		$comment = htmlspecialchars($_POST['post_comment']);
		$user_id = $_SESSION['user_id'];
		$image_id = $_POST['image_id'];
		post_comment($comment, $user_id, $image_id);
		notify_user($image_id, 1, $_POST['post_comment']);
	}
}
header("location: home.php");



function post_comment($comment, $user_id, $image_id)
{
	try {
		$conn = connect();
		$stmt = $conn->prepare("INSERT INTO user_comments (comment, image_id, user_id) VALUES (:comment, :image_id, :user_id)");
		$stmt->bindParam(':comment', $comment);
		$stmt->bindParam(':image_id', $image_id);
		$stmt->bindParam(':user_id', $user_id);
		$stmt->execute();
	} catch (PDOException $e) {
		echo "Unable to connect to the database server: " . $e->getMessage() . " in " . $e->getFile() . ":" . $e->getLine();
		exit();
	}
}


// Notif_type 1 is commenting picture, 2 is for likes
function notify_user($image_id, $notif_type, $message = '')
{
	try {
		$conn = connect();
		$stmt = $conn->prepare("SELECT uploader_id FROM user_images WHERE id = :id");
		$stmt->bindParam(':id', $image_id);
		$stmt->execute();
		$user_id = $stmt->fetch();
		$user_id = $user_id['uploader_id'];

		// Find email
		$stmt = $conn->prepare("SELECT email FROM userinfo WHERE id = :id");
		$stmt->bindParam(':id', $user_id);
		$stmt->execute();
		$email = $stmt->fetch();
		$email = $email['email'];
		$username = get_username_by_id($user_id);

		if (can_send_notifications($user_id)) {
			if ($notif_type == 1) {
				$headers = 'From: no-reply@camagru.com';
				$subject = "Someone commented on your picture!";
				$commenter = $_SESSION['logged_in_user'];
				$body = "Hey $username! $commenter said \"$message\" on your picture, go check it out here http://localhost:8080/camagru/src/home.php";

				mail($email, $subject, $body, $headers);
			} else if ($notif_type == 2) {
				$headers = 'From: no-reply@camagru.com';
				$subject = "Someone liked your picture!";
				$liker = $_SESSION['logged_in_user'];
				$body = "Hey $username! $liker liked your picture, go check it out here http://localhost:8080/camagru/src/home.php";

				mail($email, $subject, $body, $headers);
			}
		}
	} catch (PDOException $e) {
		echo "Unable to connect to the database server: " . $e->getMessage() . " in " . $e->getFile() . ":" . $e->getLine();
		exit();
	}
}

 */
/*
function getComments(int $id_image)
{
	try {
		$conn = dbConnect();
		$stmt = $conn->prepare("SELECT comment, id_user FROM comments WHERE id_image = :id_image");
		$stmt->bindParam(':id_image', $id_image);
		$stmt->execute();
		return $stmt->fetchAll();
	} catch (PDOException $e) {
		echo "Unable to connect to the database server: " . $e->getMessage() . " in " . $e->getFile() . ":" . $e->getLine();
		exit();
	}
}*/

/*

<?php
	$comments = getComments($id_image);
	if ($comments->rowCount() > 0) {
		while ($row = getComments()->$id_image) {
			$id_comment = $row['id_comment'];
		$id_image = $row['id_image'];
		$id_user = $row['id_user'];
		$comment_user = $row['username'];
		$comment_text = $row['comment'];
		$date_added = $row['date_added'];
		$original_date = $date_added;
		$comment_date = date("d-m-Y", strtotime($original_date));
	}
	while ($row = $comments->fetch(PDO::FETCH_ASSOC)) {
		$id_comment = $row['id_comment'];
		$id_image = $row['id_image'];
		$id_user = $row['id_user'];
		$comment_user = $row['username'];
		$comment_text = $row['comment'];
		$date_added = $row['date_added'];
		$original_date = $date_added;
		$comment_date = date("d-m-Y", strtotime($original_date));
?>

<?php if ($comments) :
										foreach ($comments as $comment) :
									?>
<div class="card-content">
	<p class="comment_username">
		<strong><?php echo $comment_user ?></strong>
	</p>
	<p class="comment_text">
		<?php echo $comment_text ?>
	</p>
	<br>
	<p class="comment_date">
		<?php echo $comment_date ?>
	</p>
</div>
<?php endforeach; ?>
<?php endif; ?>
*/