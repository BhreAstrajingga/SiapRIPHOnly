<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

Route::get('/', function () {
	return redirect()->route('login');
});

Route::get('/home', function () {
	if (session('status')) {
		return redirect()->route('admin.home')->with('status', session('status'));
	}
	return redirect()->route('admin.home');
});

Auth::routes(['register' => false]); // menghidupkan registration

Route::group(['prefix' => 'admin', 'as' => 'admin.', 'middleware' => ['auth']], function () {
	Route::group(['namespace' => 'Admin'], function () {
		// Admin landing
		Route::get('/', 'HomeController@index')->name('home');
	});

});

//route untuk Pelaku usaha
Route::group(['prefix' => 'importir', 'as' => 'importir.', 'middleware' => ['auth']], function () {
	Route::group(['namespace' => 'Importir'], function () {
		// Admin landing
		Route::get('/', 'HomeController@index')->name('home');
	});
});

Route::group(['prefix' => 'verification', 'as' => 'verification.', 'middleware' => ['auth']], function () {
	Route::group(['namespace' => 'Verifikator'], function () {
		// Admin landing
		Route::get('/', 'HomeController@index')->name('home');
	});
});

Route::group(['prefix' => 'direktur', 'as'=>'direktur', 'middleware' => ['auth']], function () {
	Route::group(['namespace' => 'Pejabat'], function () {
		// Admin landing
		Route::get('/', 'HomeController@index')->name('home');
	});
});

Route::group(['prefix' => 'profile', 'as' => 'profile.', 'namespace' => 'Auth', 'middleware' => ['auth']], function () {
	Route::group(['namespace' => 'Admin'], function () {
		// Admin landing
		Route::get('/', 'HomeController@index')->name('home');
	});
});

Route::group(['prefix' => 'support', 'as' => 'support.', 'middleware' => ['auth']], function () {
	Route::group(['namespace' => 'Support'], function () {
		// Admin landing
		Route::get('/', 'HomeController@index')->name('home');
	});
});

Route::group(['prefix' => 'test', 'as' => 'test.', 'namespace' => 'Admin', 'middleware' => ['auth']], function () {
	Route::group(['namespace' => 'Test'], function () {
		// Admin landing
		Route::get('/', 'HomeController@index')->name('home');
	});
});
