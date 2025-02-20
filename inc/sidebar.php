<aside class="main-sidebar sidebar-dark-primary elevation-4">	
	<a href="dashboard.php" class="brand-link">
		<img src="assets/img/AdminLTELogo.png" alt="" class="brand-image img-circle elevation-3" style="opacity: .8">
		<span class="brand-text font-weight-light">Sistema Ingresos</span>
	</a>
	<div class="sidebar">
		<div class="user-panel mt-3 pb-3 mb-3 d-flex">
			<div class="image">
				<img src="assets/img/user2-160x160.jpg" class="img-circle elevation-2" alt="User Image">
			</div>
			<div class="info">
				<a href="#" class="d-block"><?php echo $_SESSION['user_nombre'].' '.$_SESSION['user_apellido']; ?></a>
			</div>
		</div>
		<nav class="mt-2">
			<ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
				<li class="nav-item">
					<a href="dashboard.php" class="nav-link <?php if(isset($active_dashboard)){echo $active_dashboard;}?>">
						<i class="nav-icon fa-solid fa-table-columns"></i>
						<p>Dashboard</p>
					</a>
				</li>
				<li class="nav-item">
					<a href="cobros-servicios.php" class="nav-link <?php if(isset($active_cobros)){echo $active_cobros;}?>">
						<i class="nav-icon fa-solid fa-cash-register"></i>
						<p>Cobro de Servicios</p>
					</a>
				</li>
				<li class="nav-item">
					<a href="conceptos.php" class="nav-link <?php if(isset($active_conceptos)){echo $active_conceptos;}?>">
						<i class="nav-icon fa-brands fa-product-hunt"></i>
						<p>Conceptos</p>
					</a>
				</li>
				<li class="nav-item">
					<a href="categorias.php" class="nav-link <?php if(isset($active_categorias)){echo $active_categorias;}?>">
						<i class="nav-icon fa-brands fa-product-hunt"></i>
						<p>Categorías</p>
					</a>
				</li>
				<li class="nav-item">
					<a href="contribuyentes.php" class="nav-link <?php if(isset($active_contribuyentes)){echo $active_contribuyentes;}?>">
						<i class="nav-icon fa-solid fa-users"></i>
						<p>Contribuyentes</p>
					</a>
				</li>
				<?php if($_SESSION['is_admin']==1) { ?>
				<li class="nav-item <?php if(isset($menu_configuracion)){echo $menu_configuracion;}?>">
					<a href="#" class="nav-link <?php if(isset($active_menu_configuracion)){echo $active_menu_configuracion;}?>">
						<i class="nav-icon fa-solid fa-gears"></i>
						<p>
							Configuración
							<i class="fa-solid fa-angle-left right"></i>
						</p>
					</a>
					<ul class="nav nav-treeview">
						<li class="nav-item">
							<a href="usuarios.php" class="nav-link <?php if(isset($active_usuarios)){echo $active_usuarios;}?>">
								<i class="fa-solid fa-users nav-icon"></i>
								<p>Usuarios</p>
							</a>
						</li>
						<li class="nav-item">
							<a href="configuracion.php" class="nav-link <?php if(isset($active_configuracion)){echo $active_configuracion;}?>">
								<i class="fa-solid fa-gears nav-icon"></i>
								<p>Configuración</p>
							</a>
						</li>
					</ul>
				</li>
				<?php } ?>
				<li class="nav-item">
					<a href="index-login.php?logout" class="nav-link">
						<i class="nav-icon fa-solid fa-power-off text-danger"></i>
						<p>Salir</p>
					</a>
				</li>
			</ul>
		</nav>
    </div>
</aside>