<!DOCTYPE html>
<html>

<head>
	<base href="/inventorysoft/"/>

	<?php
		if(session_id() == '') {
			session_start();
		}
	?>
	
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>Inventorysoft</title>
	<!-- Tell the browser to be responsive to screen width -->
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<!-- Font Awesome -->
	<link rel="stylesheet" href="public/libraries/fontawesome-free/css/all.min.css">
	<!-- Ionicons -->
	<link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
	<!-- overlayScrollbars -->
	<link rel="stylesheet" href="templates/dist/css/adminlte.css">
	<link rel="stylesheet" href="templates/dist/css/main.css">
	<!-- Google Font: Source Sans Pro -->
	<link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
	<!-- DataTables -->
	<link rel="stylesheet" href="public/libraries/datatables-bs4/css/dataTables.bootstrap4.min.css">
	<link rel="stylesheet" href="public/libraries/datatables-responsive/css/responsive.bootstrap4.min.css">
	<!-- SweetAlert2 -->
	<link rel="stylesheet" href="public/libraries/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css">
	<script src="public/libraries/sweetalert2/sweetalert2.min.js"></script>
	<!-- jQuery -->
	<script src="public/libraries/jquery/jquery.min.js"></script>
	<!-- daterangepicker -->
	<link rel="stylesheet" href="public/libraries/daterangepicker/daterangepicker.css">

	<link rel="stylesheet" href="public/libraries/chart.js/chart.min.css">

	
	<link rel="icon" href="public/img/logo.png">
</head>

<body class="hold-transition sidebar-collapse sidebar-mini ">

	<?php
		if ( !$screenComplete ) {
			echo "<div class='wrapper'>";

				include "header.php";
				include($path);
				include "sidebar.php";
				include "footer.php";

			echo "</div>";
		} else {
			include($path);
		}
	?>
	<!-- Bootstrap 4 -->
	<script src="public/libraries/bootstrap/js/bootstrap.bundle.min.js"></script>
	<!-- AdminLTE App -->
	<script src="templates/dist/js/adminlte.min.js"></script>
	<!-- AdminLTE for demo purposes -->
	<script src="templates/dist/js/demo.js"></script>
	<!-- DataTables -->
	<script src="public/libraries/datatables/jquery.dataTables.min.js"></script>
	<script src="public/libraries/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
	<script src="public/libraries/datatables-responsive/js/dataTables.responsive.min.js"></script>
	<script src="public/libraries/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
	<script src="https://opensource.teamdf.com/number/jquery.number.js"></script>
	<!-- daterangepicker -->
	<script src="public/libraries/daterangepicker/moment.min.js"></script>
	<script src="public/libraries/daterangepicker/daterangepicker.js"></script>
	<!-- chartjs -->
	<script src="public/libraries/chart.js/chart.min.js"></script>

	<script src="public/js/main.js"></script>
	
</body>

</html>