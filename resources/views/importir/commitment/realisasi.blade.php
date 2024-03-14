@extends('layouts.admin')
@section('content')
{{-- @include('partials.breadcrumb') --}}
@include('partials.subheader')
@can('commitment_show')
@include('partials.sysalert')
    {{-- {{ dd($data_poktan) }} --}}
	<ul class="nav nav-tabs" role="tablist">
		<li class="nav-item">
			<a class="nav-link active" data-toggle="tab" href="#panel-5" role="tab" aria-selected="true">Realisasi Perjanjian Kerjasama/PKS</a>
		</li>
		<li class="nav-item">
			<a class="nav-link" data-toggle="tab" href="#panel-6" role="tab" aria-selected="true">Unggah Berkas (wajib)</a>
		</li>
	</ul>
	<div class="tab-content">
		<div class="tab-pane fade active show" id="panel-5" role="tabpanel" aria-labelledby="panel-5">
			<div class="row mb-3">
				<div class="col-12">
					<div class="panel-tag fade show bg-white border-info text-info m-0 l-h-m-n">
						<div class="d-flex align-items-center">
							<i class="fas fa-info-circle mr-1"></i>
							<div class="flex-1">
								<small><span class="mr-1 fw-500">INFORMASI!</span>Anda dapat mengisi data Realisasi Komitmen Tanam dan Produksi setelah melengkapi data Perjanjian Kerjasama.</small>
							</div>
							<a href="{{route('admin.task.commitment')}}" class="btn btn-info btn-xs btn-w-m waves-effect waves-themed">Kembali</a>
						</div>
					</div>
				</div>
			</div>
			<div class="panel" id="panel-5">
				<div class="panel-container show">
					<div class="panel-content">
						<table id="tblPks" class="table table-sm table-bordered table-hover table-striped w-100">
							<thead>
								<tr>
									<th>No. Perjanjian</th>
									<th>Poktan Mitra</th>
									<th>Anggota</th>
									<th>Luas Lahan</th>
									<th>Tindakan</th>
								</tr>
							</thead>
							<tbody>
								@foreach ($pkss as $pks)
									<tr>
										<td>{{$pks->no_perjanjian}}</td>
										<td>{{$pks->masterpoktan->nama_kelompok}}</td>
										<td class="text-right">{{$pks->lokasi_count}} org</td>
										<td class="text-right">
											{{$pks->lokasi_sum_luas_lahan}} ha
										</td>
										<td>
											@if (empty($pks->tgl_perjanjian_start || $pks->tgl_perjanjian_end || $pks->varietas_tanam || $pks->berkas_pks))
												<button type="button" class="btn btn-icon btn-xs btn-danger" data-toggle="modal" data-target="#modalId{{ $pks->id }}"><i class="fal fa-cassette-tape" data-toggle="tooltip" data-original-title="Lengkapi data"></i></button>
											@else
												<button type="button" class="btn btn-icon btn-xs btn-success" data-toggle="modal" data-target="#modalId{{ $pks->id }}"><i class="fal fa-file-check" data-toggle="tooltip" data-original-title="Data PKS lengkap. Klik jika ingin mengubah data"></i></button>
												<a href="{{route('admin.task.pks.anggotas', $pks->id)}}" class="btn btn-icon btn-xs btn-primary" data-toggle="tooltip" data-original-title="Lengkapi data realisasi Komitmen Wajib Tanam-produksi">
													<i class="fal fa-seedling"></i>
												</a>
											@endif
											{{-- @php
												$emptyColumns = collect($pks->getAttributes())->except([
													'pengajuan_id','docstatus','status','note','verif_at','verif_by',
													'jumlah_anggota','provinsi_id','kabupaten_id','kecamatan_id',
													'kelurahan_id','created_at', 'updated_at', 'deleted_at'
													])->filter(function($value) {
													return empty($value);
												});

												if ($emptyColumns->count() > 0) {
													echo '
													<button type="button" class="btn btn-icon btn-xs btn-danger" data-toggle="modal" data-target="#modalId' . $pks->id . '"><i class="fal fa-cassette-tape" data-toggle="tooltip" data-original-title="Lengkapi data"></i></button>';
												} else {
													echo '
													<button type="button" class="btn btn-icon btn-xs btn-success" data-toggle="modal" data-target="#modalId' . $pks->id . '"><i class="fal fa-file-check" data-toggle="tooltip" data-original-title="Data PKS lengkap. Klik jika ingin mengubah data"></i></button>
													<a href="'.route('admin.task.pks.anggotas', $pks->id).'" class="btn btn-icon btn-xs btn-primary" data-toggle="tooltip" data-original-title="Lengkapi data realisasi Komitmen Wajib Tanam-produksi">
														<i class="fal fa-seedling"></i>
													</a>
													';
												}
											@endphp --}}
										</td>
										<div class="modal fade" id="modalId{{ $pks->id }}" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
											<div class="modal-dialog modal-dialog-right" role="document">
												<div class="modal-content">
													<div class="modal-header">
														<span class="modal-title">
															<h4 class="fw-500">Data PKS</h4>
															<span>Data Perjanjian Kerjasama dengan Mitra Kelompok Tani</span>
														</span>
														<button type="button" class="close" data-dismiss="modal" aria-label="Close">
															<span aria-hidden="true">&times;</span>
														</button>
													</div>
													<form action=" {{route('admin.task.pks.update', $pks->id)}} " method="POST" enctype="multipart/form-data">
														@csrf
														@method('PUT')
														<div class="modal-body">
															<div class="row d-flex">
																<div class="col-md-12 mb-3">
																	<label class="form-label">Unggah Berkas PKS (Perjanjian Kerjasama)</label>
																	<div class="input-group">
																		<div class="input-group-prepend">
																			<a href="">
																			<span class="input-group-text" id="inputGroupPrepend3">PKS</span>
																			</a>
																		</div>
																		<div class="custom-file">
																			<input type="file" accept=".pdf" class="custom-file-input" id="berkas_pks" name="berkas_pks"
																			value="{{old('berkas_pks', $pks->berkas_pks)}}">
																			<label class="custom-file-label" for="berkas_pks">
																				{{ $pks->berkas_pks ? $pks->berkas_pks : 'Pilih file...' }}
																			</label>
																		</div>
																	</div>
																	<span class="help-block">
																		@php
																			$npwp = str_replace(['.', '-'], '', $npwp);
																		@endphp
																		@if($pks->berkas_pks)
																			<a href="{{ asset('storage/uploads/'.$npwp.'/'.$commitment->periodetahun.'/'.$pks->berkas_pks) }}" target="_blank">
																				Lihat berkas yang telah diunggah
																			</a>
																		@else
																		Unggah hasil pindai berkas Perjanjian dalam bentuk pdf, max 2Mb.
																		@endif
																	</span>
																</div>
																<div class="col-md-12 mb-3">
																	<div class="form-group">
																		<label class="form-label" for="no_perjanjian">Nomor Perjanjian</label>
																		<div class="input-group">
																			<div class="input-group-prepend">
																				<span class="input-group-text" id="no_perjanjian">123</span>
																			</div>
																			<input type="text" class="form-control " id="no_perjanjian" name="no_perjanjian"
																				value="{{old('no_perjanjian', $pks->no_perjanjian)}}"
																				required>
																		</div>
																		<div class="help-block">
																			Nomor Pejanjian Kerjasama dengan Poktan Mitra.
																		</div>
																	</div>
																</div>
																<div class="col-md-6 mb-3">
																	<div class="form-group">
																		<label class="form-label">Tanggal perjanjian</label>
																		<div class="input-daterange input-group" id="tgl_perjanjian_start" name="tgl_perjanjian_start">
																			<div class="input-group-prepend">
																				<span class="input-group-text"><i class="fal fa-calendar-day"></i></span>
																			</div>
																			<input type="date" name="tgl_perjanjian_start" id="tgl_perjanjian_start"
																				class="form-control " placeholder="tanggal mulai perjanjian"
																				value="{{old('tgl_perjanjian_start', $pks->tgl_perjanjian_start)}}" required
																				aria-describedby="helpId">
																		</div>
																		<div class="help-block">
																			Pilih Tanggal perjanjian ditandatangani.
																		</div>
																	</div>
																</div>
																<div class="col-md-6 mb-3">
																	<div class="form-group">
																		<label class="form-label">Tanggal berakhir perjanjian</label>
																		<div class="input-daterange input-group" id="tgl_perjanjian_end" name="tgl_perjanjian_end">
																			<div class="input-group-prepend">
																				<span class="input-group-text"><i class="fal fa-calendar-day"></i></span>
																			</div>
																			<input type="date" name="tgl_perjanjian_end" id="tgl_perjanjian_end"
																				class="form-control " placeholder="tanggal akhir perjanjian"
																				value="{{old('tgl_perjanjian_end', $pks->tgl_perjanjian_end)}}" required
																				aria-describedby="helpId">
																		</div>
																		<div class="help-block">
																			Pilih Tanggal berakhirnya perjanjian.
																		</div>
																	</div>
																</div>
																<div class="col-md-12 mb-3" hidden>
																	<div class="form-group">
																		<label class="form-label" for="simpleinputInvalid">Luas Rencana (ha)</label>
																		<div class="input-group">
																			<div class="input-group-prepend">
																				<span class="input-group-text" id="inputGroupPrepend3"><i class="fal fa-ruler"></i></span>
																			</div>
																			<input type="" class="form-control " name="luas_rencana" id="luas_rencana"
																				value="{{old('luas_rencana', $pks->sum_luaslahan)}}" step="0.01" readonly>
																		</div>
																		<div class="help-block">
																			Jumlah Luas total sesuai dokumen perjanjian.
																		</div>
																	</div>
																</div>
																<div class="col-md-12 mb-3">
																	<div class="form-group">
																		<label class="form-label" for="varietas_tanam">Varietas Tanam</label>
																		<div class="input-group">
																			<select class="form-control custom-select" name="varietas_tanam" id="select2-varietas" required>
																				<option value="" hidden></option>
																				@foreach($varietass as $varietas)
																					<option value="{{ $varietas->id }}"{{ old('varietas_tanam', $pks->varietas_tanam) == $varietas->id ? ' selected' : '' }}>
																						{{ $varietas->nama_varietas }}
																					</option>
																				@endforeach
																			</select>
																		</div>
																		<div class="help-block">
																			Varietas ditanam sesuai dokumen perjanjian.
																		</div>
																	</div>
																</div>
																<div class="col-md-12 mb-3">
																	<div class="form-group">
																		<label class="form-label" for="periode">Periode Tanam</label>
																		<div class="input-group">
																			<div class="input-group-prepend">
																				<span class="input-group-text" id=""><i class="fal fa-calendar-week"></i></span>
																			</div>
																			<input type="text" name="periode_tanam" id="periode_tanam"
																				class="form-control " placeholder="misal: Jan-Feb" aria-describedby="helpId"
																				value="{{old('periode_tanam', $pks->periode_tanam)}}" required>
																		</div>
																		<div class="help-block">
																			Periode tanam sesuai dokumen perjanjian.
																		</div>
																	</div>
																</div>
															</div>
														</div>
														<div class="modal-footer">
															<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
															<button class="btn btn-primary btn-sm" type="submit"
																@if ($disabled) disabled @endif>
																<i class="fal fa-save mr-1"></i>Simpan
															</button>
														</div>
													</form>
												</div>
											</div>
										</div>
									</tr>
								@endforeach
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
		<div class="tab-pane fade" id="panel-6" role="tabpanel" aria-labelledby="panel-6">
			<form action="{{route('admin.task.commitment.realisasi.storeUserDocs', $commitment->id)}}" method="post" enctype="multipart/form-data" id="docsUpload">
					@csrf
				<div class="row mb-3">
					<div class="col-12">
						<div class="panel-tag fade show bg-white border-danger m-0 l-h-m-n">
							<div class="d-flex align-items-center">
								<i class="fas fa-exclamation-circle mr-1 text-danger"></i>
								<div class="flex-1 text-danger">
									<small><span class="mr-1 fw-700">PERHATIAN!</span>Seluruh Dokumen Tanam & Produksi harus diunggah sebelum <span class="fw-700 text-uppercase">Pengajuan Surat Keterangan Lunas</span> dilakukan.</small>
								</div>
								<a href="{{route('admin.task.commitment')}}" class="mr-1 btn btn-info btn-xs btn-w-m waves-effect waves-themed">Kembali</a>
								<!-- Button trigger modal -->
								<button type="button" class="btn btn-danger btn-xs" data-toggle="modal" data-target="#modelId">
									Perlu Bantuan ?
								</button>
							</div>
						</div>
					</div>
				</div>
				<!-- Modal -->
				<div class="modal fade" id="modelId" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
					<div class="modal-dialog modal-lg modal-dialog-centered" role="document">
						<div class="modal-content">
							<div class="modal-header">
								<h5 class="modal-title">Berkas Unggahan</h5>
								<button type="button" class="close" data-dismiss="modal" aria-label="Close">
									<span aria-hidden="true">&times;</span>
								</button>
							</div>
							<div class="modal-body">
								<div class="row d-flex align-items-top justify-content-between">
									<div class="col-lg-6">
										<ul>Jika Anda menemui kendala dalam mengunggah berkas
											<li>Periksa Spesifikasi Berkas
												<ul>
													<li>Pastikan jenis/ekstensi berkas telah sesuai.</li>
													<li>Pastikan ukuran setiap berkas tidak melebihi 2 megabytes (Mb).</li>
												</ul>
											</li>
											<li>Cara mengunggah
												<ul>
													<li>Cobalah untuk mengunggah berkas satu persatu. Form ini hanya dapat menerima jumlah total ukuran berkas diunggah tidak lebih dari 8 megabytes (akumulasi seluruh berkas)</li>
												</ul>
											</li>
										</ul>
									</div>
									<div class="col-lg-6">
										<ul>Keterangan Berkas
											<li>
												Logbook
												<ul>
													<li>Logbook Tanam adalah Salinan lembar pencatatan oleh petani sejak tanam.</li>
													<li>Logbook Produksi adalah Salinan lembar pencatatan oleh petani sejak tanam hingga Produksi.</li>
													<li>Untuk Logbook, Anda tidak perlu mengunggah seluruh halaman/salinan, cukup lembar rekapitulasi (tanam atau produksi). Pastikan Anda menyimpan Salinan Asli (hard copy) saat dilakukan pemeriksaan/verifikasi.</li>
												</ul>
											</li>
											<li>
												Surat Pengajuan Verifikasi
												<ul>
												<li>Tanam: Unggah jika Anda ingin mengajukan Pemeriksaan/Verifikasi Tanam oleh Petugas Verifikator.</li>
												<li>Produksi: Unggah jika Anda ingin mengajukan Pemeriksaan/Verifikasi Produksi oleh Petugas Verifikator.</li>
											</li>
										</ul>
									</div>
								</div>
							</div>
							<div class="modal-footer">
								<button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
							</div>
						</div>
					</div>
				</div>
				<div class="card-deck">
					<div class="card" id="panel-6-a">
						<div class="panel-hdr">
							<h2>Dokumen Realisasi Tanam</h2>
						</div>
						<div class="card-body">
							<div class="panel-tag fade show">
								<div class="d-flex align-items-top">
									<i class="fal fa-info-circle mr-1"></i>
									<div class="flex-1">
										<small>
											Berkas-berkas yang diperlukan terkait dengan Verifikasi Tanam. Lengkapi dan unggah dokumen berikut sebelum Anda mengajukan Verifikasi Tanam. <br>
										</small>
									</div>
								</div>
							</div>
							<div class="form-group row">
								<label class="col-sm-3 col-form-label" for="sptjmtanam">Form SPTJM (tanam)</label>
								<div class="col-sm-9">
									<div class="custom-file input-group">
										<input type="file" accept=".pdf" class="custom-file-input" name="sptjmtanam" id="sptjmtanam" value="{{ old('sptjmtanam', optional($docs)->sptjmtanam) }}">
										<label class="custom-file-label" for="sptjmtanam">{{ $docs ? ($docs->sptjmtanam ? $docs->sptjmtanam : 'Pilih berkas...') : 'Pilih berkas...' }}</label>
									</div>
									<span class="help-block">
										@if($docs && $docs->sptjmtanam)
											<a href="{{ asset('storage/uploads/'.$npwp.'/'.$commitment->periodetahun.'/'.$docs->sptjmtanam) }}" target="_blank">
												Lihat Dokumen diunggah.
											</a>
										@else
											<span class="text-info"><i class="fa fa-info-circle mr-1"></i>Surat Pertanggungjawaban Mutlak Realisasi Komitmen Wajib Tanam.  Pdf, max 2Mb</span>
										@endif
									</span>
								</div>
							</div>
							<div class="form-group row">
								<label class="col-sm-3 col-form-label" for="rta">Form RTA</label>
								<div class="col-sm-9">
									<div class="custom-file input-group">
										<input type="file" accept=".pdf" class="custom-file-input" name="rta" id="rta" value="{{ old('rta', optional($docs)->rta) }}">
										<label class="custom-file-label" for="rta">{{ $docs ? ($docs->rta ? $docs->rta : 'Pilih berkas...') : 'Pilih berkas...' }}</label>
									</div>
									<span class="help-block">
										@if($docs && $docs->rta)
											<a href="{{ asset('storage/uploads/'.$npwp.'/'.$commitment->periodetahun.'/'.$docs->rta) }}" target="_blank">
												Lihat Dokumen diunggah.
											</a>
										@else
										<span class="text-info"><i class="fa fa-info-circle mr-1"></i>Form Laporan Realisasi Tanam (Form RTA).  Pdf, max 2Mb.</span>
										@endif
									</span>
								</div>
							</div>
							<div class="form-group row">
								<label class="col-sm-3 col-form-label" for="sphtanam">SPH-SBS Tanam</label>
								<div class="col-sm-9">
									<div class="custom-file input-group">
										<input type="file" accept=".pdf" class="custom-file-input" name="sphtanam" id="sphtanam" value="{{ old('sphtanam', optional($docs)->sphtanam) }}">
										<label class="custom-file-label" for="sphtanam">{{ $docs ? ($docs->sphtanam ? $docs->sphtanam : 'Pilih berkas...') : 'Pilih berkas...' }}</label>
									</div>
									<span class="help-block">
										@if($docs && $docs->sphtanam)
											<a href="{{ asset('storage/uploads/'.$npwp.'/'.$commitment->periodetahun.'/'.$docs->sphtanam) }}" target="_blank">
												Lihat Dokumen diunggah.
											</a>
										@else
										<span class="text-info"><i class="fa fa-info-circle mr-1"></i>Form SPH-SBS Tanam dari Petugas Data Kecamatan Setempat. Pdf, max 2Mb.</span>
										@endif
									</span>
								</div>
							</div>
							<div class="form-group row">
								<label class="col-sm-3 col-form-label" for="logbooktanam">Logbook Tanam</label>
								<div class="col-sm-9">
									<div class="custom-file input-group">
										<input type="file" accept=".pdf" class="custom-file-input" name="logbooktanam" id="logbooktanam" value="{{ old('logbooktanam', optional($docs)->logbooktanam) }}">
										<label class="custom-file-label" for="logbooktanam">{{ $docs ? ($docs->logbooktanam ? $docs->logbooktanam : 'Pilih berkas...') : 'Pilih berkas...' }}</label>
									</div>
									<span class="help-block">
										@if($docs && $docs->logbooktanam)
											<a href="{{ asset('storage/uploads/'.$npwp.'/'.$commitment->periodetahun.'/'.$docs->logbooktanam) }}" target="_blank">
												Lihat Dokumen diunggah.
											</a>
										@else
										<span class="text-info"><i class="fa fa-info-circle mr-1"></i>Logbook Tanam. Pdf, max 2Mb.</span>
										@endif
									</span>
								</div>
							</div><hr>
							<div class="panel-tag fade show">
								<div class="d-flex align-items-top">
									<i class="fal fa-info-circle mr-1"></i>
									<div class="flex-1">
										<small>
											Unggah berkas berikut jika Anda telah mengunggah seluruh berkas di atas dan ingin mengajukan verifikasi tanam. <br>
										</small>
									</div>
								</div>
							</div>
							<div class="form-group row">
								<label class="col-sm-3 col-form-label" for="spvt">Pengajuan Verifikasi Tanam</label>
								<div class="col-sm-9">
									<div class="custom-file input-group">
										<input type="file" accept=".pdf" class="custom-file-input" name="spvt" id="spvt" value="{{ old('spvt', optional($docs)->spvt) }}">
										<label class="custom-file-label" for="spvt">{{ $docs ? ($docs->spvt ? $docs->spvt : 'Pilih berkas...') : 'Pilih berkas...' }}</label>
									</div>
									<span class="help-block">
										@if($docs && $docs->spvt)
											<a href="{{ asset('storage/uploads/'.$npwp.'/'.$commitment->periodetahun.'/'.$docs->spvt) }}" target="_blank">
												Lihat Dokumen diunggah.
											</a>
										@else
											<span class="text-info"><i class="fa fa-info-circle mr-1"></i>Surat Pengajuan Verifikasi Tanam. Pdf, max 2Mb.</span>
										@endif
									</span>
								</div>
							</div>
						</div>
						<div class="card-footer d-flex">
							<div class="col-md-6 text-right ml-auto">
								<button class="btn btn-primary btn-sm waves-effect waves-themed" type="submit">
									<i class="fal fa-cloud-upload mr-1"></i>Unggah Berkas Tanam
								</button>
							</div>
						</div>
					</div>

					<div class="card" id="panel-6-b">
						<div class="panel-hdr">
							<h2>Dokumen Realisasi Produksi</h2>
						</div>
						<div class="card-body">
							<div class="panel-tag fade show">
								<div class="d-flex align-items-top">
									<i class="fal fa-info-circle mr-1"></i>
									<div class="flex-1">
										<small>Berkas-berkas yang diperlukan terkait dengan Verifikasi Produksi. Lengkapi dan unggah dokumen berikut sebelum Anda mengajukan Verifikasi Produksi.</small>
									</div>
								</div>
							</div>
							<div class="form-group row">
								<label class="col-sm-3 col-form-label" for="sptjmproduksi">Form SPTJM (produksi)</label>
								<div class="col-sm-9">
									<div class="custom-file input-group">
										<input type="file" accept=".pdf" class="custom-file-input" name="sptjmproduksi" id="sptjmproduksi" value="{{ old('sptjmproduksi', optional($docs)->sptjmproduksi) }}">
										<label class="custom-file-label" for="sptjmproduksi">{{ $docs ? ($docs->sptjmproduksi ? $docs->sptjmproduksi : 'Pilih berkas...') : 'Pilih berkas...' }}</label>
									</div>
									<span class="help-block">
										@if($docs && $docs->sptjmproduksi)
											<a href="{{ asset('storage/uploads/'.$npwp.'/'.$commitment->periodetahun.'/'.$docs->sptjmproduksi) }}" target="_blank">
												Lihat Dokumen diunggah.
											</a>
										@else
											<span class="text-info"><i class="fa fa-info-circle mr-1"></i>Surat Pertanggungjawaban Mutlak Realisasi Komitmen Wajib Prouksi. Pdf, max 2Mb.</span>
										@endif
									</span>
								</div>
							</div>
							<div class="form-group row">
								<label class="col-sm-3 col-form-label" for="rpo">Form RPO</label>
								<div class="col-sm-9">
									<div class="custom-file input-group">
										<input type="file" accept=".pdf" class="custom-file-input" name="rpo" id="rpo" value="{{ old('rpo', optional($docs)->rpo) }}">
										<label class="custom-file-label" for="rpo">{{ $docs ? ($docs->rpo ? $docs->rpo : 'Pilih berkas...') : 'Pilih berkas...' }}</label>
									</div>
									<span class="help-block">
										@if($docs && $docs->rpo)
											<a href="{{ asset('storage/uploads/'.$npwp.'/'.$commitment->periodetahun.'/'.$docs->rpo) }}" target="_blank">
												Lihat Dokumen diunggah.
											</a>
										@else
										<span class="text-info"><i class="fa fa-info-circle mr-1"></i>Form laporan realisasi produksi (Form RPO). Pdf, max 2Mb.</small>
										@endif
									</span>
								</div>
							</div>
							<div class="form-group row">
								<label class="col-sm-3 col-form-label" for="sphproduksi">SPH-SBS Produksi</label>
								<div class="col-sm-9">
									<div class="custom-file input-group">
										<input type="file" accept=".pdf" class="custom-file-input" name="sphproduksi" id="sphproduksi" value="{{ old('sphproduksi', optional($docs)->sphproduksi) }}">
										<label class="custom-file-label" for="sphproduksi">{{ $docs ? ($docs->sphproduksi ? $docs->sphproduksi : 'Pilih berkas...') : 'Pilih berkas...' }}</label>
									</div>
									<span class="help-block">
										@if($docs && $docs->sphproduksi)
											<a href="{{ asset('storage/uploads/'.$npwp.'/'.$commitment->periodetahun.'/'.$docs->sphproduksi) }}" target="_blank">
												Lihat Dokumen diunggah.
											</a>
										@else
										<span class="text-info"><i class="fa fa-info-circle mr-1"></i>Form SPH-SBS Tanam sampai produksi dari Petugas Data Kecamatan Setempat. Pdf, max 2Mb.</span>
										@endif
									</span>
								</div>
							</div>
							<div class="form-group row">
								<label class="col-sm-3 col-form-label" for="logbookproduksi">LogBook</label>
								<div class="col-sm-9">
									<div class="custom-file input-group">
										<input type="file" accept=".pdf" class="custom-file-input" name="logbookproduksi" id="logbookproduksi" value="{{ old('logbookproduksi', optional($docs)->logbookproduksi) }}">
										<label class="custom-file-label" for="logbookproduksi">{{ $docs ? ($docs->logbookproduksi ? $docs->logbookproduksi : 'Pilih berkas...') : 'Pilih berkas...' }}</label>
									</div>
									<span class="help-block">
										@if($docs && $docs->logbookproduksi)
											<a href="{{ asset('storage/uploads/'.$npwp.'/'.$commitment->periodetahun.'/'.$docs->logbookproduksi) }}" target="_blank">
												Lihat Dokumen diunggah.
											</a>
										@else
											<span class="text-info"><i class="fa fa-info-circle mr-1"></i>Salinan lembar pencatatan oleh petani sejak tanam hingga produksi. Pdf, max 2Mb.</small>
										@endif
									</span>
								</div>
							</div>
							<div class="form-group row">
								<label class="col-sm-3 col-form-label" for="formLa">Form LA</label>
								<div class="col-sm-9">
									<div class="custom-file input-group">
										<input type="file" accept=".pdf" class="custom-file-input" name="formLa" id="formLa" value="{{ old('formLa', optional($docs)->formLa) }}">
										<label class="custom-file-label" for="formLa">{{ $docs ? ($docs->formLa ? $docs->formLa : 'Pilih berkas...') : 'Pilih berkas...' }}</label>
									</div>
									<span class="help-block">
										@if($docs && $docs->formLa)
											<a href="{{ asset('storage/uploads/'.$npwp.'/'.$commitment->periodetahun.'/'.$docs->formLa) }}" target="_blank">
												Lihat Dokumen diunggah.
											</a>
										@else
											<span class="text-info"><i class="fa fa-info-circle mr-1"></i>Form Laporan Akhir Realisasi Komitmen Wajib Tanam-Produksi. Pdf, max 2Mb.</span>
										@endif
									</span>
								</div>
							</div><hr>
							<div class="panel-tag fade show">
								<div class="d-flex align-items-top">
									<i class="fal fa-info-circle mr-1"></i>
									<div class="flex-1">
										<small>Unggah berkas berikut jika Anda telah mengunggah seluruh berkas di atas dan ingin mengajukan verifikasi produksi.</small>
									</div>
								</div>
							</div>
							<div class="form-group row">
								<label class="col-sm-3 col-form-label" for="spvp">Pengajuan Verifikasi Produksi</label>
								<div class="col-sm-9">
									<div class="custom-file input-group">
										<input type="file" accept=".pdf" accept=".pdf" class="custom-file-input" name="spvp" id="spvp" value="{{ old('spvp', optional($docs)->spvp) }}">
										<label class="custom-file-label" for="spvp">{{ $docs ? ($docs->spvp ? $docs->spvp : 'Pilih berkas...') : 'Pilih berkas...' }}</label>
									</div>
									<span class="help-block">
										@if($docs && $docs->spvp)
											<a href="{{ asset('storage/uploads/'.$npwp.'/'.$commitment->periodetahun.'/'.$docs->spvp) }}" target="_blank">
												Lihat Dokumen diunggah.
											</a>
										@else
											<span class="text-info"><i class="fa fa-info-circle mr-1"></i>Surat Pengajuan Verifikasi Produksi. Pdf, max 2Mb.</span>
										@endif
									</span>
								</div>
							</div>
						</div>
						<div class="card-footer d-flex">
							<div class="col-md-6 text-right ml-auto">
								<button class="btn btn-primary btn-sm waves-effect waves-themed" type="submit">
									<i class="fal fa-cloud-upload mr-1"></i>Unggah Berkas Produksi
								</button>
							</div>
						</div>
					</div>
				</div>
			</form>
		</div>
	</div>
@endcan

@endsection

<!-- start script for this page -->
@section('scripts')
@parent

<script>
	$(document).ready(function()
	{
		$('#tblPks').dataTable(
		{
			responsive: true,
			lengthChange: false,
			dom:
				"<'row mb-3'<'col-sm-12 col-md-6 d-flex align-items-center justify-content-start'f><'col-sm-12 col-md-6 d-flex align-items-center justify-content-end'lB>>" +
				"<'row'<'col-sm-12'tr>>" +
				"<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",
			buttons: [
				{
					extend: 'pdfHtml5',
					text: '<i class="fa fa-file-pdf"></i>',
					titleAttr: 'Generate PDF',
					className: 'btn-outline-danger btn-sm btn-icon mr-1'
				},
				{
					extend: 'excelHtml5',
					text: '<i class="fa fa-file-excel"></i>',
					titleAttr: 'Generate Excel',
					className: 'btn-outline-success btn-sm btn-icon mr-1'
				},
				{
					extend: 'print',
					text: '<i class="fa fa-print"></i>',
					titleAttr: 'Print Table',
					className: 'btn-outline-primary btn-sm btn-icon mr-1'
				}
			]
		});
	});
</script>
@endsection
