<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

Route::get('/', function () {
	return redirect()->route('login');
});

Route::get('/home', function () {
	if (Auth::user()->roles[0]->id == 1){
		if (session('status')) {
			return redirect()->route('admin.home')->with('status', session('status'));
		}
		return redirect()->route('admin.home');
	}elseif (Auth::user()->roles[0]->id == 7){
		if (session('status')) {
			return redirect()->route('sroot.home')->with('status', session('status'));
		}
		return redirect()->route('sroot.home');
	}
});

Auth::routes(['register' => true]); // menghidupkan registration

//route super admin
Route::group(['prefix' => 'sroot', 'as' => 'sroot.', 'middleware' => ['auth']], function () {
	Route::group(['namespace' => 'Admin'], function () {
		//Landing
		Route::get('/', 'HomeController@index')->name('home');

		//broadcasting
		Route::group(['prefix' => 'broadcasts', 'as' => 'broadcasts.'], function () {
			Route::get('/', 'BroadcastMessagesController@index')->name('index');
			Route::get('/{id}/edit', 'BroadcastMessagesController@edit')->name('edit');
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
Route::group(['prefix' => 'admin', 'as' => 'admin.', 'middleware' => ['auth']], function () {
	Route::group(['namespace' => 'Admin'], function () {
		// Admin landing
		Route::get('/', 'HomeController@index')->name('home');
		Route::delete('users/destroy', 'UsersController@massDestroy')->name('users.massDestroy');
		Route::resource('users', 'UsersController');
	});
});

//route untuk Pelaku usaha
Route::group(['prefix' => 'importir', 'as' => 'importir.', 'middleware' => ['auth']], function () {
	Route::group(['namespace' => 'Importir'], function () {
		// Admin landing

	});
});

Route::group(['prefix' => 'verification', 'as' => 'verification.', 'middleware' => ['auth']], function () {
	Route::group(['namespace' => 'Verifikator'], function () {
		// Admin landing

	});
});

Route::group(['prefix' => 'direktur', 'as'=>'direktur', 'middleware' => ['auth']], function () {
	Route::group(['namespace' => 'Pejabat'], function () {
		// Admin landing

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
