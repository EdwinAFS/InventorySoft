/* OBTENER EL USUARIO A EDITAR */
$(".btn-UserEdit").click(function (e) {
  var userId = $(this).attr("userId");

  fetch("./user/findById?id=" + userId)
    .then((res) => res.json())
    .catch((error) => alert.errorAlert(error))
    .then((response) => {
      if (response.error) {
        alert.errorAlert(response.message);
      } else {
        $("#editName").val(response.data["name"]);
        $("#editUsername").val(response.data["username"]);
        $("#editRol").val(response.data["rol"]);
        $("#editId").val(response.data["id"]);

        /*
			$("#editPhoto").val(response.data['photo']);
		*/
      }
    });
});

/* ELIMINAR UN USUARIO */
$(".btn-DeleteUser").click(function (e) {
  var userId = $(this).attr("userId");

  fetch("./user/delete?id=" + userId, {
    method: "DELETE",
  })
    .then((res) => res.json())
    .catch((error) => alert.errorAlert(error))
    .then((response) => {
      if (response.error) {
        alert.errorAlert(response.message);
      } else {
        alert.successAlert(response.message);
      }
    });
});

/* EDITAR UN USUARIO */
$("#btnEditUser").click(function (e) {
  formData = document.getElementById("FormEditUser").getData();

  var data = {
    id: formData.editId,
    name: formData.editName,
    username: formData.editUsername,
    password: formData.editPassword,
  };

  fetch(`./user/update?id=${data.id}`, {
    method: "PUT",
    body: JSON.stringify(data),
    headers: {
      "Content-Type": "application/json",
    },
  })
    .then((res) => res.json())
    .catch((error) => alert.errorAlert(error))
    .then((response) => {
      if (response.error) {
        alert.errorAlert(response.message);
      } else {
        alert.successAlert(response.message);
      }
    });
});

/* CREAR UN USUARIO */
$("#btnAddUser").click(function (e) {
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
        alert.errorAlert(response.message);
      } else {
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
