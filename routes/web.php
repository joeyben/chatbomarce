<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Auth::routes();

Route::get('/home', 'App\Http\Controllers\HomeController@index')->name('home');

Route::group(['middleware' => 'auth'], function () {
	Route::get('nachrichten', [App\Http\Controllers\HomeController::class, 'nachrichten'])->name('nachrichten');
    Route::get('messages', [App\Http\Controllers\HomeController::class, 'messages'])->name('messages');
    Route::get('users', [App\Http\Controllers\HomeController::class, 'whatsappUsers'])->name('users');
    Route::get('qa', [App\Http\Controllers\HomeController::class, 'questionAnswer'])->name('q&a');
    Route::get('wuser/{id}', [App\Http\Controllers\HomeController::class, 'whatsappUser'])->name('wuser');
    Route::resource('user', 'App\Http\Controllers\UserController', ['except' => ['show']]);
	Route::get('profile', ['as' => 'profile.edit', 'uses' => 'App\Http\Controllers\ProfileController@edit']);
	Route::put('profile', ['as' => 'profile.update', 'uses' => 'App\Http\Controllers\ProfileController@update']);
	Route::get('upgrade', function () {return view('pages.upgrade');})->name('upgrade');
	 Route::get('map', function () {return view('pages.maps');})->name('map');
	 Route::get('icons', function () {return view('pages.icons');})->name('icons');
	 Route::get('table-list', function () {return view('pages.tables');})->name('table');
	Route::put('profile/password', ['as' => 'profile.password', 'uses' => 'App\Http\Controllers\ProfileController@password']);
    Route::get('feedback', [App\Http\Controllers\HomeController::class, 'feedback'])->name('feedback');
});

