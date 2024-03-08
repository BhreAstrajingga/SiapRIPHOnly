<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Verifikator\SklOldController;


Route::get('/', function () {
	return redirect()->route('login');
});

Route::get('/v2/register', function () {
	return view('v2register');
});

Route::get('/home', function () {
	if (session('status')) {
		return redirect()->route('admin.home')->with('status', session('status'));
	}
	return redirect()->route('admin.home');
});


Auth::routes(['register' => true]); // menghidupkan registration

Route::group(['prefix' => 'admin', 'as' => 'admin.', 'namespace' => 'Admin', 'middleware' => ['auth']], function () {
	// landing
	Route::get('/', 'HomeController@index')->name('home');
	// Dashboard
	Route::get('/dashboard', 'DashboardController@index')->name('dashboard');
	Route::get('/dashboard/monitoring', 'DashboardController@monitoring')->name('dashboard.monitoring');
	Route::get('/dashboard/map', 'DashboardController@map')->name('dashboard.map');

	Route::get('/dashboard/monitoringrealisasi/{periodetahun}', 'DashboardController@monitoringrealisasi')->name('dashboard.monitoringrealisasi');
	Route::get('/monitoringDataRealisasi/{periodetahun}', 'DashboardDataController@monitoringDataRealisasi')->name('monitoringDataRealisasi');

	Route::get('mapDataAll', 'UserMapDashboard@index')->name('mapDataAll');
	Route::get('mapDataByYear/{periodeTahun}', 'UserMapDashboard@ByYears')->name('mapDataByYear');
	Route::get('mapDataById/{id}', 'UserMapDashboard@show')->name('mapDataById');

	//data pemetaan
	Route::group(['prefix' => 'map', 'as' => 'map.'], function () {
		Route::get('getAllMap', 'AdminMapController@index')->name('getAllMap');
		Route::get('getAllMapByYears/{periodeTahun}', 'AdminMapController@ByYears')->name('getAllMapByYears');
		Route::get('getLocationData/{id}', 'AdminMapController@index')->name('getLocationData');
	});

	//dashboard data for admin
	Route::get('monitoringDataByYear/{periodetahun}', 'DashboardDataController@monitoringDataByYear')->name('monitoringDataByYear');

	//dashboard data for verifikator
	Route::get('verifikatorMonitoringDataByYear/{periodetahun}', 'DashboardDataController@verifikatorMonitoringDataByYear')->name('verifikatormonitoringDataByYear');

	//dashboard data for user
	Route::get('usermonitoringDataByYear/{periodeTahun}', 'DashboardDataController@userMonitoringDataByYear')->name('userMonitoringDataByYear');
	Route::get('rekapRiphData', 'DashboardDataController@rekapRiphData')->name('get.rekap.riph');

	//sklReads
	Route::post('sklReads', 'SklReadsController@sklReads')->name('sklReads');

	// Permissions
	Route::delete('permissions/destroy', 'PermissionsController@massDestroy')->name('permissions.massDestroy');
	Route::resource('permissions', 'PermissionsController');

	// Roles
	Route::delete('roles/destroy', 'RolesController@massDestroy')->name('roles.massDestroy');
	Route::resource('roles', 'RolesController');

	// Users
	Route::delete('users/destroy', 'UsersController@massDestroy')->name('users.massDestroy');
	Route::resource('users', 'UsersController');

	// Audit Logs
	Route::resource('audit-logs', 'AuditLogsController', ['except' => ['create', 'store', 'edit', 'update', 'destroy']]);
	Route::get('global-search', 'GlobalSearchController@search')->name('globalSearch');

	Route::get('profile', 'ProfileController@index')->name('profile.show');
	Route::post('profile', 'ProfileController@store')->name('profile.store');
	Route::post('profile/{id}', 'ProfileController@update')->name('profile.update');
	Route::get('profile/pejabat', 'AdminProfileController@index')->name('profile.pejabat');
	Route::post('profile/pejabat/store', 'AdminProfileController@store')->name('profile.pejabat.store');

	//google map api
	Route::get('gmapapi', 'ForeignApiController@edit')->name('gmapapi.edit');
	Route::put('gmapapi/update', 'ForeignApiController@update')->name('gmapapi.update');

	//posts
	Route::put('posts/{post}/restore', 'PostsController@restore')->name('posts.restore');
	Route::resource('posts', 'PostsController');
	Route::get('allblogs', 'PostsController@allblogs')->name('allblogs');
	Route::post('posts/{post}/star', 'StarredPostController@star')->name('posts.star');
	Route::delete('posts/{post}/unstar', 'StarredPostController@unstar')->name('posts.unstar');

	//posts categories
	Route::resource('categories', 'CategoryController');

	//messenger
	Route::get('messenger', 'MessengerController@index')->name('messenger.index');
	Route::get('messenger/create', 'MessengerController@createTopic')->name('messenger.createTopic');
	Route::post('messenger', 'MessengerController@storeTopic')->name('messenger.storeTopic');
	Route::get('messenger/inbox', 'MessengerController@showInbox')->name('messenger.showInbox');
	Route::get('messenger/outbox', 'MessengerController@showOutbox')->name('messenger.showOutbox');
	Route::post('messenger/{topic}/update', 'MessengerController@updateTopic')->name('messenger.updateTopic');
	Route::get('messenger/{topic}', 'MessengerController@showMessages')->name('messenger.showMessages');
	Route::delete('messenger/{topic}', 'MessengerController@destroyTopic')->name('messenger.destroyTopic');
	Route::post('messenger/{topic}/reply', 'MessengerController@replyToTopic')->name('messenger.reply');
	Route::get('messenger/{topic}/reply', 'MessengerController@showReply')->name('messenger.showReply');

	//verifikasi
	Route::get('dir_check_b', 'MessengerController@showReply')->name('verifikasi.dir_check_b');
	Route::get('dir_check_c', 'MessengerController@showReply')->name('verifikasi.dir_check_c');

	Route::get('riphAdmin', 'RiphAdminController@index')->name('riphAdmin.index');
	Route::get('riphAdmin/create', 'RiphAdminController@create')->name('riphAdmin.create');
	Route::post('riphAdmin/storefetched', 'RiphAdminController@storefetched')->name('riphAdmin.storefetched');
	Route::post('riphAdmin', 'RiphAdminController@store')->name('riphAdmin.store');
	Route::get('riphAdmin/{riphAdmin}/edit', 'RiphAdminController@edit')->name('riphAdmin.edit');
	Route::put('riphAdmin/{riphAdmin}', 'RiphAdminController@update')->name('riphAdmin.update');
	Route::delete('riphAdmin/{riphAdmin}', 'RiphAdminController@destroy')->name('riphAdmin.destroy');

	//daftar pejabat penandatangan SKL
	Route::get('daftarpejabats', 'PejabatController@index')->name('pejabats');
	Route::get('pejabat/create', 'PejabatController@create')->name('pejabat.create');
	Route::post('pejabat/store', 'PejabatController@store')->name('pejabat.store');
	Route::get('pejabat/{id}/show', 'PejabatController@show')->name('pejabat.show');
	Route::get('pejabat/{id}/edit', 'PejabatController@edit')->name('pejabat.edit');
	Route::put('pejabat/{id}/update', 'PejabatController@update')->name('pejabat.update');
	Route::delete('pejabat/{id}/delete', 'PejabatController@destroy')->name('pejabat.delete');
	Route::put('pejabat/{id}/activate', 'PejabatController@activate')->name('pejabat.activate');

	//daftar varietas
	Route::get('varietas', 'VarietasController@index')->name('varietas');
	Route::get('varietas/create', 'VarietasController@create')->name('varietas.create');
	Route::get('varietas/{id}/edit', 'VarietasController@edit')->name('varietas.edit');
	Route::get('varietas/{id}/show', 'VarietasController@show')->name('varietas.show');
	Route::post('varietas/store', 'VarietasController@store')->name('varietas.store');
	Route::put('varietas/{id}/update', 'VarietasController@update')->name('varietas.update');
	Route::delete('varietas/{id}/delete', 'VarietasController@destroy')->name('varietas.delete');
	Route::patch('varietas/{id}/restore', 'VarietasController@restore')->name('varietas.restore');

	//user task
	Route::group(['prefix' => 'task', 'as' => 'task.'], function () {

		Route::get('pull', 'PullRiphController@index')->name('pull');
		Route::get('getriph', 'PullRiphController@pull')->name('pull.getriph');
		Route::post('pull', 'PullRiphController@store')->name('pull.store');


		Route::get('commitment', 'CommitmentController@index')->name('commitment');
		Route::group(['prefix' => 'commitment', 'as' => 'commitment.'], function () {
			Route::get('{id}/show', 'CommitmentController@show')->name('show');
			Route::delete('{pullriph}', 'CommitmentController@destroy')->name('destroy');

			//pengisian data realisasi
			Route::get('{id}/realisasi', 'CommitmentController@realisasi')->name('realisasi');
			Route::post('{id}/realisasi/storeUserDocs', 'CommitmentController@storeUserDocs')->name('realisasi.storeUserDocs');
			Route::get('{id}/penangkar', 'PenangkarRiphController@mitra')->name('penangkar');
			Route::post('{id}/penangkar/store', 'PenangkarRiphController@store')->name('penangkar.store');
		});
		Route::delete('commitmentmd', 'CommitmentController@massDestroy')->name('commitment.massDestroy');

		//master penangkar
		Route::get('penangkar', 'MasterPenangkarController@index')->name('penangkar');
		Route::group(['prefix' => 'penangkar', 'as' => 'penangkar.'], function () {
			Route::get('create', 'MasterPenangkarController@create')->name('create');
			Route::post('store', 'MasterPenangkarController@store')->name('store');
			Route::get('{id}/edit', 'MasterPenangkarController@edit')->name('edit');
			Route::put('{id}/update', 'MasterPenangkarController@update')->name('update');
			Route::delete('{id}/delete', 'MasterPenangkarController@destroy')->name('delete');
		});

		Route::delete('mitra/{id}/delete', 'PenangkarRiphController@destroy')->name('mitra.delete');

		// daftar pks

		Route::get('pks/{id}/edit', 'PksController@edit')->name('pks.edit');
		Route::put('pks/{id}/update', 'PksController@update')->name('pks.update');

		//daftar anggota
		Route::get('pks/{id}/daftaranggota', 'PksController@anggotas')->name('pks.anggotas');
		// daftar lokasi tanam per anggota
		Route::get('pks/{pksId}/anggota/{anggotaId}/list_lokasi', 'PksController@listLokasi')->name('pks.anggota.listLokasi');
		//page tambah lokasi tanam
		Route::get('pks/{pksId}/anggota/{anggotaId}/add_lokasi', 'PksController@addLokasiTanam')->name('pks.anggota.addLokasiTanam');
		//edit lokasi tanam
		Route::get('pks/{pksId}/anggota/{anggotaId}/lokasi/{id}/edit', 'PksController@editLokasiTanam')->name('pks.anggota.editLokasiTanam');
		Route::get('pks/{pksId}/anggota/{anggotaId}/lokasi/{id}/foto', 'PksController@fotoLokasi')->name('pks.anggota.fotoLokasi');
		Route::delete('deleteFotoTanam/{id}', 'PksController@deleteFotoTanam')->name('deleteFotoTanam');
		Route::delete('deleteFotoProduksi/{id}', 'PksController@deleteFotoProduksi')->name('deleteFotoProduksi');
		Route::delete('deleteLokasiTanam/{id}', 'PksController@deleteLokasiTanam')->name('deleteLokasiTanam');

		Route::post('storeLokasiTanam', 'PksController@storeLokasiTanam')->name('storeLokasiTanam');
		Route::put('updateLokasiTanam/{id}/update', 'PksController@updateLokasiTanam')->name('updateLokasiTanam');
		Route::put('storeRealisasiProduksi/{id}', 'PksController@storeRealisasiProduksi')->name('storeRealisasiProduksi');

		Route::post('upload/dropZoneTanam', 'PksController@dropZoneTanam')->name('dropZoneTanam');
		Route::post('upload/dropZoneProduksi', 'PksController@dropZoneProduksi')->name('dropZoneProduksi');

		//saprodi
		Route::get('pks/{id}/saprodi', 'PksController@saprodi')->name('pks.saprodi');
		Route::post('pks/{id}/saprodi', 'SaprodiController@store')->name('saprodi.store');
		route::get('pks/{pksId}/saprodi/{id}/edit', 'SaprodiController@edit')->name('saprodi.edit');
		route::put('pks/{pksId}/saprodi/{id}', 'SaprodiController@update')->name('saprodi.update');
		route::delete('saprodi/{id}', 'SaprodiController@destroy')->name('saprodi.delete');
		Route::get('saprodi', 'SaprodiController@index')->name('saprodi.index');

		// Route::get('pks/create/{noriph}/{poktan}', 'PksController@create')->name('pks.create');
		// Route::delete('pksmd', 'PksController@massDestroy')->name('pks.massDestroy');

		//realisasi lokasi tanam & produksi
		Route::get('realisasi/lokasi/{lokasiId}', 'LokasiController@show')->name('lokasi.tanam');
		Route::post('realisasi/lokasi/{id}/update', 'LokasiController@update')->name('lokasi.tanam.update');
		Route::put('realisasi/lokasi/{id}/storeTanam', 'LokasiController@storeTanam')->name('lokasi.tanam.store');
		Route::put('realisasi/lokasi/{id}/storeProduksi', 'LokasiController@storeProduksi')->name('lokasi.produksi.store');

		Route::get('pengajuan', 'PengajuanController@index')->name('pengajuan.index');

		//new pengajuan tanam
		Route::get('commitment/{id}/formavt', 'PengajuanController@ajuVerifTanam')->name('commitment.avt');
		Route::get('commitment/{id}/formavt/lokasi', 'PengajuanController@ajuVerifTanam')->name('commitment.avt.lokasi');
		Route::post('commitment/{id}/formavt/store', 'PengajuanController@ajuVerifTanamStore')->name('commitment.avt.store');
		Route::get('commitment/{id}/pengajuan/tanam/show', 'PengajuanController@showAjuTanam')->name('pengajuan.tanam.show');

		//new pengajuan produksi
		Route::get('commitment/{id}/formavp', 'PengajuanController@ajuVerifProduksi')->name('commitment.avp');
		Route::get('commitment/{id}/formavp/lokasi', 'PengajuanController@ajuVerifProduksi')->name('commitment.avp.lokasi');
		Route::post('commitment/{id}/formavp/store', 'PengajuanController@ajuVerifProduksiStore')->name('commitment.avp.store');
		Route::get('commitment/{id}/pengajuan/produksi/show', 'PengajuanController@showAjuProduksi')->name('pengajuan.produksi.show');

		//new pengajuan skl
		Route::get('commitment/{id}/formavskl', 'PengajuanController@ajuVerifSkl')->name('commitment.avskl');
		Route::post('commitment/{id}/formavskl/store', 'PengajuanController@ajuVerifSklStore')->name('commitment.avskl.store');
		Route::get('commitment/{id}/formavskl/lokasi', 'PengajuanController@ajuVerifSkl')->name('commitment.avskl.lokasi');
		Route::get('commitment/{id}/pengajuan/skl/show', 'PengajuanController@showAjuSkl')->name('pengajuan.skl.show');


		Route::get('submission/{id}/show', 'PengajuanController@show')->name('submission.show');
		Route::delete('pengajuan/destroy', 'PengajuanController@massDestroy')->name('pengajuan.massDestroy');

		//daftar seluruh skl yang telah terbit (lama & baru)
		Route::get('skl/arsip', function () {
			return redirect()->route('skl.arsip');
		})->name('skl.arsip');
	});

	//template
	Route::group(['prefix' => 'template', 'as' => 'template.'], function () {
		Route::get('index', 'FileManagementController@index')->name('index');
		Route::get('create', 'FileManagementController@create')->name('create');
		Route::post('store', 'FileManagementController@store')->name('store');
		Route::post('{id}/edit', 'FileManagementController@edit')->name('edit');
		Route::put('{id}/update', 'FileManagementController@update')->name('update');
		Route::get('{id}/download', 'FileManagementController@download')->name('download');
		Route::delete('{id}/delete', 'FileManagementController@destroy')->name('delete');
	});

	Route::get('lokasiTanamByCommitment/{id}', 'DataLokasiTanamController@lokasiTanamByCommitment')->name('lokasiTanamByCommitment');
	Route::get('listLokasi/{id}', 'DataLokasiTanamController@listLokasi')->name('ajutanam.listlokasi');
	Route::get('produksi/listLokasi/{id}', 'DataLokasiTanamController@listLokasiTanamProduksi')->name('ajuproduksi.listlokasi');
});

//route untuk Pelaku usaha
Route::group(['prefix' => 'importir', 'as' => 'importir.', 'namespace' => 'Admin', 'middleware' => ['auth']], function () {
});

Route::group(['prefix' => 'verification', 'as' => 'verification.', 'namespace' => 'Verifikator', 'middleware' => ['auth']], function () {

	//verifikasi data lokasi tanam
	Route::get('{noIjin}/lokasitanam', 'LokasiTanamController@index')->name('lokasitanam');

	Route::get('{noIjin}/lokasitanam/{lokasiId}', 'LokasiTanamController@listLokasibyPetani')->name('listLokasibyPetani');
	Route::get('{id}/summary', 'VerifSklController@dataCheck')->name('data.summary');

	//new verifikasi tanam
	Route::get('tanam', 'VerifTanamController@index')->name('tanam');
	Route::group(['prefix' => 'tanam', 'as' => 'tanam.'], function () {
		Route::get('{id}/check', 'VerifTanamController@check')->name('check');
		// Route::get('{noIjin}/daftar_lokasi_tanam', 'LokasiTanamController@daftarTanam')->name('daftarTanam');
		Route::put('{id}/storeCheck', 'VerifTanamController@storeCheck')->name('storeCheck');
		Route::get('{id}/show', 'VerifTanamController@show')->name('show');
		Route::get('{id}/showlocation', 'LokasiTanamController@showLocation')->name('showLocation');
		Route::post('{id}/checkBerkas', 'VerifTanamController@checkBerkas')->name('checkBerkas');
		Route::get('{noIjin}/poktan/{poktan_id}/check', 'VerifTanamController@verifPks')->name('check.pks');
		Route::put('pks/{id}/store', 'VerifTanamController@verifPksStore')->name('check.pks.store');
		Route::put('{id}/checkPksSelesai', 'VerifTanamController@checkPksSelesai')->name('checkPksSelesai');
		// Route::get('{noIjin}/lokasi/{anggota_id}', 'VerifTanamController@lokasicheck')->name('lokasicheck');
	});

	//new verifikasi produksi
	Route::get('produksi', 'VerifProduksiController@index')->name('produksi');
	Route::group(['prefix' => 'produksi', 'as' => 'produksi.'], function () {
		Route::get('{id}/check', 'VerifProduksiController@check')->name('check');
		Route::post('{id}/storeCheck', 'VerifProduksiController@storeCheck')->name('storeCheck');
		Route::get('{id}/show', 'VerifProduksiController@show')->name('show');
		Route::post('{id}/checkBerkas', 'VerifProduksiController@checkBerkas')->name('checkBerkas');
		Route::get('{noIjin}/poktan/{poktan_id}/check', 'VerifProduksiController@verifPks')->name('check.pks');
		Route::put('pks/{id}/store', 'VerifProduksiController@verifPksStore')->name('check.pks.store');
		Route::post('{id}/checkPksSelesai', 'VerifProduksiController@checkPksSelesai')->name('checkPksSelesai');
		Route::get('{id}/showlocation', 'LokasiTanamController@showLocation')->name('showLocation');
		//unused
		Route::put('{id}/store', 'VerifProduksiController@store')->name('store');
	});

	//new verifikasi skl
	Route::get('skl', 'VerifSklController@index')->name('skl');
	Route::group(['prefix' => 'skl', 'as' => 'skl.'], function () {
		Route::get('{id}/check', 'VerifSklController@check')->name('check');
		Route::post('{id}/checkBerkas', 'VerifSklController@checkBerkas')->name('checkBerkas');
		Route::get('{noIjin}/poktan/{poktan_id}/check', 'VerifSklController@verifPks')->name('check.pks');
		Route::put('pks/{id}/store', 'VerifSklController@verifPksStore')->name('check.pks.store');
		Route::post('{id}/checkPksSelesai', 'VerifSklController@checkPksSelesai')->name('checkPksSelesai');
		Route::get('{id}/showlocation', 'LokasiTanamController@showLocation')->name('showLocation');
		Route::post('{id}/storeCheck', 'VerifSklController@storeCheck')->name('storeCheck');
		Route::get('{id}/verifSklShow', 'VerifSklController@verifSklShow')->name('verifSklShow');

		//rekomendasi penerbitan
		Route::post('{id}/recomend', 'VerifSklController@recomend')->name('recomend');

		//daftar rekomendasi skl untuk pejabat
		Route::get('recomendations', 'VerifSklController@recomendations')->name('recomendations');
		Route::group(['prefix' => 'recomendation', 'as' => 'recomendation.'], function () {
			//detail rekomendasi untuk pejabat
			Route::get('{id}/show', 'VerifSklController@showrecom')->name('show');
			//preview draft skl untuk pejabat
			Route::get('{id}/draft', 'VerifSklController@draftSKL')->name('draft');
			//fungsi untuk pejabat menyetujui penerbitan.
			Route::put('{id}/approve', 'VerifSklController@approve')->name('approve');
		});

		//daftar skl diterbitkan
		Route::get('recomendations', 'VerifSklController@recomendations')->name('recomendations');
	});

	// Route::get('{noIjin}/lokasi/{anggota_id}', 'VerifTanamController@lokasicheck')->name('lokasicheck');


	Route::get('skl/{id}/show', 'SklController@show')->name('skl.show');

	//ke bawah ini mungkin di hapus
	Route::get('skl/publishes', 'SklController@publishes')->name('skl.publishes');
	Route::get('skl/published/{id}/print', 'SklController@published')->name('skl.published');
});

Route::group(['prefix' => 'skl', 'as' => 'skl.', 'namespace' => 'Verifikator', 'middleware' => ['auth']], function () {
	// daftar rekomendasi (index rekomendasi dan skl untuk verifikator)
	Route::get('recomended/list', 'VerifSklController@recomended')->name('recomended.list');
	Route::get('{id}/print', 'VerifSklController@printReadySkl')->name('print'); //form view skl untuk admin
	Route::put('{id}/upload', 'VerifSklController@Upload')->name('upload'); //fungsi upload untuk admin
	Route::get('arsip', 'VerifSklController@arsip')->name('arsip');
});

Route::group(['prefix' => 'profile', 'as' => 'profile.', 'namespace' => 'Auth', 'middleware' => ['auth']], function () {
	// Change password
	if (file_exists(app_path('Http/Controllers/Auth/ChangePasswordController.php'))) {
		Route::get('password', 'ChangePasswordController@edit')->name('password.edit');
		Route::post('password', 'ChangePasswordController@update')->name('password.update');
		Route::post('profile', 'ChangePasswordController@updateProfile')->name('password.updateProfile');
		Route::post('profile/destroy', 'ChangePasswordController@destroy')->name('password.destroyProfile');
	}
});

Route::group(['prefix' => 'wilayah', 'as' => 'wilayah.', 'namespace' => 'Wilayah', 'middleware' => ['auth']], function () {
	Route::get('getAllProvinsi', 'GetWilayahController@getAllProvinsi');
	Route::get('getKabupatenByProvinsi/{provinsiId}', 'GetWilayahController@getKabupatenByProvinsi');
	Route::get('getKecamatanByKabupaten/{id}', 'GetWilayahController@getKecamatanByKabupaten');
	Route::get('getDesaByKec/{kecamatanId}', 'GetWilayahController@getDesaByKecamatan');
});

Route::group(['prefix' => 'digisign', 'as' => 'digisign.', 'namespace' => 'Admin', 'middleware' => ['auth']], function () {
	Route::get('index', 'DigitalSign@index')->name('index');
	Route::post('saveQrImage', 'DigitalSign@saveQrImage')->name('saveQrImage');
});

Route::group(['prefix' => 'support', 'as' => 'support.', 'middleware' => ['auth']], function () {
	// Route::group(['prefix' => 'how_to', 'as' => 'howto.', 'namespace' => 'HowTo'], function () {
	// 	Route::get('/',		'HowToController@show')->name('show');
	// });
	Route::group(['prefix' => 'how_to', 'as' => 'howto.', 'namespace' => 'Howto'], function () {
		Route::get('importir',		'HowtoController@importir')->name('importir');
		Route::get('administrator',	'HowtoController@administrator')->name('administrator');
		Route::get('verifikator',	'HowtoController@verifikator')->name('verifikator');
		Route::get('pejabat',		'HowtoController@pejabat')->name('pejabat');
	});
	Route::group(['prefix' => 'faq', 'as' => 'faq.', 'namespace' => 'Faq'], function () {
	});
	Route::group(['prefix' => 'ticket', 'as' => 'ticket.', 'namespace' => 'Ticket'], function () {
	});
});

Route::group(['prefix' => 'test', 'as' => 'test.', 'namespace' => 'Admin', 'middleware' => ['auth']], function () {
	Route::get('sample/{id}', 'TestController@index')->name('sample');
	Route::get('files', 'ListFileController@index')->name('files');
});
