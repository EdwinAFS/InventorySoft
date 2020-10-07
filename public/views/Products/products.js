$(document).ready(function () {
  /* Default del campo de valor de venta y porcentaje */
  $("#editSalePrice").prop("disabled", false);
  $("#porcentage").val(0);
  $("#porcentage").prop("disabled", true);

  $("#salePrice").prop("disabled", false);
  $("#porcentageAdd").val(0);
  $("#porcentageAdd").prop("disabled", true);

  getDataForTable(0, 0);
});

/* OBTENER EL PRODUCTO A EDITAR */
$(document).on("click", ".btn-ProductEdit", function (e) {
  var productId = $(this).attr("productId");

  fetch("./product/findById?id=" + productId)
    .then((res) => res.json())
    .then((response) => {
      if (response.error) {
        alert.errorAlert(response.message);
      } else {
        $("#editId").val(response.data["productId"]);
        $("#editCod").val(response.data["cod"]);
        $("#editDescription").val(response.data["description"]);
        $("#editStock").val(response.data["stock"]);
        $("#editPurchasePrice").val(response.data["purchasePrice"]);
        $("#editSalePrice").val(response.data["salePrice"]);
        $("#editCategory").val(response.data["fK_categoryId"]);

        if (!response.data["img"]) {
          $("#image").hide();
        } else {
          $("#image").show();
          $("#imageUrl").val(response.data["img"]);
          $("#image").attr("src", response.data["img"]);
        }
      }
    })
    .catch((error) => alert.errorAlert(error));
});

/* ELIMINAR UN PRODUCTO */
$(document).on("click", ".btn-DeleteProduct", function (e) {
  var productId = $(this).attr("productId");

  fetch("./product/delete?id=" + productId, {
    method: "DELETE",
  })
    .then((res) => res.json())
    .then((response) => {
      if (response.error) {
        alert.errorAlert(response.message);
      } else {
        alert.successAlert(response.message);
        $("#productTable").DataTable().ajax.reload();
      }
    })
    .catch((error) => alert.errorAlert(error));
});

/* EDITAR UN PRODUCTO */
$(document).on("click", "#btnEditProduct", function (e) {
  var formData = document.getElementById("FormEditProduct").getData();

  var data = {
    id: formData.editId,
    cod: formData.editCod,
    description: formData.editDescription,
    stock: formData.editStock,
    purchasePrice: formData.editPurchasePrice,
    salePrice: formData.editSalePrice,
    category: formData.editCategory,
    imageUrl: formData.imageUrl,
    image: document.querySelector("#editImage").files[0],
  };

  fetch(`./product/update?id=${data.id}`, {
    method: "PUT",
    body: convertJsonToForm(data),
  })
    .then((res) => res.json())
    .then((response) => {
      if (response.error) {
        alert.errorAlert(response.message);
      } else {
        alert.successAlert(response.message);
        $("#productTable").DataTable().ajax.reload();
      }
    })
    .catch((error) => alert.errorAlert(error));
});

/* CREAR UN PRODUCTO */
$(document).on("click", "#btnAddProduct", function (e) {
  var data = {
    ...document.getElementById("FormAddProduct").getData(),
    image: document.querySelector("#AddImage").files[0],
  };

  fetch("./product/create", {
    method: "POST",
    body: convertJsonToForm(data),
  })
    .then((res) => res.json())
    .then((response) => {
      if (response.error) {
        alert.errorAlert(response.message);
      } else {
        alert.successAlert(response.message);
        $("#productTable").DataTable().ajax.reload();
      }
    })
    .catch((error) => alert.errorAlert(error));
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
  var productId = $(this).attr("productId");

  fetch("./product/changeActive?id=" + productId, {
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

$("#EditProductModal").on("hidden.bs.modal", function (e) {
  document.getElementById("FormEditProduct").reset();
  $(".custom-file-label").html("Seleccione archivo");
});

$("#AddProductModal").on("hidden.bs.modal", function (e) {
  document.getElementById("FormAddProduct").reset();
  $(".custom-file-label").html("Seleccione archivo");
});

/* CAMPOS DINAMICOS PORCENTAJE Y VALOR DE VENTA */

$("#withPorcentage").on("click", function (e) {
  var usedPorcentage = e.currentTarget.checked;

  if (usedPorcentage) {
    $("#porcentage").prop("disabled", false);
    $("#editSalePrice").val(0);
    $("#editSalePrice").prop("disabled", true);
  } else {
    $("#editSalePrice").prop("disabled", false);
    $("#porcentage").val(0);
    $("#porcentage").prop("disabled", true);
  }
});

$("#porcentage").on("keyup", function (e) {
  var porcentage = e.currentTarget.value;

  if (porcentage > 0) {
    var purchasePrice = $("#editPurchasePrice").val();

    $("#editSalePrice").val(purchasePrice * (1 + porcentage / 100));
  }
});

$("#withPorcentageAdd").on("click", function (e) {
  var usedPorcentage = e.currentTarget.checked;

  if (usedPorcentage) {
    $("#porcentageAdd").prop("disabled", false);
    $("#salePrice").val(0);
    $("#salePrice").prop("disabled", true);
  } else {
    $("#salePrice").prop("disabled", false);
    $("#porcentageAdd").val(0);
    $("#porcentageAdd").prop("disabled", true);
  }
});

$("#porcentageAdd").on("keyup", function (e) {
  var porcentage = e.currentTarget.value;

  if (porcentage > 0) {
    var purchasePrice = $("#purchasePrice").val();

    $("#salePrice").val(purchasePrice * (1 + porcentage / 100));
  }
});

function getDataForTable() {
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
        data: "description",
        render: function (data) {
          return `<td class='cell'><h4>${data}</h4></td>`;
        },
        className: "cell",
      },
      {
        data: "img",
        render: function (data) {
          return data
            ? `<td class='cell'><img src='${data}' class='rounded' width='120' data-action='zoom'></td>`
            : `<td class='cell'><p>Sin imagen</p></td>`;
        },
        className: "cell",
      },
      {
        data: "",
        render: function (data, type, row) {
          return `
		  <td class='cell'>
			  <div class='row m-3'>
				  <div class='col text-left'>
					  <b>Codigo:</b> ${row.cod}</br>
					  <b>Stock:</b> ${row.stock}</br>
					  <b>Precio de venta:</b> ${row.purchasePrice}</br>
				  </div>
				  <div class='col text-left'>
					  <b>Precio de compra:</b> ${row.salePrice}</br>
					  <b>Numero de ventas:</b> ${row.numOfSales}</br>
					  <b>Categoria:</b> ${row.fK_categoryId}</br>
				  </div>
			  </div>
		  </td>`;
        },
        className: "cell",
      },
      {
        data: "active",
        render: function (data, type, row) {
          return data == 1
            ? `<td class='cell'><button class='btn btn-success btn-xs btn-Active' productId='${row.productId}'>Activo</button></td>`
            : `<td class='cell'><button class='btn btn-danger btn-xs btn-Active' productId='${row.productId}'>Inactivo</button></td>`;
        },
        className: "cell",
      },
      {
        data: "",
        render: function (data, type, row) {
          return `
		  	<td class='cell'>
					<div class='btn-group'>
						<button class='btn btn-warning text-white m-0 btn-ProductEdit' productId='${row.productId}' data-toggle='modal' data-target='#EditProductModal'>
							<i class='fas fa-pencil-alt'></i>
						</button>
						<button class='btn btn-danger text-white m-0 btn-DeleteProduct' productId='${row.productId}'>
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
