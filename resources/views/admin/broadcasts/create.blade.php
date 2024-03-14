@extends('layouts.admin')
@section('content')
{{-- @include('partials.breadcrumb') --}}
@include('partials.subheader')
@include('partials.sysalert')
<div class="row">
	<div class="col-12">
		<div class="panel" id="panel-1">
			<div class="panel-container show">
				<form method="POST" action="{{route('admin.broadcasts.store')}}" enctype="multipart/form-data">
					@csrf
					<div class="panel-content">
						<div class="row d-flex justify-content between align-items-center">
							<div class="col-md mb-3">
								<div class="form-group">
									<label class="form-label" for="title">Judul Pengumuman</label>
									<input type="text" class="form-control" id="title" name="title" value="{{ old('title') }}" required>
									<span class="help-block text-muted">Judul Pengumuman, contoh: PENGAJUAN SKL</span>
								</div>
							</div>
							<div class="col-md-12 mb-3">
								<div class="form-group">
									<label class="form-label" for="messages">Isi Pengumuman</label>
									<textarea type="text" class="form-control " id="messages" name="messages" placeholder="messages" required>{{ old('messages') }}</textarea>
									<span class="help-block text-muted">Isi pesan/pengumuman untuk disampaikan.</span>
								</div>
							</div>
							<div class="col-md-6 mb-3">
								<div class="form-group">
									<label class="form-label" for="target">Untuk</label>
									<select class="form-control form-control-sm" name="target" id="target">
										<option value="">-- pilih target pengguna</option>
										<option value="0">Semua Pengguna</option>
										<option value="1">Administrator</option>
										<option value="2">Pelaku Usaha</option>
										<option value="3">Verifikator</option>
									</select>
									<span class="help-block">Kepada siapa pengumuman ini akan ditampilkan.</span>
								</div>
							</div>
							<div class="col-md-6 mb-3">
								<div class="form-group">
									<label class="form-label" for="target">Sifat</label>
									<select class="form-control form-control-sm" name="type" id="type">
										<option value="">-- pilih jenis pengumuman</option>
										<option value="info">Biasa</option>
										<option value="warning">Penting</option>
										<option value="danger">Sangat Penting</option>
									</select>
									<span class="help-block">Sifat Pengumuman.</span>
								</div>
							</div>
						</div>
					</div>
					<div class="card-footer">
						<div class="d-flex justify-content-end align-itmes-center">
							<div></div>
							<div>
								<a href="{{route('admin.broadcasts.index')}}" class="btn btn-sm btn-default">Kembali</a>
								<button class="btn btn-primary btn-sm" role="button" type="submit">
									<i class="fal fa-save"></i>
									Simpan
								</button>
							</div>
						</div>
					</div>
                </form>
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
