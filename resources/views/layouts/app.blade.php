<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
	<!-- CSRF Token -->
	<meta name="csrf-token" content="{{ csrf_token() }}">

	<title>{{ config('app.name', 'Laravel') }}</title>

	<!-- Scripts -->
	<link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700|Roboto+Slab:400,700|Material+Icons" />
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css">
	<link href="assets/css/material-dashboard.css?v=2.1.2" rel="stylesheet" />
	<!--link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous"-->
	<link rel="stylesheet" href="https://cdn.datatables.net/1.10.20/css/jquery.dataTables.min.css">

	<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
	<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
	<script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.22/js/dataTables.bootstrap4.min.js"></script>
	<script src="https://cdn.datatables.net/responsive/2.2.6/js/dataTables.responsive.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.2.6/js/responsive.bootstrap.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.6.4/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.6.4/js/buttons.flash.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.6.4/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.6.4/js/buttons.print.min.js"></script>
</head>

<body>
	<div class="wrapper ">
		<div class="sidebar" data-color="purple" data-background-color="white">
			<!--
					Tip 1: You can change the color of the sidebar using: data-color="purple | azure | green | orange | danger"

					Tip 2: you can also add an image using data-image tag
				-->
			<div class="logo">
				<a href="{{ url('/') }}" class="simple-text logo-mini">
					{{ config('app.name', 'Laravel') }}
				</a>
			</div>
			<div class="sidebar-wrapper">
				<ul class="nav">
					@guest
					@else
					<li class="nav-item active ">
						<a class="nav-link" href="{{ url('/') }}">
							<i class="material-icons">dashboard</i>
							<p>Home</p>
						</a>
					</li>
					@if($perhitungan == 1)
					<li class="nav-item active ">
						<a class="nav-link" href="{{ url('perhitungan') }}">
							<i class="material-icons">dashboard</i>
							<p>Perhitungan</p>
						</a>
					</li>
					@endif
					@if(Auth::user()->jabatan == 'admin')
					<li class="nav-item active ">
						<a class="nav-link" href="{{ url('kriteria') }}">
							<i class="material-icons">dashboard</i>
							<p>Kriteria</p>
						</a>
					</li>
					@if($check_nilai_bobot_kriteria == 1)
					<li class="nav-item active ">
						<a class="nav-link" href="{{ url('nilai_bobot_kriteria') }}">
							<i class="material-icons">dashboard</i>
							<p>Nilai Bobot Kriteria</p>
						</a>
					</li>
					@endif
					@if($check_kriteria == 1)
					<li class="nav-item active ">
						<a class="nav-link" href="{{ url('alternatif') }}">
							<i class="material-icons">dashboard</i>
							<p>Alternatif</p>
						</a>
					</li>
					@endif
					@if($check_nilai_bobot_alternatif == 1)
					<li class="nav-item active ">
						<a class="nav-link" href="{{ url('nilai_bobot_alternatif') }}">
							<i class="material-icons">dashboard</i>
							<p>Nilai Bobot Alternatif</p>
						</a>
					</li>
					@endif
					<li class="nav-item active ">
						<a class="nav-link" href="{{ url('upload') }}">
							<i class="material-icons">dashboard</i>
							<p>Upload</p>
						</a>
					</li>
					@endguest
					@endif
					

					<!-- your sidebar here -->
				</ul>
			</div>
		</div>
		<div class="main-panel">
			<!-- Navbar -->
			<nav class="navbar navbar-expand-lg navbar-transparent navbar-absolute fixed-top ">
				<div class="container-fluid">
					<div class="navbar-wrapper">
						<a class="navbar-brand" href="javascript:;">AHP TOPSIS</a>
					</div>
					<button class="navbar-toggler" type="button" data-toggle="collapse" aria-controls="navigation-index" aria-expanded="false" aria-label="Toggle navigation">
						<span class="sr-only">Toggle navigation</span>
						<span class="navbar-toggler-icon icon-bar"></span>
						<span class="navbar-toggler-icon icon-bar"></span>
						<span class="navbar-toggler-icon icon-bar"></span>
					</button>
					<div class="collapse navbar-collapse justify-content-end">
						<ul class="navbar-nav">
							@guest
							<li class="nav-item">
								<a class="nav-link" href="{{ route('login') }}">
									{{ __('Login') }}
								</a>
							</li>
							@if (Route::has('register'))
							<li class="nav-item" hidden>
								<a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
							</li>
							@endif
							@else
							<li class="nav-item dropdown">
								<a class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
									{{ Auth::user()->name }} <span class="caret"></span>
								</a>

								<div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
									<a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault();document.getElementById('logout-form').submit();">
										{{ __('Logout') }}
									</a>

									<form action="{{ route('logout') }}" id="logout-form" method="POST" style="display: none;">
										@csrf
									</form>
								</div>
							</li>
							@endguest
						</ul>
					</div>
				</div>
			</nav>
			<!-- End Navbar -->
			<div class="content">
				<div class="container-fluid">
					@yield('content')
				</div>
			</div>
		</div>
	</div>
	
</body>

</html>