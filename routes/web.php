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


Route::get('paul-carrere', function () {
    return Redirect::to('https://linkedin.com/in/paul-carrere');
})->name('pro');



//Voyager package routes (for admin panel purposes)
Route::group(['prefix' => 'admin'], function () {
    Voyager::routes();
});

// Authentication Routes...
Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');
Route::post('login', 'Auth\LoginController@login');
Route::get('logout', 'Auth\LoginController@logout')->name('logout');


Route::get('/', 'HomeController@index')->name('home');
Route::get('research/results','ResultController@index')->name('result');
Route::get('/protocol/{id}', 'SpecificationController@index')->name('protocol.spec');
Route::post('/protocol/{id}', 'SpecificationController@post')->name('postProtocol.spec');
/*------------------------------------------------------------------------------------------
                                Pages de criteres
------------------------------------------------------------------------------------------*/
//Protocol
Route::get('research/protocol', 'ProtocolController@index')->name('protocol');
Route::post('research/protocol', 'ProtocolController@postSelect')->name('postProtocol');
//Center
Route::get('research/center', 'CenterController@index')->name('center');
Route::post('research/center', 'CenterController@postSelect')->name('postCenter');

Route::group(['middleware' => ['in.process']], function () {

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
    //Baecke
    Route::get('research/activities', 'PhysicalController@index')->name('activities');
    Route::post('research/activities', 'PhysicalController@postSelect')->name('postActivities');
    //Gene
    Route::get('research/select-gene', 'GeneController@index')->name('select-gene');

    Route::post('research/select-gene', 'GeneController@postSelect')->name('postSelect-gene');
});

/*-------------------------------------------------------------------------------------------
                                        Exportation
-------------------------------------------------------------------------------------------*/
Route::get('research/export','ResultController@export')->name('export');


/*-------------------------------------------------------------------------------------------
                                               Ajax
 -------------------------------------------------------------------------------------------*/
//Route::get('/ajax-genes', 'AjaxController@genes')->name('ajax-genes');
//Route::get('/ajax-genes', 'AjaxController@genes')->name('ajax-genes')->middleware('ajax');
//Route::post('/ajax-previous', 'AjaxController@pathThatDemandPrevious')->name('ajax-previous')->middleware('ajax');

