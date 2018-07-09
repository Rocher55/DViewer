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


Route::get('test','tests@index');

// Authentication Routes...
Route::get('login', 'Auth\Login2Controller@showLoginForm')->name('login');
Route::post('login', 'Auth\Login2Controller@login');
Route::post('logout', 'Auth\LoginController@logout')->name('logout');


Route::get('/', 'HomeController@index')->name('home');
Route::get('/ajax', 'AjaxController@ajax_call')->name('ajax');
Route::get('research/results','ResultController@index')->name('result');

/*------------------------------------------------------------------------------------------
                                Pages de criteres
------------------------------------------------------------------------------------------*/
//Protocol
Route::get('research/protocol', 'ProtocolController@index')->name('protocol');
Route::post('research/protocol', 'ProtocolController@postSelect')->name('postProtocol');

//Center
Route::get('research/center', 'CenterController@index')->name('center');
Route::post('research/center', 'CenterController@postSelect')->name('postCenter');

//Patient
Route::get('research/patient', 'PatientController@index')->name('patient');
Route::post('research/patient', 'PatientController@postSelect')->name('postPatient');

//CID
Route::get('research/cid', 'CidController@index')->name('cid');
Route::post('research/cid', 'CidController@postSelect')->name('postCid');

//Food-diaries
Route::get('research/food', 'FoodController@index')->name('food');
Route::post('research/food', 'FoodController@postSelect')->name('postFood');

//Biochemistry
Route::get('research/biochemistry', 'BiochemistryController@index')->name('biochemistry');
Route::post('research/biochemistry', 'BiochemistryController@postSelect')->name('postBiochemistry');

//Analyse
Route::get('research/analyse', 'AnalyseController@index')->name('analyse');
Route::post('research/analyse', 'AnalyseController@postSelect')->name('postAnalyse');




/*------------------------------------------------------------------------------------------
                                Pages de données à afficher
------------------------------------------------------------------------------------------*/
//Biochemistry
Route::get('research/select-bio', 'SelectController@index')->name('select-bio');
Route::post('research/select-bio', 'SelectController@postSelect')->name('postSelect-bio');

//Gene
Route::get('research/select-gene', 'GeneController@index')->name('select-gene');
Route::post('research/select-gene', 'GeneController@postSelect')->name('postSelect-gene');



/*-------------------------------------------------------------------------------------------
                                        Exportation
-------------------------------------------------------------------------------------------*/
Route::get('research/export','ResultController@export')->name('export');




