@extends('layouts.admin')


@section('content')
	@can('landing_access')
		<div class="row mb-5 d-flex align-items-top justify-content-between">
			<div class="col-md text-left">
				<div class="hidden-md-down">
					<h5>
						Selamat Datang di Simethris,
						<span class="fw-700">
							{{ Auth::user()->data_user->company_name ?? Auth::user()->name }}
						</span>
					</h5>
				</div>
				<div class="hidden-sm-up">
					<h2 class="display-4 ">Hallo,
						<span class="fw-700">
							{{ Auth::user()->data_user->company_name ?? Auth::user()->name }}
						</span>
					</h2>
				</div>
				<h4 class="hidden-md-down">
				</h4>
			</div>
			<div class="col-md text-right hidden-md-down">
				<p class="text-muted">{!! $quote !!}</p>
			</div>
		</div>

		@if($message )
			<div class="alert alert-primary alert-dismissible fade show" role="alert">
				<button type="button" class="close" data-dismiss="alert" aria-label="Close">
					<span aria-hidden="true"><i class="fal fa-times"></i></span>
				</button>
				<div class="d-flex align-items-top">
					<div class="alert-icon width-2">
						<span class="icon-stack" style="font-size: 22px;">
							<i class="base-2 icon-stack-3x color-{{$message->type}}-400"></i>
							<i class="base-10 text-white icon-stack-1x"></i>
							<i class="ni md-profile color-{{$message->type}}-800 icon-stack-2x"></i>
						</span>
					</div>
					<div class="flex-1">
						<strong class="text-uppercase fw-700 text-{{$message->type}}">
							{{$message->title}}
						</strong> <br>
						Kepada
						@if ($message->target === 0) <strong>Semua Pengguna</strong>.
						@elseif ($message->target === 1) <strong>Administrator</strong>.
						@elseif ($message->target === 2) <strong>Para Pelaku Usaha</strong>.
						@elseif ($message->target === 3) <strong>Para Verifikator</strong>.
						@endif
						{{$message->messages}} <br>

					</div>
				</div>
			</div>
		@endif

		<div class="row">
		</div>
		<!-- Page Content -->
	@endcan
@endsection


{{-- =================== script =================== --}}
@section('scripts')
	@parent
@endsection
