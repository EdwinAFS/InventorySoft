$(document).ready(function () {
	getDataForTable();
});

/* OBTENER LA CATEGORIA A EDITAR */
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

/* ELIMINAR UN CATEGORIA */
$(document).on("click", ".btn-DeleteCategory", function (e) {
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
					$("#categoryTable").DataTable().ajax.reload();
				}
			})
			.catch((error) => alert.errorAlert(error));
	});
});

/* EDITAR UN CATEGORIA */
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
				$("#categoryTable").DataTable().ajax.reload();
			}
		})
		.catch((error) => alert.errorAlert(error));
});

/* CREAR UN CATEGORIA */
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
				$("#categoryTable").DataTable().ajax.reload();
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

function getDataForTable() {
	fetch("./login/rol")
		.then((response) => response.json())
		.then(({ rolCode }) => {
			table = $("#categoryTable");
			
			table.DataTable().destroy();

			table.DataTable({
				order: [[1, "asc"]],
				processing: true,
				language: {
					url: "//cdn.datatables.net/plug-ins/1.10.15/i18n/Spanish.json",
				},
				ajax: {
					type: "GET",
					url: `./category/datatable`,
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
						data: "description",
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
						data: "",
						render: function (data, type, row) {
							return `
							<td class='cell'>
									<div class='btn-group'>
										${
											["Admin", "InventoryManager"].includes(rolCode)
												? `
												<button class='btn btn-warning text-white m-0 btn-CategoryEdit' categoryId='${row.id}' data-toggle='modal' data-target='#EditCategoryModal'>
													<i class='fas fa-pencil-alt'></i>
												</button>
												<button class='btn btn-danger text-white m-0 btn-DeleteCategory' categoryId='${row.id}'>
													<i class='fas fa-times'></i>
												</button>`
												: "No disponible"
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
}
