

/* configuration -> file input */
$('input[type="file"]').change(function(e) {
	var fileName = e.target.files[0].name;
	$('.custom-file-label').html(fileName);
});

/* DataTable */
$(".dataTable").DataTable({
	"columnDefs": [
		{
			"targets": [ 0 ],
			"visible": false,
			"searchable": false
		}
	],
	"language": {

		"sProcessing":     "Procesando...",
		"sLengthMenu":     "Mostrar _MENU_ registros",
		"sZeroRecords":    "No se encontraron resultados",
		"sEmptyTable":     "Ningún dato disponible en esta tabla",
		"sInfo":           "Mostrando registros del _START_ al _END_ de un total de _TOTAL_",
		"sInfoEmpty":      "Mostrando registros del 0 al 0 de un total de 0",
		"sInfoFiltered":   "(filtrado de un total de _MAX_ registros)",
		"sInfoPostFix":    "",
		"sSearch":         "Buscar:",
		"sUrl":            "",
		"sInfoThousands":  ",",
		"sLoadingRecords": "Cargando...",
		"oPaginate": {
		"sFirst":    "Primero",
		"sLast":     "Último",
		"sNext":     "Siguiente",
		"sPrevious": "Anterior"
		},
		"oAria": {
			"sSortAscending":  ": Activar para ordenar la columna de manera ascendente",
			"sSortDescending": ": Activar para ordenar la columna de manera descendente"
		}

	}
});

function convertJsonToForm( json ){
	var form_data = new FormData();

	for ( var key in json ) {
		form_data.append(key, json[key]);
	}

	return form_data;
}


$("#logout").click(function () {

	fetch("./login/logout")
	.then((res) => res.json())
	.catch((error) => alert.errorAlert(error))
	.then((response) => {
		if(response.error){
			alert.errorAlert(response.message);
		}else{
			window.location.href =  response.url;
		}
	});
	
});

HTMLFormElement.prototype.getData = function (){

	var $form = $(`#${this.id}`);
	var unindexed_array = $form.serializeArray();
    var indexed_array = {};

    $.map(unindexed_array, function(n, i){
        indexed_array[n['name']] = n['value'];
    });

    return indexed_array;
}

const alert = {
	errorAlert: function( message = "", detail = ""){
		Swal.fire({
			icon: 'error',
			title: 'Oops...',
			html: message + "<span style='font-size: 13px'>" +((detail != "")? "</br>": "") + detail +"</span>"
		});
	},
	successAlert: function( message = "" ){
		Swal.fire({
			icon: 'success',
			text: message
		});
	}
}
