<!-- Modal Editar Usuario -->

<!-- Modal -->
<div class="modal fade" id="EditCategoryModal" tabindex="-1" role="dialog" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered" role="document">
		<div class="modal-content ">

			<form method="PUT" role="form" enctype="multipart/form-data" id="FormEditCategory">
				<div class="modal-header bg-primary">
					<h5 class="modal-title">Editar Categoria</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true" class="text-white">&times;</span>
					</button>
				</div>

				<div class="modal-body">

					<input type="hidden" id="editId" name="editId">

					<div class="form-group">
						<div class="input-group">
							<span class="input-group-text"><i class="fa fa-list-alt"> </i></span>
							<input type="text" class="form-control input-lg" name="editDescription" id="editDescription" placeholder="Ingrese la descripcion">
						</div>
					</div>

				</div>

				<div class="modal-footer d-flex justify-content-center">
					<button type="button" class="btn btn-secondary" data-dismiss="modal"> Cerrar </button>
					<button type="button" class="btn btn-primary" id="btnEditCategory"> Guardar </button>
				</div>

			</form>

		</div>
	</div>
</div>