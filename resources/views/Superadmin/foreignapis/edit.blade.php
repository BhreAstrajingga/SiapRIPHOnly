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
					Google Map API's
				</h2>
				<div class="panel-toolbar">
					@include('partials.globaltoolbar')
				</div>
			</div>
			<div class="panel-container show">
				<form method="POST" action="{{ route('sroot.gmapapi.update')}}"
					enctype="multipart/form-data">
					@csrf
					@method('PUT')
					<div class="panel-content">
						<div class="row d-flex justify-content between align-items-center">
							<div class="col-lg-4 mb-3">
								<div class="form-group">
									<label class="form-label" for="nama_lembaga">Provider</label>
									<div class="input-group">
										<div class="input-group-prepend">
											<span class="input-group-text" id="nama_lembaga"><i class="fal fa-registered"></i></span>
										</div>
										<input type="text" class="form-control" id="provider" name="provider" value="{{ old('provider', $key->provider) }}" disabled>
									</div>
									<div class="help-block">
										Penyedia Layanan
									</div>
								</div>
							</div>
							<div class="col-lg-5 mb-3">
								<div class="form-group">
									<label class="form-label" for="nama_pimpinan">API Key</label>
									<div class="input-group">
										<div class="input-group-prepend">
											<span class="input-group-text" id="key"><i class="fal fa-key"></i></span>
										</div>
										<input type="text" class="form-control " id="apikey" name="apikey" placeholder="kunci layanan" value="{{ old('key', $key->key) }}" required>
									</div>
									<div class="help-block">
										Kunci Layanan
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="card-footer">
						<div class="d-flex justify-content-end align-itmes-center">
							<div></div>
							<div>
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
