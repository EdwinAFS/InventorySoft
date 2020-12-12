<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
	<!-- Content Header (Page header) -->
	<section class="content-header">
		<div class="container-fluid">
			<div class="row mb-2">
				<div class="col-sm-6">
					<h1>Tablero</h1>
				</div>
				<div class="col-sm-6">
					<ol class="breadcrumb float-sm-right">
						<li class="breadcrumb-item"><a href="#">Inicio</a></li>
					</ol>
				</div>
			</div>
		</div><!-- /.container-fluid -->
	</section>

	<!-- Main content -->
	<section class="content">

		<!-- Default box -->
		<div class="card">
			
			<div class="card-body">
				<div class="row">
					<div class="col-lg-3 col-6">
						<!-- small box -->
						<div class="small-box bg-info">
							<div class="inner">
								<h3><?php echo $salesLastMonth?></h3>

								<p>Ventas del ultimo mes</p>
							</div>
							<div class="icon">
								<i class="ion ion-social-usd"></i>
							</div>
							<a href="sale" class="small-box-footer">Más información<i class="fas fa-arrow-circle-right"></i></a>
						</div>
					</div>
					<!-- ./col -->
					<div class="col-lg-3 col-6">
						<!-- small box -->
						<div class="small-box bg-success">
							<div class="inner">
								<h3><?php echo $categories?></h3>

								<p>Categorías</p>
							</div>
							<div class="icon">
								<i class="ion ion-clipboard"></i>
							</div>
							<a href="category" class="small-box-footer">Más información <i class="fas fa-arrow-circle-right"></i></a>
						</div>
					</div>
					<!-- ./col -->
					<div class="col-lg-3 col-6">
						<!-- small box -->
						<div class="small-box bg-warning ">
							<div class="inner text-white">
								<h3><?php echo $customers?></h3>

								<p>Clientes</p>
							</div>
							<div class="icon">
								<i class="ion ion-person-add"></i>
							</div>
							<a href="customer" class="small-box-footer"><span class="text-white">Más información</span> <i class="fas fa-arrow-circle-right text-white"></i></a>
						</div>
					</div>
					<!-- ./col -->
					<div class="col-lg-3 col-6">
						<!-- small box -->
						<div class="small-box bg-danger">
							<div class="inner">
								<h3><?php echo $products?></h3>

								<p>Productos</p>
							</div>
							<div class="icon">
								<i class="ion ion-ios-cart"></i>
							</div>
							<a href="product" class="small-box-footer">Más información <i class="fas fa-arrow-circle-right"></i></a>
						</div>
					</div>
					<!-- ./col -->
				</div>
			</div>
		</div>
	</section>
</div>