<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

/**
 * Peticiones de filtrado de kpi.
 */
Route::get('filter-kpis', 'Api\FilterController@index');

/** 
 * Apis para la vista de configuración de kpis.
 */
Route::get('kpi-dependencies', 'Api\KpiController@dependencies');
Route::get('partials', 'Api\KpiController@partials');
Route::get('kpi', 'Api\KpiController@index');
Route::post('kpi', 'Api\KpiController@store');
Route::patch('kpi/{id}', 'Api\KpiController@update');
Route::delete('kpi/{id}', 'Api\KpiController@destroy');

Route::get('counter', 'Api\CounterController@index');