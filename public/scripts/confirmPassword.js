function confirmPassword() {
	var password = document.getElementById("password").value;
	var confirmPassword = document.getElementById("confirm_password").value;
	var error_message = document.getElementById("error_message");
	if (password != confirm_password) {
		error_message.innerHTML = "Passwords do not match!";
		return false;
	}
	return true;
}

document.getElementById("signup_btn").addEventListener("click", (e) => {
	e.preventDefault();

	confirmPassword();
})
