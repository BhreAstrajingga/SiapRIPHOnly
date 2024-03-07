@extends('layouts.admin')
@section('content')
{{-- @include('partials.breadcrumb') --}}
@include('partials.subheader')
@include('partials.sysalert')
<div class="row">
	<div class="col-12">
		<div class="panel" id="panel-1">
			<div class="panel-hdr">
				<h2>

				</h2>
				<div class="panel-toolbar">
					@include('partials.globaltoolbar')
				</div>
			</div>
			<div class="panel-container show">
				<div class="panel-content">
					<table class="table table-bordered table-hover table-sm table-striped w-100" id="broadcastMessage">
						<thead>
							<tr>
								<th>Sifat</th>
								<th>Judul</th>
								<th>Oleh</th>
								<th>Target</th>
								<th>Status</th>
								<th>Tanggal</th>
								<th>Aksi</th>
							</tr>
						</thead>
						<tbody>
							@foreach ($messages as $message)
								<tr>
									<td>
										@if($message->type === 'info')
											<span>Biasa</span>
										@elseif ($message->type === 'warning')
											<span>Penting</span>
										@elseif ($message->type === 'danger')
											<span>Sangat Penting</span>
										@endif
									</td>
									<td>
										<a href="{{route('sroot.broadcasts.edit', $message->id)}}">{{$message->title}}</a>
									</td>
									<td>
										{{$message->user->name}}
									</td>
									<td>
										{{$message->target}}
									</td>
									<td>
										{{$message->status}}
									</td>
									<td>
										{{$message->created_at}}
									</td>
									<td>
										action
									</td>
								</tr>
							@endforeach
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection

@section('scripts')
@parent
<script>
	$(document).ready(function() {

	});
</script>



@endsection
