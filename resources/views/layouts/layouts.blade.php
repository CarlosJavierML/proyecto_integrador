<!DOCTYPE html>
<html lang="en" class="light-style layout-menu-fixed" dir="ltr" data-theme="theme-default" data-assets-path="../assets/" data-template="vertical-menu-template-free">

<head>
	<meta charset="utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />

	<title>GAMA TORRES</title>

	<meta name="description" content="" />
	<meta name="csrf-token" content="{{ csrf_token() }}">

	<!-- Favicons -->
	<link href="assets/img/edificio.png" rel="icon">
	<link href="assets/img/edificio.png" rel="apple-touch-icon">

	<!-- Fonts -->
	<link rel="preconnect" href="https://fonts.googleapis.com" />
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
	<link href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap" rel="stylesheet" />

	<!-- Icons. Uncomment required icon fonts -->
	<link rel="stylesheet" href="../assets/vendor/fonts/boxicons.css" />

	<!-- Core CSS -->
	<link rel="stylesheet" href="../assets/vendor/css/core.css" class="template-customizer-core-css" />
	<link rel="stylesheet" href="../assets/vendor/css/theme-default.css" class="template-customizer-theme-css" />
	<link rel="stylesheet" href="../assets/css/demo.css" />

	<!-- Vendors CSS -->
	<link rel="stylesheet" href="../assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css" />

	<link rel="stylesheet" href="../assets/vendor/libs/apex-charts/apex-charts.css" />

	<!-- Page CSS -->

	<!-- Helpers -->
	<script src="../assets/vendor/js/helpers.js"></script>
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.css">

	<!--! Template customizer & Theme config files MUST be included after core stylesheets and helpers.js in the <head> section -->
	<!--? Config:  Mandatory theme config file contain global vars & default theme options, Set your preferred theme option in this file.  -->
	<script src="../assets/js/config.js"></script>
	
	@yield('content-css')
	
</head>

<body>

	@auth
	<!-- Layout wrapper -->
	<div class="layout-wrapper layout-content-navbar">
		<div class="layout-container">
			<!-- Menu -->

			<aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
				<div class="app-brand demo" style="height: 85px; margin-top: 12px;">
					<a href="index.html" class="app-brand-link">
						<span class="app-brand-logo demo">
							<img src="assets/img/Logo.png" style="width:30%; padding-top: 7px; margin-left: 45px; margin-top: 5px;">
						</span>
					</a>
					<a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto d-block d-xl-none">
						<i class="bx bx-chevron-left bx-sm align-middle"></i>
					</a>
				</div>

				<div class="menu-inner-shadow"></div>

				<ul class="menu-inner py-1">
					<!-- Dashboard -->
					<!-- <li class="menu-item active"> -->
					@if (Session::get('roleuser') == 1 || Session::get('roleuser') ==  2 || Session::get('roleuser') == 3)

					<li class="menu-item">
						<a href="/home" class="menu-link">
							<i class='bx bx-home-smile'></i>
							<div data-i18n="Analytics"> Home</div>
						</a>
					</li>

					<li class="menu-item">
						<a href="/usuarios" class="menu-link">
							<i class='bx bxs-user-circle'></i>
							<div data-i18n="Analytics"> Usuarios</div>
						</a>
					</li>
					<li class="menu-item">
						<a href="/visitantes" class="menu-link">
							<i class='bx bxs-contact'></i>
							<div data-i18n="Analytics"> Visitantes</div>
						</a>
					</li>
					<li class="menu-item">
						<a href="/apartamentos" class="menu-link">
							<i class="nu-icomen tf-icons bx bxs-building-house"></i>
							<div data-i18n="Analytics"> Apartamentos</div>
						</a>
					</li>
					<li class="menu-item">
						<a href="/vehiculos" class="menu-link">
							<i class='bx bxs-car'></i>
							<div data-i18n="Analytics"> Vehiculos</div>
						</a>
					</li>
					<li class="menu-item">
						<a href="/clubs" class="menu-link">
							<i class='bx bxs-message-rounded-dots'></i>
							<div data-i18n="Analytics"> Club House</div>
						</a>
					</li>
					<li class="menu-header small text-uppercase">
						<span class="menu-header-text">Reportes</span>
					</li>
					<li class="menu-item">
						<a href="javascript:void(0);" class="menu-link menu-toggle">
							<i class="menu-icon tf-icons bx bx-dock-top"></i>
							<div data-i18n="Account Settings">Administrativos</div>
						</a>
						<ul class="menu-sub">
							<li class="menu-item">
								<a href="pages-account-settings-account.html" class="menu-link">
									<div data-i18n="Account">Apartamentos</div>
								</a>
							</li>
							<li class="menu-item">
								<a href="pages-account-settings-notifications.html" class="menu-link">
									<div data-i18n="Notifications">Vehículos</div>
								</a>
							</li>
							<li class="menu-item">
								<a href="pages-account-settings-connections.html" class="menu-link">
									<div data-i18n="Connections">Visitantes</div>
								</a>
							</li>
						</ul>
					</li>
					@elseif(Session::get('roleuser') == 4)
					<li class="menu-item">
						<a href="/home" class="menu-link">
							<i class='bx bx-home-smile'></i>
							<div data-i18n="Analytics"> Home</div>
						</a>
					</li>
					<li class="menu-item">
						<a href="/clubs" class="menu-link">
							<i class='bx bxs-message-rounded-dots'></i>
							<div data-i18n="Analytics"> Club House</div>
						</a>
					</li>
					@endif
				</ul>
			</aside>
			<!-- / Menu -->

			<!-- Layout container -->
			<div class="layout-page">
				<!-- Navbar -->

				<nav class="layout-navbar container-xxl navbar navbar-expand-xl navbar-detached align-items-center bg-navbar-theme" id="layout-navbar">
					<div class="layout-menu-toggle navbar-nav align-items-xl-center me-3 me-xl-0 d-xl-none">
						<a class="nav-item nav-link px-0 me-xl-4" href="javascript:void(0)">
							<i class="bx bx-menu bx-sm"></i>
						</a>
					</div>

					<div class="navbar-nav-right d-flex align-items-center" id="navbar-collapse">
						

						<ul class="navbar-nav flex-row align-items-center ms-auto">
														<!-- User -->
							<li class="nav-item navbar-dropdown dropdown-user dropdown">
								<a class="nav-link dropdown-toggle hide-arrow" href="javascript:void(0);" data-bs-toggle="dropdown">
									<div class="avatar avatar-online">
										<img src="../assets/img/avatars/8.png" alt class="w-px-40 h-auto rounded-circle" />
									</div>
								</a>
								<ul class="dropdown-menu dropdown-menu-end">
									<li>
										<a class="dropdown-item" href="#">
											<div class="d-flex">
												<div class="flex-shrink-0 me-3">
													<div class="avatar avatar-online">
														<img src="../assets/img/avatars/8.png" alt class="w-px-40 h-auto rounded-circle" />
													</div>
												</div>
												<div class="flex-grow-1">
													<span class="fw-semibold d-block">{{auth()->user()->name ?? auth()->user()->email}}</span>
													@if (Session::get('roleuser') == 1)
													<span class="badge badge-success mt-2" style="border-color:#00aaff !important; color:#00aaff;">Administrador</span>
													@elseif(Session::get('roleuser') == 4)
													<span class="badge badge-success mt-2" style="border-color:#00ff77 !important; color:#00ff77;">Residente</span>
													@elseif(Session::get('roleuser') == 2)
													<span class="badge badge-success mt-2" style="border-color:#a200ff !important; color:#a200ff;">Vigilante</span>
													@elseif(Session::get('roleuser') == 3)
													<span class="badge badge-success mt-2" style="border-color:#ffbf00 !important; color:#ffbf00;">Gerennte</span>
													@endif

												</div>
											</div>
										</a>
									</li>
									<li>
										<div class="dropdown-divider"></div>
									</li>
									<!--
									<li>
										<a class="dropdown-item" href="#">
											<i class="bx bx-user me-2"></i>
											<span class="align-middle">My Profile</span>
										</a>
									</li>
									<li>
										<a class="dropdown-item" href="#">
											<i class="bx bx-cog me-2"></i>
											<span class="align-middle">Settings</span>
										</a>
									</li>
									<li>
										<div class="dropdown-divider"></div>
									</li>-->
									<li>

										<a href="/logout" class="dropdown-item" href="auth-login-basic.html">
											<i class="bx bx-power-off me-2"></i>
											<span class="align-middle">Log Out</span>
										</a>


									</li>
								</ul>
							</li>
							<!--/ User -->
						</ul>
					</div>
				</nav>

				<!-- / Navbar -->
				<!-- Content wrapper -->
				<div class="content-wrapper">
					<!-- Content -->

					<div class="container-xxl flex-grow-1 container-p-y">
						@yield('content')
					</div>
					<!-- / Content -->

					
					@endauth

					@guest

					<!-- Layout wrapper -->
					<div class="layout-wrapper layout-content-navbar">
					

						<!-- / Navbar -->

						<!-- Content wrapper -->
						<div class="content-wrapper">
							<!-- Content -->

							<div class="container-xxl flex-grow-1 container-p-y">
								<div class="row">
									<div class="col-lg-8 mb-4 order-0">
										<div class="card">
											<div class="d-flex align-items-end row">
												<div class="col-sm-7">
													<div class="card-body">
														<h5 class="card-title text-primary">Para ver el contenido debes</h5>
														<p class="mb-4">
														<p>
															<a href="/login">Iniciar Sesión</a>
														</p>
														</p>
													</div>
												</div>
												<div class="col-sm-5 text-center text-sm-left">
													<div class="card-body pb-0 px-0 px-md-4">
														<img src="../assets/img/illustrations/man-with-laptop-light.png" height="140" alt="View Badge User" data-app-dark-img="illustrations/man-with-laptop-dark.png" data-app-light-img="illustrations/man-with-laptop-light.png" />
													</div>
												</div>
											</div>
										</div>
									</div>


									

									<div class="content-backdrop fade"></div>
								</div>
								<!-- Content wrapper -->
							</div>
							<!-- / Layout page -->
						</div>

						<!-- Overlay -->
						<div class="layout-overlay layout-menu-toggle"></div>
					</div>
					<!-- / Layout wrapper -->



					@endguest


					<div class="content-backdrop fade"></div>
					<!-- Footer -->
					<footer class="content-footer footer bg-footer-theme">
						<div class="container-xxl d-flex flex-wrap justify-content-between py-2 flex-md-row flex-column">
							<div class="mb-2 mb-md-0">
								©
								<script>
									document.write(new Date().getFullYear());
								</script>
								, made with ❤️ by
								<a href="https://themeselection.com" target="_blank" class="footer-link fw-bolder">ThemeSelection</a>
							</div>
						</div>
					</footer>
				</div>
				<!-- Content wrapper -->
				
			</div>
			
			<!-- / Layout page -->
		</div>
		
		<!-- Overlay -->
		<div class="layout-overlay layout-menu-toggle"></div>
	</div>
	<!-- / Layout wrapper -->


	<!-- Core JS -->
	<!-- build:js assets/vendor/js/core.js -->
	<script src="../assets/vendor/libs/jquery/jquery.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.js"></script>
	<script src="../assets/vendor/libs/popper/popper.js"></script>
	<script src="../assets/vendor/js/bootstrap.js"></script>
	<script src="../assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js"></script>

	<script src="../assets/vendor/js/menu.js"></script>
	<!-- endbuild -->

	<!-- Vendors JS -->
	<script src="../assets/vendor/libs/apex-charts/apexcharts.js"></script>

	<!-- Main JS -->
	<script src="../assets/js/main.js"></script>

	<!-- Page JS -->
	<script src="../assets/js/dashboards-analytics.js"></script>

	<!-- Place this tag in your head or just before your close body tag. -->
	<script async defer src="https://buttons.github.io/buttons.js"></script>

	

	@yield('content-js')

	
</body>

</html>