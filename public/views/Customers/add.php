<!-- Modal Agregar Cliente -->
<div class="modal fade" id="AddCustomerModal" tabindex="-1" role="dialog" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered" role="document">
		<div class="modal-content ">

			<form method="POST" role="form" enctype="multipart/form-data" id="FormAddCustomer">
				<div class="modal-header bg-primary">
					<h5 class="modal-title">Agregar Cliente</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true" class="text-white">&times;</span>
					</button>
				</div>

				<div class="modal-body">

					<label for="name">Nombre</label>
					<div class="input-group mb-3">
						<div class="input-group-prepend">
							<div class="input-group-text">
								<span class="fas fa-user-alt"></span>
							</div>
						</div>
						<input type="text" name="name" id="name" class="form-control" placeholder="Nombre" required>
					</div>

					<label for="identification">No. Identificación</label>
					<div class="input-group mb-3">
						<div class="input-group-prepend">
							<div class="input-group-text">
								<i class="far fa-id-card"></i>
							</div>
						</div>
						<input type="text" name="identification" id="identification" class="form-control" placeholder="No. Identificación" required>
					</div>

					<label for="email">Email</label>
					<div class="input-group mb-3">
						<div class="input-group-prepend">
							<div class="input-group-text">
								<i class="far fa-envelope"></i>
							</div>
						</div>
						<input type="email" name="email" id="email" class="form-control" placeholder="Email">
					</div>

					<label for="phone">Teléfono</label>
					<div class="input-group mb-3">
						<div class="input-group-prepend">
							<div class="input-group-text">
								<i class="fas fa-phone"></i>
							</div>
						</div>
						<input type="tel" name="phone" id="phone" class="form-control" placeholder="Teléfono" pattern="[0-9]{3}-[0-9]{2}-[0-9]{3}">
					</div>

					<label for="address">Dirección</label>
					<div class="input-group mb-3">
						<div class="input-group-prepend">
							<div class="input-group-text">
								<i class="fas fa-map-marker-alt"></i>
							</div>
						</div>
						<input type="text" name="address" id="address" class="form-control" placeholder="Dirección">
					</div>

					<label for="birthdate">Fecha de nacimiento</label>
					<div class="input-group mb-3">
						<div class="input-group-prepend">
							<div class="input-group-text">
								<i class="fas fa-calendar-day"></i>
							</div>
						</div>
						<input type="date" name="birthdate" id="birthdate" class="form-control" placeholder="Fecha de nacimiento">
					</div>

				</div>

				<div class="modal-footer d-flex justify-content-center">
					<button type="button" class="btn btn-secondary" data-dismiss="modal"> Cerrar </button>
					<button type="button" id="btnAddCustomer" class="btn btn-primary"> Guardar </button>
				</div>

			</form>

		</div>

	</div>
</div>