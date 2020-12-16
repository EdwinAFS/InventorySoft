<div class="content-wrapper">
	<section class="content-header">
		<div class="container-fluid">
			<div class="row mb-2">
				<div class="col-sm-6">
					<h1>Cambiar contraseña</h1>
				</div>
				<div class="col-sm-6">
					<ol class="breadcrumb float-sm-right">
						<li class="breadcrumb-item"><a href="home">Inicio</a></li>
						<li class="breadcrumb-item active">Cambiar contraseña</li>
					</ol>
				</div>
			</div>
		</div>
	</section>

	<section class="content">

		<div class="card">

			<div class="card-body  d-flex align-items-center flex-column">

				<form method="POST" role="form" enctype="multipart/form-data" id="FormChangePassword" class="col-md-5">

					<input type="hidden" id="username" name="username" value="<?php echo $_SESSION['username'] ?>">

					<div class="form-group">
						<div class="input-group">
							<span class="input-group-text"><i class="fa fa-lock"> </i></span>
							<input type="password" class="form-control input-lg" name="password" placeholder="contraseña actual" autocomplete="off">
						</div>
					</div>

					<div class="form-group">
						<div class="input-group">
							<span class="input-group-text"><i class="fa fa-lock"> </i></span>
							<input type="password" class="form-control input-lg" name="newPassword" onkeyup='check();' placeholder="Ingrese nueva contraseña" autocomplete="off">
						</div>
					</div>

					<div class="form-group ">
						<div class="input-group">
							<span class="input-group-text"><i class="fa fa-lock"> </i></span>
							<input type="password" class="form-control input-lg" name="confirmPassword" onkeyup='check();' placeholder="Confirme la contraseña" autocomplete="off">
						</div>
						<span class="help-block text-danger" id="passwordError">las contraseña no coincide</span>

					</div>


					<div class="p-3 d-flex justify-content-center">
						<button type="button" id="btnChangePassword" class="btn btn-primary"> Cambiar contraseña </button>
					</div>

				</form>
			</div>

		</div>

	</section>
</div>

<script src="public/views/profile/changePassword.js"></script>