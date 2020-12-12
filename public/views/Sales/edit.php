<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
	<!-- Content Header (Page header) -->
	<section class="content-header">
		<div class="container-fluid">
			<div class="row mb-2">
				<div class="col-sm-6">
					<h1>Agregar Ventas</h1>
				</div>
				<div class="col-sm-6">
					<ol class="breadcrumb float-sm-right">
						<li class="breadcrumb-item"><a href="home">Inicio</a></li>
						<li class="breadcrumb-item active"><a href="sale">Ventas</a></li>
						<li class="breadcrumb-item active">Agregar Ventas</li>
					</ol>
				</div>
			</div>
		</div><!-- /.container-fluid -->
	</section>

	<!-- Main content -->
	<section class="content">

		<div class="card">

			<div class="card-body">
				<form method="PUT" role="form" enctype="multipart/form-data" id="FormEditCustomer">


					<input type="hidden" id="editId" name="editId">

					<label for="name">Nombre</label>
					<div class="input-group mb-3">
						<div class="input-group-prepend">
							<div class="input-group-text">
								<span class="fas fa-user-alt"></span>
							</div>
						</div>
						<input type="text" name="editName" id="editName" class="form-control" placeholder="Nombre" required>
					</div>

					<label for="identification">No. Identificación</label>
					<div class="input-group mb-3">
						<div class="input-group-prepend">
							<div class="input-group-text">
								<i class="far fa-id-card"></i>
							</div>
						</div>
						<input type="text" name="editIdentification" id="editIdentification" class="form-control" placeholder="No. Identificación" required>
					</div>

					<label for="email">Email</label>
					<div class="input-group mb-3">
						<div class="input-group-prepend">
							<div class="input-group-text">
								<i class="far fa-envelope"></i>
							</div>
						</div>
						<input type="email" name="editEmail" id="editEmail" class="form-control" placeholder="Email">
					</div>

					<label for="phone">Teléfono</label>
					<div class="input-group mb-3">
						<div class="input-group-prepend">
							<div class="input-group-text">
								<i class="fas fa-phone"></i>
							</div>
						</div>
						<input type="tel" name="editPhone" id="editPhone" class="form-control" placeholder="Teléfono" pattern="[0-9]{3}-[0-9]{2}-[0-9]{3}">
					</div>

					<label for="address">Dirección</label>
					<div class="input-group mb-3">
						<div class="input-group-prepend">
							<div class="input-group-text">
								<i class="fas fa-map-marker-alt"></i>
							</div>
						</div>
						<input type="text" name="editAddress" id="editAddress" class="form-control" placeholder="Dirección">
					</div>

					<label for="birthdate">Fecha de nacimiento</label>
					<div class="input-group mb-3">
						<div class="input-group-prepend">
							<div class="input-group-text">
								<i class="fas fa-calendar-day"></i>
							</div>
						</div>
						<input type="date" name="editBirthdate" id="editBirthdate" class="form-control" placeholder="Fecha de nacimiento">
					</div>


					<div class="modal-footer d-flex justify-content-center">
						<button type="button" class="btn btn-secondary" data-dismiss="modal"> Cerrar </button>
						<button type="button" class="btn btn-primary" id="btnEditCustomer"> Guardar </button>
					</div>

				</form>

			</div>

		</div>
	</section>
	<!-- /.content -->
</div>
<!-- /.content-wrapper -->