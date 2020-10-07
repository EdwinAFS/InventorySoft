<div class="modal fade" id="EditProductModal" tabindex="-1" role="dialog" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered" role="document">
		<div class="modal-content ">

			<form method="PUT" role="form" enctype="multipart/form-data" id="FormEditProduct">
				<div class="modal-header bg-primary">
					<h5 class="modal-title">Editar Producto</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true" class="text-white">&times;</span>
					</button>
				</div>

				<div class="modal-body">

					<input type="hidden" id="editId" name="editId">

					<div class="form-group">
						<label for="editCod">Codigo</label>
						<input type="text" class="form-control input-lg" name="editCod" id="editCod" placeholder="Ingrese el codigo del producto">
					</div>

					<div class="form-group">
						<label for="editDescription">Producto</label>
						<input type="text" class="form-control input-lg" name="editDescription" id="editDescription" placeholder="Ingrese el nombre del producto">
					</div>

					<div class="row">
						<div class="col">
							<div class="form-group">
								<label for="editPurchasePrice">Compra</label>
								<input type="number" class="form-control input-lg" name="editPurchasePrice" id="editPurchasePrice" placeholder="Ingrese el precio de compra">
							</div>
						</div>
						<div class="col">
							<div class="form-group">
								<label for="editSalePrice">Venta</label>
								<input type="number" class="form-control input-lg" name="editSalePrice" id="editSalePrice" placeholder="Ingrese el precio de venta">
							</div>
						</div>
					</div>

					<div class="row justify-content-end">
						<div class="col-3">
							
							<div class="icheck-primary">
								<input type="checkbox" id="withPorcentage">
								<label for="withPorcentage">
									<small>Usar porcentaje</small>
								</label>
							</div>

						</div>
						<div class="col-3">
							<div class="form-group">
								<div class="input-group">
									<input type="number" class="form-control w-1" min="0" id="porcentage">
									<div class="input-group-append">
										<span class="input-group-text">%</span>
									</div>
								</div>
							</div>
						</div>
					</div>

					<div class="row">
						<div class="col">
							<div class="form-group">
								<label for="editStock">Stock</label>
								<input type="number" class="form-control input-lg" name="editStock" id="editStock" placeholder="Ingrese el stock">
							</div>
						</div>
						<div class="col">
							<div class="form-group">
								<label for="editCategory">Categoria</label>
								<select class="form-control input-lg" name="editCategory" id="editCategory" placeholder="Seleccione la categoria">
									<?php
									foreach ($categories as $category) {
										echo "<option value='{$category->getId()}'>{$category->getDescription()}</option>";
									}
									?>
								</select>
							</div>
						</div>
					</div>

					<div class="form-group">
						<label for="image">Imagen</label>
						<div class="custom-file">
							<input type="file" class="custom-file-input photo" name="editImage" id="editImage">
							<label class="custom-file-label" for="image" data-browse="Elegir">Seleccionar Archivo</label>
						</div>
					</div>

					<div class="form-group">
						<input type="hidden" name="imageUrl" id="imageUrl">
						<img id="image" name="image" src="" alt="image" class="img-thumbnail" width="150px">
					</div>

				</div>

				<div class="modal-footer d-flex justify-content-center">
					<button type="button" class="btn btn-secondary" data-dismiss="modal"> Cerrar </button>
					<button type="button" class="btn btn-primary" id="btnEditProduct"> Guardar </button>
				</div>

			</form>

		</div>
	</div>
</div>