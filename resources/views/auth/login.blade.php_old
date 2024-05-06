<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<title>
		{{env('APP_NAME')}}
	</title>
	<meta name="description" content="Page Title">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no, user-scalable=no, minimal-ui">
	<!-- Call App Mode on ios devices -->
	<meta name="apple-mobile-web-app-capable" content="yes" />
	<!-- Remove Tap Highlight on Windows Phone IE -->
	<meta name="msapplication-tap-highlight" content="no">
	<!-- smartadmin base css -->
	<link id="vendorsbundle" rel="stylesheet" media="screen, print" href="{{ asset('css/smartadmin/vendors.bundle.css') }}">
	<link id="appbundle" rel="stylesheet" media="screen, print" href="{{ asset('css/smartadmin/app.bundle.css') }}">
	<link id="mytheme" rel="stylesheet" media="screen, print" href="#">
	<link id="myskin" rel="stylesheet" media="screen, print" href="{{ asset('css/smartadmin/skins/skin-master.css') }}">
	<!-- Place favicon.ico in the root directory -->
	<link rel="apple-touch-icon" sizes="180x180" href="{{ asset('img/favicon.png') }}">
	<link rel="icon" type="image/png" sizes="32x32" href="{{ asset('img/favicon.png') }}">
	<link rel="mask-icon" href="{{ asset('img/logo.png') }}" color="#5bbad5">
	<link rel="stylesheet" media="screen, print" href="{{ asset('css/miscellaneous/reactions/reactions.css') }}">

	<!-- You can add your own stylesheet here to override any styles that comes before it
		<link rel="stylesheet" media="screen, print" href="css/your_styles.css">-->
	<link rel="stylesheet" media="screen, print" href="{{ asset('css/smartadmin/datagrid/datatables/datatables.bundle.css') }}">
	<link rel="stylesheet" media="screen, print" href="{{ asset('css/formplugins/bootstrap-datepicker/bootstrap-datepicker.css') }}">
	<link rel="stylesheet" media="screen, print" href="{{ asset('css/formplugins/dropzone/dropzone.css') }}">
	<link rel="stylesheet" media="screen, print" href="{{ asset('css/formplugins/select2/select2.bundle.css') }}">
	<link rel="stylesheet" media="screen, print" href="{{ asset('css/formplugins/summernote/summernote.css') }}">
	<link rel="stylesheet" media="screen, print" href="{{ asset('css/miscellaneous/nestable/nestable.css') }}">
	<link rel="stylesheet" media="screen, print" href="{{ asset('css/miscellaneous/reactions/reactions.css') }}">
	<link rel="stylesheet" media="screen, print" href="{{ asset('css/smartadmin/skins/skin-master.css') }}">
	<link rel="stylesheet" media="screen, print" href="{{ asset('css/smartadmin/statistics/c3/c3.css') }}">
	<link rel="stylesheet" media="screen, print" href="{{ asset('css/smartadmin/statistics/chartist/chartist.css') }}">
	<link rel="stylesheet" media="screen, print" href="{{ asset('css/smartadmin/statistics/chartjs/chartjs.css') }}">
	<link rel="stylesheet" media="screen, print" href="{{ asset('css/smartadmin/fa-light.css') }}">
	<link rel="stylesheet" media="screen, print" href="{{ asset('css/smartadmin/fa-regular.css') }}">
	<link rel="stylesheet" media="screen, print" href="{{ asset('css/smartadmin/fa-solid.css') }}">
	<link rel="stylesheet" media="screen, print" href="{{ asset('css/smartadmin/fa-brands.css') }}">
	@yield('style')

</head>

<body class="mod-bg-1 mod-nav-link footer-function-fixed nav-function-minify nav-function-fixed">
	<!-- BEGIN Page Wrapper -->
	<div class="page-wrapper">
		<div class="page-inner">
			<div class="page-content-wrapper">
				<!-- BEGIN Page Content -->
				<!-- the #js-page-content id is needed for some plugins to initialize -->
				<main id="js-page-content" role="main" class="page-content">
					<!-- welcome message -->
					<div class="row mb-3">
						<div class="col text-center">
							<h1 class="hidden-md-down">Selamat Datang di </h1>
							<h1 class="display-4 fw-700">{{env('APP_NAME')}}</h1>
							{{-- <h1 class="display-4 hidden-sm-up">Selamat Datang di {{env('APP_NAME')}}</h1> --}}
							<h4 class="hidden-md-down">
								<div class="d-flex flex-start w-100">
									<div class="d-flex flex-fill">
										<div class="flex-fill">
											<span class="text-muted js-get-date"></span>

										</div>
									</div>
								</div>
							</h4>
							<span>Silahkan pilih menu di bawah ini untuk melanjutkan</span>
						</div>
					</div>

					<div class="row justify-content-center">
						<div class="col-md-12 order-md-2 mb-4">
							<div class="row justify-content-center text-center">
								<div class="card border m-auto m-lg-2" style="max-width: 18rem;">
									{{-- <img src="img/card-backgrounds/cover-kementan.jpg" class="card-img-top" alt="..."> --}}
									<i class="fal fa-user-crown fa-8x mt-5"></i>
									<div class="card-body">
										<h5 class="card-title fw-500">Administrator & Verifikator</h5>
										<p class="card-text text-left">Klik tombol di bawah jika Role Anda adalah Administrator atau Verifikator.</p>
									</div>
									<div class="card-footer">
										{{-- <a href="/login" class="btn btn-sm btn-primary"><i class="fal fa-plane-departure mr-1"></i>Masuk</a> --}}
										<button type="button" class="btn btn-sm btn-primary waves-effect waves-themed" data-toggle="modal" data-target="#login1" onclick="loginClick(1)"><i class="fal fa-plane-departure mr-1"></i>Masuk</button>
									</div>
								</div>
								{{-- <div class="card border m-auto m-lg-2" style="max-width: 18rem;">
									<img src="img/card-backgrounds/cover-2021.jpeg" class="card-img-top" alt="...">
									<div class="card-body">
										<h5 class="card-title fw-500 text-danger">Simethris versi 2021</h5>
										<p class="card-text text-left">Jika Anda ingin melaporkan Realisasi Wajib Tanam-Produksi untuk RIPH periode sebelum Tahun 2022.</p>

									</div>
									<div class="card-footer">
										<button type="button" class="btn btn-sm btn-danger waves-effect waves-themed" data-toggle="modal" data-target="#login1" onclick="loginClick(3)"><i class="fal fa-plane-departure mr-1"></i>Masuk</button>
									</div>
								</div> --}}
								<div class="card border m-auto m-lg-2" style="max-width: 18rem;">
									<i class="fal fa-user-tie fa-8x mt-5"></i>
									{{-- <img src="img/card-backgrounds/cover-v3.jpg" class="card-img-top" alt="..."> --}}
									<div class="card-body">
										<h5 class="card-title fw-500">Pelaku Usaha</h5>
										<p class="card-text text-left">Jika Anda ingin melaporkan Realisasi Wajib Tanam-Produksi untuk RIPH periode Tahun 2022 dan setelahnya.</p>

									</div>
									<div class="card-footer">
										{{-- <a href="/login" class="btn btn-sm btn-warning"><i class="fal fa-plane-departure mr-1"></i>Masuk</a> --}}
										<button type="button" class="btn btn-sm btn-warning waves-effect waves-themed" data-toggle="modal" data-target="#login1" onclick="loginClick(2)"><i class="fal fa-plane-departure mr-1"></i>Masuk</button>
									</div>
								</div>
							</div>
						</div>
					</div>
					{{-- login1 --}}

					<div class="modal fade" id="login1" tabindex="-1" role="dialog" style="display: none;" aria-modal="true">
						<div class="modal-dialog modal-dialog-centered" role="document">
							<div class="modal-content">
								<div class="modal-header">
									<button type="button" class="close" data-dismiss="modal" aria-label="Close">
										<span aria-hidden="true"><i class="fal fa-times"></i></span>
									</button>
								</div>
								<div class="modal-body">

									<form id="js-login" novalidate="" method="POST" action="{{ route('login') }}">
										@csrf
										<input id="roleaccess" name="roleaccess" type="hidden" value=""/>
										<div class="form-group">
											<label class="form-label" for="username">Username</label>
											<div class="input-group" data-toggle="tooltip" title data-original-title="Your Username" data-title="Nama Pengguna (username)" data-intro="Type your username here" data-step="3">
												<div class="input-group-prepend">
													<div class="input-group-text">
														<span class="fal fa-user"></span>
													</div>
												</div>

												<input id="username" name="username" type="text" class="form-control form-control-md {{ $errors->has('username') ? ' is-invalid' : '' }}" required autocomplete="{{ trans('global.login_username') }}" autofocus placeholder="{{ trans('global.login_username') }}" value="{{ old('username', null) }}" />
												@if($errors->has('username'))
												<div class="invalid-feedback">
													{{ $errors->first('username') }}
												</div>
												@endif
											</div>
										</div>
										<div class="form-group">
											<label class="form-label" for="password">Password</label>
											<div class="input-group bg-white shadow-inset-2" data-toggle="tooltip" title data-original-title="Your password" data-title="Password" data-intro="Type your password" data-step="4">
												<div class="input-group-prepend">
													<div class="input-group-text">
														<span class="fal fa-key"></span>
													</div>
												</div>
												<input id="password" name="password" type="password" class="form-control form-control-md border-right-0 bg-transparent pr-0 {{ $errors->has('password') ? ' is-invalid' : '' }}" required autocomplete="{{ trans('global.login_password') }}" autofocus placeholder="{{ trans('global.login_password') }}" value="" />
												@if($errors->has('password'))
												<div class="invalid-feedback">
													{{ $errors->first('password') }}
												</div>
												@endif
												<div class="input-group-append">
													<span class="input-group-text bg-transparent border-left-0">
														<i class="far fa-eye-slash text-muted" id="togglePassword"></i>
													</span>
												</div>
											</div>
										</div>
										<div class="form-group text-left" data-title="Ingat Saya" data-intro="Centang jika Anda ingin langsung masuk jika login berhasil" data-step="5">
											<div class="custom-control custom-checkbox">
												<input type="checkbox" class="custom-control-input" id="rememberme">
												<label class="custom-control-label" for="rememberme">{{ trans('global.remember_me') }}</label>
											</div>
										</div>
										<div class="row no-gutters">
											<div class="col-lg-12 pl-lg-1 my-2" data-title="Tombol masuk" data-intro="Klik tombol ini untuk mengakses aplikasi jika seluruh kolom telah terisi" data-step="6">
												<button id="js-login-btn" type="submit" class="btn btn-block btn-info btn-xm">{{ trans('global.login') }}</button>
											</div>
										</div>

										<div class="row no-gutters">
											{{-- <div class="text-center">Belum memiliki akun?</div> --}}
											<div class="col-lg-12 pl-lg-1 my-2">
												<a href="#" id="regbutton" class="btn btn-block btn-outline-danger btn-xm">Daftarkan Akun</a>
											</div>
										</div>
									</form>
								</div>
							</div>
						</div>
					</div>
				</main>
				<!-- this overlay is activated only when mobile menu is triggered -->
				<div class="page-content-overlay" data-action="toggle" data-class="mobile-nav-on"></div> <!-- END Page Content -->
				<!-- BEGIN Page Footer -->

				<!-- END Page Footer -->
				<!-- BEGIN Shortcuts -->

				<!-- END Shortcuts -->
				<!-- BEGIN Color profile -->
				<!-- this area is hidden and will not be seen on screens or screen readers -->
				<!-- we use this only for CSS color refernce for JS stuff -->
				@include('partials.colorprofile')
				<!-- END Color profile -->
			</div>
		</div>
	</div>


	<!-- BEGIN Page Settings -->
	@include('partials.pagesettings')
	<!-- end page settings -->
	<!-- end page wrapper -->

	<!-- base vendor bundle:
			DOC: if you remove pace.js from core please note on Internet Explorer some CSS animations may execute before a page is fully loaded, resulting 'jump' animations
				+ pace.js (recommended)
				+ jquery.js (core)
				+ jquery-ui-cust.js (core)
				+ popper.js (core)
				+ bootstrap.js (core)
				+ slimscroll.js (extension)
				+ app.navigation.js (core)
				+ ba-throttle-debounce.js (core)
				+ waves.js (extension)
				+ smartpanels.js (extension)
				+ src/../jquery-snippets.js (core)
				{ { asset('js/vendors.bundle.js') }}
				{ { asset('js/app.bundle.js') }}
				{ { asset('js/datagrid/datatables/datatables.bundle.js') }}
		-->
	<!-- Smartadmin core -->
	<script src="{{ asset('js/vendors.bundle.js') }}"></script>
	<script src="{{ asset('js/app.bundle.js') }}"></script>
	<!-- Smartadmin plugin -->
	<script src="{{ asset('js/smartadmin/datagrid/datatables/datatables.bundle.js') }}"></script>
	<script src="{{ asset('js/moment/moment.min.js') }}"></script>
	<script src="{{ asset('js/smartadmin/formplugins/bootstrap-datepicker/bootstrap-datepicker.js') }}"></script>
	<script src="{{ asset('js/smartadmin/formplugins/dropzone/dropzone.js') }}"></script>
	<script src="{{ asset('js/smartadmin/formplugins/select2/select2.bundle.js') }}"></script>
	<script src="{{ asset('js/smartadmin/formplugins/summernote/summernote.js') }}"></script>
	<!-- Smartadmin misc -->
	<script src="{{ asset('js/miscellaneous/nestable/nestable.js') }}"></script>
	<!-- smartadmin statistics -->
	<script src="{{ asset('js/smartadmin/statistics/c3/c3.js') }}"></script>
	<script src="{{ asset('js/smartadmin/statistics/chartist/chartist.js') }}"></script>
	<script src="{{ asset('js/smartadmin/statistics/chartjs/chartjs.bundle.js') }}"></script>
	<script src="{{ asset('js/smartadmin/statistics/d3/d3.js') }}"></script>
	<script src="{{ asset('js/smartadmin/statistics/echart/echarts.min.js') }}"></script>
	<script src="{{ asset('js/smartadmin/statistics/easypiechart/easypiechart.bundle.js') }}"></script>
	<script src="{{ asset('js/smartadmin/statistics/sparkline/sparkline.bundle.js') }}"></script>
	<script src="{{ asset('js/smartadmin/statistics/flot/flot.bundle.js') }}"></script>


	{{-- <script type="text/javascript">
			/* Activate smart panels */
			$('#js-page-content').smartPanel();

		</script> --}}
	<script>
		$(document).ready(function () {
			@if ($errors->any())

				$('#login1').modal('show');
				document.querySelector('#roleaccess').value = {{ $errors->first('roleaccess') }};
			@endif

		})

		const togglePassword = document.querySelector('#togglePassword');
		const password = document.querySelector('#password');

		togglePassword.addEventListener('click', function (e) {
			// toggle the type attribute
			const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
			password.setAttribute('type', type);
			// toggle the eye slash icon\
			if (this.classList.contains('fa-eye')){
				this.classList.remove('fa-eye');
				this.classList.add('fa-eye-slash');
			} else {
				this.classList.remove('fa-eye-slash');
				this.classList.add('fa-eye');
			}

		});


		function loginClick(role_access) {
			const roleaccess = document.querySelector('#roleaccess');
			const regbut = document.querySelector('#regbutton');
			roleaccess.value = role_access;
			if (role_access==1){
				$("#regbutton").hide();
			} else if (role_access==2){
				$("#regbutton").show();
				regbut.href = 'https://riph.pertanian.go.id/';
			} else {
				$("#regbutton").show();
				regbut.href = "{{ route('register') }}";
			}

		}
	</script>
</body>

</html>
