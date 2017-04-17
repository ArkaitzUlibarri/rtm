<?php

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

Route::get('/home', 'MainController@index');

Route::get('/alarms', 'AlarmsController@index');
Route::get('/alarms/download', 'AlarmsController@download');

Route::get('configuration', 'ConfigurationController@index');

Route::resource('users', 'UsersController', ['only' => [
	'index', 'edit', 'update', 'create', 'store'
]]);

// Route::resource('configuration2', 'ConfigurationController');
