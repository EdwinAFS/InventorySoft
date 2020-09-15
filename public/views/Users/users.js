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
        alert.successAlert(response.message);
      }
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
        alert.successAlert(response.message);
        resetForm();
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
        $(this).addClass(response.data.active == "1" ? "btn-success" : "btn-danger");

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
