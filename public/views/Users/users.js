
/* OBTENER EL USUARIO A EDITAR */
$(".btn-UserEdit").click(function( e ){
	var userId = $(this).attr("userId");
	
	fetch("./user/findById?id=" + userId)
		.then((res) => res.json())
		.catch((error) => alert.errorAlert(error))
		.then((response) => {
			if(response.error){
				alert.errorAlert(response.message);
			}else{
				console.log(response.data);
			}
		});;

});


/* CREAR UN USUARIO */
$("#btnAddUser").click(function( e ){
	var data = {
		...document.getElementById("FormAddUser").getData(),
		photo: document.querySelector('#AddPhoto').files[0]
	};

	fetch("./user/create", {
		method: "POST",
		body: convertJsonToForm(data)
	})
	.then((res) => res.json())
	.catch((error) => alert.errorAlert(error))
	.then((response) => {
		if(response.error){
			alert.errorAlert(response.message);
		}else{
			alert.successAlert(response.message);
		}
	});

});

/* CAMBIAR EL LABEL DEL INPUT SELECCIONAR IMAGEN */
$(".photo").change( function( e ){

	var image = this.files[0];

	if( ! ["image/png", "image/jpeg"].includes(image["type"]) ){

		Swal.fire({
			title: "Error al subir imagen",
			text: "!La imagen debe estar en formato JPG o PNG!",
			icon: 'error',
			confirmButtonText: "Cerrar",
		}).then((resp)=>{
			if( resp.value) this.value = "";
			$('.custom-file-label').html("Seleccione archivo");
		});

		
	}else if( image["size"] > 2000000 ){
		Swal.fire({
			title: "Error al subir imagen",
			text: "!La imagen no debe pesar mas de 2 MB!",
			icon: 'error',
			confirmButtonText: "Cerrar",
		}).then((resp)=>{
			if( resp.value) this.value = "";
			$('.custom-file-label').html("Seleccione archivo");
		});
	} 

});

