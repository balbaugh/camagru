'use strict';

// ?? ADD LIKES AND COMMENTS HERE ??

// const page_active = document.querySelector("#pagective");
const like_post = document.querySelectorAll("#like_post");
const comment = document.querySelectorAll("#commentBtn");

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
	comment[j].addEventListener("click", (e) => {
		document.getElementById("comment_" + e.target.attributes.data.value).submit();
	})
}

function confirmDelete() {
	let confirm = window.confirm("Are you sure you want to delete this image ?");

	if (confirm) {
		return true;
	}
	else {
		return false;
	}
}
