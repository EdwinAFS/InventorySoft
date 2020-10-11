
<?php
include "add.php";
include "edit.php";
?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
	<!-- Content Header (Page header) -->
	<section class="content-header">
		<div class="container-fluid">
			<div class="row mb-2">
				<div class="col-sm-6">
					<h1>Clientes</h1>
				</div>
				<div class="col-sm-6">
					<ol class="breadcrumb float-sm-right">
						<li class="breadcrumb-item"><a href="main">Inicio</a></li>
						<li class="breadcrumb-item active">Clientes</li>
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
				<button class="btn btn-primary" data-toggle="modal" data-target="#AddCustomerModal">
					Agregar Cliente
				</button>
			</div>

			<div class="card-body">
				<table class="table table-bordered table-striped dataTable dt-responsive w-100" id="customerTable">
					<thead>
						<tr>
							<th>ID</th>
							<th>Nombre</th>
							<th>Documento</th>
							<th>Email</th>
							<th>Telefono</th>
							<th>Direccion</th>
							<th>Fecha nacimiento</th>
							<th>Total compras</th>
							<th>Ultima compra</th>
							<th>Ingreso al sistema</th>					
							<th>Estado</th>
							<th>Accion</th>
						</tr>
					</thead>
					
				</table>
			</div>

		<!-- 	<div class="card-footer">
				Footer
			</div> -->

		</div>

	</section>
	<!-- /.content -->
</div>
<!-- /.content-wrapper -->



<script src="public/views/Customers/customers.js"></script>
