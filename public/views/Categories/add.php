<!-- Modal Agregar Usuario -->
<div class="modal fade" id="AddCategoryModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered" role="document">
		<div class="modal-content ">

			<form method="POST" role="form" enctype="multipart/form-data" id="FormAddCategory">
				<div class="modal-header bg-primary">
					<h5 class="modal-title">Agregar Categoria</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true" class="text-white">&times;</span>
					</button>
				</div>

				<div class="modal-body">

					<div class="form-group">
						<div class="input-group">
							<span class="input-group-text"><i class="fa fa-list-alt"> </i></span>
							<input type="text" class="form-control input-lg" name="description" placeholder="Ingrese la descripcion" autocomplete="off">
						</div>
					</div>

				</div>

				<div class="modal-footer d-flex justify-content-center">
					<button type="button" class="btn btn-secondary" data-dismiss="modal"> Cerrar </button>
					<button type="button" id="btnAddCategory" class="btn btn-primary"> Guardar </button>
				</div>

			</form>

		</div>
	</div>
</div>