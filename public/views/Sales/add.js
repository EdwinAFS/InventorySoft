$(document).ready(function () {
	getDataForTableForProducts();
	moveTableForSales();

	// format de precio
	$(".price").number(true, 2);

	$("#paymentMethodId").change(function (paymentMethod) {
		var content = methodPayment(paymentMethod.currentTarget.value);
		$("#paymentMethod").html(content);
		$(".price").number(true, 2);
	});
});

window.onresize = function () {
	moveTableForSales();
};

/* CREAR PEDIDO */
$(document).on("click", "#saveSale", function (e) {

	var productJson = [];
	$(".nuevoProducto").children('div').each(function () {
		$data = $(this).find("input");
		console.log($data);
		productJson.push({
			productId: $data[0].value,
			productQuantity: $data[2].value,
			totalPayment: $($data[3]).val()
		});
	});	

	var data = {
		cod: new Date().getTime(),
		taxes: $("#impuestoVenta").val(),
		netPay: $("#netPay").val(),
		total: $("#total").val(),
		products: JSON.stringify(productJson),
		fK_customerId: $("#customer option:selected").val(),
		fK_sellerId: $("#sellerId").val(),
		fK_paymentMethodId: $("#paymentMethodId").val(),
		transactionCode: $("#transactionCode").val(),
		cash: $("#cash").val(),
		cashback: $("#cashback").val()
	};

	fetch("./sale/create", {
		method: "POST",
		body: convertJsonToForm(data),
	})
		.then((res) => res.json())
		.then((response) => {
			if (response.error) {
				alert.errorAlert(response.message);
			} else {
				alert.successAlert(response.message)
					.then( function(){
						window.location.href = 'sale';		
					});
			}
		})
		.catch((error) => alert.errorAlert(error));
});

/* MANEJAR PEDIDOS */

function moveTableForSales() {
	var tableIsHidden = $("#containerProducts").is(":hidden");

	if (tableIsHidden) {
		$("#tableContainerProducts").appendTo("#modalBodyForSales");

		var table = $("#productTable").DataTable();
		table.columns([1]).visible(true);
		table.columns([2, 4, 5]).visible(false);
	} else {
		$("#ContainerProductsModal").modal("hide");

		$("#tableContainerProducts").appendTo("#divForSales");

		var table = $("#productTable").DataTable();
		table.columns([1]).visible(false);
		table.columns([2, 4, 5]).visible(true);
	}
}

$(document).on("click", ".btn-AddProduct", function (e) {
	var product = JSON.parse($(this).attr("data"));

	if (product.stock <= 0) {
		Swal.fire("No hay disponible en el stock");
		return;
	}

	$(this).removeClass("btn-primary");
	$(this).addClass("btn-default");
	$(this).prop("disabled", true);

	$(".nuevoProducto").append(
		`
		<div class="row w-100" style="padding-left: 6px; margin-bottom: -15px !important;">
		<hr class="w-100" style="margin: 10px;">
			<input type="hidden" name="productId" value=${product.productId}>
			<div class="column input-group mb-3 col-sm-6">
				<div class="input-group-prepend">
					<div class="input-group-text">
						<button type="button" class="btn btn-danger btn-xs btn-DeleteProduct productId" productId='${product.productId}' ><i class="fa fa-times"></i></button>
					</div>
				</div>
				<input type="text" class="form-control" id="addProduct" name="addProduct" placeholder="Descripción del producto" value=${product.description} readonly required>
			</div>

			<div class="column input-group mb-3 col-sm-3">
				<input type="number" class="form-control productQuantity" id="productQuantity" name="productQuantity" min="1" placeholder="0" max=${product.stock} min=0 value='1' required >
			</div>

			<div class="column input-group mb-3 col-sm-3">
				<div class="input-group-prepend">
					<div class="input-group-text">
						<i class="ion ion-social-usd"></i>
					</div>
				</div>
				<input type="text" min="1" class="form-control salePrice price" name="salePrice" salePrice='${product.salePrice}' value=${product.salePrice} readonly required>
	
			</div>
		</div>`
	);

	calculateTotal();

	$(".price").number(true, 2);
});

$(document).on("click", ".btn-DeleteProduct", function (e) {
	var productId = $(this).attr("productId");

	var buttonAddProduct = $(`#Add${productId}`);
	buttonAddProduct.removeClass("btn-default");
	buttonAddProduct.addClass("btn-primary");
	buttonAddProduct.prop("disabled", false);

	var row = $(this).parent().parent().parent().parent();
	row.remove();

	calculateTotal();
});

$(document).on("change", ".productQuantity", function (e) {
	var productQuantity = Number($(this).val());

	var stock = Number($(this).attr("max"));

	if (productQuantity > stock) {
		var productQuantity = stock;
		$(this).val(productQuantity);
		Swal.fire({
			icon: "error",
			title: "Oops...",
			text: "No hay esa cantidad disponible en el stock",
		});
	}

	var salePriceInput = $(this).parent().parent().children()[4].children[1];

	var salePriceOriginal = salePriceInput.getAttribute("salePrice");

	salePriceInput.value = salePriceOriginal * productQuantity;

	calculateTotal();
});

$(document).on("change", "#impuestoVenta", function (e) {
	calculateTotal();
});

function getDataForTableForProducts() {
	table = $("#productTable");

	table.DataTable().destroy();

	table.DataTable({
		order: [[4, "asc"]],
		processing: true,
		language: {
			url: "//cdn.datatables.net/plug-ins/1.10.15/i18n/Spanish.json",
		},
		ajax: {
			type: "GET",
			url: `./product/datatable?quantity=0&numberPag=0`,
		},
		columns: [
			{
				data: "productId",
				render: function (data) {
					return data;
				},
				visible: false,
			},
			{
				data: "",
				render: function (data, type, row) {
					var typeAlert =
						row.stock <= 10
							? "danger"
							: row.stock > 11 && row.stock <= 15
							? "warning"
							: "success";

					return `
						<td class='cell'>
							<div class='d-flex flex-column text-left'>
								<p><strong>Código: </strong> ${row.cod} </p>
								<p><strong>Descripcion: </strong> ${row.description} </p>
								<p><strong>Stock: </strong> <button class='btn btn-${typeAlert}'>${row.stock}</button> </p>
							</div>
						</td>
					`;
				},
				visible: false,
				className: "cell",
			},
			{
				data: "cod",
				render: function (data) {
					return `<td class='cell'><h4>${data}</h4></td>`;
				},
				className: "cell",
				width: "20%",
			},
			{
				data: "img",
				render: function (data) {
					return data
						? `<td class='cell'><img src='${data}' class='rounded' width='60' data-action='zoom'></td>`
						: `<td class='cell'><p>Sin imagen</p></td>`;
				},
				className: "cell",
				width: "50px",
			},
			{
				data: "description",
				render: function (data) {
					return `<td class='cell'><h4>${data}</h4></td>`;
				},
				className: "cell",
				width: "30%",
			},
			{
				data: "stock",
				render: function (data) {
					var typeAlert =
						data <= 10
							? "danger"
							: data > 11 && data <= 15
							? "warning"
							: "success";
					return `<td class='cell mw-100'><button class='btn btn-${typeAlert}'>${data}</button></td>`;
				},
				className: "cell",
				width: "20px",
			},
			{
				data: "",
				render: function (data, type, row) {
					return `
						<td class='cell mw-100'">
							<div class='btn-group'>
								<button class='btn btn-primary m-0 btn-AddProduct' productId='${
									row.productId
								}' data=${JSON.stringify(row)} id='Add${row.productId}'>
									Agregar
								</button>
							</div>
						</td>
					</tr>`;
				},
				className: "cell",
				width: "50px",
			},
		],
	});
}

function calculateTotal() {
	var grossValue = 0;
	var total = 0;

	priceForProduct = $(".salePrice");
	var salesTax = $("#impuestoVenta").val();

	for (let i = 0; i < priceForProduct.length; i++) {
		grossValue += Number($(priceForProduct[i]).val());
	}

	total = grossValue + grossValue * (salesTax / 100);

	$(".price").number(true, 2);

	$("#total").val(grossValue);
	$("#netPay").val(total);
}

function methodPayment(type) {
	const DEBITO = 1;
	const CREDITO = 2;
	const EFECTIVO = 3;

	switch (Number(type)) {
		case DEBITO:
		case CREDITO:
			return `
				<div class="input-group-prepend">
					<div class="input-group-text">
						<i class="fa fa-lock"></i>
					</div>
				</div>
				<input type="text" class="form-control" id="transactionCode" name="transactionCode" placeholder="Código transacción" required>
			`;
		case EFECTIVO:
			return `
				<div class='input-group col-sm-6'>
					<input type="text" class="form-control price" id="cash" name="cash" placeholder="Recibido" required>
				</div>
				<div class='input-group col-sm-6'>
					<input type="text" class="form-control price" id="cashback" name="cashback" placeholder="Cambio" required>
				</div>
			`;
		default:
			return ``;
	}
}

// calcular el cambio del efectivo recibido
$("#saleForm").on('change', '#cash', function() {
	var cash = $(this).val();
	var cashBack = cash - $("#netPay").val();
	$("#cashback").val(cashBack);
})