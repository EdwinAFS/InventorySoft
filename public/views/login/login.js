$("#btnLogin").click(function () {

	var data = {
		username: $("#username").val(),
		password: $("#password").val()
	};

	fetch("./login/autenticate", {
		method: "POST",
		body: convertJsonToForm(data)
	})
	.then((res) => res.json())
	.catch((error) => alert.errorAlert(error))
	.then((response) => {
		if(response.error){
			alert.errorAlert(response.message);
		}else{
			window.location.href =  response.home;
		}
	});
	
});




