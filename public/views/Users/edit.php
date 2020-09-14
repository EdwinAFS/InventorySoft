<!-- Modal Editar Usuario -->

<!-- Modal -->
<div class="modal fade" id="EditUserModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered" role="document">
		<div class="modal-content ">

			<form method="PUT" role="form" enctype="multipart/form-data" id="FormEditUser">
				<div class="modal-header bg-primary">
					<h5 class="modal-title">Editar Usuario</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true" class="text-white">&times;</span>
					</button>
				</div>

				<div class="modal-body">

					<input type="hidden" id="editId" name="editId">

					<div class="form-group">
						<div class="input-group">
							<span class="input-group-text"><i class="fa fa-user"> </i></span>
							<input type="text" class="form-control input-lg" name="editName" id="editName" placeholder="Ingrese el nombre">
						</div>
					</div>

					<div class="form-group">
						<div class="input-group">
							<span class="input-group-text"><i class="fa fa-key"> </i></span>
							<input type="text" class="form-control input-lg" name="editUsername" id="editUsername" placeholder="Ingrese el usuario">
						</div>
					</div>

					<div class="form-group">
						<div class="input-group">
							<span class="input-group-text"><i class="fa fa-lock"> </i></span>
							<input type="password" class="form-control input-lg" name="editPassword" placeholder="Ingrese el contraseña" autocomplete="off">
						</div>
					</div>

					<div class="form-group">
						<div class="input-group">
							<span class="input-group-text"><i class="fa fa-users"> </i></span>
							<select class="form-control input-lg" name="editRol" id="editRol" placeholder="Ingrese el contraseña">
								<option value="administrador">Administrador</option>
								<option value="vendedor">vendedor</option>
							</select>
						</div>
					</div>

					<div class="custom-file">
						<input type="file" class="custom-file-input photo" name="editPhoto" id="editPhoto">
						<label class="custom-file-label" for="photo" data-browse="Elegir">Seleccionar Archivo</label>
					</div>
					
					<div class="form-group">
						<input type="hidden" name="photoUrl" id="photoUrl">
						<img id="avatar" name="avatar" src="" alt="Avatar" class="img-thumbnail" width="150px">
					</div>

				</div>

				<div class="modal-footer d-flex justify-content-center">
					<button type="button" class="btn btn-secondary" data-dismiss="modal"> Cerrar </button>
					<button type="button" class="btn btn-primary" id="btnEditUser"> Guardar </button>
				</div>

			</form>

		</div>
	</div>
</div>