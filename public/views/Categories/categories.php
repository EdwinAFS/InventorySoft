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
					<h1>Categorias</h1>
				</div>
				<div class="col-sm-6">
					<ol class="breadcrumb float-sm-right">
						<li class="breadcrumb-item"><a href="home">Inicio</a></li>
						<li class="breadcrumb-item active">Categorias</li>
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
				
				<?php

				echo in_array($_SESSION["rolCode"], ["Admin", "InventoryManager"]) ?
					'<button class="btn btn-primary" data-toggle="modal" data-target="#AddCategoryModal">
						Agregar Categoria
					</button>' : "";

				?>

			</div>

			<div class="card-body">
				<table class="table table-bordered table-striped dataTable dt-responsive w-100" id="categoryTable">
					<thead>
						<tr>
							<th>ID</th>
							<th>Descripcion</th>
							<th>Estado</th>
							<th>Acciones</th>
						</tr>
					</thead>
					
				</table>
			</div>

		</div>

	</section>
	<!-- /.content -->
</div>
<!-- /.content-wrapper -->

<script src="public/views/Categories/categories.js"></script>