<!-- Modal Agregar Usuario -->
<div class="modal fade" id="AddUserModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered" role="document">
		<div class="modal-content ">

			<form method="POST" role="form" enctype="multipart/form-data" id="FormAddUser">
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
						<input type="file" class="custom-file-input photo" name="photo" id="photo">
						<label class="custom-file-label" for="photo" data-browse="Elegir">Seleccionar Archivo</label>
					</div>

				</div>

				<div class="modal-footer d-flex justify-content-center">
					<button type="button" class="btn btn-secondary" data-dismiss="modal"> Cerrar </button>
					<button type="button" id="btnAddUser" class="btn btn-primary"> Guardar </button>
				</div>

			</form>

		</div>
	</div>
</div>