<!DOCTYPE html>
<html>

<head>
	<base href="<?php echo BASE; ?>" />

	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>Inventorysoft</title>
	<!-- Tell the browser to be responsive to screen width -->
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<!-- jQuery -->
	<script src="vendor\almasaeed2010\adminlte\plugins\jquery\jquery.min.js"></script>
	<!-- Font Awesome -->
	<link rel="stylesheet" href="vendor\almasaeed2010\adminlte\plugins\fontawesome-free\css\all.min.css">
	<!-- Ionicons -->
	<link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
	<!-- overlayScrollbars -->
	<link rel="stylesheet" href="public/css/main.css">

	<link rel="stylesheet" href="vendor\almasaeed2010\adminlte\dist\css\adminlte.min.css">
	<!-- Google Font: Source Sans Pro -->
	<link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
	<!-- DataTables -->
	<link rel="stylesheet" href="vendor\almasaeed2010\adminlte\plugins\datatables-bs4\css\dataTables.bootstrap4.min.css">
	<link rel="stylesheet" href="vendor\almasaeed2010\adminlte\plugins\datatables-responsive\css\responsive.bootstrap4.min.css">
	<!-- SweetAlert2 -->
	<link rel="stylesheet" href="vendor\almasaeed2010\adminlte\plugins\sweetalert2-theme-bootstrap-4\bootstrap-4.min.css">
	<!-- daterangepicker -->
	<link rel="stylesheet" href="vendor\almasaeed2010\adminlte\plugins\daterangepicker\daterangepicker.css">
	<!-- chartjs -->
	<script src="vendor\almasaeed2010\adminlte\plugins\chart.js\Chart.min.js"></script>
	<link rel="stylesheet" href="vendor\almasaeed2010\adminlte\plugins\chart.js\Chart.min.css">

	<link rel="icon" href="public/img/logo.png">

</head>

<body class="hold-transition sidebar-collapse sidebar-mini layout-fixed">

	<?php
	if (!$screenComplete) {
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
	<script src="vendor\almasaeed2010\adminlte\plugins\bootstrap\js\bootstrap.bundle.min.js"></script>
	<!-- AdminLTE App -->
	<script src="vendor\almasaeed2010\adminlte\dist\js\adminlte.min.js"></script>
	<!-- DataTables -->
	<script src="vendor\almasaeed2010\adminlte\plugins\datatables\jquery.dataTables.min.js"></script>
	<script src="vendor\almasaeed2010\adminlte\plugins\datatables-bs4\js\dataTables.bootstrap4.min.js"></script>
	<script src="vendor\almasaeed2010\adminlte\plugins\datatables-responsive\js\dataTables.responsive.min.js"></script>
	<script src="vendor\almasaeed2010\adminlte\plugins\datatables-responsive\js\responsive.bootstrap4.min.js"></script>
	<!-- jquery.number -->
	<script src="https://opensource.teamdf.com/number/jquery.number.js"></script>
	<!-- daterangepicker -->
	<script src="vendor/almasaeed2010/adminlte/plugins/daterangepicker/moment.min.js"></script>
	<script src="vendor\almasaeed2010\adminlte\plugins\daterangepicker\daterangepicker.js"></script>
	<!-- SweetAlert2 -->
	<script src="vendor\almasaeed2010\adminlte\plugins\sweetalert2\sweetalert2.min.js"></script>

	<script src="public/js/main.js"></script>

</body>

</html>