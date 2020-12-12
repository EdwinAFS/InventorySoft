<link rel="stylesheet" href="public/css/zoom.css">

<div class="content-wrapper">
	<section class="content-header">
		<div class="container-fluid">
			<div class="row mb-2">
				<div class="col-sm-6">
					<h1>Reporte de Ventas</h1>
				</div>
				<div class="col-sm-6">
					<ol class="breadcrumb float-sm-right">
						<li class="breadcrumb-item"><a href="home">Inicio</a></li>
						<li class="breadcrumb-item active">Reporte</li>
					</ol>
				</div>
			</div>
		</div><!-- /.container-fluid -->
	</section>
	<section class="content">

		<!-- Default box -->
		<div class="card">

			<div class="row">
				<div class="col-md-5 p-3">
					<button type="button" class="btn btn-default" id="date_range">
						<span>
							<i class="fa fa-calendar"></i> Rango de fecha
						</span>
						<i class="fa fa-caret-down"></i>
					</button>
				</div>
			</div>

			<!-- SaleMonth -->
			<div class="card bg-gradient-light">
				<div class="card-header border-0 ui-sortable-handle" style="cursor: move;">
					<h3 class="card-title">
						<i class="fas fa-cart-arrow-down pr-2"></i>
						Ventas por mes
					</h3>

					<div class="card-tools">
						<button type="button" class="btn bg-light btn-sm" data-card-widget="collapse">
							<i class="fas fa-minus"></i>
						</button>
					</div>
				</div>
				<div class="card-body">
					<div class="row d-flex justify-content-center">
						<div class="col-md-9" id="saleMonthChartContainer">
							<canvas id="saleMonthChart"></canvas>
						</div>
					</div>
				</div>
			</div>

			<!-- TopProducts -->
			<div class="card bg-gradient-light">
				<div class="card-header border-0 ui-sortable-handle" style="cursor: move;">
					<h3 class="card-title">
						<i class="fab fa-product-hunt pr-2"></i>
						Top de productos mas vendidos
					</h3>

					<div class="card-tools">
						<button type="button" class="btn bg-light btn-sm" data-card-widget="collapse">
							<i class="fas fa-minus"></i>
						</button>
					</div>
				</div>
				<div class="card-body">
					<div class="row d-flex justify-content-center">
						<div class="col-md-8" id="topProductsChartContainer">
							<canvas id="topProductsChart"></canvas>
						</div>
					</div>
				</div>
			</div>

			<!-- TopSellers -->
			<div class="card bg-gradient-light">
				<div class="card-header border-0 ui-sortable-handle" style="cursor: move;">
					<h3 class="card-title">
						<i class="fas fa-users pr-2"></i>
						Top de vendedores
					</h3>

					<div class="card-tools">
						<button type="button" class="btn bg-light btn-sm" data-card-widget="collapse">
							<i class="fas fa-minus"></i>
						</button>
					</div>
				</div>
				<div class="card-body">
					<div class="d-flex justify-content-center ">
						<div class="col-md-5 text-center" id="ranking">

						</div>
					</div>
				</div>

			</div>



		</div>
</div>
</section>


</div>

<script src="public/views/Sales/report/report.js"></script>
<script src="public/js/zoom.js"></script>