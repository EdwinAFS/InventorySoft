$(document).ready(function () {
	getDataForTableForSales();
});

/* OBTENER EL CLIENTE A EDITAR */
$(document).on("click", ".btn-SalePrint", function (e) {
	var saleId = $(this).attr("saleId");

	window.open(`./sale/print?id=${saleId}`, "_blank");
});

/* ELIMINAR UN CLIENTE */
$(document).on("click", ".btn-DeleteSale", function (e) {
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
			var saleId = $(this).attr("saleId");

			fetch("./sale/delete?id=" + saleId, {
				method: "DELETE",
			})
				.then((res) => res.json())
				.then((response) => {
					if (response.error) {
						alert.errorAlert(response.message);
					} else {
						alert.successAlert(response.message);
						$("#saleTable").DataTable().ajax.reload();
					}
				})
				.catch((error) => alert.errorAlert(error));
		}
	});
});

/* EDITAR UN CLIENTE */
$(document).on("click", "#btnEditSale", function (e) {
	var formData = document.getElementById("FormEditSale").getData();

	var data = {
		id: formData.editId,
		name: formData.editName,
		identification: formData.editIdentification,
		email: formData.editEmail,
		phone: formData.editPhone,
		address: formData.editAddress,
		birthdate: formData.editBirthdate,
	};

	fetch(`./sale/update?id=${data.id}`, {
		method: "PUT",
		body: convertJsonToForm(data),
	})
		.then((res) => res.json())
		.then((response) => {
			if (response.error) {
				alert.errorAlert(response.message);
			} else {
				alert.successAlert(response.message);
				$("#saleTable").DataTable().ajax.reload();
			}
		})
		.catch((error) => alert.errorAlert(error));
});

function getDataForTableForSales(
	startDate = moment().format("YYYY-M-D"),
	endDate = moment().format("YYYY-M-D")
) {
	table = $("#saleTable");

	table.DataTable().destroy();

	table.DataTable({
		order: [[7, "desc"]],
		processing: true,
		language: {
			url: "//cdn.datatables.net/plug-ins/1.10.15/i18n/Spanish.json",
		},
		ajax: {
			type: "GET",
			url: `./sale/datatable?startDate=${startDate}&endDate=${endDate}`,
		},
		columns: [
			{
				data: "Id",
				render: function (data) {
					return data;
				},
				visible: false,
			},
			{
				data: "Cod",
				render: function (data) {
					return data;
				},
			},
			{
				data: "Customer.name",
				render: function (data) {
					return data;
				},
			},
			{
				data: "Seller.name",
				render: function (data) {
					return data;
				},
			},
			{
				data: "PaymentMethod.description",
				render: function (data) {
					return data;
				},
			},
			{
				data: "NetPay",
				render: $.fn.dataTable.render.number(",", ".", 2),
			},
			{
				data: "Total",
				render: $.fn.dataTable.render.number(",", ".", 2),
			},
			{
				data: "Created_at",
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
						<button class='btn btn-primary text-white m-0 btn-SalePrint' saleId='${row.Id}'>
							<i class="fas fa-print"></i>
						</button>
						<button class='btn btn-danger text-white m-0 btn-DeleteSale' saleId='${row.Id}'>
							<i class='fas fa-times'></i>
						</button>
					</div>
				</td>
			</tr>`;
				},
				className: "cell",
			},
		],
	});
}

$(function () {
	$("#date_range").daterangepicker(
		{
			locale: {
				format: "YYYY-MM-DD",
				separator: " - ",
				applyLabel: "Aplicar",
				cancelLabel: "Cancelar",
				fromLabel: "Desde",
				toLabel: "Hasta",
				customRangeLabel: "Personalizar",
				daysOfWeek: ["Do", "Lu", "Ma", "Mi", "Ju", "Vi", "Sa"],

				monthNames: [
					"Enero",
					"Febrero",
					"Marzo",
					"Abril",
					"Mayo",
					"Junio",
					"Julio",
					"Agosto",
					"Setiembre",
					"Octubre",
					"Noviembre",
					"Diciembre",
				],
				firstDay: 1,
			},
			ranges: {
				Hoy: [moment(), moment()],
				Ayer: [moment().subtract(1, "days"), moment().subtract(1, "days")],
				"Últimos 7 días": [moment().subtract(6, "days"), moment()],
				"Últimos 30 días": [moment().subtract(29, "days"), moment()],
				"Este mes": [moment().startOf("month"), moment().endOf("month")],
				"Último mes": [
					moment().subtract(1, "month").startOf("month"),
					moment().subtract(1, "month").endOf("month"),
				],
			},
			startDate: moment().subtract(29, "days"),
			endDate: moment(),
		},
		function (start, end) {
			$("#date_range span").html(
				start.format("YYYY-MM-DD") + " - " + end.format("YYYY-MM-DD")
			);
			startDate = start.format("YYYY-MM-DD");
			endDate = end.format("YYYY-MM-DD");

			getDataForTableForSales(startDate, endDate);
		}
	);
});
