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

//genes similaires à la recherche
Route::get('/ajax-genes', 'AjaxController@genes')->name('ajax-genes');

//
Route::post('/ajax-previous', 'AjaxController@pathThatDemandPrevious')->name('ajax-previous');

//recupere les données brutes de la base
Route::get('/protocols', 'AjaxController@protocols')->name('api/protocols');
Route::get('/centers', 'AjaxController@centers')->name('api/centers');
Route::get('/cids', 'AjaxController@cids')->name('api/cids');

// selectionne une ligne d'après les ids passés
Route::get('/does-that-exists/center-protocol', 'AjaxController@existsCenterProtocol')->name('api/exists/center-protocol');

//download les templates
Route::get('/template/patients', 'AjaxController@patientTemplate')->name('patientTemplate');
