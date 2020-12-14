$(document).ready(function () {
	getDataForTable();
});

/* OBTENER EL CLIENTE A EDITAR */
$(document).on("click", ".btn-CustomerEdit", function (e) {
	var customerId = $(this).attr("customerId");

	fetch("./customer/findById?id=" + customerId)
		.then((res) => res.json())
		.then((response) => {
			if (response.error) {
				alert.errorAlert(response.message);
			} else {
				$("#editId").val(response.data["customerId"]);
				$("#editName").val(response.data["name"]);
				$("#editIdentification").val(response.data["identification"]);
				$("#editEmail").val(response.data["email"]);
				$("#editPhone").val(response.data["phone"]);
				$("#editAddress").val(response.data["address"]);
				$("#editBirthdate").val(response.data["birthdate"]);
			}
		})
		.catch((error) => alert.errorAlert(error));
});

/* ELIMINAR UN CLIENTE */
$(document).on("click", ".btn-DeleteCustomer", function (e) {
	Swal.fire({
		title: "Estas seguro de eliminar este registro?",
		icon: "warning",
		showCancelButton: true,
		confirmButtonColor: "#3085d6",
		cancelButtonColor: "#d33",
		confirmButtonText: "!Si, Estoy seguro!",
		cancelButtonText: "Cancelar",
	}).then((result) => {
		if (result.value) {
			var customerId = $(this).attr("customerId");

			fetch("./customer/delete?id=" + customerId, {
				method: "DELETE",
			})
				.then((res) => res.json())
				.then((response) => {
					if (response.error) {
						alert.errorAlert(response.message);
					} else {
						alert.successAlert(response.message);
						$("#customerTable").DataTable().ajax.reload();
					}
				})
				.catch((error) => alert.errorAlert(error));
		}
	});
});

/* EDITAR UN CLIENTE */
$(document).on("click", "#btnEditCustomer", function (e) {
	var formData = document.getElementById("FormEditCustomer").getData();

	var data = {
		id: formData.editId,
		name: formData.editName,
		identification: formData.editIdentification,
		email: formData.editEmail,
		phone: formData.editPhone,
		address: formData.editAddress,
		birthdate: formData.editBirthdate,
	};

	fetch(`./customer/update?id=${data.id}`, {
		method: "PUT",
		body: convertJsonToForm(data),
	})
		.then((res) => res.json())
		.then((response) => {
			if (response.error) {
				alert.errorAlert(response.message);
			} else {
				alert.successAlert(response.message);
				$("#customerTable").DataTable().ajax.reload();
			}
		})
		.catch((error) => alert.errorAlert(error));
});

/* CREAR UN CLIENTE */
$(document).on("click", "#btnAddCustomer", function (e) {
	var data = {
		...document.getElementById("FormAddCustomer").getData(),
	};

	fetch("./customer/create", {
		method: "POST",
		body: convertJsonToForm(data),
	})
		.then((res) => res.json())
		.then((response) => {
			if (response.error) {
				alert.errorAlert(response.message);
			} else {
				alert.successAlert(response.message);
				$("#customerTable").DataTable().ajax.reload();
			}
		})
		.catch((error) => alert.errorAlert(error));
});

$(document).on("click", ".btn-Active", function (e) {
	fetch("./login/rol")
		.then((response) => response.json())
		.then(({ rolCode }) => {
			if ( !["Admin"].includes(rolCode) ) return;

			var customerId = $(this).attr("customerId");

			fetch("./customer/changeActive?id=" + customerId, {
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

$("#EditCustomerModal").on("hidden.bs.modal", function (e) {
	document.getElementById("FormEditCustomer").reset();
});

$("#AddCustomerModal").on("hidden.bs.modal", function (e) {
	document.getElementById("FormAddCustomer").reset();
});

function getDataForTable() {
	fetch("./login/rol")
		.then((response) => response.json())
		.then(({ rolCode }) => {
			table = $("#customerTable");

			table.DataTable().destroy();

			table.DataTable({
				order: [[4, "asc"]],
				processing: true,
				language: {
					url: "//cdn.datatables.net/plug-ins/1.10.15/i18n/Spanish.json",
				},
				ajax: {
					type: "GET",
					url: `./customer/datatable`,
				},
				columns: [
					{
						data: "customerId",
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
						data: "identification",
						render: function (data) {
							return data;
						},
					},
					{
						data: "email",
						render: function (data) {
							return data;
						},
					},
					{
						data: "phone",
						render: function (data) {
							return data;
						},
					},
					{
						data: "address",
						render: function (data) {
							return data;
						},
					},
					{
						data: "birthdate",
						render: function (data) {
							return data;
						},
					},
					{
						data: "active",
						render: function (data, type, row) {
							return data == 1
								? `<td class='cell'><button class='btn btn-success btn-xs btn-Active' customerId='${row.customerId}'>Activo</button></td>`
								: `<td class='cell'><button class='btn btn-danger btn-xs btn-Active' customerId='${row.customerId}'>Inactivo</button></td>`;
						},
						className: "cell",
					},
					{
						data: "",
						render: function (data, type, row) {
							return `
							<td class='cell'>
									<div class='btn-group'>
										<button class='btn btn-warning text-white m-0 btn-CustomerEdit' customerId='${
											row.customerId
										}' data-toggle='modal' data-target='#EditCustomerModal'>
											<i class='fas fa-pencil-alt'></i>
										</button>
										${
											["Admin"].includes(rolCode)
												? `<button class='btn btn-danger text-white m-0 btn-DeleteCustomer' customerId='${row.customerId}'>
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
}
