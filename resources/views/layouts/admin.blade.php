<!DOCTYPE html>
<html lang="en" class="root-text-sm">
	<head>
		<meta charset="utf-8">
		<title>
			Simethris 2023 | {{ ($page_title ?? '3.0') }}
		</title>
		<meta name="description" content="Page Title">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no, user-scalable=no, minimal-ui">
		<!-- Call App Mode on ios devices -->
		<meta name="apple-mobile-web-app-capable" content="yes" />
		<!-- Remove Tap Highlight on Windows Phone IE -->
		<meta name="msapplication-tap-highlight" content="no">
		<!-- smartadmin base css -->
		<link rel="stylesheet" href="{{ asset('css/app.css') }}" />
		<link id="vendorsbundle" rel="stylesheet" media="screen, print" href="{{ asset('css/smartadmin/vendors.bundle.css') }}">
		<link id="appbundle" rel="stylesheet" media="screen, print" href="{{ asset('css/smartadmin/app.bundle.css') }}">
		<link id="mytheme" rel="stylesheet" media="screen, print" href="#">
		<link id="myskin" rel="stylesheet" media="screen, print" href="{{ asset('css/smartadmin/skins/skin-master.css') }}">
		<!-- Place favicon.ico in the root directory -->
		<link href="{{ asset('css/fontawesome.min.css') }}" rel="stylesheet">
		<link href="{{ asset('img/favicon.png') }}" rel="icon" />
		<link href="{{ asset('img/logo-icon.png') }}" rel="apple-touch-icon" sizes="180x180" />
		<link href="{{ asset('img/logo-icon.png') }}" rel="safari-pinned-tab.svg" color="#5bbad5" />


		<link rel="stylesheet" media="screen, print" href="{{ asset('css/smartadmin/miscellaneous/reactions/reactions.css') }}">

		<!-- You can add your own stylesheet here to override any styles that comes before it
		<link rel="stylesheet" media="screen, print" href="css/your_styles.css">-->
		<link rel="stylesheet" media="screen, print" href="{{ asset('css/smartadmin/datagrid/datatables/datatables.bundle.css') }}">
		<link rel="stylesheet" media="screen, print" href="{{ asset('css/formplugins/bootstrap-datepicker/bootstrap-datepicker.css') }}">
		<link rel="stylesheet" media="screen, print" href="{{ asset('css/formplugins/dropzone/dropzone.css') }}">
		<link rel="stylesheet" media="screen, print" href="{{ asset('css/formplugins/select2/select2.bundle.css') }}">
		<link rel="stylesheet" media="screen, print" href="{{ asset('css/formplugins/summernote/summernote.css') }}">
		<link rel="stylesheet" media="screen, print" href="{{ asset('css/smartadmin/miscellaneous/nestable/nestable.css') }}">
		<link rel="stylesheet" media="screen, print" href="{{ asset('css/smartadmin/miscellaneous/reactions/reactions.css') }}">
		<link rel="stylesheet" media="screen, print" href="{{ asset('css/smartadmin/skins/skin-master.css') }}">
		<link rel="stylesheet" media="screen, print" href="{{ asset('css/smartadmin/statistics/c3/c3.css') }}">
		<link rel="stylesheet" media="screen, print" href="{{ asset('css/smartadmin/statistics/chartist/chartist.css') }}">
		<link rel="stylesheet" media="screen, print" href="{{ asset('css/smartadmin/statistics/chartjs/chartjs.css') }}">
		<link rel="stylesheet" media="screen, print" href="{{ asset('css/smartadmin/fa-light.css') }}">
		<link rel="stylesheet" media="screen, print" href="{{ asset('css/smartadmin/fa-regular.css') }}">
		<link rel="stylesheet" media="screen, print" href="{{ asset('css/smartadmin/fa-solid.css') }}">
		<link rel="stylesheet" media="screen, print" href="{{ asset('css/smartadmin/fa-brands.css') }}">

		<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

		<!-- coreui -->
		<link href="{{ asset('css/ajax/all.css') }}" rel="stylesheet" />
		{{-- <link href="{{ asset('css/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet" />
		<link href="{{ asset('css/datatables/buttons.dataTables.min.css') }}" rel="stylesheet" />
		<link href="{{ asset('css/datatables/select.dataTables.min.css') }}" rel="stylesheet" /> --}}

		<link href="{{ asset('css/toastr.css') }}" rel="stylesheet" />

		<script src="https://maps.googleapis.com/maps/api/js?key={{ isset($mapkey) ? $mapkey->key : 'Default Key' }}&libraries=drawing,geometry&callback=initMap" async defer></script>

		<meta name="csrf-token" content="{{ csrf_token() }}">
		@yield('styles')
	</head>

	<body class="mod-bg-2 mod-nav-link blur">  {{-- mod-skin-dark --}}
		<script src="{{ asset('js/smartadmin/pagesetting.js') }}"></script>
		<!-- begin page wrapper -->
		<div class="page-wrapper">
			<div class="page-inner">
				<!-- begin sidebar -->
				@include('partials.menu')
				<!-- end sidebar -->
				<div class="page-content-wrapper">
					<!-- begin page header -->
					@include('partials.header')
					<!-- end page header -->
					<!-- begin page content -->
					<main id="js-page-content" role="main" class="page-content">
						<!-- start alert pesan -->
						@if(session('message'))
							<div class="alert alert-success alert-dismissible fade show" role="alert">
								<button type="button" class="close" data-dismiss="alert" aria-label="Close">
									<span aria-hidden="true"><i class="fal fa-times-circle"></i></span>
								</button>
								<strong>{{ session('message') }}.</strong>
							</div>
						@endif
						<!-- end alert pesan -->
						<!-- start alert error -->
						@if($errors->count() > 0)
							<div class="alert alert-danger alert-dismissible fade show" role="alert">
								<button type="button" class="close" data-dismiss="alert" aria-label="Close">
									<span aria-hidden="true"><i class="fal fa-times-circle"></i></span>
								</button>
								<strong>PERHATIAN!</strong>
								<ul class="list-unstyled">
									@foreach($errors->all() as $error)
									<li>{{ $error }}</li>
									@endforeach
								</ul>
							</div>
						@endif
						<!-- end alert error -->
						@yield('content')
					</main>
					<div class="page-content-overlay" data-action="toggle" data-class="mobile-nav-on"></div>
				</div>
			</div>
		</div>
		<form id="logoutform" action="{{ route('logout') }}" method="POST" style="display: none;">
			{{ csrf_field() }}
		</form>
		<script src="{{ asset('js/app.js') }}"></script>

		<!-- Smartadmin core -->


		<script src="{{ asset('js/vendors.bundle.js') }}"></script>

		<script src="{{ asset('js/app.bundle.js?v=1.1') }}"></script>
		<!-- Smartadmin plugin -->
		<script src="{{ asset('js/smartadmin/datagrid/datatables/datatables.bundle.js') }}"></script>
		<script src="{{ asset('js/smartadmin/datagrid/datatables/datatables.export.js') }}"></script>
		<script src="{{ asset('js/datatables/datetime.js') }}"></script>

		<script src="{{ asset('js/moment/moment.min.js') }}"></script>
		<script src="{{ asset('js/formplugins/bootstrap-datepicker/bootstrap-datepicker.js') }}"></script>
		<script src="{{ asset('js/formplugins/dropzone/dropzone.js') }}"></script>
		<script src="{{ asset('js/formplugins/select2/select2.bundle.js') }}"></script>
		<script src="{{ asset('js/formplugins/summernote/summernote.js') }}"></script>
		<!-- Smartadmin misc -->
		<script src="{{ asset('js/smartadmin/miscellaneous/nestable/nestable.js') }}"></script>
		<!-- smartadmin statistics -->
		<script src="{{ asset('js/smartadmin/statistics/c3/c3.js') }}"></script>
		<script src="{{ asset('js/smartadmin/statistics/chartist/chartist.js') }}"></script>
		<script src="{{ asset('js/smartadmin/statistics/chartjs/chartjs.bundle.js') }}"></script>
		<script src="{{ asset('js/smartadmin/statistics/d3/d3.js') }}"></script>
		<script src="{{ asset('js/smartadmin/statistics/echart/echarts.min.js') }}"></script>
		<script src="{{ asset('js/smartadmin/statistics/easypiechart/easypiechart.bundle.js') }}"></script>
		<script src="{{ asset('js/smartadmin/statistics/sparkline/sparkline.bundle.js') }}"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.10/jquery.mask.js"></script>


		<script src="{{ asset('js/toastr.js') }}"></script>


		<!-- coreui -->
		<script src="{{ asset('js/main.js?v=1.0.2') }}"></script>
		<script src="{{ asset('js/pdfmake/pdfmake.min.js') }}"></script>
		<script src="{{ asset('js/pdfmake/vfs_fonts.js') }}"></script>
		<script src="{{ asset('js/jszip/jszip.min.js') }}"></script>

		<!-- search bar -->
		<script type="text/javascript">


			console.log("Init Language");
			if (!$.i18n) {
				initApp.loadScript("/js/i18n/i18n.js",
					function activateLang () {
						$.i18n.init({
							resGetPath: '/media/data/__lng__.json',
							load: 'unspecific',
							fallbackLng: false,
							lng: '{{ app()->getLocale() }}'
						}, function (t){
							$('[data-i18n]').i18n();
							$('[data-lang]').removeClass('active');
							$('[data-lang="{{ app()->getLocale() }}"]').addClass('active');
							console.log("Init language to: " + "{{ app()->getLocale() }}");
						});

					}

				);

			} else {
				i18n.setLng('{{ app()->getLocale() }}', function(){
					$('[data-i18n]').i18n();
					$('[data-lang]').removeClass('active');
					$('[data-lang="{{ app()->getLocale() }}"]').addClass('active');
					console.log("setting language to: " + "{{ app()->getLocale() }}");
				});

			}


		$(document).ready(function() {
		$('.searchable-field').select2({
			minimumInputLength: 3,
			ajax: {
			url: '',
			dataType: 'json',
			type: 'GET',
			delay: 200,
			data: function(term) {
				return {
				search: term
				};
			},
			results: function(data) {
				return {
				data
				};
			}
			},
			escapeMarkup: function(markup) {
			return markup;
			},
			templateResult: formatItem,
			templateSelection: formatItemSelection,
			placeholder: "{{ trans('global.search') }} ...",
			language: {
			inputTooShort: function(args) {
				var remainingChars = args.minimum - args.input.length;
				var translation = "{{ trans('global.search_input_too_short') }}";

				return translation.replace(':count', remainingChars);
			},
			errorLoading: function() {
				return "{{ trans('global.results_could_not_be_loaded') }}";
			},
			searching: function() {
				return "{{ trans('global.searching') }}";
			},
			noResults: function() {
				return "{{ trans('global.no_results') }}";
			},
			}

		});

		function formatItem(item) {
			if (item.loading) {
			return "{{ trans('global.searching') }}...";
			}
			var markup = "<div class='searchable-link' href='" + item.url + "'>";
			markup += "<div class='searchable-title'>" + item.model + "</div>";
			$.each(item.fields, function(key, field) {
			markup += "<div class='searchable-fields'>" + item.fields_formated[field] + " : " + item[field] + "</div>";
			});
			markup += "</div>";

			return markup;
		}

		function formatItemSelection(item) {
			if (!item.model) {
			return "{{ trans('global.search') }}...";
			}
			return item.model;
		}
		$(document).delegate('.searchable-link', 'click', function() {
			var url = $(this).attr('href');
			window.location = url;
		});


		});
		</script>
		@yield('scripts')
	</body>
</html>
