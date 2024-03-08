@extends('layouts.admin')
@section('content')
{{-- @include('partials.breadcrumb') --}}
@include('partials.subheader')
@include('partials.sysalert')
<div class="row">
	<div class="col-12">
		<div class="panel" id="panel-1">
			<div class="panel-container show">
				<div class="panel-content">
					<table class="table table-bordered table-hover table-sm table-striped w-100" id="broadcastMessage">
						<thead>
							<tr>
								<th>Tanggal</th>
								<th>Sifat</th>
								<th>Judul</th>
								<th>Oleh</th>
								<th>Target</th>
								<th>Status</th>
								<th>Aksi</th>
							</tr>
						</thead>
						<tbody>
							@foreach ($messages as $message)
								<tr>
									<td>
										{{$message->created_at}}
									</td>
									<td>
										<span class="badge badge-{{$message->type}}">
											@if($message->type === 'info')
												Biasa
											@elseif ($message->type === 'warning')
												Penting
											@elseif ($message->type === 'danger')
												Sangat Penting
											@endif
										</span>
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
										<div class="custom-control custom-switch">
											<input type="checkbox" class="custom-control-input" id="customSwitch2{{$message->id}}" @if($message->status === 1) checked="" @endif>
											@if($message->status === 1)
												<label class="custom-control-label" for="customSwitch2{{$message->id}}">Tampil</label>
											@else
												<label class="custom-control-label" for="customSwitch2{{$message->id}}">Tidak Tampil</label>
											@endif
										</div>
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
