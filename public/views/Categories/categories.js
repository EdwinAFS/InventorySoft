/* OBTENER EL USUARIO A EDITAR */
$(document).on("click", ".btn-CategoryEdit", function (e) {
	var categoryId = $(this).attr("categoryId");

	fetch("./category/findById?id=" + categoryId)
		.then((res) => res.json())
		.then((response) => {
			if (response.error) {
				alert.errorAlert(response.message);
			} else {
				$("#editDescription").val(response.data["description"]);
				$("#editId").val(response.data["id"]);
			}
		})
		.catch((error) => alert.errorAlert(error));
});

/* ELIMINAR UN USUARIO */
$(document).on("click", ".btn-DeleteCategory", function (e) {
	var categoryId = $(this).attr("categoryId");

	fetch("./category/delete?id=" + categoryId, {
		method: "DELETE",
	})
		.then((res) => res.json())
		.then((response) => {
			if (response.error) {
				alert.errorAlert(response.message);
			} else {
				alert.successAlert(response.message);
			}
		})
		.catch((error) => alert.errorAlert(error));
});

/* EDITAR UN USUARIO */
$(document).on("click", "#btnEditCategory", function (e) {
	formData = document.getElementById("FormEditCategory").getData();

	var data = {
		id: formData.editId,
		description: formData.editDescription,
	};

	fetch(`./category/update?id=${data.id}`, {
		method: "PUT",
		body: convertJsonToForm(data),
	})
		.then((res) => res.json())
		.then((response) => {
			if (response.error) {
				alert.errorAlert(response.message);
			} else {
				alert.successAlert(response.message);
			}
		})
		.catch((error) => alert.errorAlert(error));
});

/* CREAR UN USUARIO */
$(document).on("click", "#btnAddCategory", function (e) {
	var data = {
		...document.getElementById("FormAddCategory").getData(),
	};

	fetch("./category/create", {
		method: "POST",
		body: convertJsonToForm(data),
	})
		.then((res) => res.json())
		.then((response) => {
			if (response.error) {
				alert.errorAlert(response.message);
			} else {
				alert.successAlert(response.message);
				document.getElementById("FormAddCategory").reset();
			}
		})
		.catch((error) => alert.errorAlert(error));
});

/* CAMBIAR ACTIVE */
$(document).on("click", ".btn-Active", function (e) {
	var categoryId = $(this).attr("categoryId");

	fetch("./login/rol")
		.then((response) => response.json())
		.then(({ rolCode }) => {
			if (rolCode != "Admin" && rolCode != "InventoryManager") return;

			fetch("./category/changeActive?id=" + categoryId, {
				method: "PATCH",
			})
				.then((res) => res.json())
				.then((response) => {
					if (response.error) {
						alert.errorAlert(response.message);
					} else {
						$(this).removeClass(
							response.data.active == "1" ? "btn-danger" : "btn-success"
						);
						$(this).addClass(
							response.data.active == "1" ? "btn-success" : "btn-danger"
						);

						$(this).html(response.data.active == "1" ? "Activo" : "Inactivo");
					}
				})
				.catch((error) => alert.errorAlert(error));
		});
});
