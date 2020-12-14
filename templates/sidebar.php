

 <!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary">

	<!-- Logo -->
	<a href="#" class="brand-link">
		<img 
			src="public/img/logo.png"
        	alt="Inventario logo"
			class="brand-image img-circle elevation-3"
		>
      	<span class="brand-text font-weight-light">Inventario</span>
	</a>

	<!-- Sidebar -->
	<div class="sidebar">
		<nav class="mt-2">
			<ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
					
				<li class="nav-item">
					<a href="Home" class="nav-link">
						<i class="nav-icon fas fa-home"></i>
						<p> Inicio </p>
					</a>
				</li>
				<li class="nav-item">
					<a href="user" class="nav-link">
						<i class="nav-icon far fa-user"></i>
						<p> Usuarios </p>
					</a>
				</li>
				<li class="nav-item">
					<a href="category" class="nav-link">
						<i class="nav-icon fas fa-th"></i>
						<p> Categorias </p>
					</a>
				</li>
				<li class="nav-item">
					<a href="product" class="nav-link">
						<i class="nav-icon fab fa-product-hunt"></i>
						<p> Productos </p>
					</a>
				</li>
				<li class="nav-item">
					<a href="customer" class="nav-link">
						<i class="nav-icon fas fa-users"></i>
						<p> Clientes </p>
					</a>
				</li>

				<li class="nav-item has-treeview">
					<a href="sale" class="nav-link">
						<i class="nav-icon fa fa-list-ul"></i>
						<p> Ventas <i class="right fas fa-angle-left"></i> </p>
					</a>
					<ul class="nav nav-treeview">
						<li class="nav-item">
							<a href="sale" class="nav-link">
							<i class="far fa-circle nav-icon"></i>
							<p>Ventas</p>
							</a>
						</li>
						<?php
						echo ( $_SESSION["rolCode"] == 'Admin')? '<li class="nav-item">
										<a href="sale/report" class="nav-link">
										<i class="far fa-circle nav-icon"></i>
										<p>Reporte</p>
										</a>
									</li>': '';
						?>
					</ul>
				</li>
				
			</ul>
		</nav>
	</div>

	
</aside>