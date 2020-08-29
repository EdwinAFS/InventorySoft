<?php
	session_start();
?>

<!DOCTYPE html>
<html>

<head>
	<base href="/inventorysoft/"/>

	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>Inventorysoft</title>
	<!-- Tell the browser to be responsive to screen width -->
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<!-- Font Awesome -->
	<link rel="stylesheet" href="views/public/plugins/fontawesome-free/css/all.min.css">
	<!-- Ionicons -->
	<link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
	<!-- overlayScrollbars -->
	<link rel="stylesheet" href="views/public/dist/css/adminlte.css">
	<!-- Google Font: Source Sans Pro -->
	<link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
	<!-- DataTables -->
	<link rel="stylesheet" href="views/public/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
	<link rel="stylesheet" href="views/public/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
	<!-- SweetAlert2 -->
	<link rel="stylesheet" href="views/public/plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css">
	<script src="views/public/plugins/sweetalert2/sweetalert2.min.js"></script>
	<!-- jQuery -->
	<script src="views/public/plugins/jquery/jquery.min.js"></script>

	
	<link rel="icon" href="views/public/img/logo.png">
</head>

<body class="hold-transition sidebar-collapse sidebar-mini ">

	<?php
	if (
		isset($_SESSION["iniciarSesion"]) &&
		$_SESSION["iniciarSesion"] == "ok"
	) {
		echo "<div class='wrapper'>";

			include "generals/header.php";
			include($path);
			include "generals/sidebar.php";
			include "generals/footer.php";

		echo "</div>";
	} else {
		include "generals/login.php";
	}

	?>
	<!-- Bootstrap 4 -->
	<script src="views/public/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
	<!-- AdminLTE App -->
	<script src="views/public/dist/js/adminlte.min.js"></script>
	<!-- AdminLTE for demo purposes -->
	<script src="views/public/dist/js/demo.js"></script>
	<!-- DataTables -->
	<script src="views/public/plugins/datatables/jquery.dataTables.min.js"></script>
	<script src="views/public/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
	<script src="views/public/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
	<script src="views/public/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
	
	<script src="views/public/js/main.js"></script>
	
</body>

</html>