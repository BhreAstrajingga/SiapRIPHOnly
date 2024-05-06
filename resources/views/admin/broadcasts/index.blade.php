@extends('layouts.admin')
@section('styles')
<link rel="stylesheet" media="screen, print" href="{{ asset('css/smartadmin/notifications/sweetalert2/sweetalert2.bundle.css') }}">
@endsection
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
								<th>Judul</th>
								<th>Sifat</th>
								<th>Oleh</th>
								<th>Untuk</th>
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
										<a href="
											@if(Auth::user()->roles[0]->id === 7)
												{{route('sroot.broadcasts.edit', $message->id)}}
											@else
												{{route('admin.broadcasts.edit', $message->id)}}
											@endif">
											{{$message->title}}
										</a>
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
										{{$message->user->name}}
									</td>
									<td>
										@if($message->target == 0)
											Semua Pengguna
										@elseif ($message->target == 1)
											Administrator
										@elseif ($message->target == 2)
											Pelaku Usaha
										@elseif ($message->target == 3)
											Verifikator
										@endif
									</td>
									<td>
										<div class="custom-control custom-switch">
											<input type="checkbox" class="custom-control-input"
												id="customSwitch2{{$message->id}}"
												@if($message->status === 1) checked @endif
												data-id="{{$message->id}}"
												onchange="updateStatus(this)">
											@if($message->status === 1)
												<label class="custom-control-label" for="customSwitch2{{$message->id}}">Tampil</label>
											@else
												<label class="custom-control-label" for="customSwitch2{{$message->id}}">Tidak Tampil</label>
											@endif
										</div>
									</td>
									<td>
										<div class="d-flex justify-content-center">
											<a class="btn btn-sm btn-icon" href="javascript:void(0)" data-toggle="modal" data-target="#edit{{$message->id}}"><i class="fal fa-window-restore text-primary"></i></a>
											@can('broadcast_access')
											<form action="{{ route('admin.broadcasts.destroy', $message->id) }}" method="POST">
												@csrf
												@method('DELETE')
												<button class="btn btn-sm btn-icon" type="submit" data-toggle="tooltip" title data-original-title="Hapus Data"><i class="fal fa-trash text-danger"></i></button>
											</form>
											@endcan
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
<script src="{{ asset('js/smartadmin/notifications/sweetalert2/sweetalert2.bundle.js') }}"></script>
@parent
<script>
	$(document).ready(function() {
		$('#broadcastMessage').dataTable({
			responsive: true,
			lengthChange: false,
			ordering: true,
			order: [ [0, 'desc'] ],
			dom:
			"<'row'<'col-sm-12 col-md-6'l><'col-sm-12 col-md-6 d-flex align-items-center justify-content-end'<'select'>>>" +
			"<'row mb-3'<'col-sm-12 col-md-6 d-flex align-items-center justify-content-start'f><'col-sm-12 col-md-6 d-flex align-items-center justify-content-end'B>>" +
			"<'row'<'col-sm-12'tr>>" +
			"<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",
			buttons: [
				{
					extend: 'pdfHtml5',
					text: '<i class="fa fa-file-pdf"></i>',
					titleAttr: 'Generate PDF',
					className: 'btn-outline-danger btn-xs btn-icon mr-1'
				},
				{
					extend: 'excelHtml5',
					text: '<i class="fa fa-file-excel"></i>',
					titleAttr: 'Generate Excel',
					className: 'btn-outline-success btn-xs btn-icon mr-1'
				},
				{
					extend: 'print',
					text: '<i class="fa fa-print"></i>',
					titleAttr: 'Print Table',
					className: 'btn-outline-primary btn-xs btn-icon mr-1'
				},
				{
					text: '<i class="fal fa-comment-plus"></i>',
					titleAttr: 'Pengumuman Baru',
					className: 'btn btn-info btn-xs btn-icon ml-3',
					action: function(e, dt, node, config) {
						@if(Auth::user()->roles[0]->id === 7) // Jika peran adalah 'sroot'
							window.location.href = '{{ route('sroot.broadcasts.create') }}';
						@elseif(Auth::user()->roles[0]->id === 8) // Jika peran adalah 'admin'
							window.location.href = '{{ route('admin.broadcasts.create') }}';
						@endif
					}
				}
			]
		});
	});
</script>
<script>
    function updateStatus(checkbox) {
		var messageId = checkbox.getAttribute('data-id');
		$.ajax({
			type: 'POST',
			url: '{{ route("admin.broadcasts.updateStatus", ["id" => ":id"]) }}'.replace(':id', messageId),
			data: {
				_token: '{{ csrf_token() }}',
				_method: 'PUT',
			},
			success: function(response) {
				Swal.fire(
                    {
                        position: "top-end",
						icon: "success",
                        title: "Status berhasil diperbarui",
                        showConfirmButton: false,
                        timer: 1500
                    });
				console.log(response.message);
			},
			error: function(error) {
				Swal.fire(
                    {
                        position: "top-end",
						icon: "error",
                        title: "Status gagal diperbarui",
                        showConfirmButton: false,
                        timer: 1500
                    });
				console.error('Error updating status:', error);
			}
		});
	}
</script>


@endsection
