<div class="wrapper">
	<!-- Navbar -->
	<nav class="main-header navbar navbar-expand navbar-white navbar-light">
		<!-- Left navbar links -->
		<ul class="navbar-nav">
			<li class="nav-item">
				<a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
			</li>
		</ul>

		<!-- Right navbar links -->
		<ul class="navbar-nav ml-auto">
			<li class="nav-item">
				<div class="dropdown">
					<a class="nav-link dropdown-toggle" href="#" id="dropdownMenuButton" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
						<i class="nav-icon far fa-user"></i>
						<span style="padding: 5px;"><?php echo $_SESSION["name"]; ?></span>
					</a>

					<div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
						<a class="dropdown-item" href="profile">Perfil</a>
						<a class="dropdown-item" href="profile/changePassword">Cambiar contraseña</a>
						<div class="dropdown-divider"></div>
						<a class="dropdown-item" id="logout">Cerrar sesión</a>
					</div>
				</div>
			</li>

		</ul>
	</nav>
	<!-- /.navbar -->
</div>