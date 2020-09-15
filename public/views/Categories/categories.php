<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
	<!-- Content Header (Page header) -->
	<section class="content-header">
		<div class="container-fluid">
			<div class="row mb-2">
				<div class="col-sm-6">
					<h1>Usuarios</h1>
				</div>
				<div class="col-sm-6">
					<ol class="breadcrumb float-sm-right">
						<li class="breadcrumb-item"><a href="main">Inicio</a></li>
						<li class="breadcrumb-item active">Usuarios</li>
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
				<button class="btn btn-primary" data-toggle="modal" data-target="#AddUserModal">
					Agregar Usuario
				</button>
			</div>

			<div class="card-body">
				<table class="table table-bordered table-striped dataTable dt-responsive w-100">
					<thead>
						<tr>
							<th>ID</th>
							<th>Descripcion</th>
							<th>Estado</th>
							<th>Acciones</th>
						</tr>
					</thead>
					<tbody>
						<?php
						foreach ($categories as $category) {
							echo "
								<tr>
									<td>{$category->getId()}</td>
									<td>{$category->getDescription()}</td>
								";

							echo ($category->getActive()) ?
									"<td><button class='btn btn-success btn-xs btn-Active' userId='{$category->getId()}'>Activo</button></td>" :
									"<td><button class='btn btn-danger btn-xs btn-Active' userId='{$category->getId()}'>Inactivo</button></td>";

							echo "
									<td>
										<div class='btn-group'>
											<button class='btn btn-warning text-white m-0 btn-UserEdit' userId='{$category->getId()}' data-toggle='modal' data-target='#EditUserModal'>
												<i class='fas fa-pencil-alt'></i>
											</button>
											<button class='btn btn-danger text-white m-0 btn-DeleteUser' userId='{$category->getId()}'>
												<i class='fas fa-times'></i>
											</button>
										</div>
									</td>
								</tr>
								";
						}

						?>

					</tbody>
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