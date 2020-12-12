
<!-- iCheck -->
<link rel="stylesheet" href="public/libraries/icheck-bootstrap/icheck-bootstrap.min.css">

<?php
include "add.php";
include "edit.php";
?>

<link rel="stylesheet" href="public/css/zoom.css">

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
	<!-- Content Header (Page header) -->
	<section class="content-header">
		<div class="container-fluid">
			<div class="row mb-2">
				<div class="col-sm-6">
					<h1>Productos</h1>
				</div>
				<div class="col-sm-6">
					<ol class="breadcrumb float-sm-right">
						<li class="breadcrumb-item"><a href="home">Inicio</a></li>
						<li class="breadcrumb-item active">Productos</li>
					</ol>
				</div>
			</div>
		</div><!-- /.container-fluid -->
	</section>

	<!-- Main content -->
	<section class="content">

		<!-- Default box -->
		<div class="card">

			<div class="card-header">
				<button class="btn btn-primary" data-toggle="modal" data-target="#AddProductModal">
					Agregar Producto
				</button>
			</div>

			<div class="card-body">
				<table class="table table-bordered table-striped dataTable dt-responsive w-100" id="productTable">
					<thead>
						<tr>
							<th>ID</th>
							<th>Producto</th>
							<th>Imagen</th>
							<th>Información</th>
							<th>Estado</th>
							<th>Accion</th>
						</tr>
					</thead>
					
				</table>
			</div>

			<div class="card-footer">
				Footer
			</div>

		</div>

	</section>
	<!-- /.content -->
</div>
<!-- /.content-wrapper -->



<script src="public/views/Products/products.js"></script>
<script src="public/js/zoom.js"></script>