<style>
	.login-page {
		position: absolute !important;
		top: 0 !important;
		left: 0 !important;
		width: 100% !important;
		height: 100vh !important;
		background: url(public/img/fondo-login.jpg) !important;
		background-size: cover !important;
		overflow: hidden !important;
		z-index: 5 !important;
	}

	.login-page img::after {
		opacity: 0.5;
	}
</style>
<div class="login-page">

	<div class="login-box ">

		<div class="card">
			<div class="card-body login-card-body">
				<p class="login-box-msg h4">Ingresar al sistema</p>

				<form method="post">

					<div class="input-group mb-3">
						<input type="text" name="username" id="username" class="form-control" placeholder="Usuario" required>
						<div class="input-group-append">
							<div class="input-group-text">
								<span class="fas fa-user"></span>
							</div>
						</div>
					</div>

					<div class="input-group mb-3">
						<input type="password" name="password" id="password" class="form-control" placeholder="Contraseña" required>
						<div class="input-group-append">
							<div class="input-group-text">
								<span class="fas fa-lock"></span>
							</div>
						</div>
					</div>

					<div class="row d-flex justify-content-center pt-2">
						<div class="col-4">
							<button type="button" id="btnLogin" class="btn btn-primary btn-block">Ingresar</button>
						</div>
					</div>

					<!-- <div class="row d-flex justify-content-center pt-4">
						<div class="col-6">
							<a href="forgot-password.html">Olvide mi contraseña</a>
						</div>
					</div> -->
				</form>

			</div>
		</div>
	</div>

</div>

<script src="public/views/login/login.js"></script>