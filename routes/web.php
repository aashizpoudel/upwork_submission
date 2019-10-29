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
    return view('index');
});

Route::post('/upload-images','MediaController@uploadImages');
Route::post('/upload-files','MediaController@uploadFiles');
Route::post('/submit-details',"DetailController@store");


Route::get('/get-images','MediaController@getImages');
Route::get('/get-files','MediaController@getFiles');


Route::get('/delete/{id}','MediaController@delete');


