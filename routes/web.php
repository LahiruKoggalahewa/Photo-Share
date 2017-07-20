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

Route::get('/search', function () {
    return view('index');
});
//Route::get('/', 'PhotoManipulation@viewSearch')->name('home');

Route::get('/upload', function () {
    return view('upload');
});

Route::post('/postPhoto', 'PhotoManipulation@upload');

Route::post('/search', 'PhotoManipulation@search');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
