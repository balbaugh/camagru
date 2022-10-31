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



// JS FOR IMAGE MODAL
function attachImgEvents() {
	// attach the click event on each posted img
	var postedImages = document.getElementsByClassName("postedImageImg");
	for (let i = 0; i < postedImages.length; i++) {
		postedImages[i].addEventListener("click", function () {
			modalShowImage(this);
		})
	}
}

// modal & modalImg will be set in the initialiseModalBox() call.
var modal;
var modalImg;

function initialiseModalBox() {
	// set the modal & modalImg variables
	// - only set it once per browser session.
	modal = document.getElementById("myModal");
	modalImg = document.getElementById("myModalImage")
	// Get the <span> element that closes the modal
	var button = document.getElementsByClassName("modal-close")[0];
	// When the user clicks on <span> (x), close the modal
	button.onclick = function () {
		modal.style.display = "none";
	};
}

// modal box - show the bigger version of image
function modalShowImage(theImage) {
	modalImg.src = theImage.src;
	modal.style.display = "block";
}

// when the DOM's content is loaded ...
// ... attach the img events.
// ... initialiase the modal variables & the modal events
document.addEventListener("DOMContentLoaded", (event) => {
	attachImgEvents();
	initialiseModalBox();
});
