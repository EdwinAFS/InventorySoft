<link rel="stylesheet" href="public/css/zoom.css">

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

			<div class="card-body d-flex">

				<!-- FORMULARIO DE VENTA -->
				<div class="col-lg-5 col-sm-12">
					<div class="box box-success">

						<div class="box-header with-border"></div>

						<div class="box-body">


							<form role="form" method="post" id="saleForm">

								<div class="box">

									<!-- VENDEDOR -->
									<div class="input-group mb-3">
										<div class="input-group-prepend">
											<div class="input-group-text">
												<span class="fas fa-user-alt"></span>
											</div>
										</div>
										<input type="text" class="form-control" value="<?php echo $_SESSION["name"]; ?>" readonly />
										<input type="hidden" name="sallerId" id="sellerId" value="<?php echo $_SESSION["id"]; ?>" />
									</div>

									<!-- CODIGO DE FACTURA -->
									<div class="input-group mb-3">
										<div class="input-group-prepend">
											<div class="input-group-text">
												<span class="fas fa-user-alt"></span>
											</div>
										</div>
										<input type="text" class="form-control" id="invoiceCode" name="invoiceCode" value=<?php echo $invoiceCode ?> readonly>
									</div>



									<!-- CLIENTE   -->
									<div class="input-group mb-3">
										<div class="input-group-prepend">
											<div class="input-group-text">
												<span class="fa fa-key"></span>
											</div>
										</div>
										<select class="form-control input-lg" name="customer" id="customer" placeholder="Seleccione la cliente">
											<?php
											foreach ($customers as $customer) {
												echo "<option value='{$customer->getId()}'>{$customer->getName()}</option>";
											}
											?>
											
										</select>
									</div>


									<!-- ENTRADA PARA AGREGAR PRODUCTO -->
									<div class="form-group row nuevoProducto">

									</div>

									<div class="form-group d-block d-sm-none d-none d-sm-block d-md-none d-none d-md-block d-lg-none" id="AddProductContainer">
										<button type="button" class="btn btn-default" id="AddProduct" data-toggle="modal" data-target="#ContainerProductsModal">Agregar producto</button>
									</div>


									<hr>

									<!-- ENTRADA IMPUESTOS Y TOTAL -->
									<div class="row justify-content-end">
										<div class="col-sm-8 ">

											<table class="table">
												<thead>
													<tr>
														<th>Impuesto</th>
														<th>Total</th>
													</tr>
												</thead>

												<tbody>
													<tr>
														<td>
															<div class="input-group mb-3">
																<div class="input-group-prepend">
																	<div class="input-group-text">
																		<span class="fa fa-percent"></span>
																	</div>
																</div>
																<input type="number" class="form-control input-lg" min="0" id="impuestoVenta" name="impuestoVenta" placeholder="0" required>
																<input type="hidden" name="nuevoPrecioImpuesto" id="nuevoPrecioImpuesto" required>
																<input type="hidden" name="nuevoPrecioNeto" id="nuevoPrecioNeto" required>
															</div>
														</td>

														<td>
															<div class="input-group mb-3">
																<div class="input-group-prepend">
																	<div class="input-group-text">
																		<span class="ion ion-social-usd"></span>
																	</div>
																</div>
																<input type="text" class="form-control input-lg price" id="netPay" name="netPay" total="" placeholder="0" readonly required>
																<input type="hidden" id="total" name="total">
															</div>
														</td>

													</tr>
												</tbody>
											</table>

										</div>
									</div>


									<!-- ENTRADA MÉTODO DE PAGO -->
									<div class="form-group row">

										<div class="input-group col-sm-4 m-0">
											<div class="input-group">
												<div class="input-group-prepend">
													<div class="input-group-text">
														<i class="fas fa-pager"></i>
													</div>
												</div>
												<select class="form-control" id="paymentMethodId" name="paymentMethodId" required>
													<option value="" disabled="disabled" selected>Seleccione...</option>
													<?php
														foreach ($paymentMethods as $paymentMethod) {
															echo "<option value='{$paymentMethod->getId()}'>{$paymentMethod->getDescription()}</option>";
														}
													?>
												</select>
											</div>
										</div>

										<div class="input-group col-sm-8 m-0" id="paymentMethod"></div>
									</div>

									<hr />

									<div class="form-group text-center">
										<button type="button" class="btn btn-primary" id="saveSale"> Guardar </button>
									</div>

								</div>

							</form>


						</div>

					</div>
				</div>

				<!-- LA TABLA DE PRODUCTOS -->
				<div class="col-lg-7 d-none d-lg-block d-xl-none  d-none d-xl-block" id="containerProducts">

					<div class="box box-warning" id="tableProducts">
						<div class="box-header with-border"></div>
						<div class="box-body table-responsive" id="divForSales">
							<div id="tableContainerProducts">
								<table id="productTable" class="table table-bordered table-striped w-100 table-hover">
									<thead>
										<tr>
											<th style="width: 10px">#</th>
											<th>Producto</th>
											<th>Código</th>
											<th>Imagen</th>
											<th>Descripcion</th>
											<th>Stock</th>
											<th>Acciones</th>
										</tr>
									</thead>
								</table>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>
	<!-- /.content -->
</div>
<!-- /.content-wrapper -->


<!-- Modal para listar productos -->
<div class="modal fade  bs-example-modal-lg" id="ContainerProductsModal" tabindex="-1" role="dialog" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered modal-lg" role="document">
		<div class="modal-content ">

			<div class="modal-header bg-primary">
				<h5 class="modal-title">Lista de Producto</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true" class="text-white">&times;</span>
				</button>
			</div>

			<div class="modal-body" id="modalBodyForSales" style="overflow: auto">


			</div>

			<div class="modal-footer d-flex justify-content-center">
				<button type="button" class="btn btn-secondary" data-dismiss="modal"> Cerrar </button>
				<button type="button" id="btnAddProduct" class="btn btn-primary"> Guardar </button>
			</div>

		</div>

	</div>
</div>


<script src="public/views/Sales/add.js"></script>
<script src="public/js/zoom.js"></script>