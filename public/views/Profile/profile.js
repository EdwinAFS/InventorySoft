
/* EDITAR PERFIL */
$(document).on("click", "#btnEditUser", function (e) {
  formData = document.getElementById("FormEditUser").getData();

  var data = {
    id: formData.editId,
    name: formData.editName,
    username: formData.editUsername,
    photoUrl: formData.photoUrl,
    photo: document.querySelector("#editPhoto").files[0],
  };

  fetch(`./profile/updateProfile?id=${data.id}`, {
    method: "PUT",
    body: convertJsonToForm(data),
  })
    .then((res) => res.json())
    .catch((error) => alert.errorAlert(error))
    .then((response) => {
      if (response.error) {
        alert.errorAlert(response.message, response.detail);
      } else {
		alert.successAlert(response.message)
			.then( response =>{
				location.reload();
			});
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

$("#EditUserModal").on("hidden.bs.modal", function (e) {
  document.getElementById("FormEditUser").reset();
  $(".custom-file-label").html("Seleccione archivo");
});

$("#AddUserModal").on("hidden.bs.modal", function (e) {
  document.getElementById("FormAddUser").reset();
  $(".custom-file-label").html("Seleccione archivo");
});
