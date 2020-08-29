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
							<th>Nombre</th>
							<th>Usuario</th>
							<th>Estado</th>
							<th>Ultimo login</th>
							<th>Acciones</th>
						</tr>
					</thead>
					<tbody>
						<tr>
							<td>1 </td>
							<td>Edwin </td>
							<td>Edwin</td>
							<td>
								<button class="btn btn-success btn-xs">Activo</button>
							</td>
							<td>2020-08-26 09:47</td>
							<td>
								<div class="btn-group">
									<button class="btn btn-warning text-white">
										<i class="fas fa-pencil-alt"></i>
									</button>
									<button class="btn btn-danger text-white">
										<i class="fas fa-times"></i>
									</button>
								</div>
							</td>
						</tr>
						<tr>
							<td>2</td>
							<td>Jairo</td>
							<td>Jairo</td>
							<td>
								<button class="btn btn-danger btn-xs">Inactivo</button>
							</td>
							<td>2020-08-26 09:47</td>
							<td>
								<div class="btn-group">
									<button class="btn btn-warning text-white">
										<i class="fas fa-pencil-alt"></i>
									</button>
									<button class="btn btn-danger text-white">
										<i class="fas fa-times"></i>
									</button>
								</div>
							</td>
						</tr>


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

<!-- Modal Agregar Usuario -->

<!-- Modal -->
<div class="modal fade" id="AddUserModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered" role="document">
		<div class="modal-content ">

			<form method="POST" role="form" enctype="multipart/form-data">
				<div class="modal-header bg-primary">
					<h5 class="modal-title">Agregar Usuario</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true" class="text-white">&times;</span>
					</button>
				</div>

				<div class="modal-body">

					<div class="form-group">
						<div class="input-group">
							<span class="input-group-text"><i class="fa fa-user"> </i></span>
							<input type="text" class="form-control input-lg" name="name" placeholder="Ingrese el nombre">
						</div>
					</div>

					<div class="form-group">
						<div class="input-group">
							<span class="input-group-text"><i class="fa fa-key"> </i></span>
							<input type="text" class="form-control input-lg" name="username" placeholder="Ingrese el usuario">
						</div>
					</div>


					<div class="form-group">
						<div class="input-group">
							<span class="input-group-text"><i class="fa fa-lock"> </i></span>
							<input type="password" class="form-control input-lg" name="password" placeholder="Ingrese el contraseña" autocomplete="off">
						</div>
					</div>

					<div class="form-group">
						<div class="input-group">
							<span class="input-group-text"><i class="fa fa-users"> </i></span>
							<select class="form-control input-lg" name="rol" placeholder="Ingrese el contraseña">
								<option value="administrador">Administrador</option>
								<option value="vendedor">vendedor</option>
							</select>
						</div>
					</div>

					<div class="custom-file">
						<input type="file" class="custom-file-input" id="foto">
						<label class="custom-file-label" for="foto" data-browse="Elegir">Seleccionar Archivo</label>
					</div>

				</div>

				<div class="modal-footer">
					<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
					<button type="button" class="btn btn-primary">Save changes</button>
				</div>

			</form>

		</div>
	</div>
</div>