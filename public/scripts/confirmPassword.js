function confirmPassword() {
	var password = document.getElementById("password").value;
	var confirmPassword = document.getElementById("confirmPassword").value;
	var errorMessage = document.getElementById("errorMessage");
	if (password != confirmPassword) {
		errorMessage.innerHTML = "PASSWORDS DO NOT MATCH!";
		return false;
	}
	return true;
}

document.getElementById("submit_registration").addEventListener("click", (e) => {
	e.preventDefault();

	confirmPassword();
})
