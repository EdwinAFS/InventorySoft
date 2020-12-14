<?php
include "add.php";
include "edit.php";

?>



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
						<li class="breadcrumb-item"><a href="home">Inicio</a></li>
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
				<?php

				echo in_array($_SESSION["rolCode"], ["Admin", "Seller"]) ?
					'<button class="btn btn-primary" data-toggle="modal" data-target="#AddUserModal">
						Agregar Usuario
					</button>' : "";

				?>

			</div>

			<div class="card-body">
				<table class="table table-bordered table-striped dataTable dt-responsive w-100">
					<thead>
						<tr>
							<th>ID</th>
							<th>Nombre</th>
							<th>Usuario</th>
							<th>Rol</th>
							<th>Estado</th>
							<th>Ultimo login</th>
							<th>Acciones</th>
						</tr>
					</thead>
					<tbody>
						<?php
						foreach ($users as $user) {
							echo "
								<tr>
									<td>{$user->getId()}</td>
									<td>{$user->getName()}</td>
									<td>{$user->getUsername()}</td>
									<td>{$user->getRol()->getDescription()}</td>
								";

							echo ($user->getActive()) ?
								"<td class='cell'><button class='btn btn-success btn-xs btn-Active' userId='{$user->getId()}'>Activo</button></td>" :
								"<td class='cell'><button class='btn btn-danger btn-xs btn-Active' userId='{$user->getId()}'>Inactivo</button></td>";

							echo "	<td>{$user->getLastLogin()}</td>
									<td class='cell'>
										<div class='btn-group'>
											" . ((in_array($_SESSION["rolCode"], ["Admin", "Seller"])) ? "<button class='btn btn-warning text-white m-0 btn-UserEdit' userId='{$user->getId()}' data-toggle='modal' data-target='#EditUserModal'>
													<i class='fas fa-pencil-alt'></i>
												</button>" : "") . "
											" . (($_SESSION["rolCode"] == "Admin") ? "<button class='btn btn-danger text-white m-0 btn-DeleteUser' userId='{$user->getId()}'>
													<i class='fas fa-times'></i>
												</button>" : "") . "
										</div>
									</td>
								</tr>
								";
						}

						?>

					</tbody>
				</table>
			</div>


		</div>

	</section>
	<!-- /.content -->
</div>
<!-- /.content-wrapper -->

<script src="public/views/users/users.js"></script>