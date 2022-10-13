<?php include 'includes/headNavHome.html.php'; ?>

<body>
	<?php include 'includes/navbar.html.php'; ?>
	Hello World
	<?php if (isset($error)) : ?>
	<p>
		<?= $error ?>
	</p>
	<?php else : ?>
	<!-- : do whatever is required for this page: show text, : show a form, list records from the database, etc. -->
	<!-- PUT GALLERY CODE HERE -->
	<div class="columns">
		<div class="column is-one-quarter">
			<div class="card">
				<div class="card-image">
					<figure class="image is-4by3">
						<img src="../../public/photos/<?= $image->image_name ?>" alt="placeholder image">
					</figure>
				</div>
				<div class="card-content">
					<div class="media">
						<div class="media-content">
							<p class="title is-4"><?= $image->image_name ?></p>
							<p class="subtitle is-6"><?= $image->image_description ?></p>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<?php endif; ?>


	<?php require 'includes/footer.html.php'; ?>
</body>

</html>


<!-- Finally, in the gallery.html.php , add an if statement inside the loop that iterates over the images. If the currently logged-in user is the user who posted the image, display the Edit and Delete options. Otherwise, don’t show them. -->
<!-- The clever part here is the if statement. It checks that $id_user —which stores the ID of the currently logged-in user—is equal to the id_user of the image being printed, and it only shows the edit and delete options for images that were posted by the currently logged-in user. -->
<!-- WE SHOULD DO SOMETHING LIKE THIS FOR COMMENTS AND LIKES TOO -->

// ...
echo $date->format('jS F Y');
?>)
<!--
<?php /*if (empty($image) || $id_user == $image['id_user']): */?>
<a href="/image/edit/<?/*=$image['id_image']*/?>">Edit</a>
<form action="/image/delete" method="post">
	<input type="hidden" name="id" value="<?/*=$image['id_image']*/?>">
	<input type="submit" value="Delete">
</form>
<?php /*endif; */?>
</p>
</blockquote>
<?php /*endforeach; */?>
-->

// For the fields from the joke table, this is fairly simple. We just change the
    syntax from an array to an object. For example, $joke['joketext'] becomes
    $joke->joketext. It’s slightly more complicated where we want to read
    information about each joke’s author. Before reading the author’s email
    address, we need to fetch the author instance. To read the author’s email,
    we previously used $joke['email'], which now becomes
    $joke->getAuthor()->email. This actually fetches the author from within the
    template! Previously, when writing the controller, we had to anticipate
    exactly which variables were needed by the template. Now, the controller
    just provides a list of jokes. The template can now read any of the values
    it needs, including information about the author. If we added a new column
    in the database—for example, a joke category—we could amend the template to
    show this value without needing to change the controller.

<p><?=$totalImages?> jokes have been submitted to the Internet Joke Database.</p>
<?php foreach ($images as $image): ?>
<blockquote>
    <p>
        <?=htmlspecialchars($image->description, ENT_QUOTES, 'UTF-8')?>
        (by <?=htmlspecialchars( $image->getUser()->username,
            ENT_QUOTES,
            'UTF-8' );"> on
            <?php
            $date = new DateTime($image->date_added);
            echo $date->format('jS F Y');
            ?>)

<?php if ($id_user == $image->id_user): ?>
<a href="/image/edit/<?=$image->id_image?>">Edit</a> <form action="/image/delete" method="post">
        <input type="hidden" name="id" value="<?=$image->id_image?>">
        <input type="submit" value="Delete"> </form>
    <?php endif; ?>
    </p>
</blockquote>
<?php endforeach; ?>