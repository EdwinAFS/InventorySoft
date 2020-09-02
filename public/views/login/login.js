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
	.catch((error) => AlertError(error))
	.then((response) => {
		if(response.error){
			AlertError(response.message);
		}else{
			window.location.href =  response.home;
		}
	});
	
});




