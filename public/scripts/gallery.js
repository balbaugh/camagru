'use strict';

const likeImage = document.querySelector('#likeImage');
let user = "<?php echo $_SESSION['id_user']; ?>";

if (user) {
	for (const element of likeImage) {
		element.style.cursor = "pointer";
		element.addEventListener('click', (e) => {
			document.getElementById(e.target.attributes.data.value).submit();
		})
	}
}

function imageLike(id_image) {
	let xhr = new XMLHttpRequest();
	let likeImage = document.getElementById('likeImage' + id_image);
	let status = likeImage.title;

	xhr.open('POST', '../controllers/gallery.php', true);
	xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');

	if (status == 'like') {
		xhr.send('like=1&likeImage=' + id_image + '&user=' + user);
		likeImage.title = 'unlike';
		likeImage.src = '../public/images/like.png';
	}


}