@extends('layouts.skl')
@section ('styles')
<link rel="stylesheet" media="screen, print" href="{{asset('/css/smartadmin/page-invoice.css')}}">
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>
@endsection
@section('content')
{{-- @include('partials.breadcrumb') --}}
<div class="subheader d-print-none">
	<h1 class="subheader-title">
		<i class="subheader-icon {{ ($heading_class ?? '') }}"></i> {{  ($page_heading ?? '') }} <span class="fw-300"></span>
		<small>
			Surat Keterangan Lunas diterbitkan
		</small>
	</h1>
	<div class="subheader-block d-lg-flex align-items-center">
		<div class="form-group">
			<label class="form-label" for="provinsi"></label>
			<div class="input-group">
				<button onclick="printPage()" class="btn btn-sm btn-primary btn-sm">
					<i class="fal fa-print mr-1"></i> Cetak SKL
				</button>
			</div>
		</div>
	</div>
</div>
<div class="container" style="background-color: white !important;">
	<div data-size="A4">
		<div class="row">
			<div class="col-sm-12 mb-5">
				<img src="{{asset('/img/kopsto.png')}}" width="100%">
				<div class="d-flex align-items-center mb-3">
					<img class="mr-2" src="{{asset('/img/favicon.png')}}" alt="Simethris" aria-roledescription="logo" style="width: 100px">
					<div class="keep-print-font mb-0 flex-1 position-relative">
						<h5 class="keep-print-font text-center fw-500 mb-0">KEMENTERIAN PERTANIAN</h5>
						<h3 class="keep-print-font text-center fw-500 mb-0">DIREKTORAT JENDERAL HORTIKULTURA</h3>
						<h1 class="fw-500 keep-print-font l-h-n m-0 text-center mb-2">DIREKTORAT SAYURAN DAN TANAMAN OBAT</h1>
						<h6 class="keep-print-font l-h-n m-0 text-center fs-md mb-2">
							Jalan AUP No. 3 Pasar Minggu - Jakarta Selatan 12520
						</h6>
						<h6 class="keep-print-font l-h-n m-0 text-center fs-sm">
								<span class="keep-print-font mr-2">TELP/FAX (021) 780665 - 7817611 |</span>
								<span class="keep-print-font mr-2">EMAIL: ditsayurobat@pertanian.go.id |</span>
								<span class="keep-print-font">WEBSITE http://ditsayur.hortikultura.pertanian.go.id</span>
						</h6>
					</div>
				</div>
				<img src="{{asset('/img/border.png')}}" width="100%" height="7px">
			</div>
		</div>
		<div class="row mb-5">
			<div class="col-sm-6 d-flex">
				<div class="table-responsive">
					<table class="table table-clean table-sm align-self-end">
						<tbody>
							<tr>
								<td>
									<strong>Nomor</strong>
								</td>
								<td>
									<span class="mr-1">: {{$skl->no_skl}}</span>
								</td>
							</tr>
							<tr>
								<td>
									<strong>Lampiran</strong>
								</td>
								<td>
									: -
								</td>
							</tr>
							<tr>
								<td>
									<strong>Hal</strong>
								</td>
								<td>
									: Keterangan Telah Melaksanakan Wajib Tanam dan Wajib Produksi
								</td>
							</tr>
						</tbody>
					</table>
				</div>
			</div>
			<div class="col-sm-6 ml-sm-auto">
				<div class="table-responsive">
					<table class="table table-sm table-clean text-right">
						<tbody>
							<tr>
								<td>
									<strong>{{ date('d F Y', strtotime($skl->published_date)) }}</strong>
								</td>
							</tr>
						</tbody>
					</table>
				</div>
			</div>
		</div>
		<div class="row fs-xl">
			<div class="col-sm-12">
				Kepada Yth.<br>
				Pimpinan<br>
				<strong>
					<span class="keep-print-font">{{$commitment->datauser->company_name}}</span>
				</strong><br>
				di<br>
				Tempat<br>
				<p class="justify-align-stretch mt-5">
					Berdasarkan hasil evaluasi dan validasi laporan realisasi tanam dan produksi, dengan ini kami menyatakan:
				</p>
			</div>
			<div class="col-12">
				<dl class="row">
					<dd class="col-sm-3">Nama Perusahaan</dd>
					<dt class="col-sm-9">: {{$commitment->user->data_user->company_name}}</dt>
					<dd class="col-sm-3">Nomor RIPH</dd>
					<dt class="col-sm-9">: {{$commitment->no_ijin}}</dt>
					<dd class="col-sm-3">Wajib Tanam</dd>
					<dt class="col-sm-9">
						<dl class="row">
							<dd class="col-sm-3">Komitmen</dd>
							<dt class="col-sm-9">: {{ number_format($commitment->volume_riph * 0.05 / 6, 2, '.', ',') }} ha;</dt>
							<dd class="col-sm-3">Realisasi</dd>
							<dt class="col-sm-9">: {{ number_format($total_luas, 2, '.', ',') }} ha.</dt>
							<dd class="col-sm-3">Verifikasi</dd>
							<dt class="col-sm-9">: {{number_format($pengajuan->luas_verif,2,'.',',')}} ha.</dt>
						</dl>
					</dt>
					<dd class="col-sm-3">Wajib Produksi</dd>
					<dt class="col-sm-9">
						<dl class="row">
							<dd class="col-sm-3">Komitmen</dd>
							<dt class="col-sm-9">: {{ number_format($commitment->volume_riph * 0.05, 2, '.', ',') }} ton;</dt>
							<dd class="col-sm-3">Realisasi</dd>
							<dt class="col-sm-9">: {{ number_format($total_volume, 2, '.', ',') }} ton.</dt>
							<dd class="col-sm-3">Verifikasi</dd>
							<dt class="col-sm-9">: {{number_format($pengajuan->volume_verif,2,'.',',')}} ton.</dt>
						</dl>
					</dt>
				</dl>
				{{-- <div class="row">
					<table class="table w-100 table-sm table-bordered table-striped">
						<tbody>
							<tr>
								<td width="25%">Nama Perusahaan</td>
								<th colspan="3">{{$commitment->datauser->company_name}}</th>
							</tr>
							<tr>
								<td>Nomor RIPH</td>
								<th colspan="3">{{$commitment->no_ijin}}</th>
							</tr>
							<tr>
								<td></td>
								<td width="25%" class="text-center">Komitmen</td>
								<td width="25%" class="text-center">Realisasi</td>
								<td width="25%" class="text-center">Terverifikasi</td>
							</tr>
							<tr>
								<td>Wajib Tanam (ha)</td>
								<th class="text-right pr-5">{{ number_format($wajib_tanam, 2, '.', ',') }}</th>
								<th class="text-right pr-5">{{ number_format($total_luas, 2, '.', ',') }}</th>
								<th class="text-right pr-5">{{number_format($luas_verif, 2,'.',',')}}</th>
							</tr>
							<tr>
								<td>Wajib Produksi (ton)</td>
								<th class="text-right pr-5">{{ number_format($wajib_produksi, 2, '.', ',') }}</th>
								<th class="text-right pr-5">{{ number_format($total_volume, 2, '.', ',') }}</th>
								<th class="text-right pr-5">{{number_format($volume_verif,2,'.',',')}}</th>
							</tr>
						</tbody>
					</table>
				</div> --}}
			</div>
			<div class="col-12">
				<p class="justify-align-stretch">
					Telah melaksanakan kewajiban pengembangan bawang putih di dalam negeri sebagaimana ketentuan dalam Permentan 39 tahun 2019 dan perubahannya.
				</p>
				<p class="justify-align-stretch mt-3">
					Atas perhatian dan kerjasama Saudara disampaikan terima kasih.
				</p>
			</div>
			<div class="col-12">
				<dl class="row mt-5 align-items-center">
					<dd class="col-sm-7">
						{{$QrCode}}
					</dd>
					<dd class="col-sm-5">
						{{-- <div class="text-dark" style="background-image: url('{{ asset('storage/uploads/dataadmin/'.$pejabat->dataadmin->sign_img) }}'); background-size: 50%;background-repeat: no-repeat;"> --}}
							Direktur,
							<br>
								<img style="max-width: 7em" src="{{ asset('storage/uploads/dataadmin/'.$pejabat->dataadmin->sign_img) }}" alt="ttd">
								<br>
							<u><strong>{{$pejabat->dataadmin->nama ?? ''}}</strong></u><br>
							<span class="mr-1">NIP.</span>{{$pejabat->dataadmin->nip ??''}}
						</div>
					</dd>
				</dl>
				<div class="row">
					<div class="col-sm-12">
						<ul><u>Tembusan</u>
							<li>Direktur Jenderal Hortikultura</li>
						</ul>
					</div>
				</div>
			</div>
			<div class="row position-relative">
				<i class="position-absolute pos-right pos-bottom opacity-50 mb-n1 ml-n1" >dicetak pada: {{ now() }}</i>
			</div>
		</div>
	</div>
</div>
@endsection
<!-- @parent -->
<!-- start script for this page -->
@section('scripts')
<script>
	function printPage() {
	  // Open print dialog
	  window.print();
	}
</script>
@endsection
