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

Route::get('/home', 'HomeController@index')->name('home');

Route::get('/{modelYear}/{manufacturer}/{model}', 'UsersController@vehicles');  
Route::get('/', 'UsersController@vehicles');	
Route::post('/', 'UsersController@vehicles');	
Route::get('/vehicles/{modelYear}/{manufacturer}/{model}', 'UsersController@vehicles'); 
Route::post('/vehicles', 'UsersController@vehicles');
