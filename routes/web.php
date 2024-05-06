<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

Route::get('/', function () {
	return redirect()->route('login');
});


Route::group(['namespace' => 'Admin', 'middleware' => ['auth']], function () {
    Route::get('/', 'HomeController@index')->name('home');
});


Route::get('/home', function () {
    if (session('status')) {
        return redirect()->route('home')->with('status', session('status'));
    } else {
        return redirect()->route('home');
    }
});

// Route::get('/home', function () {
// 	if (Auth::user()->roles[0]->id == 1){
// 		if (session('status')) {
// 			return redirect()->route('admin.home')->with('status', session('status'));
// 		}
// 		return redirect()->route('admin.home');
// 	}elseif (Auth::user()->roles[0]->id == 7){
// 		if (session('status')) {
// 			return redirect()->route('sroot.home')->with('status', session('status'));
// 		}
// 		return redirect()->route('sroot.home');
// 	}elseif (Auth::user()->roles[0]->id == 2){
// 		if (session('status')) {
// 			return redirect()->route('importir.home')->with('status', session('status'));
// 		}
// 		return redirect()->route('importir.home');
// 	}
// });

Auth::routes(['register' => true]); // menghidupkan registration

Route::group(['middleware' => ['auth']], function () {
	//route super admin
	Route::group(['prefix' => 'sroot', 'as' => 'sroot.'], function () {
		Route::group(['namespace' => 'Admin'], function () {
			//Landing
			// Route::get('/', 'HomeController@index')->name('home');
			//broadcasting
			Route::resource('broadcasts', 'BroadcastMessagesController');
			Route::group(['prefix' => 'broadcasts', 'as' => 'broadcasts.'], function () {
				Route::put('/{id}/updateStatus', 'BroadcastMessagesController@updateStatus')->name('updateStatus');
			});
		});
		Route::group(['namespace' => 'Sroot'], function () {
			Route::delete('roles/destroy', 'RolesController@massDestroy')->name('roles.massDestroy');
			Route::delete('permissions/destroy', 'PermissionsController@massDestroy')->name('permissions.massDestroy');
			Route::resource('permissions', 'PermissionsController');
			Route::resource('roles', 'RolesController');

			Route::group(['prefix' => 'gmapapi', 'as' => 'gmapapi.'], function () {
				//google map api
				Route::get('/', 'ForeignApiController@edit')->name('edit');
				Route::put('/update', 'ForeignApiController@update')->name('update');
			});
		});
	});

	//route admin
	Route::group(['prefix' => 'admin', 'as' => 'admin.'], function () {
		Route::group(['namespace' => 'Admin'], function () {
			// Admin landing
			// Route::get('/', 'HomeController@index')->name('home');
			Route::delete('users/destroy', 'UsersController@massDestroy')->name('users.massDestroy');
			Route::resource('users', 'UsersController');
			Route::resource('broadcasts', 'BroadcastMessagesController');
			Route::group(['prefix' => 'broadcasts', 'as' => 'broadcasts.'], function () {
				Route::put('/{id}/updateStatus', 'BroadcastMessagesController@updateStatus')->name('updateStatus');
			});
		});
	});

	//route untuk Pelaku usaha
	Route::group(['prefix' => 'importir', 'as' => 'importir.'], function () {
		Route::group(['namespace' => 'Admin'], function () {
			// Landing
			// Route::get('/', 'HomeController@index')->name('home');
		});

		Route::group(['namespace' => 'Importir'], function () {
			// Commitment
			Route::group(['prefix' => 'commitment', 'as' => 'commitment.'], function () {
				Route::get('synchronize', 'PullRiphController@index')->name('pull');
				Route::get('getriph', 'PullRiphController@pull')->name('pull.getriph');
				Route::post('pull', 'PullRiphController@store')->name('pull.store');
				Route::get('/', 'CommitmentController@index')->name('index');
				Route::get('/{no_ijin}/show', 'CommitmentController@show')->name('show');
				Route::get('/{no_ijin}/realisasi', 'CommitmentController@realisasi')->name('realisasi');
			});
		});
	});

	Route::group(['prefix' => 'verification', 'as' => 'verification.'], function () {
		Route::group(['namespace' => 'Verifikator'], function () {
			// Admin landing

		});
	});

	Route::group(['prefix' => 'direktur', 'as'=>'direktur'], function () {
		Route::group(['namespace' => 'Pejabat'], function () {
			// Admin landing

		});
	});

	//administrator support dan bantuan
	Route::group(['prefix' => 'support', 'as'=>'support'], function () {
		Route::group(['namespace' => 'Admin'], function () {
			// Admin landing

		});
		Route::group(['namespace' => 'Support'], function () {
			// help desk
			// hot line
		});
	});
});

Route::group(['prefix' => 'profile', 'as' => 'profile.', 'namespace' => 'Auth', 'middleware' => ['auth']], function () {
	Route::group(['namespace' => 'Admin'], function () {
		// Admin landing

	});
});

Route::group(['prefix' => 'support', 'as' => 'support.', 'middleware' => ['auth']], function () {
	Route::group(['namespace' => 'Support'], function () {
		// Admin landing

	});
});

Route::group(['prefix' => 'test', 'as' => 'test.', 'namespace' => 'Admin', 'middleware' => ['auth']], function () {
	Route::group(['namespace' => 'Test'], function () {
		// Admin landing

	});
});
