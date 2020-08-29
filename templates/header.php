
<nav class="main-header navbar navbar-expand-lg navbar-dark bg-primary" >

	<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
		<span class="navbar-toggler-icon"></span>
	</button>

  	<div class="collapse navbar-collapse" id="navbarNav">
	
	  	<!-- Menu -->
		<ul class="navbar-nav">
			<li class="nav-item">
				<a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
			</li>
			<li class="nav-item active">
				<a class="nav-link" href="#">Home <span class="sr-only">(current)</span></a>
			</li>
			<li class="nav-item">
				<a class="nav-link" href="#">Features</a>
			</li>
			<li class="nav-item">
				<a class="nav-link" href="#">Pricing</a>
			</li>
			<li class="nav-item">
				<a class="nav-link disabled" href="#">Disabled</a>
			</li>
		</ul>

		<!-- Perfil -->
		<ul class="navbar-nav ml-auto">

			<li class="nav-item dropdown">
				
				<a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
					<i class="nav-icon far fa-user"></i>
					<span style="padding: 5px;"><?php echo $_SESSION["name"]; ?></span>
				</a>

				<div class="dropdown-menu" aria-labelledby="navbarDropdown">
					<a class="dropdown-item" href="#">Perfil</a>
					<a class="dropdown-item" href="#">Cambiar contraseña</a>
					<div class="dropdown-divider"></div>
					<a class="dropdown-item" href="logout">Cerrar sesión</a>
				</div>
			</li>

		</ul>
		
	</div>

</nav>

