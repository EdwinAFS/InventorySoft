/* EDITAR PERFIL */
$(document).on("click", "#btnChangePassword", function (e) {
	formData = document.getElementById("FormChangePassword").getData();

	if (formData.newPassword != formData.confirmPassword) {
		return;
	}

	if (formData.newPassword == "") {
		alert.errorAlert("No puede dejar los campos de contraseña vacios");
		return;
	}

	var data = {
		username: formData.username,
		password: formData.password,
		newPassword: formData.newPassword,
	};

	fetch(`./profile/updatePassword`, {
		method: "PUT",
		body: convertJsonToForm(data),
	})
		.then((res) => res.json())
		.catch((error) => alert.errorAlert(error))
		.then((response) => {
			if (response.error) {
				alert.errorAlert(response.message, response.detail);
			} else {
				alert.successAlert(response.message).then((response) => {
					location.reload();
				});
			}
		});
});

function check() {
	formData = document.getElementById("FormChangePassword").getData();
	errorMessage = document.getElementById("passwordError");

	if (formData.newPassword != formData.confirmPassword) {
		errorMessage.style.display = "block";
	} else {
		errorMessage.style.display = "none";
	}
}
