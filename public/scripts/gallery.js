'use strict';

/*

function imageLike(id_image) {
	let xml = new XMLHttpRequest();
	let likeButton = document.getElementById(id_image);
	let status = likeButton.title;

	xml.open('POST', '../controllers/likes.php', true);
	xml.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

	if (status == 'Liked') {
		xml.send('like=1&id_image=' + id_image+'&status=Liked');
		likeButton.title = 'notLiked';
	}

	if (status == 'notLiked') {
		xml.send('like=1&id_image=' + id_image+'&status=notLiked');
		likeButton.title = 'Liked';
	}
}
*/

const page_active = document.querySelector("#pageActive");
const like_post = document.querySelectorAll("#like_post");
const comment = document.querySelectorAll(".comment-icon");

let user = "<?php echo $_SESSION['id_user'] ?>"

if (user) {
	for (let i = 0; i < like_post.length; i++) {
		like_post[i].style.cursor = "pointer";
		like_post[i].addEventListener("click", (e) => {
			document.getElementById(e.target.attributes.data.value).submit();
		})
	}
}

for (let j = 0; j < comment.length; j++) {
	comment[j].addEventListener("click", e => {
		document.getElementById("comment_" + e.target.attributes.data.value).submit();
	})
}



