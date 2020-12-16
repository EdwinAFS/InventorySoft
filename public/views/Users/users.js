$(document).ready(function () {
	getDataForTable();
});

/* OBTENER EL USUARIO A EDITAR */
$(document).on("click", ".btn-UserEdit", function (e) {
	var userId = $(this).attr("userId");

	fetch("./user/findById?id=" + userId)
		.then((res) => res.json())
		.catch((error) => alert.errorAlert(error))
		.then((response) => {
			if (response.error) {
				alert.errorAlert(response.message, response.detail);
			} else {

				$("#userTable").DataTable().ajax.reload();

				$("#editName").val(response.data["name"]);
				$("#editUsername").val(response.data["username"]);
				$("#editId").val(response.data["id"]);
				$("#editRol").val(response.data["rolID"]);

				if (!response.data["photo"]) {
					$("#avatar").hide();
				} else {
					$("#avatar").show();
					$("#photoUrl").val(response.data["photo"]);
					$("#avatar").attr("src", response.data["photo"]);
				}
			}
		});
});

/* ELIMINAR UN USUARIO */
$(document).on("click", ".btn-DeleteUser", function (e) {
	Swal.fire({
		title: "Estas seguro de eliminar este registro?",
		icon: "warning",
		showCancelButton: true,
		confirmButtonColor: "#3085d6",
		cancelButtonColor: "#d33",
		confirmButtonText: "!Si, Estoy seguro!",
		cancelButtonText: "Cancelar",
	}).then((result) => {
		if (!result.value) {
			return;
		}

		var userId = $(this).attr("userId");

		fetch("./user/delete?id=" + userId, {
			method: "DELETE",
		})
			.then((res) => res.json())
			.catch((error) => alert.errorAlert(error))
			.then((response) => {
				if (response.error) {
					alert.errorAlert(response.message, response.detail);
				} else {
					$("#userTable").DataTable().ajax.reload();
					alert.successAlert(response.message);
				}
			});
	});
});

/* EDITAR UN USUARIO */
$(document).on("click", "#btnEditUser", function (e) {
	formData = document.getElementById("FormEditUser").getData();

	var data = {
		id: formData.editId,
		name: formData.editName,
		username: formData.editUsername,
		rolID: formData.editRol,
		password: formData.editPassword,
		photoUrl: formData.photoUrl,
		photo: document.querySelector("#editPhoto").files[0],
	};

	fetch(`./user/update?id=${data.id}`, {
		method: "PUT",
		body: convertJsonToForm(data),
	})
		.then((res) => res.json())
		.catch((error) => alert.errorAlert(error))
		.then((response) => {
			if (response.error) {
				alert.errorAlert(response.message, response.detail);
			} else {
				$("#userTable").DataTable().ajax.reload();
				alert.successAlert(response.message);
			}
		});
});

/* CREAR UN USUARIO */
$(document).on("click", "#btnAddUser", function (e) {
	var data = {
		...document.getElementById("FormAddUser").getData(),
		photo: document.querySelector("#AddPhoto").files[0],
	};

	fetch("./user/create", {
		method: "POST",
		body: convertJsonToForm(data),
	})
		.then((res) => res.json())
		.catch((error) => alert.errorAlert(error))
		.then((response) => {
			if (response.error) {
				alert.errorAlert(response.message, response.detail);
			} else {
				$("#userTable").DataTable().ajax.reload();
				alert.successAlert(response.message);
			}
		});
});

/* CAMBIAR EL LABEL DEL INPUT SELECCIONAR IMAGEN */
$(".photo").change(function (e) {
	var image = this.files[0];

	if (!["image/png", "image/jpeg"].includes(image["type"])) {
		Swal.fire({
			title: "Error al subir imagen",
			text: "!La imagen debe estar en formato JPG o PNG!",
			icon: "error",
			confirmButtonText: "Cerrar",
		}).then((resp) => {
			if (resp.value) this.value = "";
			$(".custom-file-label").html("Seleccione archivo");
		});
	} else if (image["size"] > 2000000) {
		Swal.fire({
			title: "Error al subir imagen",
			text: "!La imagen no debe pesar mas de 2 MB!",
			icon: "error",
			confirmButtonText: "Cerrar",
		}).then((resp) => {
			if (resp.value) this.value = "";
			$(".custom-file-label").html("Seleccione archivo");
		});
	}
});

$(document).on("click", ".btn-Active", function (e) {
	var userId = $(this).attr("userId");

	fetch("./user/changeActive?id=" + userId, {
		method: "PATCH",
	})
		.then((res) => res.json())
		.then((response) => {
			if (response.error) {
				alert.errorAlert(response.message, response.detail);
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

$("#EditUserModal").on("hidden.bs.modal", function (e) {
	document.getElementById("FormEditUser").reset();
	$(".custom-file-label").html("Seleccione archivo");
});

$("#AddUserModal").on("hidden.bs.modal", function (e) {
	document.getElementById("FormAddUser").reset();
	$(".custom-file-label").html("Seleccione archivo");
});

function getDataForTable() {
	fetch("./login/rol")
		.then((response) => response.json())
		.then(({ rolCode }) => {
			table = $("#userTable");

			table.DataTable().destroy();

			table.DataTable({
				order: [[1, "asc"]],
				processing: true,
				language: {
					url: "//cdn.datatables.net/plug-ins/1.10.15/i18n/Spanish.json",
				},
				ajax: {
					type: "GET",
					url: `./user/datatable`,
				},

				columns: [
					{
						data: "id",
						render: function (data) {
							return data;
						},
						visible: false,
					},
					{
						data: "name",
						render: function (data) {
							return data;
						},
					},
					{
						data: "username",
						render: function (data) {
							return data;
						},
					},
					{
						data: "rol",
						render: function (data) {
							return data;
						},
					},
					{
						data: "active",
						render: function (data, type, row) {
							return data == 1
								? `<td class='cell'><button class='btn btn-success btn-xs btn-Active' categoryId='${row.id}'>Activo</button></td>`
								: `<td class='cell'><button class='btn btn-danger btn-xs btn-Active' categoryId='${row.id}'>Inactivo</button></td>`;
						},
						className: "cell",
					},
					{
						data: "lastLogin",
						render: function (data) {
							return data;
						},
					},
					{
						data: "",
						render: function (data, type, row) {
							return `
							<td class='cell'>
									<div class='btn-group'>
										${
											["Admin", "Seller"].includes(rolCode)
												? `
												<button class='btn btn-warning text-white m-0 btn-UserEdit' userId='${row.id}' data-toggle='modal' data-target='#EditUserModal'>
													<i class='fas fa-pencil-alt'></i>
												</button>`
												: ""
										}
										${
											["Admin"].includes(rolCode)
												? `
												<button class='btn btn-danger text-white m-0 btn-DeleteUser' userId='${row.id}'>
													<i class='fas fa-times'></i>
												</button>`
												: ""
										}
										
									</div>
								</td>
							</tr>`;
						},
						className: "cell",
					},
				],
			});
		});

	/*
		
							echo "	<td>{$user->getLastLogin()}</td>
									<td class='cell'>
										<div class='btn-group'>
											" . ((in_array($_SESSION["rolCode"], ["Admin", "Seller"])) ? "<button class='btn btn-warning text-white m-0 btn-UserEdit' userId='{$user->getId()}' data-toggle='modal' data-target='#EditUserModal'>
													<i class='fas fa-pencil-alt'></i>
												</button>" : "") . "
											" . (($_SESSION["rolCode"] == "Admin") ? "<button class='btn btn-danger text-white m-0 btn-DeleteUser' userId='{$user->getId()}'>
													<i class='fas fa-times'></i>
												</button>" : "") . "
										</div>
									</td>
								</tr>
								";
		
		*/
}
