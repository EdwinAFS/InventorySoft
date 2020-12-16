<div class="content-wrapper">
	<section class="content-header">
		<div class="container-fluid">
			<div class="row mb-2">
				<div class="col-sm-6">
					<h1>Perfil</h1>
				</div>
				<div class="col-sm-6">
					<ol class="breadcrumb float-sm-right">
						<li class="breadcrumb-item"><a href="home">Inicio</a></li>
						<li class="breadcrumb-item active">Perfil</li>
					</ol>
				</div>
			</div>
		</div>
	</section>

	<section class="content">

		<div class="card">

			<div class="card-body  d-flex align-items-center flex-column">



				<img src="<?php echo $data->getPhoto()?: 'public/img/profile.png' ?>" class="figure-img img-fluid rounded border" width="200">

				<form method="POST" role="form" enctype="multipart/form-data" id="FormEditUser" class="col-md-5">

					<input type="hidden" id="editId" name="editId" value="<?php echo $data->getId() ?>">

					<div class="form-group">
						<div class="input-group">
							<span class="input-group-text"><i class="fa fa-user"> </i></span>
							<input type="text" class="form-control input-lg" name="editName" value="<?php echo $data->getName() ?>" placeholder="Ingrese el nombre">
						</div>
					</div>

					<div class="form-group">
						<div class="input-group">
							<span class="input-group-text"><i class="fa fa-key"> </i></span>
							<input type="text" class="form-control input-lg" name="editUsername" value="<?php echo $data->getUsername() ?>" placeholder="Ingrese el usuario" autocomplete="off">
						</div>
					</div>

					<div class="form-group">
						<div class="input-group">
							<span class="input-group-text"><i class="fa fa-users"> </i></span>
							<input type="text" class="form-control input-lg" name="rol" id="rol" value="<?php echo $data->getRol()->getDescription() ?>" disabled>
						</div>
					</div>

					<div class="custom-file">
						<input type="file" class="custom-file-input photo" name="editPhoto" id="editPhoto">
						<label class="custom-file-label" for="photo" data-browse="Elegir">Seleccionar Archivo</label>
					</div>

					<input type="hidden" name="photoUrl" id="photoUrl" value="<?php echo $data->getPhoto()?>">

					<div class="p-3 d-flex justify-content-center">
						<button type="button" id="btnEditUser" class="btn btn-primary"> Guardar </button>
					</div>

				</form>
			</div>

		</div>

	</section>
</div>

<script src="public/views/profile/profile.js"></script>