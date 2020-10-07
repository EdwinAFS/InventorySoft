<!-- Modal Agregar Producto -->
<div class="modal fade" id="AddProductModal" tabindex="-1" role="dialog" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered" role="document">
		<div class="modal-content ">

			<form method="POST" role="form" enctype="multipart/form-data" id="FormAddProduct">
				<div class="modal-header bg-primary">
					<h5 class="modal-title">Agregar Producto</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true" class="text-white">&times;</span>
					</button>
				</div>

				<div class="modal-body">

					<div class="form-group">
						<label for="cod">Codigo</label>
						<input type="text" class="form-control input-lg" name="cod" placeholder="Ingrese el codigo del producto">
					</div>

					<div class="form-group">
						<label for="description">Producto</label>
						<input type="text" class="form-control input-lg" name="description" placeholder="Ingrese el nombre del producto">
					</div>

					<div class="row">
						<div class="col">
							<div class="form-group">
								<label for="purchasePrice">Compra</label>
								<input type="number" class="form-control input-lg" name="purchasePrice" id="purchasePrice" placeholder="Ingrese el precio de compra">
							</div>
						</div>
						<div class="col">
							<div class="form-group">
								<label for="salePrice">Venta</label>
								<input type="number" class="form-control input-lg" name="salePrice" id="salePrice" placeholder="Ingrese el precio de venta">
							</div>
						</div>
					</div>

					<div class="row justify-content-end">
						<div class="col-3">
							<div class="icheck-primary">
								<input type="checkbox" id="withPorcentageAdd">
								<label for="withPorcentageAdd">
									<small>Usar porcentaje</small>
								</label>
							</div>

						</div>
						<div class="col-3">
							<div class="form-group">
								<div class="input-group">
									<input type="number" class="form-control w-1" min="0" id="porcentageAdd">
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
								<label for="stock">Stock</label>
								<input type="number" class="form-control input-lg" name="stock" placeholder="Ingrese el stock">
							</div>
						</div>
						<div class="col">
							<div class="form-group">
								<label for="category">Categoria</label>
								<select class="form-control input-lg" name="category" placeholder="Seleccione la categoria">
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

						<label for="image">Imagen del producto</label>
						<div class="custom-file">
							<input type="file" class="custom-file-input photo" name="image" id="AddImage">
							<label class="custom-file-label" for="image" data-browse="Elegir">Seleccionar Archivo</label>
						</div>
					</div>

				</div>

				<div class="modal-footer d-flex justify-content-center">
					<button type="button" class="btn btn-secondary" data-dismiss="modal"> Cerrar </button>
					<button type="button" id="btnAddProduct" class="btn btn-primary"> Guardar </button>
				</div>

			</form>

		</div>

	</div>
</div>