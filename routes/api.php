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
Route::get('/ajax-genes', 'AjaxController@genes')->name('ajax-genes');
Route::post('/ajax-previous', 'AjaxController@pathThatDemandPrevious')->name('ajax-previous');

Route::get('/protocols', 'AjaxController@protocols')->name('api/protocols');
Route::get('/centers', 'AjaxController@centers')->name('api/centers');
Route::get('/cids', 'AjaxController@cids')->name('api/cids');
Route::get('/does-that-exists/center-protocol', 'AjaxController@existsCenterProtocol')->name('api/exists/center-protocol');

