<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
	<!-- Content Header (Page header) -->
	<section class="content-header">
		<div class="container-fluid">
			<div class="row mb-2">
				<div class="col-sm-6">
					<h1>Ventas</h1>
				</div>
				<div class="col-sm-6">
					<ol class="breadcrumb float-sm-right">
						<li class="breadcrumb-item"><a href="home">Inicio</a></li>
						<li class="breadcrumb-item active">Ventas</li>
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
				<a href="sale/add" class="badge badge-primary">
					<button class="btn btn-primary">Agregar Venta</button>
				</a>
				<button type="button" class="btn btn-default pull-right float-right" id="date_range">
					<span>
						<i class="fa fa-calendar"></i> Rango de fecha
					</span>
					<i class="fa fa-caret-down"></i>
				</button>

			</div>

			<div class="card-body">
				<table class="table table-bordered table-striped dt-responsive w-100" id="saleTable">
					<thead>
						<tr>
							<th>ID</th>
							<th>No. factura</th>
							<th>Cliente</th>
							<th>Vendedor</th>
							<th>Forma de pago</th>
							<th>Neto</th>
							<th>Total</th>
							<th>Fecha</th>
							<th>Accion</th>
						</tr>
					</thead>

				</table>
			</div>

		</div>

	</section>
	<!-- /.content -->
</div>
<!-- /.content-wrapper -->


<script src="public/views/Sales/sales.js"></script>